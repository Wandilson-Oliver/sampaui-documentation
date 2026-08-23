export function registerPlayground(Alpine) {
    Alpine.data('playgroundShell', (templatesData = {}, config = {}) => ({
        templates: templatesData || {},
        config: config || {},
        activeTemplate: 'components',
        activeTab: 'html',
        layout: 'horizontal',
        viewport: 'desktop',
        canvasBg: 'neutral',
        html: '',
        css: '',
        js: '',
        livewire: '',
        splitPercent: 50,
        isDragging: false,
        onMouseMoveHandler: null,
        onMouseUpHandler: null,
        copied: false,
        formatted: false,
        isCompiling: false,
        compileError: null,
        savedFeedback: false,
        autocompleteVisible: false,
        autocompleteSuggestions: [],
        autocompleteIndex: 0,
        autocompleteQuery: '',

        devices: {
            desktop: { name: 'Desktop Fluido (100%)', width: '100%', type: 'desktop', label: '100% (Desktop)' },
            macbook_pro_16: { name: 'MacBook Pro 16" (1728px)', width: '1728px', type: 'desktop', label: '1728px (MacBook Pro 16")' },
            macbook_pro_14: { name: 'MacBook Pro 14" (1512px)', width: '1512px', type: 'desktop', label: '1512px (MacBook Pro 14")' },
            macbook_air: { name: 'MacBook Air 13" (1280px)', width: '1280px', type: 'desktop', label: '1280px (MacBook Air 13")' },
            ipad_pro_12: { name: 'iPad Pro 12.9" (1024px)', width: '1024px', type: 'tablet', label: '1024px (iPad Pro 12.9")' },
            ipad_air: { name: 'iPad Air 11" (834px)', width: '834px', type: 'tablet', label: '834px (iPad Air 11")' },
            ipad_mini: { name: 'iPad Mini (744px)', width: '744px', type: 'tablet', label: '744px (iPad Mini)' },
            iphone_17_pro_max: { name: 'iPhone 17 Pro Max (440px)', width: '440px', type: 'mobile', label: '440px (iPhone 17 Pro Max)' },
            iphone_17: { name: 'iPhone 17 (393px)', width: '393px', type: 'mobile', label: '393px (iPhone 17)' },
            iphone_16_pro_max: { name: 'iPhone 16 Pro Max (440px)', width: '440px', type: 'mobile', label: '440px (iPhone 16 Pro Max)' },
            iphone_16: { name: 'iPhone 16 (393px)', width: '393px', type: 'mobile', label: '393px (iPhone 16)' },
            iphone_15_pro_max: { name: 'iPhone 15 Pro Max (430px)', width: '430px', type: 'mobile', label: '430px (iPhone 15 Pro Max)' },
            iphone_15: { name: 'iPhone 15 (393px)', width: '393px', type: 'mobile', label: '393px (iPhone 15)' },
        },
        currentDevice: 'desktop',

        autocompleteList: [
            // Componentes Oficiais SampaUI
            { label: '<x-sampaui::card>', type: 'sampaui', desc: 'Card container oficial com slots', icon: 'bi-card-heading', snippet: '<x-sampaui::card title="Título do Card" description="Descrição auxiliar">\n  <p class="text-sm text-slate-600">Conteúdo do card.</p>\n  <x-slot:actions>\n    <x-sampaui::button size="sm">Ação</x-sampaui::button>\n  </x-slot:actions>\n</x-sampaui::card>' },
            { label: '<x-sampaui::button>', type: 'sampaui', desc: 'Botão com variantes, ícone e loading', icon: 'bi-hand-index-thumb', snippet: '<x-sampaui::button variant="primary" icon="check2-circle" wire:click="save">Salvar Alterações</x-sampaui::button>' },
            { label: '<x-sampaui::input>', type: 'sampaui', desc: 'Campo de texto com label, erro e ícone', icon: 'bi-input-cursor-text', snippet: '<x-sampaui::input name="nome" label="Nome Completo" placeholder="Digite seu nome..." icon="person" required />' },
            { label: '<x-sampaui::textarea>', type: 'sampaui', desc: 'Campo de texto multilinha com auto-resize', icon: 'bi-textarea-resize', snippet: '<x-sampaui::textarea name="obs" label="Observações" rows="3" auto-resize counter maxlength="300" placeholder="Escreva aqui..." />' },
            { label: '<x-sampaui::select>', type: 'sampaui', desc: 'Select padrão com opções', icon: 'bi-menu-button-wide', snippet: '<x-sampaui::select name="status" label="Status" :options="[\'active\' => \'Ativo\', \'pending\' => \'Pendente\']" />' },
            { label: '<x-sampaui::select-search>', type: 'sampaui', desc: 'Select com busca local integrada', icon: 'bi-search', snippet: '<x-sampaui::select-search name="cliente_id" label="Cliente" placeholder="Buscar cliente..." :options="[\'1\' => \'Ana Souza\', \'2\' => \'Bruno Lima\']" />' },
            { label: '<x-sampaui::select-multiple>', type: 'sampaui', desc: 'Select múltiplo com tags e busca', icon: 'bi-tags', snippet: '<x-sampaui::select-multiple name="perfis" label="Perfis de Acesso" :options="[\'admin\' => \'Administrador\', \'editor\' => \'Editor\', \'viewer\' => \'Visualizador\']" />' },
            { label: '<x-sampaui::checkbox>', type: 'sampaui', desc: 'Checkbox estilizado com label', icon: 'bi-check-square', snippet: '<x-sampaui::checkbox name="termos" label="Aceito os termos de serviço" checked />' },
            { label: '<x-sampaui::toggle>', type: 'sampaui', desc: 'Interruptor toggle switch animado', icon: 'bi-toggle-on', snippet: '<x-sampaui::toggle name="notificacoes" label="Receber notificações por email" checked />' },
            { label: '<x-sampaui::radio>', type: 'sampaui', desc: 'Radio button selecionável', icon: 'bi-ui-radios', snippet: '<x-sampaui::radio name="opcao" label="Opção Principal" value="1" checked />' },
            { label: '<x-sampaui::pin>', type: 'sampaui', desc: 'Entrada de código PIN / OTP 2FA', icon: 'bi-shield-lock', snippet: '<x-sampaui::pin name="code" :length="6" label="Código de Verificação" />' },
            { label: '<x-sampaui::date-picker>', type: 'sampaui', desc: 'Seletor de data e período', icon: 'bi-calendar-date', snippet: '<x-sampaui::date-picker name="data_evento" label="Data do Evento" placeholder="Selecione a data..." />' },
            { label: '<x-sampaui::file-upload>', type: 'sampaui', desc: 'Upload de arquivo com drag-and-drop', icon: 'bi-cloud-arrow-up', snippet: '<x-sampaui::file-upload name="documento" label="Anexar Documento (PDF)" accept=".pdf" />' },
            { label: '<x-sampaui::avatar-upload>', type: 'sampaui', desc: 'Upload de foto de perfil com preview', icon: 'bi-person-bounding-box', snippet: '<x-sampaui::avatar-upload name="avatar" label="Foto de Perfil" />' },
            { label: '<x-sampaui::phone>', type: 'sampaui', desc: 'Input de telefone com máscara', icon: 'bi-telephone', snippet: '<x-sampaui::phone name="whatsapp" label="WhatsApp" placeholder="(11) 99999-9999" />' },
            { label: '<x-sampaui::modal>', type: 'sampaui', desc: 'Janela modal Livewire com backdrop', icon: 'bi-window-stack', snippet: '<x-sampaui::modal model="showModal" title="Título do Modal" subtitle="Subtítulo descritivo">\n  <p>Conteúdo da janela modal.</p>\n  <x-slot:actions>\n    <x-sampaui::button variant="outline" wire:click="$set(\'showModal\', false)">Cancelar</x-sampaui::button>\n    <x-sampaui::button variant="primary" wire:click="save">Confirmar</x-sampaui::button>\n  </x-slot:actions>\n</x-sampaui::modal>' },
            { label: '<x-sampaui::drawer>', type: 'sampaui', desc: 'Gaveta / painel lateral deslizante', icon: 'bi-layout-sidebar-inset-reverse', snippet: '<x-sampaui::drawer model="showDrawer" placement="right" title="Filtros">\n  <p>Conteúdo do painel lateral.</p>\n  <x-slot:actions>\n    <x-sampaui::button variant="primary" wire:click="$set(\'showDrawer\', false)">Aplicar</x-sampaui::button>\n  </x-slot:actions>\n</x-sampaui::drawer>' },
            { label: '<x-sampaui::table>', type: 'sampaui', desc: 'DataTable com busca, ordenação e paginação', icon: 'bi-table', snippet: '<x-sampaui::table\n  title="Clientes"\n  searchable\n  selectable\n  :columns="[\'name\' => [\'label\' => \'Nome\', \'sortable\' => true], \'status\' => \'Status\']"\n  :rows="[[\'id\' => 1, \'name\' => \'Ana Souza\', \'status\' => \'Ativo\']]"\n/>' },
            { label: '<x-sampaui::badge>', type: 'sampaui', desc: 'Badge indicativo de status e contadores', icon: 'bi-patch-check', snippet: '<x-sampaui::badge variant="primary" icon="check2">Ativo</x-sampaui::badge>' },
            { label: '<x-sampaui::alert>', type: 'sampaui', desc: 'Alerta informativo com variantes e ícone', icon: 'bi-exclamation-triangle', snippet: '<x-sampaui::alert variant="info" title="Atenção" icon="info-circle">\n  Mensagem detalhada do alerta.\n</x-sampaui::alert>' },
            { label: '<x-sampaui::toast>', type: 'sampaui', desc: 'Container global de notificações Toast', icon: 'bi-bell', snippet: '<x-sampaui::toast position="top-right" :max="5" />' },
            { label: '<x-sampaui::dropdown>', type: 'sampaui', desc: 'Menu dropdown de ações', icon: 'bi-menu-app', snippet: '<x-sampaui::dropdown label="Ações">\n  <x-sampaui::dropdown-item icon="pencil" wire:click="edit">Editar</x-sampaui::dropdown-item>\n  <x-sampaui::dropdown-item icon="trash" variant="danger" wire:click="delete">Excluir</x-sampaui::dropdown-item>\n</x-sampaui::dropdown>' },
            { label: '<x-sampaui::tabs>', type: 'sampaui', desc: 'Abas de navegação dinâmica', icon: 'bi-segmented-nav', snippet: '<x-sampaui::tabs :tabs="[\'geral\' => \'Geral\', \'config\' => \'Configurações\']" active="geral">\n  <x-sampaui::tab-panel name="geral">Conteúdo da aba Geral.</x-sampaui::tab-panel>\n  <x-sampaui::tab-panel name="config">Conteúdo de Configurações.</x-sampaui::tab-panel>\n</x-sampaui::tabs>' },
            { label: '<x-sampaui::accordion>', type: 'sampaui', desc: 'Lista expansível tipo acordeão', icon: 'bi-chevron-bar-expand', snippet: '<x-sampaui::accordion :items="[\n  [\'title\' => \'Item 1\', \'content\' => \'Conteúdo detalhado 1\', \'open\' => true],\n  [\'title\' => \'Item 2\', \'content\' => \'Conteúdo detalhado 2\']\n]" />' },
            { label: '<x-sampaui::avatar>', type: 'sampaui', desc: 'Avatar com foto ou iniciais e status', icon: 'bi-person-circle', snippet: '<x-sampaui::avatar name="Ana Clara" size="md" status="online" />' },
            { label: '<x-sampaui::indicator>', type: 'sampaui', desc: 'Indicador visual de presença/conexão', icon: 'bi-circle-fill', snippet: '<x-sampaui::indicator variant="primary" pulse label="Online" />' },
            { label: '<x-sampaui::stat-card>', type: 'sampaui', desc: 'Card de métricas e KPIs', icon: 'bi-graph-up-arrow', snippet: '<x-sampaui::stat-card title="Faturamento Mensal" value="R$ 48.900,00" icon="currency-dollar" trend="+18.4%" />' },
            { label: '<x-sampaui::skeleton>', type: 'sampaui', desc: 'Placeholder de carregamento animado', icon: 'bi-slash-square', snippet: '<x-sampaui::skeleton :lines="3" />' },
            { label: '<x-sampaui::empty-state>', type: 'sampaui', desc: 'Estado vazio com ícone e ações', icon: 'bi-inbox', snippet: '<x-sampaui::empty-state title="Nenhum registro" description="Adicione seu primeiro item.">\n  <x-slot:actions>\n    <x-sampaui::button icon="plus">Novo Item</x-sampaui::button>\n  </x-slot:actions>\n</x-sampaui::empty-state>' },
            { label: '<x-sampaui::chat-message>', type: 'sampaui', desc: 'Balão de mensagem no chat', icon: 'bi-chat-dots', snippet: '<x-sampaui::chat-message sender="Ana Souza" time="10:42" message="Olá! Tudo bem?" />' },
            { label: '<x-sampaui::chat-composer>', type: 'sampaui', desc: 'Compositor de mensagens com envio', icon: 'bi-send', snippet: '<x-sampaui::chat-composer placeholder="Digite sua mensagem..." wire-model="message" send-action="send" />' },

            // Diretivas Blade
            { label: '@if ... @endif', type: 'blade', desc: 'Condicional Blade', icon: 'bi-code-square', snippet: '@if ($condicao)\n  <div>Condição verdadeira</div>\n@endif' },
            { label: '@foreach ... @endforeach', type: 'blade', desc: 'Loop de repetição Blade', icon: 'bi-repeat', snippet: '@foreach ($itens as $item)\n  <div>{{ $item }}</div>\n@endforeach' },
            { label: '@props', type: 'blade', desc: 'Propriedades de componente Blade', icon: 'bi-sliders', snippet: "@props(['title' => '', 'variant' => 'primary'])" },
            { label: '@csrf', type: 'blade', desc: 'Token de proteção CSRF', icon: 'bi-shield-lock', snippet: '@csrf' },
            { label: '@php ... @endphp', type: 'blade', desc: 'Bloco de código PHP', icon: 'bi-filetype-php', snippet: "@php\n  $variavel = 'valor';\n@endphp" },

            // Tags HTML Padrão
            { label: '<div>', type: 'html', desc: 'Container com layout flex', icon: 'bi-bounding-box', snippet: '<div class="flex items-center justify-between gap-4">\n  \n</div>' },
            { label: '<button>', type: 'html', desc: 'Botão HTML estilizado', icon: 'bi-ui-checks', snippet: '<button type="button" class="px-4 py-2 bg-primary text-white rounded-xl font-medium shadow-sm hover:bg-primary/90 transition cursor-pointer">\n  Clique Aqui\n</button>' },
            { label: '<span>', type: 'html', desc: 'Elemento inline de texto', icon: 'bi-type', snippet: '<span class="text-sm font-semibold text-primary">Texto em destaque</span>' },
            { label: '<input>', type: 'html', desc: 'Input de texto HTML', icon: 'bi-input-cursor', snippet: '<input type="text" class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none" placeholder="Digite aqui..." />' },
            { label: '<h1>', type: 'html', desc: 'Título principal H1', icon: 'bi-type-h1', snippet: '<h1 class="text-2xl font-bold text-slate-900 tracking-tight">Título Principal</h1>' },
            { label: '<p>', type: 'html', desc: 'Parágrafo de texto padrão', icon: 'bi-text-paragraph', snippet: '<p class="text-sm leading-relaxed text-slate-600">Descrição do conteúdo aqui.</p>' },
            { label: '<a>', type: 'html', desc: 'Link de navegação com hover', icon: 'bi-link-45deg', snippet: '<a href="#" class="text-sm font-medium text-primary hover:underline transition">Saiba mais &rarr;</a>' },
            { label: '<form>', type: 'html', desc: 'Formulário completo com CSRF', icon: 'bi-card-checklist', snippet: '<form method="POST" action="" class="space-y-4">\n  @csrf\n  \n</form>' },

            // Classes Utilitárias Tailwind CSS
            { label: 'class="flex items-center justify-between"', type: 'tailwind', desc: 'Flexbox horizontal com separação', icon: 'bi-distribute-horizontal', snippet: 'class="flex items-center justify-between gap-4"' },
            { label: 'class="grid grid-cols-2 gap-4"', type: 'tailwind', desc: 'Grid responsivo de 2 colunas', icon: 'bi-grid', snippet: 'class="grid grid-cols-1 sm:grid-cols-2 gap-4"' },
            { label: 'class="grid grid-cols-3 gap-6"', type: 'tailwind', desc: 'Grid responsivo de 3 colunas', icon: 'bi-grid-3x3', snippet: 'class="grid grid-cols-1 md:grid-cols-3 gap-6"' },
            { label: 'class="bg-primary text-white rounded-xl shadow-lg"', type: 'tailwind', desc: 'Card de destaque SampaUI', icon: 'bi-palette', snippet: 'class="bg-primary text-white rounded-xl p-6 shadow-lg shadow-primary/20"' },
            { label: 'class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"', type: 'tailwind', desc: 'Card moderno em superfície clara', icon: 'bi-square', snippet: 'class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"' },
            { label: 'class="min-h-screen flex items-center justify-center p-6"', type: 'tailwind', desc: 'Container centralizado full-screen', icon: 'bi-arrows-fullscreen', snippet: 'class="min-h-screen flex items-center justify-center bg-slate-50 p-6"' },
            { label: 'class="transition-all duration-300 hover:scale-105"', type: 'tailwind', desc: 'Efeito de escala no hover', icon: 'bi-magic', snippet: 'class="transition-all duration-300 hover:scale-105 cursor-pointer"' },

            // Snippets CSS
            { label: 'display: flex; align-items: center;', type: 'css', desc: 'Flexbox centralizado puro', icon: 'bi-filetype-css', snippet: 'display: flex;\nalign-items: center;\njustify-content: center;' },
            { label: 'background: linear-gradient(...)', type: 'css', desc: 'Gradiente de cores moderno', icon: 'bi-paint-bucket', snippet: 'background: linear-gradient(135deg, #2FAFD3 0%, #7C5CFC 100%);' },
            { label: 'box-shadow: 0 10px 30px rgba(...)', type: 'css', desc: 'Sombra suave de elevação', icon: 'bi-box-seam', snippet: 'box-shadow: 0 10px 30px -5px rgba(47, 175, 211, 0.3);' },
            { label: 'border-radius: 1rem;', type: 'css', desc: 'Bordas arredondadas', icon: 'bi-app', snippet: 'border-radius: 1rem;' },

            // Snippets JavaScript
            { label: 'console.log()', type: 'js', desc: 'Log no console do navegador', icon: 'bi-terminal', snippet: "console.log('SampaUI Playground:', data);" },
            { label: 'document.addEventListener(...)', type: 'js', desc: 'Ouvinte de evento DOM', icon: 'bi-lightning', snippet: "document.addEventListener('DOMContentLoaded', () => {\n  console.log('Pronto!');\n});" },
            { label: 'fetch() API call', type: 'js', desc: 'Requisição assíncrona Fetch', icon: 'bi-arrow-left-right', snippet: "fetch('/api/dados')\n  .then(res => res.json())\n  .then(data => {\n    console.log(data);\n  });" },
            { label: 'setTimeout(...)', type: 'js', desc: 'Temporizador assíncrono', icon: 'bi-clock', snippet: "setTimeout(() => {\n  \n}, 1000);" },
            
            // Snippets Livewire 4+ / Volt Single-File
            { label: 'new class extends Component', type: 'livewire', desc: 'Componente Single-File Volt do Livewire', icon: 'bi-lightning-charge-fill', snippet: "<?php\n\nuse Livewire\\Volt\\Component;\n\nnew class extends Component {\n    public bool $showModal = false;\n\n    public function save()\n    {\n        // Salvar dados\n    }\n};" },
            { label: 'public bool $showModal = false;', type: 'livewire', desc: 'Propriedade booleana reativa Livewire', icon: 'bi-toggle-on', snippet: 'public bool $showModal = false;' },
            { label: 'public string $search = "";', type: 'livewire', desc: 'Propriedade de busca reativa Livewire', icon: 'bi-fonts', snippet: 'public string $search = "";' },
            { label: 'public function save()', type: 'livewire', desc: 'Método de ação reativa Livewire', icon: 'bi-play-circle', snippet: "public function save()\n{\n    $this->showModal = false;\n}" }
        ],

        init() {
            const saved = localStorage.getItem('sampaui_playground_state_v9');
            if (saved) {
                try {
                    const parsed = JSON.parse(saved);
                    this.html = typeof parsed.html === 'string' ? parsed.html : (this.templates['components']?.html || '');
                    this.css = typeof parsed.css === 'string' ? parsed.css : '';
                    this.js = typeof parsed.js === 'string' ? parsed.js : '';
                    this.livewire = typeof parsed.livewire === 'string' ? parsed.livewire : (this.templates[parsed.activeTemplate || 'components']?.livewire || '');
                    this.layout = parsed.layout || 'horizontal';
                    this.viewport = parsed.viewport || 'desktop';
                    this.canvasBg = parsed.canvasBg || 'neutral';
                    this.activeTemplate = parsed.activeTemplate || 'components';
                    this.activeTab = parsed.activeTab || 'html';
                    this.currentDevice = parsed.currentDevice || 'desktop';
                    this.splitPercent = typeof parsed.splitPercent === 'number' ? parsed.splitPercent : 50;
                } catch (e) {
                    this.loadTemplate('components');
                }
            } else {
                this.loadTemplate('components');
            }

            this.$nextTick(() => {
                this.updatePreview();
            });
        },

        startDragging(e) {
            e.preventDefault();
            this.isDragging = true;
            document.body.style.userSelect = 'none';
            document.body.style.cursor = this.layout === 'horizontal' ? 'col-resize' : 'row-resize';

            this.onMouseMoveHandler = (event) => this.onDrag(event);
            this.onMouseUpHandler = () => this.stopDragging();

            window.addEventListener('mousemove', this.onMouseMoveHandler);
            window.addEventListener('mouseup', this.onMouseUpHandler);
            window.addEventListener('touchmove', this.onMouseMoveHandler, { passive: false });
            window.addEventListener('touchend', this.onMouseUpHandler);
        },

        onDrag(e) {
            if (!this.isDragging || !this.$refs.splitWorkspace) return;
            if (e.type === 'touchmove') {
                e.preventDefault();
            }
            const rect = this.$refs.splitWorkspace.getBoundingClientRect();

            if (this.layout === 'horizontal') {
                const clientX = e.clientX ?? e.touches?.[0]?.clientX ?? (rect.left + rect.width / 2);
                const percent = ((clientX - rect.left) / rect.width) * 100;
                this.splitPercent = Math.max(15, Math.min(85, Math.round(percent * 10) / 10));
            } else {
                const clientY = e.clientY ?? e.touches?.[0]?.clientY ?? (rect.top + rect.height / 2);
                const percent = ((clientY - rect.top) / rect.height) * 100;
                this.splitPercent = Math.max(15, Math.min(85, Math.round(percent * 10) / 10));
            }
        },

        stopDragging() {
            if (!this.isDragging) return;
            this.isDragging = false;
            document.body.style.userSelect = '';
            document.body.style.cursor = '';

            if (this.onMouseMoveHandler) {
                window.removeEventListener('mousemove', this.onMouseMoveHandler);
                window.removeEventListener('touchmove', this.onMouseMoveHandler);
                this.onMouseMoveHandler = null;
            }
            if (this.onMouseUpHandler) {
                window.removeEventListener('mouseup', this.onMouseUpHandler);
                window.removeEventListener('touchend', this.onMouseUpHandler);
                this.onMouseUpHandler = null;
            }

            this.saveState();
        },

        setActiveTab(tab) {
            this.activeTab = tab;
            this.saveState();
        },

        setViewport(mode) {
            this.viewport = mode;
            if (mode === 'desktop') {
                this.currentDevice = 'desktop';
            } else if (mode === 'tablet') {
                this.currentDevice = 'ipad_air';
            } else if (mode === 'mobile') {
                this.currentDevice = 'iphone_16_pro_max';
            }
            this.saveState();
        },

        setDevice(key) {
            if (this.devices[key]) {
                this.currentDevice = key;
                this.viewport = this.devices[key].type;
                this.saveState();
            }
        },

        setCanvasBg(mode) {
            this.canvasBg = mode;
            this.saveState();
            this.updatePreview();
        },

        currentCode() {
            if (this.activeTab === 'html') return this.html || '';
            if (this.activeTab === 'css') return this.css || '';
            if (this.activeTab === 'js') return this.js || '';
            return this.livewire || '';
        },

        setCurrentCode(value) {
            if (this.activeTab === 'html') this.html = value;
            else if (this.activeTab === 'css') this.css = value;
            else if (this.activeTab === 'js') this.js = value;
            else this.livewire = value;
            this.debouncedUpdate();
        },

        getLineCount(text) {
            return (text || '').split('\n').length;
        },

        getLineNumbersArray(text) {
            const count = Math.max(1, (text || '').split('\n').length);
            return Array.from({ length: count }, (_, i) => i + 1);
        },

        loadTemplate(key) {
            if (!this.templates[key]) return;
            this.activeTemplate = key;
            this.html = this.templates[key].html || '';
            this.css = this.templates[key].css || '';
            this.js = this.templates[key].js || '';
            this.livewire = this.templates[key].livewire || '';
            this.saveState();
            this.updatePreview();
        },

        resetCurrentTemplate() {
            if (this.templates[this.activeTemplate]) {
                this.loadTemplate(this.activeTemplate);
            } else {
                this.loadTemplate('components');
            }
        },

        clearCode() {
            this.html = '';
            this.css = '';
            this.js = '';
            this.livewire = '';
            this.saveState();
            this.updatePreview();
        },

        toggleLayout() {
            this.layout = this.layout === 'horizontal' ? 'vertical' : 'horizontal';
            this.saveState();
        },

        formatCode() {
            let code = this.currentCode();
            if (!code || !code.trim()) return;

            if (this.activeTab === 'html') {
                let formatted = '';
                let indent = 0;
                const tab = '  ';
                const lines = code.replace(/>\s*</g, '>\n<').split('\n');

                lines.forEach((line) => {
                    const trimmed = line.trim();
                    if (!trimmed) return;

                    if (trimmed.match(/^<\/\w/)) {
                        indent = Math.max(0, indent - 1);
                    }

                    formatted += tab.repeat(indent) + trimmed + '\n';

                    if (trimmed.match(/^<\w[^>]*[^\/]>.*$/) && !trimmed.match(/^<(input|img|br|hr|meta|link)/i) && !trimmed.includes('</')) {
                        indent++;
                    }
                });
                this.setCurrentCode(formatted.trim());
            } else if (this.activeTab === 'css') {
                let formatted = code
                    .replace(/\s*\{\s*/g, ' {\n  ')
                    .replace(/\s*;\s*/g, ';\n  ')
                    .replace(/\s*\}\s*/g, '\n}\n\n')
                    .replace(/\n\s*\n\s*\n/g, '\n\n')
                    .trim();
                this.setCurrentCode(formatted);
            }

            this.formatted = true;
            setTimeout(() => this.formatted = false, 1500);
        },

        async downloadHtml() {
            const doc = await this.generateDocument();
            const blob = new Blob([doc], { type: 'text/html;charset=utf-8' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `sampaui-${this.activeTemplate || 'playground'}.html`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        },

        getViewportStyles() {
            const dev = this.devices[this.currentDevice] || this.devices['desktop'];
            if (dev.width === '100%') {
                return 'width: 100%; height: 100%;';
            }
            return `width: ${dev.width}; min-width: ${dev.width}; height: 100%; flex-shrink: 0;`;
        },

        getViewportWidthLabel() {
            const dev = this.devices[this.currentDevice] || this.devices['desktop'];
            return dev.label || '100% (Desktop)';
        },

        savedFeedback: false,

        handleKeydown(e) {
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 's') {
                e.preventDefault();
                this.saveState();
                this.updatePreview();
                this.savedFeedback = true;
                setTimeout(() => this.savedFeedback = false, 1500);
                return;
            }

            // Navegação e confirmação no menu de Autocomplete
            if (this.autocompleteVisible && this.autocompleteSuggestions.length > 0) {
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    this.autocompleteIndex = (this.autocompleteIndex + 1) % this.autocompleteSuggestions.length;
                    return;
                }
                if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    this.autocompleteIndex = (this.autocompleteIndex - 1 + this.autocompleteSuggestions.length) % this.autocompleteSuggestions.length;
                    return;
                }
                if (e.key === 'Enter' || e.key === 'Tab') {
                    e.preventDefault();
                    this.applyAutocomplete(this.autocompleteSuggestions[this.autocompleteIndex], e.target);
                    return;
                }
                if (e.key === 'Escape') {
                    e.preventDefault();
                    this.autocompleteVisible = false;
                    return;
                }
            }

            if (e.key === 'Tab') {
                e.preventDefault();
                const target = e.target;
                const start = target.selectionStart;
                const end = target.selectionEnd;
                const val = target.value;

                if (start === end) {
                    if (e.shiftKey) {
                        if (val.substring(start - 2, start) === '  ') {
                            target.value = val.substring(0, start - 2) + val.substring(start);
                            target.selectionStart = target.selectionEnd = start - 2;
                        } else if (val.substring(start - 1, start) === ' ') {
                            target.value = val.substring(0, start - 1) + val.substring(start);
                            target.selectionStart = target.selectionEnd = start - 1;
                        }
                    } else {
                        target.value = val.substring(0, start) + '  ' + val.substring(end);
                        target.selectionStart = target.selectionEnd = start + 2;
                    }
                } else {
                    const lineStart = val.lastIndexOf('\n', start - 1) + 1;
                    let lineEnd = val.indexOf('\n', end);
                    if (lineEnd === -1) lineEnd = val.length;

                    const selectedText = val.substring(lineStart, lineEnd);
                    const lines = selectedText.split('\n');

                    let newText = '';
                    if (e.shiftKey) {
                        newText = lines.map(line => line.startsWith('  ') ? line.substring(2) : (line.startsWith(' ') ? line.substring(1) : line)).join('\n');
                    } else {
                        newText = lines.map(line => '  ' + line).join('\n');
                    }

                    target.value = val.substring(0, lineStart) + newText + val.substring(lineEnd);
                    target.selectionStart = lineStart;
                    target.selectionEnd = lineStart + newText.length;
                }

                if (this.activeTab === 'html') this.html = target.value;
                if (this.activeTab === 'css') this.css = target.value;
                if (this.activeTab === 'js') this.js = target.value;

                this.debouncedUpdate();
            }
        },

        checkAutocomplete(target) {
            if (!target) return;
            const cursorPos = target.selectionStart || 0;
            const textBefore = target.value.substring(0, cursorPos);
            const match = textBefore.match(/([<@a-zA-Z0-9_:\-\.]+)\s*$/);
            const query = match ? match[1].toLowerCase() : '';

            if (query && query.length >= 1) {
                let allowedTypes = [];
                if (this.activeTab === 'html') allowedTypes = ['sampaui', 'blade', 'html', 'tailwind'];
                else if (this.activeTab === 'css') allowedTypes = ['css'];
                else if (this.activeTab === 'js') allowedTypes = ['js'];

                const filtered = this.autocompleteList.filter(item => {
                    if (!allowedTypes.includes(item.type)) return false;
                    return item.label.toLowerCase().includes(query) ||
                           item.desc.toLowerCase().includes(query) ||
                           item.snippet.toLowerCase().includes(query);
                }).slice(0, 7);

                if (filtered.length > 0) {
                    this.autocompleteSuggestions = filtered;
                    this.autocompleteQuery = query;
                    this.autocompleteIndex = 0;
                    this.autocompleteVisible = true;
                    return;
                }
            }

            this.autocompleteVisible = false;
        },

        applyAutocomplete(item, targetElement = null) {
            if (!item) return;
            const textarea = targetElement || document.querySelector(`textarea[x-show="activeTab === '${this.activeTab}'"]`);
            if (!textarea) return;

            const cursorPos = textarea.selectionStart || 0;
            const val = textarea.value || '';
            const textBefore = val.substring(0, cursorPos);
            const textAfter = val.substring(cursorPos);

            const queryLen = this.autocompleteQuery ? this.autocompleteQuery.length : 0;
            const newTextBefore = textBefore.substring(0, textBefore.length - queryLen) + item.snippet;
            const newFullText = newTextBefore + textAfter;

            if (this.activeTab === 'html') this.html = newFullText;
            else if (this.activeTab === 'css') this.css = newFullText;
            else if (this.activeTab === 'js') this.js = newFullText;
            else if (this.activeTab === 'livewire') this.livewire = newFullText;

            this.autocompleteVisible = false;
            this.saveState();
            this.updatePreview();

            this.$nextTick(() => {
                textarea.focus();
                const newCursor = newTextBefore.length;
                textarea.setSelectionRange(newCursor, newCursor);
                this.syncScroll({ target: textarea });
            });
        },

        syncScroll(e) {
            if (this.$refs.lineNumbers) {
                this.$refs.lineNumbers.scrollTop = e.target.scrollTop;
            }
            if (this.$refs.codeHighlight) {
                this.$refs.codeHighlight.scrollTop = e.target.scrollTop;
                this.$refs.codeHighlight.scrollLeft = e.target.scrollLeft;
            }
        },

        escapeHtml(str) {
            return (str || '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;');
        },

        highlightHtml(code) {
            if (!code) return '';
            let escaped = this.escapeHtml(code);

            // 1. Comentários HTML: <!-- ... -->
            escaped = escaped.replace(/(&lt;!--[\s\S]*?--&gt;)/g, '<span style="color: #6a9955; font-style: italic;">$1</span>');

            // 2. Diretivas Blade: @if, @foreach, @props, etc.
            escaped = escaped.replace(/(@(?:if|elseif|else|endif|foreach|endforeach|for|endfor|while|endwhile|switch|case|break|default|endswitch|props|php|endphp|csrf|method|include|extends|section|endsection|yield|push|endpush|stack)\b(?:\([^\)]*\))?)/g, '<span style="color: #f43f5e; font-weight: bold;">$1</span>');

            // 3. Tags HTML, SampaUI e Blade: &lt;tag attrs... &gt;
            escaped = escaped.replace(/(&lt;\/?)([a-zA-Z0-9_:\.\-]+)([\s\S]*?)(\/?&gt;)/g, (fullMatch, openTag, tagName, attrs, closeTag) => {
                const isSampa = tagName.startsWith('x-sampaui::') || tagName.startsWith('x-slot:') || tagName.startsWith('x-');
                const tagColor = isSampa ? '#c084fc' : '#38bdf8';

                let formattedAttrs = attrs;
                if (attrs && attrs.trim()) {
                    formattedAttrs = attrs.replace(/\b([a-zA-Z0-9_:@\.\-]+)(?:=("[^"\r\n]*"|'[^'\r\n]*'|`[^`\r\n]*`))?/g, (attrMatch, attrName, attrVal) => {
                        if (!attrVal) {
                            return `<span style="color: #93c5fd;">${attrName}</span>`;
                        }
                        const isClass = attrName === 'class';
                        const isWireOrAlpine = attrName.startsWith('wire:') || attrName.startsWith('x-') || attrName.startsWith('@');
                        const attrColor = isClass ? '#67e8f9' : (isWireOrAlpine ? '#f472b6' : '#93c5fd');
                        const valColor = isClass ? '#fde047' : '#86efac';

                        return `<span style="color: ${attrColor};">${attrName}</span><span style="color: #94a3b8;">=</span><span style="color: ${valColor};">${attrVal}</span>`;
                    });
                }

                return `<span style="color: #94a3b8;">${openTag}</span><span style="color: ${tagColor}; font-weight: bold;">${tagName}</span>${formattedAttrs}<span style="color: #94a3b8;">${closeTag}</span>`;
            });

            return escaped;
        },

        highlightCss(code) {
            if (!code) return '';
            let escaped = this.escapeHtml(code);
            escaped = escaped.replace(/(\/\*[\s\S]*?\*\/)/g, '<span style="color: #6a9955; font-style: italic;">$1</span>');
            escaped = escaped.replace(/([^\r\n\{\}]+)(?=\{)/g, '<span style="color: #fde047; font-weight: bold;">$1</span>');
            escaped = escaped.replace(/\b([a-zA-Z\-]+)\s*(?=:)/g, '<span style="color: #38bdf8;">$1</span>');
            escaped = escaped.replace(/(:)([^;\}]+)/g, '<span style="color: #94a3b8;">$1</span><span style="color: #86efac;">$2</span>');
            return escaped;
        },

        highlightJs(code) {
            if (!code) return '';
            let escaped = this.escapeHtml(code);
            escaped = escaped.replace(/(\/\/.*$)/gm, '<span style="color: #6a9955; font-style: italic;">$1</span>');
            escaped = escaped.replace(/(\/\*[\s\S]*?\*\/)/g, '<span style="color: #6a9955; font-style: italic;">$1</span>');
            escaped = escaped.replace(/("[^"\r\n]*"|'[^'\r\n]*'|`[^`\r\n]*`)/g, '<span style="color: #fcd34d;">$1</span>');
            escaped = escaped.replace(/\b(function|const|let|var|return|if|else|for|while|do|switch|case|break|continue|default|async|await|try|catch|finally|throw|class|extends|new|this|super|import|export|from|typeof|instanceof|void|delete|in|of)\b/g, '<span style="color: #f43f5e; font-weight: bold;">$1</span>');
            escaped = escaped.replace(/\b(true|false|null|undefined|NaN|Infinity)\b/g, '<span style="color: #c084fc; font-weight: bold;">$1</span>');
            escaped = escaped.replace(/(?<![#&a-zA-Z\-_])\b(\d+(?:\.\d+)?)\b(?![a-zA-Z\-_;])/g, '<span style="color: #4ec9b0;">$1</span>');
            return escaped;
        },

        highlightLivewire(code) {
            if (!code) return '';
            let escaped = this.escapeHtml(code);
            // 1. Strings literais
            escaped = escaped.replace(/("[^"\r\n]*"|'[^'\r\n]*'|`[^`\r\n]*`)/g, '<span style="color: #fcd34d;">$1</span>');
            // 2. Comentários
            escaped = escaped.replace(/(\/\/.*$)/gm, '<span style="color: #6a9955; font-style: italic;">$1</span>');
            escaped = escaped.replace(/(\/\*[\s\S]*?\*\/)/g, '<span style="color: #6a9955; font-style: italic;">$1</span>');
            // 3. Tags PHP
            escaped = escaped.replace(/(&lt;\?php|\?&gt;)/g, '<span style="color: #fb7185; font-weight: bold;">$1</span>');
            // 4. Palavras reservadas PHP / Livewire
            escaped = escaped.replace(/\b(use|namespace|class|extends|implements|new|public|protected|private|function|return|if|else|elseif|foreach|as|while|for|switch|case|break|default|try|catch|finally|throw|readonly|static|final|abstract|trait)\b/g, '<span style="color: #f43f5e; font-weight: bold;">$1</span>');
            // 5. Tipos
            escaped = escaped.replace(/\b(string|bool|int|float|array|object|void|mixed|null|Component|Volt)\b/g, '<span style="color: #38bdf8; font-weight: bold;">$1</span>');
            // 6. Variáveis ($this, $prop)
            escaped = escaped.replace(/(\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)/g, '<span style="color: #a78bfa;">$1</span>');
            // 7. Booleanos e números
            escaped = escaped.replace(/\b(true|false|null)\b/gi, '<span style="color: #c084fc; font-weight: bold;">$1</span>');
            escaped = escaped.replace(/(?<![#&a-zA-Z\-_])\b(\d+(?:\.\d+)?)\b(?![a-zA-Z\-_;])/g, '<span style="color: #4ec9b0;">$1</span>');
            return escaped;
        },

        getHighlightedCode() {
            if (this.activeTab === 'html') {
                return this.highlightHtml(this.html) + (this.html.endsWith('\n') ? ' ' : '');
            }
            if (this.activeTab === 'css') {
                return this.highlightCss(this.css) + (this.css.endsWith('\n') ? ' ' : '');
            }
            if (this.activeTab === 'js') {
                return this.highlightJs(this.js) + (this.js.endsWith('\n') ? ' ' : '');
            }
            return this.highlightLivewire(this.livewire) + (this.livewire.endsWith('\n') ? ' ' : '');
        },

        parseLivewireState(phpCode) {
            const state = {};
            if (!phpCode) return state;
            try {
                // Capturar propriedades públicas: public string $name = 'Valor'; public bool $open = false;
                const propRegex = /public\s+(?:[a-zA-Z0-9_|\\?]+\s+)?\$([a-zA-Z0-9_]+)(?:\s*=\s*([^;]+))?;/g;
                let match;
                while ((match = propRegex.exec(phpCode)) !== null) {
                    const key = match[1];
                    const rawVal = match[2] ? match[2].trim() : 'null';
                    let val = null;
                    if (rawVal === 'true') val = true;
                    else if (rawVal === 'false') val = false;
                    else if (rawVal === 'null') val = null;
                    else if (/^-?\d+(\.\d+)?$/.test(rawVal)) val = Number(rawVal);
                    else if (/^['"].*['"]$/.test(rawVal)) val = rawVal.slice(1, -1);
                    else if (rawVal === '[]') val = [];
                    else val = rawVal;
                    state[key] = val;
                }
            } catch (_) {}
            return state;
        },

        debouncedUpdate() {
            clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(() => {
                this.saveState();
                this.updatePreview();
            }, 250);
        },

        saveState() {
            const state = {
                html: this.html,
                css: this.css,
                js: this.js,
                livewire: this.livewire,
                layout: this.layout,
                viewport: this.viewport,
                canvasBg: this.canvasBg,
                activeTemplate: this.activeTemplate,
                activeTab: this.activeTab,
                currentDevice: this.currentDevice,
                splitPercent: this.splitPercent,
            };
            localStorage.setItem('sampaui_playground_state_v9', JSON.stringify(state));
        },

        async compileBladeCode(code) {
            if (!code || (!code.includes('<x-') && !code.includes('@'))) {
                return code;
            }

            const compileUrl = this.config?.compileUrl || '/playground/compile';
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

            try {
                this.isCompiling = true;
                const response = await fetch(compileUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ code, livewire: this.livewire || '' }),
                });

                if (!response.ok) {
                    throw new Error(`Erro HTTP ${response.status}`);
                }

                const result = await response.json();
                this.isCompiling = false;
                if (result.success) {
                    this.compileError = null;
                    return result.html;
                } else {
                    this.compileError = result.error || 'Erro na compilação do Blade';
                    return `<div class="p-6 text-danger bg-danger/10 rounded-xl border border-danger/30 m-4">
                        <h4 class="font-bold flex items-center gap-2 mb-2"><i class="bi bi-exclamation-triangle-fill"></i> Erro de Sintaxe Blade</h4>
                        <pre class="text-xs overflow-auto font-mono whitespace-pre-wrap">${result.error}</pre>
                    </div>` + result.html;
                }
            } catch (err) {
                this.isCompiling = false;
                console.warn('[Playground] Erro ao compilar Blade:', err);
                return code;
            }
        },

        async generateDocument() {
            const rawHtml = this.html || '';
            const compiledHtml = await this.compileBladeCode(rawHtml);
            const cssContent = this.css || '';
            const jsContent = this.js || '';
            const livewireStateJson = JSON.stringify(this.parseLivewireState(this.livewire || ''));
            const sampauiJsUrl = (this.config?.assetsUrl ? this.config.assetsUrl + '/sampaui.js' : '/vendor/sampaui/sampaui.js');

            const isDark = this.canvasBg === 'dark';
            const isLight = this.canvasBg === 'light';

            const htmlClass = isDark ? 'h-full dark' : (isLight ? 'h-full light' : 'h-full neutral');
            const bodyBg = isDark
                ? 'bg-[#0b0f17] text-slate-100 dark'
                : (isLight ? 'bg-white text-slate-900 light' : 'bg-slate-100 text-slate-800 neutral');

            return `<!DOCTYPE html>
<html lang="pt-BR" class="${htmlClass}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SampaUI Preview</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- Bootstrap Icons CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <!-- Silenciar aviso informativo de desenvolvimento do Tailwind CDN no preview -->
  <script>
    (function() {
      const _origWarn = console.warn;
      console.warn = function(...args) {
        if (args[0] && typeof args[0] === 'string' && args[0].includes('cdn.tailwindcss.com')) {
          return;
        }
        _origWarn.apply(console, args);
      };
    })();
  </script>

  <!-- Tailwind CSS CDN com tokens, paleta e suporte dark oficial SampaUI -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
            mono: ['"JetBrains Mono"', 'ui-monospace', 'monospace'],
          },
          colors: {
            primary: '#2FAFD3',
            secondary: '#102A43',
            accent: '#F7931E',
            danger: '#D93045',
            success: '#2CB36C',
            warning: '#FBBF24',
            info: '#4FC3E8',
            purple: '#7C5CFC',
            surface: '#FFFFFF',
            border: '#E2E8F0',
            light: '#F8FAFC',
            muted: '#CBD5E1',
            text: '#0F172A',
          },
          borderRadius: {
            'default': '0.75rem',
            'lg': '1rem',
          }
        }
      }
    }
  </script>

  <!-- Livewire / Alpine $wire Emulator para o Playground -->
  <script>
    window.rawWireState = Object.assign(${livewireStateJson}, window.rawWireState || {});
    window.wireState = window.rawWireState;

    document.addEventListener('alpine:init', () => {
      window.wireState = Alpine.reactive(window.rawWireState);
    });

    function dispatchOverlayOpen(key) {
      const candidates = [key, 'sampaui-modal-standalone-' + key, 'sampaui-drawer-standalone-' + key].filter(Boolean);
      candidates.forEach((name) => {
        window.dispatchEvent(new CustomEvent('open-modal', { detail: name }));
        document.dispatchEvent(new CustomEvent('open-modal', { detail: name }));
        window.dispatchEvent(new CustomEvent('open-modal-' + name));
        document.dispatchEvent(new CustomEvent('open-modal-' + name));
        window.dispatchEvent(new CustomEvent('open-drawer', { detail: name }));
        document.dispatchEvent(new CustomEvent('open-drawer', { detail: name }));
        window.dispatchEvent(new CustomEvent('open-drawer-' + name));
        document.dispatchEvent(new CustomEvent('open-drawer-' + name));
      });

      // Acionamento direto de componentes Alpine na árvore DOM (com validação de escopo)
      try {
        document.querySelectorAll('[x-data]').forEach((el) => {
          if (el._x_dataStack) {
            el._x_dataStack.forEach((scope) => {
              if (scope && typeof scope.openOverlay === 'function' && !scope.visible) {
                const elId = el.getAttribute('id') || el.querySelector('[id]')?.getAttribute('id') || '';
                const elModel = el.getAttribute('model') || '';
                if (!key || candidates.includes(elId) || candidates.includes(elModel) || elId.includes(key) || elModel === key) {
                  scope.openOverlay();
                }
              }
            });
          }
        });
      } catch (_) {}
    }

    function dispatchOverlayClose(key) {
      const candidates = [key, 'sampaui-modal-standalone-' + key, 'sampaui-drawer-standalone-' + key].filter(Boolean);
      candidates.forEach((name) => {
        window.dispatchEvent(new CustomEvent('close-modal', { detail: name }));
        document.dispatchEvent(new CustomEvent('close-modal', { detail: name }));
        window.dispatchEvent(new CustomEvent('close-modal-' + name));
        document.dispatchEvent(new CustomEvent('close-modal-' + name));
        window.dispatchEvent(new CustomEvent('close-drawer', { detail: name }));
        document.dispatchEvent(new CustomEvent('close-drawer', { detail: name }));
        window.dispatchEvent(new CustomEvent('close-drawer-' + name));
        document.dispatchEvent(new CustomEvent('close-drawer-' + name));
      });

      // Fechamento direto de componentes Alpine na árvore DOM (com validação de escopo)
      try {
        document.querySelectorAll('[x-data]').forEach((el) => {
          if (el._x_dataStack) {
            el._x_dataStack.forEach((scope) => {
              if (scope && typeof scope.close === 'function' && scope.visible) {
                const elId = el.getAttribute('id') || el.querySelector('[id]')?.getAttribute('id') || '';
                const elModel = el.getAttribute('model') || '';
                if (!key || candidates.includes(elId) || candidates.includes(elModel) || elId.includes(key) || elModel === key) {
                  scope.close();
                }
              }
            });
          }
        });
      } catch (_) {}
    }

    window.$wire = new Proxy({}, {
      get(target, prop) {
        if (prop === 'entangle') {
          return (name) => ({
            get live() { return window.wireState[name]; },
            set live(val) {
              window.wireState[name] = val;
              if (val) dispatchOverlayOpen(name);
              else dispatchOverlayClose(name);
            }
          });
        }
        if (prop === '$set') {
          return (key, val) => {
            window.wireState[key] = val;
            const isOpening = (val === true || val === 1 || val === '1' || val === 'true');
            if (isOpening) {
              dispatchOverlayOpen(key);
            } else {
              dispatchOverlayClose(key);
            }
          };
        }
        if (prop === '$toggle') {
          return (key) => {
            window.wireState[key] = !window.wireState[key];
            if (window.wireState[key]) {
              dispatchOverlayOpen(key);
            } else {
              dispatchOverlayClose(key);
            }
          };
        }
        if (prop === 'dispatch' || prop === '$dispatch') {
          return (eventName, payload) => {
            window.dispatchEvent(new CustomEvent(eventName, { detail: payload }));
            document.dispatchEvent(new CustomEvent(eventName, { detail: payload }));
            if (eventName === 'open-modal' || eventName === 'open-drawer') {
              dispatchOverlayOpen(typeof payload === 'string' ? payload : (payload?.id || payload?.model || ''));
            } else if (eventName === 'close-modal' || eventName === 'close-drawer') {
              dispatchOverlayClose(typeof payload === 'string' ? payload : (payload?.id || payload?.model || ''));
            }
          };
        }
        if (prop === '$get' || prop === 'get') {
          return (key) => window.wireState[key];
        }
        if (prop === '$refresh' || prop === 'refresh') {
          return () => {};
        }
        if (prop in window.wireState) {
          return window.wireState[prop];
        }
        return (...args) => {
          if (prop === 'save' || prop === 'submit' || prop === 'authenticate') {
            dispatchOverlayClose('showCustomerModal');
            dispatchOverlayClose('showFilterDrawer');
          }
        };
      },
      set(target, prop, val) {
        window.wireState[prop] = val;
        if (val) dispatchOverlayOpen(prop);
        else dispatchOverlayClose(prop);
        return true;
      }
    });

    // Interceptar cliques em botões de fechar, cancelar ou com x-on:click="close()" no preview
    document.addEventListener('click', (e) => {
      let target = e.target;
      let closeTrigger = null;
      while (target && target !== document && target.nodeType === 1) {
        const text = (target.textContent || '').trim().toLowerCase();
        const onclick = (target.getAttribute('x-on:click') || target.getAttribute('@click') || target.getAttribute('onclick') || '').toLowerCase();
        const ariaLabel = (target.getAttribute('aria-label') || '').toLowerCase();

        if (
          text === 'cancelar' ||
          text === 'fechar' ||
          ariaLabel.includes('fechar') ||
          ariaLabel.includes('close') ||
          onclick.includes('close(') ||
          onclick.includes('open = false') ||
          onclick.includes('open=false') ||
          onclick.includes('close-modal') ||
          onclick.includes('close-drawer')
        ) {
          closeTrigger = target;
          break;
        }
        target = target.parentElement;
      }

      if (closeTrigger) {
        document.querySelectorAll('[data-sampaui-overlay]').forEach((el) => {
          if (el._x_dataStack) {
            el._x_dataStack.forEach((scope) => {
              if (scope && typeof scope.close === 'function') {
                scope.close();
              }
            });
          }
        });
        dispatchOverlayClose();
      }
    }, true);

    // Interceptar cliques em wire:click no preview interativo (fase de captura)
    document.addEventListener('click', (e) => {
      let target = e.target;
      let btn = null;
      while (target && target !== document && target.nodeType === 1) {
        if (target.hasAttribute && target.hasAttribute('wire:click')) {
          btn = target;
          break;
        }
        target = target.parentElement;
      }
      if (!btn) return;
      const rawAction = btn.getAttribute('wire:click') || '';
      const action = rawAction.trim();

      if (action.startsWith('$set(')) {
        e.preventDefault();
        const inside = action.slice(5, action.endsWith(')') ? -1 : undefined);
        const commaIdx = inside.indexOf(',');
        if (commaIdx !== -1) {
          const key = inside.slice(0, commaIdx).trim().replace(/^['"]|['"]$/g, '');
          const rawVal = inside.slice(commaIdx + 1).trim().replace(/^['"]|['"]$/g, '');
          const val = (rawVal === 'true') ? true : ((rawVal === 'false') ? false : (isNaN(Number(rawVal)) ? rawVal : Number(rawVal)));
          window.$wire.$set(key, val);
          return;
        }
      }

      if (action.startsWith('$toggle(')) {
        e.preventDefault();
        const key = action.slice(8, action.endsWith(')') ? -1 : undefined).trim().replace(/^['"]|['"]$/g, '');
        window.$wire.$toggle(key);
        return;
      }

      if (action.startsWith('$dispatch(') || action.startsWith('dispatch(')) {
        e.preventDefault();
        const start = action.indexOf('(');
        const inside = action.slice(start + 1, action.endsWith(')') ? -1 : undefined);
        const commaIdx = inside.indexOf(',');
        if (commaIdx !== -1) {
          const evName = inside.slice(0, commaIdx).trim().replace(/^['"]|['"]$/g, '');
          const rawParam = inside.slice(commaIdx + 1).trim();
          let param = rawParam.replace(/^['"]|['"]$/g, '');
          if (rawParam.startsWith('{')) {
            try { param = JSON.parse(rawParam.replace(/'/g, '"')); } catch (_) {}
          }
          window.$wire.dispatch(evName, param);
        } else {
          window.$wire.dispatch(inside.trim().replace(/^['"]|['"]$/g, ''));
        }
        return;
      }

      if (action.startsWith('openModal(') || action.startsWith('openDrawer(')) {
        e.preventDefault();
        const key = action.slice(action.indexOf('(') + 1, action.endsWith(')') ? -1 : undefined).trim().replace(/^['"]|['"]$/g, '') || 'modal';
        dispatchOverlayOpen(key);
        return;
      }

      // Propriedade booleana direta (ex: wire:click="showCustomerModal" ou wire:click="showFilterDrawer")
      if (action in window.wireState || action === 'showCustomerModal' || action === 'showFilterDrawer') {
        e.preventDefault();
        window.$wire.$set(action, !window.wireState[action]);
        return;
      }

      // Método genérico Livewire: save, submit, toggleConnect, etc.
      e.preventDefault();
      const methodName = action.replace(/\(.*?\)$/, '').trim();
      if (typeof window.$wire[methodName] === 'function') {
        window.$wire[methodName]();
      } else {
        if (methodName === 'save' || methodName === 'submit' || methodName === 'authenticate') {
          dispatchOverlayClose('showCustomerModal');
          dispatchOverlayClose('showFilterDrawer');
        }
      }
    }, true);
  </script>

  <!-- SampaUI Runtime & Alpine.js -->
  <script src="${sampauiJsUrl}"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

  <style>
    [x-cloak] {
      display: none !important;
    }
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      margin: 0;
      padding: 0;
      min-height: 100%;
      -webkit-font-smoothing: antialiased;
    }
    html.dark, html.dark body {
      background-color: #0b0f17 !important;
      color: #f0f6fc !important;
    }
    html.dark .bg-slate-50, html.dark .bg-slate-100, html.dark .bg-white {
      background-color: #161b22 !important;
      border-color: #30363d !important;
      color: #f0f6fc !important;
    }
    html.dark .text-slate-800, html.dark .text-slate-900, html.dark .text-secondary {
      color: #f0f6fc !important;
    }
    html.dark .text-slate-500, html.dark .text-slate-600 {
      color: #8b949e !important;
    }
    html.dark .border-slate-200, html.dark .border-slate-100 {
      border-color: #30363d !important;
    }
    html.light, html.light body {
      background-color: #ffffff !important;
      color: #0f172a !important;
    }
    html.neutral, html.neutral body {
      background-color: #f1f5f9 !important;
      color: #1e293b !important;
    }
    ${cssContent}
  </style>
</head>
<body class="h-full ${bodyBg} antialiased selection:bg-primary/30">
  ${compiledHtml}

  <script>
    try {
      ${jsContent}
    } catch (err) {
      console.error('[Preview JS Error]:', err);
    }
  </script>
</body>
</html>`;
        },

        async updatePreview() {
            if (!this.$refs.previewFrame) return;
            const doc = await this.generateDocument();
            this.$refs.previewFrame.srcdoc = doc;
        },

        async copyCode() {
            const code = this.currentCode();
            try {
                await navigator.clipboard.writeText(code);
            } catch {
                const ta = document.createElement('textarea');
                ta.value = code;
                document.body.appendChild(ta);
                ta.select();
                document.execCommand('copy');
                document.body.removeChild(ta);
            }
            this.copied = true;
            setTimeout(() => this.copied = false, 1800);
        },

        async openInNewWindow() {
            const fullDoc = await this.generateDocument();
            const win = window.open('', '_blank');
            if (win) {
                win.document.open();
                win.document.write(fullDoc);
                win.document.close();
            }
        }
    }));
}
