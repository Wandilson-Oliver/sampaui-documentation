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
    @endphp

    <section class="doc-home-hero" aria-labelledby="home-title">
        <div class="doc-home-hero-copy">
            <span class="doc-home-logo-frame">
                <img src="{{ asset('images/logo_sampaui.png') }}" alt="SampaUI">
            </span>

            <div class="doc-home-eyebrow">
                <span class="doc-version-pill"><i class="bi bi-stars" aria-hidden="true"></i> v{{ $sampaVersion }}</span>
                <span>Documentação SampaUI</span>
            </div>

            <h1 id="home-title">Componentes Blade para produtos digitais <span>profissionais.</span></h1>
            <p>
                Um kit completo para acelerar CRMs, dashboards, portais e sistemas internos com Laravel, Livewire e Tailwind — mantendo cada tela consistente, acessível e pronta para produção.
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

        <div class="doc-home-product-preview" aria-label="Prévia com componentes reais do SampaUI">
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
    </section>

    <section class="doc-home-overview" aria-label="Resumo da documentação">
        <div><strong>{{ $componentTotal }}</strong><span>componentes documentados</span></div>
        <div><strong>{{ $templateTotal }}</strong><span>templates documentados</span></div>
        <div><strong>4</strong><span>tecnologias integradas</span></div>
        <div><strong>IA</strong><span>registry e llms.txt</span></div>
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

    <section
        id="componentes"
        class="doc-home-section"
        aria-labelledby="components-title"
        x-data="{ activeFilter: 'all' }"
    >
        <div class="doc-home-section-heading doc-home-section-heading-row">
            <div>
                <span class="doc-kicker">Todos os componentes</span>
                <h2 id="components-title">Componentes organizados para acelerar CRMs, ERPs e sistemas internos em Laravel.</h2>
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
                        'doc-catalog-card-ui' => ! $isForm,
                    ])
                >
                    <div class="doc-catalog-mini-preview" aria-hidden="true">
                        @if ($status === 'Planejado')
                            @include('docs.partials.component-preview', ['slug' => $component['slug']])
                        @else
                            @include('docs.partials.component-preview', ['slug' => $component['slug']])
                        @endif
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
