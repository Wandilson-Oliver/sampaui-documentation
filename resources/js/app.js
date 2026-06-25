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
    modalOpen: false,
    variant: 'primary',
    size: 'md',
    label: slug === 'badge' ? 'Disponível' : (slug === 'modal' ? 'Confirmar proposta' : (slug === 'table' ? 'Clientes' : 'Salvar alterações')),
    loading: false,
    disabled: false,
    error: false,
    full: false,
    icon: slug === 'button' ? 'check2-circle' : '',
    variants: slug === 'badge'
        ? ['primary', 'success', 'warning', 'danger', 'info', 'purple', 'light']
        : ['primary', 'secondary', 'accent', 'danger', 'success', 'info', 'purple', 'outline', 'ghost'],
    sizes: ['sm', 'md', 'lg'],
    get supportsVariant() {
        return ['button', 'badge'].includes(this.slug);
    },
    get supportsSize() {
        return ['button', 'badge'].includes(this.slug);
    },
    get supportsIcon() {
        return ['button', 'badge', 'input'].includes(this.slug);
    },
    get supportsLoading() {
        return ['button', 'input', 'select', 'table', 'modal'].includes(this.slug);
    },
    get supportsError() {
        return ['input', 'select'].includes(this.slug);
    },
    get supportsFull() {
        return this.slug === 'button';
    },
    get code() {
        if (this.slug === 'button') {
            return `<x-sampaui::button variant="${this.variant}" size="${this.size}"${this.icon ? ` icon="${this.icon}"` : ''}${this.loading ? ' loading' : ''}${this.disabled ? ' disabled' : ''}${this.full ? ' full' : ''}>\n    ${this.label}\n</x-sampaui::button>`;
        }

        if (this.slug === 'input') {
            return `<x-sampaui::input name="name" label="${this.label}" icon="${this.icon || 'person'}"${this.error ? ' error="Informe o nome completo."' : ''}${this.disabled ? ' disabled' : ''}${this.loading ? ' loading' : ''} />`;
        }

        if (this.slug === 'select') {
            return `<x-sampaui::select name="stage" label="${this.label}" :options="$stages"${this.error ? ' error="Selecione uma etapa."' : ''}${this.disabled ? ' disabled' : ''}${this.loading ? ' loading' : ''} />`;
        }

        if (this.slug === 'badge') {
            return `<x-sampaui::badge variant="${this.variant}" size="${this.size}"${this.icon ? ` icon="${this.icon}"` : ''}>\n    ${this.label}\n</x-sampaui::badge>`;
        }

        if (this.slug === 'table') {
            return `<x-sampaui::table title="${this.label}" searchable selectable export-href="/exports/clientes.csv"${this.loading ? ' loading' : ''} per-page="10" :columns="$columns" :rows="$rows" />`;
        }

        return `<x-sampaui::modal model="confirming" title="${this.label}">\n    Confirme a ação antes de continuar.\n</x-sampaui::modal>`;
    },
}));

Livewire.start();
