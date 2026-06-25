import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import '../../vendor/sampaui/sampaui/dist/sampaui.js';

window.Alpine = Alpine;

Alpine.data('copyCode', () => ({
    copied: false,
    async copy(code) {
        try {
            await navigator.clipboard.writeText(code);
        } catch {
            const textarea = document.createElement('textarea');
            textarea.value = code;
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand('copy');
            textarea.remove();
        }

        this.copied = true;
        window.setTimeout(() => {
            this.copied = false;
        }, 1600);
    },
}));

Alpine.data('docsShell', () => ({
    sidebarOpen: false,
    showBackToTop: false,
    theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light',
    toggleTheme() {
        this.theme = this.theme === 'dark' ? 'light' : 'dark';
        document.documentElement.classList.toggle('dark', this.theme === 'dark');
        window.localStorage.setItem('sampaui-docs-theme', this.theme);
    },
    scrollToTop() {
        this.$refs.scrollArea?.scrollTo({ top: 0, behavior: 'smooth' });
    },
}));

Alpine.data('tableOfContents', (items = []) => ({
    items,
    activeId: items[0]?.id ?? '',
    observer: null,
    init() {
        this.$nextTick(() => {
            const scrollArea = this.$root.closest('.doc-main-scroll');
            const sections = this.items
                .map((item) => document.getElementById(item.id))
                .filter(Boolean);

            if (! sections.length || typeof window.IntersectionObserver === 'undefined') {
                return;
            }

            this.observer = new window.IntersectionObserver((entries) => {
                const visibleSection = entries
                    .filter((entry) => entry.isIntersecting)
                    .sort((left, right) => left.boundingClientRect.top - right.boundingClientRect.top)[0];

                if (visibleSection?.target?.id) {
                    this.activeId = visibleSection.target.id;
                }
            }, {
                root: scrollArea,
                rootMargin: '-10% 0px -75% 0px',
                threshold: [0, 0.25, 1],
            });

            sections.forEach((section) => this.observer.observe(section));
        });
    },
    destroy() {
        this.observer?.disconnect();
    },
}));

Alpine.data('docSearch', (items = []) => ({
    query: '',
    open: false,
    activeIndex: 0,
    items,
    normalize(value) {
        return String(value ?? '')
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .toLowerCase();
    },
    get results() {
        const term = this.normalize(this.query);

        if (! term) {
            return [];
        }

        return this.items
            .filter((item) => this.normalize(item.search).includes(term))
            .slice(0, 12);
    },
    get recentItems() {
        return this.items.filter((item) => item.recent).slice(0, 4);
    },
    get popularItems() {
        return this.items.filter((item) => item.popular && item.type === 'Componente').slice(0, 6);
    },
    get exampleItems() {
        return this.items.filter((item) => item.type === 'Exemplo').slice(0, 4);
    },
    get hasResults() {
        return this.results.length > 0;
    },
    select(index = this.activeIndex) {
        const item = this.results[index];

        this.go(item);
    },
    go(item) {
        if (item?.url) window.location.href = item.url;
    },
    next() {
        if (! this.hasResults) {
            return;
        }

        this.activeIndex = (this.activeIndex + 1) % this.results.length;
    },
    previous() {
        if (! this.hasResults) {
            return;
        }

        this.activeIndex = this.activeIndex === 0 ? this.results.length - 1 : this.activeIndex - 1;
    },
}));

Alpine.data('componentPlayground', (slug) => ({
    slug,
    variant: 'primary',
    size: 'md',
    label: slug === 'badge' ? 'Disponível' : (slug === 'modal' ? 'Confirmar proposta' : (slug === 'table' ? 'Clientes' : 'Salvar alterações')),
    loading: false,
    disabled: false,
    variants: slug === 'badge'
        ? ['primary', 'success', 'warning', 'danger', 'info', 'purple', 'light']
        : ['primary', 'secondary', 'accent', 'danger', 'success', 'info', 'purple', 'outline', 'ghost'],
    sizes: slug === 'button' || slug === 'badge' ? ['sm', 'md', 'lg'] : [],
    get buttonClass() {
        const variants = {
            primary: 'bg-[#5574c9] text-white hover:bg-[#4663b5]',
            secondary: 'bg-[#2e314a] text-white',
            accent: 'bg-[#fdb82e] text-[#2e314a]',
            danger: 'bg-[#e84586] text-white',
            success: 'bg-[#79c8bc] text-[#12332d]',
            info: 'bg-[#43bee3] text-[#12313a]',
            purple: 'bg-[#895fc4] text-white',
            outline: 'border border-[#5574c9] bg-transparent text-[#5574c9]',
            ghost: 'bg-transparent text-[#2e314a] dark:text-slate-100',
        };
        const sizes = { sm: 'px-3 py-2 text-xs', md: 'px-4 py-2.5 text-sm', lg: 'px-5 py-3 text-base' };

        return `inline-flex items-center gap-2 rounded-lg font-semibold transition disabled:cursor-not-allowed disabled:opacity-50 ${variants[this.variant] ?? variants.primary} ${sizes[this.size] ?? sizes.md}`;
    },
    get badgeClass() {
        const variants = {
            primary: 'border-[#5574c9]/25 bg-[#5574c9]/10 text-[#5574c9]',
            success: 'border-[#79c8bc]/40 bg-[#79c8bc]/15 text-emerald-700 dark:text-emerald-200',
            warning: 'border-[#ff7d3d]/35 bg-[#ff7d3d]/12 text-orange-700 dark:text-orange-200',
            danger: 'border-[#e84586]/35 bg-[#e84586]/12 text-rose-700 dark:text-rose-200',
            info: 'border-[#43bee3]/35 bg-[#43bee3]/12 text-cyan-700 dark:text-cyan-200',
            purple: 'border-[#895fc4]/35 bg-[#895fc4]/12 text-violet-700 dark:text-violet-200',
            light: 'border-slate-200 bg-slate-50 text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200',
        };
        const sizes = { sm: 'px-2 py-1 text-[0.68rem]', md: 'px-2.5 py-1 text-xs', lg: 'px-3 py-1.5 text-sm' };

        return `inline-flex items-center rounded-full border font-bold ${variants[this.variant] ?? variants.primary} ${sizes[this.size] ?? sizes.md}`;
    },
    get code() {
        if (this.slug === 'button') {
            return `<x-sampaui::button variant="${this.variant}" size="${this.size}"${this.loading ? ' loading' : ''}${this.disabled ? ' disabled' : ''}>\n    ${this.label}\n</x-sampaui::button>`;
        }

        if (this.slug === 'input') {
            return `<x-sampaui::input name="name" label="${this.label}" icon="person"${this.disabled ? ' disabled' : ''} />`;
        }

        if (this.slug === 'select') {
            return `<x-sampaui::select name="stage" label="${this.label}" :options="$stages"${this.disabled ? ' disabled' : ''} />`;
        }

        if (this.slug === 'badge') {
            return `<x-sampaui::badge variant="${this.variant}" size="${this.size}">\n    ${this.label}\n</x-sampaui::badge>`;
        }

        if (this.slug === 'table') {
            return `<x-sampaui::table title="${this.label}" searchable selectable per-page="10" :columns="$columns" :rows="$rows" />`;
        }

        return `<x-sampaui::modal model="confirming" title="${this.label}">\n    Confirme a ação antes de continuar.\n</x-sampaui::modal>`;
    },
}));

Livewire.start();
