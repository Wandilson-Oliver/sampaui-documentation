@extends('docs.layout', ['title' => 'Documentação SampaUI'])

@section('content')
    @php
        $sampaVersion = config('docs.version');
        $componentTotal = count($components);
        $templateTotal = count($navigationExamples ?? []);
        $roadmap = [
            ['title' => 'Mais padrões de CRM', 'copy' => 'Receitas para pipeline, atendimento, propostas e pós-venda.', 'icon' => 'diagram-3', 'status' => 'Em evolução'],
            ['title' => 'Exemplos completos', 'copy' => 'Mais fluxos Livewire documentados e prontos para adaptar.', 'icon' => 'sliders2', 'status' => 'Planejado'],
            ['title' => 'Catálogo para IA', 'copy' => 'Registry e contexto estruturado para agentes de código.', 'icon' => 'stars', 'status' => 'Contínuo'],
        ];
        $catalogFilters = [
            ['key' => 'all', 'label' => 'Todos'],
            ['key' => 'popular', 'label' => 'Popular'],
            ['key' => 'new', 'label' => 'Novos'],
            ['key' => 'forms', 'label' => 'Formulários'],
            ['key' => 'ui', 'label' => 'Design de UI'],
            ['key' => 'data', 'label' => 'Data'],
            ['key' => 'overlay', 'label' => 'Overlay'],
            ['key' => 'navigation', 'label' => 'Navigation'],
            ['key' => 'feedback', 'label' => 'Feedback'],
            ['key' => 'layout', 'label' => 'Layout'],
            ['key' => 'communication', 'label' => 'Comunicação'],
        ];
        $featuredTemplates = [
            [
                'route' => 'examples.dashboard',
                'title' => 'Dashboard Analytics',
                'category' => 'Analytics & KPI',
                'description' => 'Painel analítico completo com cards de métricas, gráficos e tabela financeira.',
                'icon' => 'grid-1x2',
            ],
            [
                'route' => 'examples.chat',
                'title' => 'Central de Atendimento & Chat',
                'category' => 'Comunicação',
                'description' => 'Layout responsivo em tempo real com busca de contatos, timeline e composer.',
                'icon' => 'chat-dots',
            ],
            [
                'route' => 'examples.advanced-table',
                'title' => 'DataTable Avançada',
                'category' => 'Dados & Listagens',
                'description' => 'Tabela rica com busca em tempo real, seleção em lote, filtros e paginação.',
                'icon' => 'table',
            ],
            [
                'route' => 'examples.users.index',
                'title' => 'Gestão de Usuários & CRUD',
                'category' => 'Administrativo',
                'description' => 'Listagem de usuários com pesquisa, filtros de status, ordenação e modais de ação.',
                'icon' => 'people',
            ],
        ];
    @endphp

    {{-- Hero Principal --}}
    <section class="doc-home-hero" aria-labelledby="home-title">
        <div class="doc-home-hero-copy">
            <span class="doc-home-logo-frame">
                <img src="{{ asset('images/logo_sampaui.png') }}" alt="SampaUI">
            </span>

            <div class="doc-home-eyebrow">
                <span class="doc-version-pill"><i class="bi bi-stars" aria-hidden="true"></i> Docs v{{ $sampaVersion }}</span>
                <span>Documentação SampaUI</span>
            </div>

            <h1 id="home-title">Componentes Blade para produtos digitais <span>profissionais.</span></h1>
            <p>
                Um kit completo para acelerar CRMs, dashboards, portais e sistemas internos com Laravel, Livewire e Tailwind — mantendo cada tela consistente, acessível e pronta para produção.
            </p>

            <div class="doc-home-actions">
                <x-sampaui::button size="sm" icon="grid" onclick="document.getElementById('componentes').scrollIntoView({behavior: 'smooth'})">
                    Ver componentes
                </x-sampaui::button>
                <x-sampaui::button size="sm" variant="outline" icon="window-sidebar" onclick="window.location='{{ route('examples.index') }}'">
                    Explorar exemplos
                </x-sampaui::button>
            </div>

            <div class="doc-quick-install" x-data="copyCode()">
                <span class="doc-quick-install-prompt">$</span>
                <code x-ref="code">composer require sampaui/sampaui</code>
                <button type="button" class="doc-quick-install-btn" x-on:click="copy('composer require sampaui/sampaui')" title="Copiar comando">
                    <i class="bi" x-bind:class="copied ? 'bi-check2 text-emerald-500' : 'bi-copy'" aria-hidden="true"></i>
                    <span x-text="copied ? 'Copiado!' : 'Copiar'"></span>
                </button>
            </div>

            <div class="doc-stack-badges" aria-label="Tecnologias compatíveis">
                @foreach ([
                    ['label' => 'Composer', 'icon' => 'box-seam'],
                    ['label' => 'Laravel 13', 'icon' => 'braces-asterisk'],
                    ['label' => 'Livewire 4', 'icon' => 'lightning-charge'],
                    ['label' => 'Tailwind 4', 'icon' => 'wind'],
                    ['label' => 'Alpine.js', 'icon' => 'code-slash'],
                ] as $technology)
                    <span><i class="bi bi-{{ $technology['icon'] }}" aria-hidden="true"></i>{{ $technology['label'] }}</span>
                @endforeach
            </div>
        </div>

        {{-- Preview ao Vivo em Mockup de Janela --}}
        <div class="doc-browser-window" aria-label="Prévia com componentes reais do SampaUI">
            <div class="doc-browser-header">
                <div class="doc-browser-dots" aria-hidden="true">
                    <span class="doc-browser-dot bg-rose-400"></span>
                    <span class="doc-browser-dot bg-amber-400"></span>
                    <span class="doc-browser-dot bg-emerald-400"></span>
                </div>
                <span class="doc-browser-title">painel.empresa.com.br</span>
                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
            </div>

            <div class="doc-home-product-preview">
                <x-sampaui::header
                    title="Dashboard"
                    subtitle="Resumo do dia"
                    search
                    notifications
                    notification-count="3"
                />

                <div class="doc-home-metric-grid">
                    <x-sampaui::card title="Novos clientes" description="Últimos 30 dias">
                        <strong class="doc-home-metric-value">248</strong>
                        <x-sampaui::badge variant="success" size="sm">+18%</x-sampaui::badge>
                    </x-sampaui::card>
                    <x-sampaui::card title="Conversão" description="Meta mensal">
                        <strong class="doc-home-metric-value">32,4%</strong>
                        <x-sampaui::progress value="72" />
                    </x-sampaui::card>
                </div>

                <x-sampaui::table
                    title="Atividade recente"
                    description="Listagem simples"
                    compact
                    :columns="['name' => 'Cliente', 'status' => 'Status', 'owner' => 'Responsável']"
                    :rows="[
                        ['name' => 'Ana Souza', 'status' => 'Ativo', 'owner' => 'Comercial'],
                        ['name' => 'Bruno Lima', 'status' => 'Pendente', 'owner' => 'Suporte'],
                        ['name' => 'Carla Martins', 'status' => 'Ativo', 'owner' => 'Implantação'],
                    ]"
                />
            </div>
        </div>
    </section>

    {{-- Visão Geral em Números --}}
    <section class="doc-home-overview" aria-label="Resumo da documentação">
        <div class="doc-home-stat-card">
            <span class="doc-home-stat-icon"><i class="bi bi-grid-fill"></i></span>
            <div class="doc-home-stat-info">
                <strong>{{ $componentTotal }}</strong>
                <span>componentes documentados</span>
            </div>
        </div>

        <div class="doc-home-stat-card">
            <span class="doc-home-stat-icon"><i class="bi bi-window-stack"></i></span>
            <div class="doc-home-stat-info">
                <strong>{{ $templateTotal }}</strong>
                <span>templates documentados</span>
            </div>
        </div>

        <div class="doc-home-stat-card">
            <span class="doc-home-stat-icon"><i class="bi bi-cpu-fill"></i></span>
            <div class="doc-home-stat-info">
                <strong>4</strong>
                <span>tecnologias integradas</span>
            </div>
        </div>

        <div class="doc-home-stat-card">
            <span class="doc-home-stat-icon"><i class="bi bi-stars"></i></span>
            <div class="doc-home-stat-info">
                <strong>IA</strong>
                <span>registry e llms.txt</span>
            </div>
        </div>
    </section>

    {{-- Seção de Instalação --}}
    <section id="instalacao" class="doc-install-section" aria-labelledby="install-title">
        <div>
            <span class="doc-kicker">Instalação</span>
            <h2 id="install-title">Quatro comandos até o primeiro componente.</h2>
            <p>Instale o pacote, publique configuração e assets, depois compile o app consumidor. Sem dependências adicionais no projeto.</p>
            
            <div class="doc-install-features">
                <span class="doc-install-feature-pill"><i class="bi bi-check-circle-fill"></i> Zero JS pesado</span>
                <span class="doc-install-feature-pill"><i class="bi bi-check-circle-fill"></i> @theme Tailwind v4</span>
                <span class="doc-install-feature-pill"><i class="bi bi-check-circle-fill"></i> Livewire 4 First</span>
            </div>

            <a href="{{ route('documentation.pages.show', 'design-system') }}">Ver guia de configuração <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
        </div>
        <x-docs.code-block :code="'composer require sampaui/sampaui'.PHP_EOL.'php artisan package:discover --ansi'.PHP_EOL.'php artisan sampaui:install --force --no-interaction'.PHP_EOL.'npm run build'" label="Terminal" />
    </section>

    {{-- Templates e Blocks em Destaque --}}
    <section class="doc-home-section" aria-labelledby="templates-title">
        <div class="doc-home-section-heading doc-home-section-heading-row">
            <div>
                <span class="doc-kicker">Blocks & Templates</span>
                <h2 id="templates-title">Composições prontas para acelerar seus projetos</h2>
                <p>Dashboards analíticos, fluxos de autenticação, tabelas completas e atendimento prontos para copiar e adaptar.</p>
            </div>
            <a href="{{ route('examples.index') }}" class="doc-card-link text-sm font-bold">
                Ver todos os {{ $templateTotal }} templates <i class="bi bi-arrow-right" aria-hidden="true"></i>
            </a>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($featuredTemplates as $template)
                <a
                    href="{{ route($template['route']) }}"
                    class="group flex flex-col justify-between rounded-xl border border-border bg-surface p-4 shadow-xs transition-all duration-150 hover:-translate-y-0.5 hover:border-primary/60 hover:shadow-md hover:shadow-primary/5"
                >
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-primary/10 text-primary">
                                <i class="bi bi-{{ $template['icon'] }} text-base"></i>
                            </span>
                            <span class="text-[0.6875rem] font-bold uppercase tracking-wider text-secondary/60">{{ $template['category'] }}</span>
                        </div>
                        <h3 class="text-sm font-bold text-heading group-hover:text-primary transition-colors">{{ $template['title'] }}</h3>
                        <p class="mt-1 text-xs text-secondary/70 leading-relaxed">{{ $template['description'] }}</p>
                    </div>

                    <span class="mt-4 inline-flex items-center gap-1.5 text-xs font-semibold text-primary">
                        Explorar template <i class="bi bi-arrow-right transition-transform group-hover:translate-x-0.5" aria-hidden="true"></i>
                    </span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Catálogo Completo de Componentes --}}
    <section
        id="componentes"
        class="doc-home-section"
        aria-labelledby="components-title"
        x-data="{
            activeFilter: 'all',
            searchQuery: '',
            matches(filters, name, slug, summary) {
                const matchesFilter = this.activeFilter === 'all' || filters.includes(this.activeFilter);
                if (!matchesFilter) return false;
                if (!this.searchQuery || this.searchQuery.trim() === '') return true;
                const q = this.searchQuery.toLowerCase().trim();
                return name.toLowerCase().includes(q) || slug.toLowerCase().includes(q) || summary.toLowerCase().includes(q);
            }
        }"
    >
        <div class="doc-home-section-heading doc-home-section-heading-row">
            <div>
                <span class="doc-kicker">Todos os componentes</span>
                <h2 id="components-title">Componentes organizados para acelerar CRMs, ERPs e sistemas internos em Laravel.</h2>
                <p>Props, estados, snippets Blade/Livewire e boas práticas em uma estrutura filtrável e previsível.</p>
            </div>
            <span class="doc-count-pill">{{ $componentTotal }} componentes</span>
        </div>

        {{-- Barra de Busca e Filtros Rápidos --}}
        <div class="doc-catalog-search-wrap">
            <i class="bi bi-search" aria-hidden="true"></i>
            <input
                type="search"
                x-model="searchQuery"
                placeholder="Filtrar componentes por nome, tag ou finalidade... (ex: table, modal, chat, button, select)"
                class="doc-catalog-search-input"
                aria-label="Buscar componentes"
            />
            <button
                type="button"
                class="doc-catalog-search-clear"
                x-show="searchQuery"
                x-on:click="searchQuery = ''"
                aria-label="Limpar busca"
            >
                <i class="bi bi-x-circle-fill"></i>
            </button>
        </div>

        <div class="doc-catalog-filters" role="tablist" aria-label="Filtrar componentes">
            @foreach ($catalogFilters as $filter)
                <button
                    type="button"
                    role="tab"
                    x-on:click="activeFilter = @js($filter['key'])"
                    x-bind:aria-selected="(activeFilter === @js($filter['key'])).toString()"
                    x-bind:class="activeFilter === @js($filter['key']) ? 'doc-catalog-filter-active' : ''"
                >
                    {{ $filter['label'] }}
                </button>
            @endforeach
        </div>

        <div class="doc-catalog-grid">
            @foreach ($components as $component)
                @php
                    $category = \App\Support\DocumentationGuidance::category($component['slug']);
                    $filter = \App\Support\DocumentationGuidance::filter($component['slug']);
                    $status = \App\Support\DocumentationGuidance::status($component);
                    $isPopular = \App\Support\DocumentationGuidance::isPopular($component['slug']);
                    $isNew = \App\Support\DocumentationGuidance::isNew($component['slug']);
                    $isForm = $category === 'Formulários';
                    $filters = collect(['all', $filter])
                        ->when($isPopular, fn ($items) => $items->push('popular'))
                        ->when($isNew, fn ($items) => $items->push('new'))
                        ->unique()
                        ->values()
                        ->all();
                @endphp
                <a
                    href="{{ route('documentation.components.show', $component['slug']) }}"
                    x-show="matches(@js($filters), @js($component['name']), @js($component['slug']), @js($component['summary']))"
                    x-transition.opacity.duration.150ms
                    @class([
                        'doc-catalog-card',
                        'doc-catalog-card-form' => $isForm,
                        'doc-catalog-card-ui' => ! $isForm,
                    ])
                >
                    <div class="doc-catalog-mini-preview" aria-hidden="true">
                        @include('docs.partials.component-preview', ['slug' => $component['slug']])
                    </div>
                    <div class="doc-catalog-meta-row">
                        @if ($status === 'Planejado')
                            <span class="doc-status-label doc-status-label-planned">Planejado</span>
                        @elseif ($isPopular)
                            <span class="doc-status-label doc-status-label-popular">Popular</span>
                        @elseif ($isNew)
                            <span class="doc-status-label doc-status-label-new">Novo</span>
                        @endif
                        <span class="doc-props-count">{{ count($component['props']) }} props</span>
                        <span class="doc-category-pill">{{ $category }}</span>
                    </div>
                    <div class="doc-catalog-card-copy">
                        <h3>{{ $component['name'] }}</h3>
                        <p>{{ $component['summary'] }}</p>
                    </div>
                    <span class="doc-card-link">Abrir documentação <i class="bi bi-arrow-right" aria-hidden="true"></i></span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Roadmap do Pacote --}}
    <section id="roadmap" class="doc-home-section" aria-labelledby="roadmap-title">
        <div class="doc-home-section-heading">
            <span class="doc-kicker">Roadmap</span>
            <h2 id="roadmap-title">O pacote continua evoluindo com o ecossistema.</h2>
            <p>Prioridades públicas para tornar o SampaUI mais útil em produtos reais.</p>
        </div>
        <div class="doc-roadmap-grid">
            @foreach ($roadmap as $item)
                <article>
                    <span><i class="bi bi-{{ $item['icon'] }}" aria-hidden="true"></i></span>
                    <div><small>{{ $item['status'] }}</small><h3>{{ $item['title'] }}</h3><p>{{ $item['copy'] }}</p></div>
                </article>
            @endforeach
        </div>
    </section>
@endsection
