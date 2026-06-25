@extends('docs.layout', ['title' => 'Documentação SampaUI'])

@section('content')
    @php
        $sampaVersion = config('docs.version');
        $componentTotal = count($components);
        $popularSlugs = ['button', 'input', 'select', 'badge', 'table', 'modal'];
        $popularComponents = collect($components)->whereIn('slug', $popularSlugs)->sortBy(fn (array $component): int => array_search($component['slug'], $popularSlugs, true))->values();
        $exampleCards = [
            ['title' => 'Dashboard operacional', 'copy' => 'Métricas, funil, atividades e decisões rápidas para a operação comercial.', 'route' => route('examples.dashboard'), 'icon' => 'speedometer2', 'tag' => 'Dashboard', 'tone' => 'primary'],
            ['title' => 'Chat atendimento', 'copy' => 'Conversas, histórico e contexto do cliente em uma experiência inspirada no WhatsApp Web.', 'route' => route('examples.chat'), 'icon' => 'chat-dots', 'tag' => 'Atendimento', 'tone' => 'success'],
            ['title' => 'Tabela avançada', 'copy' => 'Filtros, status, ações por linha, loading, vazio e paginação para dados operacionais.', 'route' => route('examples.advanced-table'), 'icon' => 'table', 'tag' => 'Dados', 'tone' => 'info'],
            ['title' => 'Formulário administrativo', 'copy' => 'Cadastro extenso com validação, contato, endereço, valores e preferências.', 'route' => route('examples.admin-form'), 'icon' => 'ui-checks-grid', 'tag' => 'Forms', 'tone' => 'accent'],
            ['title' => 'Login completo', 'copy' => 'Autenticação pronta para Livewire com feedback, loading e recuperação de acesso.', 'route' => route('examples.authentication'), 'icon' => 'shield-lock', 'tag' => 'Auth', 'tone' => 'purple'],
            ['title' => 'Perfil e upload', 'copy' => 'Avatar, arquivos, dados pessoais e segurança reunidos em uma tela real.', 'route' => route('examples.profile'), 'icon' => 'person-badge', 'tag' => 'Upload', 'tone' => 'danger'],
        ];
        $roadmap = [
            ['title' => 'Mais padrões de CRM', 'copy' => 'Receitas para carteira, visitas, propostas e pós-venda.', 'icon' => 'buildings', 'status' => 'Em evolução'],
            ['title' => 'Playgrounds avançados', 'copy' => 'Mais estados interativos e exemplos Livewire copiáveis.', 'icon' => 'sliders2', 'status' => 'Planejado'],
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
            ['key' => 'real-estate', 'label' => 'Real Estate'],
        ];
    @endphp

    <section class="doc-home-hero" aria-labelledby="home-title">
        <div class="doc-home-hero-copy">
            <div class="doc-home-eyebrow">
                <span class="doc-version-pill"><i class="bi bi-stars" aria-hidden="true"></i> v{{ $sampaVersion }}</span>
                <span>Documentação SampaUI</span>
            </div>

            <h1 id="home-title">Componentes Blade para produtos imobiliários <span>profissionais.</span></h1>
            <p>
                Um kit completo para acelerar CRMs, portais e sistemas internos com Laravel, Livewire e Tailwind — mantendo cada tela consistente, acessível e pronta para produção.
            </p>

            <div class="doc-home-actions">
                <x-sampaui::button size="sm" icon="grid" onclick="window.location='#componentes'">
                    Ver componentes
                </x-sampaui::button>
                <x-sampaui::button size="sm" variant="outline" icon="window-sidebar" onclick="window.location='{{ route('examples.index') }}'">
                    Explorar exemplos
                </x-sampaui::button>
            </div>

            <div class="doc-stack-badges" aria-label="Tecnologias compatíveis">
                @foreach ([
                    ['label' => 'Composer', 'icon' => 'box-seam'],
                    ['label' => 'Laravel 13', 'icon' => 'braces-asterisk'],
                    ['label' => 'Livewire 4', 'icon' => 'lightning-charge'],
                    ['label' => 'Tailwind 4', 'icon' => 'wind'],
                ] as $technology)
                    <span><i class="bi bi-{{ $technology['icon'] }}" aria-hidden="true"></i>{{ $technology['label'] }}</span>
                @endforeach
            </div>
        </div>

        <div class="doc-crm-preview" aria-label="Prévia de dashboard CRM imobiliário">
            <div class="doc-crm-toolbar">
                <div class="doc-crm-brand"><span>S</span><strong>SampaCRM</strong></div>
                <div class="doc-crm-search"><i class="bi bi-search" aria-hidden="true"></i><span>Buscar no CRM...</span></div>
                <div class="doc-crm-toolbar-actions">
                    <button type="button" aria-label="Notificações"><i class="bi bi-bell" aria-hidden="true"></i><span></span></button>
                    <button type="button" aria-label="Adicionar"><i class="bi bi-plus-lg" aria-hidden="true"></i></button>
                    <x-sampaui::avatar name="Ana Souza" size="sm" status="online" />
                </div>
            </div>

            <div class="doc-crm-body">
                <nav class="doc-crm-rail" aria-label="Navegação da prévia CRM">
                    @foreach (['house-door', 'person', 'buildings', 'bar-chart', 'calendar3', 'chat-square-text'] as $icon)
                        <span @class(['active' => $loop->first])><i class="bi bi-{{ $icon }}" aria-hidden="true"></i></span>
                    @endforeach
                </nav>

                <div class="doc-crm-workspace">
                    <div class="doc-crm-metrics">
                        @foreach ([
                            ['label' => 'Receita total', 'value' => 'R$ 2,4 mi', 'delta' => '+18%', 'variant' => 'success', 'icon' => 'graph-up-arrow'],
                            ['label' => 'Novos leads', 'value' => '1.248', 'delta' => '+24%', 'variant' => 'info', 'icon' => 'person-plus'],
                            ['label' => 'Negociações', 'value' => '347', 'delta' => '+12%', 'variant' => 'accent', 'icon' => 'briefcase'],
                            ['label' => 'Conversão', 'value' => '28,6%', 'delta' => '+5,2 p.p.', 'variant' => 'purple', 'icon' => 'bullseye'],
                        ] as $metric)
                            <article>
                                <div><span>{{ $metric['label'] }}</span><i class="bi bi-{{ $metric['icon'] }}" aria-hidden="true"></i></div>
                                <strong>{{ $metric['value'] }}</strong>
                                <small class="doc-tone-{{ $metric['variant'] }}">{{ $metric['delta'] }} no mês</small>
                            </article>
                        @endforeach
                    </div>

                    <div class="doc-crm-grid">
                        <article class="doc-crm-panel doc-crm-pipeline">
                            <header><strong>Pipeline de vendas</strong><span>Este mês <i class="bi bi-chevron-down" aria-hidden="true"></i></span></header>
                            @foreach ([
                                ['label' => 'Prospecção', 'value' => 82, 'leads' => 256, 'amount' => 'R$ 680 mil'],
                                ['label' => 'Qualificação', 'value' => 64, 'leads' => 132, 'amount' => 'R$ 420 mil'],
                                ['label' => 'Visita', 'value' => 46, 'leads' => 64, 'amount' => 'R$ 310 mil'],
                                ['label' => 'Proposta', 'value' => 31, 'leads' => 38, 'amount' => 'R$ 210 mil'],
                                ['label' => 'Fechamento', 'value' => 18, 'leads' => 21, 'amount' => 'R$ 140 mil'],
                            ] as $stage)
                                <div class="doc-pipeline-row">
                                    <div><strong>{{ $stage['label'] }}</strong><span>{{ $stage['leads'] }} leads · {{ $stage['amount'] }}</span></div>
                                    <x-sampaui::progress :value="$stage['value']" />
                                </div>
                            @endforeach
                        </article>

                        <article class="doc-crm-panel doc-crm-activity">
                            <header><strong>Atividade recente</strong><a href="{{ route('examples.dashboard') }}">Ver todas</a></header>
                            @foreach ([
                                ['name' => 'Ana Souza', 'action' => 'Novo lead cadastrado', 'time' => '10 min', 'status' => 'online'],
                                ['name' => 'Bruno Lima', 'action' => 'Proposta enviada', 'time' => '35 min', 'status' => 'away'],
                                ['name' => 'Mariana Costa', 'action' => 'Visita agendada', 'time' => '1 h', 'status' => 'online'],
                                ['name' => 'Diego Ramos', 'action' => 'Negociação atualizada', 'time' => '2 h', 'status' => 'offline'],
                            ] as $activity)
                                <div class="doc-activity-row">
                                    <x-sampaui::avatar :name="$activity['name']" :status="$activity['status']" size="sm" />
                                    <div><strong>{{ $activity['name'] }}</strong><span>{{ $activity['action'] }}</span></div>
                                    <time>{{ $activity['time'] }}</time>
                                </div>
                            @endforeach
                        </article>

                        <article class="doc-crm-panel doc-crm-agenda">
                            <header><div><strong>Agenda do dia</strong><span>24 de junho</span></div><i class="bi bi-calendar3" aria-hidden="true"></i></header>
                            @foreach ([
                                ['time' => '09:00', 'title' => 'Visita', 'copy' => 'Apartamento · Jardim Europa'],
                                ['time' => '11:00', 'title' => 'Reunião', 'copy' => 'Alinhamento com corretor'],
                                ['time' => '14:00', 'title' => 'Ligação', 'copy' => 'Follow-up proposta #1287'],
                            ] as $event)
                                <div class="doc-agenda-row"><time>{{ $event['time'] }}</time><span></span><div><strong>{{ $event['title'] }}</strong><small>{{ $event['copy'] }}</small></div></div>
                            @endforeach
                        </article>
                    </div>

                    <article class="doc-crm-panel doc-crm-proposals">
                        <header><strong>Propostas recentes</strong><x-sampaui::badge size="sm" variant="light">3 atualizações</x-sampaui::badge></header>
                        <div class="doc-crm-table" role="table" aria-label="Propostas recentes">
                            <div role="row"><span>#</span><span>Imóvel</span><span>Cliente</span><span>Valor</span><span>Estágio</span></div>
                            @foreach ([
                                ['id' => '#1287', 'property' => 'Apartamento · Itaim Bibi', 'client' => 'Bruno Lima', 'value' => 'R$ 850.000', 'status' => 'Proposta', 'variant' => 'primary'],
                                ['id' => '#1286', 'property' => 'Casa · Alphaville', 'client' => 'Ana Souza', 'value' => 'R$ 1.250.000', 'status' => 'Visita', 'variant' => 'success'],
                            ] as $proposal)
                                <div role="row"><strong>{{ $proposal['id'] }}</strong><span>{{ $proposal['property'] }}</span><span>{{ $proposal['client'] }}</span><span>{{ $proposal['value'] }}</span><x-sampaui::badge size="sm" :variant="$proposal['variant']">{{ $proposal['status'] }}</x-sampaui::badge></div>
                            @endforeach
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section class="doc-home-overview" aria-label="Resumo da documentação">
        <div><strong>{{ $componentTotal }}</strong><span>componentes documentados</span></div>
        <div><strong>14</strong><span>exemplos completos</span></div>
        <div><strong>4</strong><span>tecnologias integradas</span></div>
        <div><strong>IA</strong><span>registry e llms.txt</span></div>
    </section>

    <section class="doc-home-section" aria-labelledby="why-title">
        <div class="doc-home-section-heading">
            <span class="doc-kicker">Por que usar SampaUI</span>
            <h2 id="why-title">Da primeira tela ao CRM completo, sem perder consistência.</h2>
            <p>Componentes, exemplos e decisões de interface foram pensados para acelerar produtos Laravel reais.</p>
        </div>

        <div class="doc-benefit-grid">
            @foreach ([
                ['title' => 'Feito para Laravel', 'copy' => 'Blade e Livewire como primeira classe, sem adaptar uma biblioteca React para o seu fluxo.', 'icon' => 'braces-asterisk'],
                ['title' => 'Pronto para produção', 'copy' => 'Estados, acessibilidade, dark mode e atributos preservados desde o primeiro componente.', 'icon' => 'shield-check'],
                ['title' => 'Foco imobiliário', 'copy' => 'Padrões para leads, imóveis, funil, atendimento, propostas e operação comercial.', 'icon' => 'buildings'],
                ['title' => 'Customização segura', 'copy' => 'Tokens semânticos e class="" permitem evoluir o produto sem quebrar o pacote.', 'icon' => 'sliders2'],
            ] as $benefit)
                <article>
                    <span><i class="bi bi-{{ $benefit['icon'] }}" aria-hidden="true"></i></span>
                    <h3>{{ $benefit['title'] }}</h3>
                    <p>{{ $benefit['copy'] }}</p>
                </article>
            @endforeach
        </div>
    </section>

    <section id="instalacao" class="doc-install-section" aria-labelledby="install-title">
        <div>
            <span class="doc-kicker">Instalação</span>
            <h2 id="install-title">Quatro comandos até o primeiro componente.</h2>
            <p>Instale o pacote, publique configuração e assets, depois compile o app consumidor. Sem dependências adicionais no projeto.</p>
            <a href="{{ route('documentation.pages.show', 'design-system') }}">Ver guia de configuração <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
        </div>
        <x-docs.code-block :code="'composer require sampaui/sampaui'.PHP_EOL.'php artisan package:discover --ansi'.PHP_EOL.'php artisan sampaui:install --force --no-interaction'.PHP_EOL.'npm run build'" label="Terminal" />
    </section>

    <section class="doc-home-section" aria-labelledby="popular-title">
        <div class="doc-home-section-heading doc-home-section-heading-row">
            <div>
                <span class="doc-kicker">Componentes populares</span>
                <h2 id="popular-title">Os blocos mais usados, renderizados de verdade.</h2>
                <p>Veja o comportamento antes de abrir a documentação completa de cada componente.</p>
            </div>
            <a href="#componentes" class="doc-inline-link">Ver catálogo completo <i class="bi bi-arrow-down" aria-hidden="true"></i></a>
        </div>

        <div class="doc-popular-grid">
            @foreach ($popularComponents as $component)
                <a href="{{ route('documentation.components.show', $component['slug']) }}" class="doc-popular-card">
                    <div class="doc-popular-preview">
                        @include('docs.partials.component-preview', ['slug' => $component['slug']])
                    </div>
                    <div class="doc-popular-meta">
                        <span>{{ \App\Support\DocumentationGuidance::category($component['slug']) }}</span>
                        <span>{{ count($component['props']) }} props</span>
                    </div>
                    <h3>{{ $component['name'] }}</h3>
                    <p>{{ $component['summary'] }}</p>
                    <span class="doc-card-link">Abrir documentação <i class="bi bi-arrow-right" aria-hidden="true"></i></span>
                </a>
            @endforeach
        </div>
    </section>

    <section
        id="componentes"
        class="doc-home-section"
        aria-labelledby="components-title"
        x-data="{ activeFilter: 'all' }"
    >
        <div class="doc-home-section-heading doc-home-section-heading-row">
            <div>
                <span class="doc-kicker">Todos os componentes</span>
                <h2 id="components-title">Um catálogo completo para sistemas internos.</h2>
                <p>Props, estados, snippets Blade/Livewire e boas práticas em uma estrutura filtrável e previsível.</p>
            </div>
            <span class="doc-count-pill">{{ $componentTotal }} componentes</span>
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
                    $componentIcon = \App\Support\DocumentationGuidance::icon($component['slug']);
                    $filters = collect(['all', $filter])
                        ->when($isPopular, fn ($items) => $items->push('popular'))
                        ->when($isNew, fn ($items) => $items->push('new'))
                        ->when($status === 'Planejado', fn ($items) => $items->push('real-estate'))
                        ->unique()
                        ->values()
                        ->all();
                @endphp
                <a
                    href="{{ route('documentation.components.show', $component['slug']) }}"
                    x-show="@js($filters).includes(activeFilter)"
                    x-transition.opacity.duration.150ms
                    @class([
                        'doc-catalog-card',
                        'doc-catalog-card-form' => $isForm,
                        'doc-catalog-card-real-estate' => $category === 'Real Estate',
                        'doc-catalog-card-ui' => ! $isForm && $category !== 'Real Estate',
                    ])
                >
                    <div class="doc-catalog-mini-preview" aria-hidden="true">
                        @if ($status === 'Planejado')
                            <div class="doc-planned-preview">
                                <span><i class="bi bi-{{ $component['planned_icon'] ?? $componentIcon }}" aria-hidden="true"></i></span>
                                <small>Planejado</small>
                            </div>
                        @else
                            @include('docs.partials.component-preview', ['slug' => $component['slug']])
                        @endif
                    </div>
                    <div class="doc-catalog-card-top">
                        <span class="doc-catalog-icon"><i class="bi bi-{{ $componentIcon }}" aria-hidden="true"></i></span>
                        <div>
                            @if ($status === 'Planejado')
                                <span class="doc-status-label doc-status-label-planned">Planejado</span>
                            @elseif ($isPopular)
                                <span class="doc-status-label doc-status-label-popular">Popular</span>
                            @elseif ($isNew)
                                <span class="doc-status-label doc-status-label-new">Novo</span>
                            @endif
                            <span class="doc-props-count">{{ count($component['props']) }} props</span>
                        </div>
                    </div>
                    <div class="doc-catalog-card-copy">
                        <span>{{ $category }}</span>
                        <h3>{{ $component['name'] }}</h3>
                        <p>{{ $component['summary'] }}</p>
                    </div>
                    <span class="doc-card-link">Abrir documentação <i class="bi bi-arrow-right" aria-hidden="true"></i></span>
                </a>
            @endforeach
        </div>
    </section>

    <section id="blocks" class="doc-home-section" aria-labelledby="templates-title">
        <div class="doc-home-section-heading doc-home-section-heading-row">
            <div>
                <span class="doc-kicker">Templates e exemplos completos</span>
                <h2 id="templates-title">Páginas que parecem o seu produto.</h2>
                <p>Telas funcionais com dados realistas, interações e código pronto para adaptar.</p>
            </div>
            <x-sampaui::button variant="outline" icon="arrow-right" icon-position="right" onclick="window.location='{{ route('examples.index') }}'">Ver todos</x-sampaui::button>
        </div>

        <div class="doc-template-grid">
            @foreach ($exampleCards as $example)
                <a href="{{ $example['route'] }}" class="doc-template-card">
                    <div class="doc-template-preview doc-template-preview-{{ $example['tone'] }}">
                        <div class="doc-template-window">
                            <span></span><span></span><span></span>
                            <i class="bi bi-{{ $example['icon'] }}" aria-hidden="true"></i>
                            <div><b></b><b></b><b></b></div>
                        </div>
                    </div>
                    <div class="doc-template-copy">
                        <x-sampaui::badge variant="light" size="sm">{{ $example['tag'] }}</x-sampaui::badge>
                        <h3>{{ $example['title'] }}</h3>
                        <p>{{ $example['copy'] }}</p>
                        <span>Explorar template <i class="bi bi-arrow-right" aria-hidden="true"></i></span>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <section class="doc-real-estate-section" aria-labelledby="patterns-title">
        <div>
            <span class="doc-kicker">Padrões imobiliários</span>
            <h2 id="patterns-title">Componha jornadas completas para captar, atender e converter.</h2>
            <p>Receitas de interface para lead comprador, carteira de imóveis, funil comercial, agenda de visitas e propostas.</p>
            <x-sampaui::button icon="buildings" onclick="window.location='{{ route('documentation.pages.show', 'real-estate-patterns') }}'">Ver padrões imobiliários</x-sampaui::button>
        </div>
        <div class="doc-pattern-flow" aria-label="Jornada imobiliária">
            @foreach ([
                ['label' => 'Captar', 'icon' => 'person-plus'],
                ['label' => 'Qualificar', 'icon' => 'funnel'],
                ['label' => 'Atender', 'icon' => 'chat-dots'],
                ['label' => 'Converter', 'icon' => 'file-earmark-check'],
            ] as $step)
                <div><span><i class="bi bi-{{ $step['icon'] }}" aria-hidden="true"></i></span><strong>{{ $step['label'] }}</strong></div>
            @endforeach
        </div>
    </section>

    <section class="doc-home-section" aria-labelledby="roadmap-title">
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
