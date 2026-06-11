@extends('docs.layout', ['title' => 'Documentação SampaUI'])

@section('content')
    @php
        $sampaVersion = \SampaUI\SampaUI::VERSION;
        $componentTotal = count($components);
        $workflowCards = [
            ['title' => 'Captar lead', 'icon' => 'person-plus', 'copy' => 'Inputs, telefone, orçamento, origem, corretor e preferências do comprador.', 'route' => route('examples.admin-form')],
            ['title' => 'Gerir carteira', 'icon' => 'buildings', 'copy' => 'Cards, badges, progresso, tabelas e filtros para imóveis, clientes e propostas.', 'route' => route('examples.dashboard')],
            ['title' => 'Atender rápido', 'icon' => 'chat-dots', 'copy' => 'Chat estilo WhatsApp Web com lista de conversas, histórico, anexos e painel do cliente.', 'route' => route('examples.chat')],
            ['title' => 'Converter proposta', 'icon' => 'file-earmark-check', 'copy' => 'Drawer, modal, etapas, validação e feedback para negociação e contrato.', 'route' => route('examples.advanced-table')],
        ];
        $exampleLinks = [
            ['label' => 'Dashboard operacional', 'route' => route('examples.dashboard'), 'icon' => 'speedometer2'],
            ['label' => 'Chat atendimento', 'route' => route('examples.chat'), 'icon' => 'chat-left-text'],
            ['label' => 'Tabela avançada', 'route' => route('examples.advanced-table'), 'icon' => 'table'],
            ['label' => 'Formulário administrativo', 'route' => route('examples.admin-form'), 'icon' => 'ui-checks-grid'],
            ['label' => 'Login completo', 'route' => route('examples.authentication'), 'icon' => 'shield-lock'],
            ['label' => 'Perfil e upload', 'route' => route('examples.profile'), 'icon' => 'person-badge'],
        ];
    @endphp

    <section class="grid gap-6 xl:grid-cols-[minmax(0,1.35fr)_minmax(22rem,0.65fr)]">
        <article class="doc-hero-card doc-home-hero">
            <div class="relative z-[1] flex flex-wrap items-center gap-2">
                <span class="doc-chip">v{{ $sampaVersion }}</span>
                <span class="doc-chip">CRM imobiliário</span>
                <span class="doc-chip">Laravel 13 + Livewire 4</span>
                <span class="doc-chip">Tailwind 4</span>
            </div>

            <div class="relative z-[1] mt-8">
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-primary">Documentação SampaUI</p>
                <h2 class="mt-3 max-w-4xl text-4xl font-semibold leading-tight text-primary xl:text-[3.25rem]">
                    Componentes Blade para produtos imobiliários profissionais.
                </h2>
                <p class="mt-5 max-w-3xl text-base leading-7 text-secondary">
                    Use o SampaUI para montar CRM, captação, funil comercial, atendimento, propostas, dashboards e auth com o mesmo padrão visual. Os exemplos abaixo são renderizados com o pacote real instalado por Composer.
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <x-sampaui::button icon="buildings" onclick="window.location='{{ route('documentation.pages.show', 'real-estate-patterns') }}'">
                        Ver padrões imobiliários
                    </x-sampaui::button>
                    <x-sampaui::button variant="outline" icon="window-sidebar" onclick="window.location='{{ route('examples.index') }}'">
                        Abrir exemplos
                    </x-sampaui::button>
                    <x-sampaui::button variant="ghost" icon="box-arrow-in-down" onclick="window.location='#instalacao'">
                        Instalação
                    </x-sampaui::button>
                </div>

                <div class="doc-hero-facts">
                    <div>
                        <strong>{{ $componentTotal }}</strong>
                        <span>componentes</span>
                    </div>
                    <div>
                        <strong>12+</strong>
                        <span>exemplos reais</span>
                    </div>
                    <div>
                        <strong>IA</strong>
                        <span>registry e llms.txt</span>
                    </div>
                </div>
            </div>
        </article>

        <aside class="space-y-5">
            <x-sampaui::card title="Pipeline comercial" description="Prévia do padrão imobiliário" padding="lg">
                <div class="space-y-4">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-semibold text-primary">Apartamento Vila Mariana</p>
                            <p class="mt-1 text-xs text-secondary">Lead quente - visita hoje</p>
                        </div>
                        <x-sampaui::badge variant="success">Online</x-sampaui::badge>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-3 xl:grid-cols-1 2xl:grid-cols-3">
                        <div class="rounded-default border border-light bg-light/60 p-4">
                            <p class="text-xs text-secondary">Valor</p>
                            <p class="mt-1 text-lg font-semibold text-primary">R$ 890 mil</p>
                        </div>
                        <div class="rounded-default border border-light bg-light/60 p-4">
                            <p class="text-xs text-secondary">Etapa</p>
                            <p class="mt-1 text-lg font-semibold text-primary">Proposta</p>
                        </div>
                        <div class="rounded-default border border-light bg-light/60 p-4">
                            <p class="text-xs text-secondary">SLA</p>
                            <p class="mt-1 text-lg font-semibold text-primary">18 min</p>
                        </div>
                    </div>

                    <x-sampaui::progress value="68" label="Meta mensal" />

                    <div class="flex flex-wrap gap-2">
                        <x-sampaui::button size="sm" icon="calendar2-check">Agendar</x-sampaui::button>
                        <x-sampaui::button size="sm" variant="outline" icon="chat-dots">Responder</x-sampaui::button>
                    </div>
                </div>
            </x-sampaui::card>

            <x-sampaui::alert variant="info" title="Padrão de uso">
                Primeiro componha com SampaUI. Ajuste espaçamento com `class=""` apenas quando o componente já não resolver o layout.
            </x-sampaui::alert>
        </aside>
    </section>

    <section class="doc-component-board">
        <div class="doc-section-header">
            <div>
                <p class="doc-kicker">Fluxos imobiliários</p>
                <h2 class="doc-heading">Comece pelo resultado da tela</h2>
                <p class="doc-copy">
                    A documentação agora organiza os componentes por casos reais: lead, imóvel, atendimento, proposta e operação.
                </p>
            </div>
            <x-sampaui::badge variant="primary" icon="diagram-3">Receitas</x-sampaui::badge>
        </div>

        <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach ($workflowCards as $workflow)
                <a href="{{ $workflow['route'] }}" class="doc-component-tile">
                    <span class="doc-tile-icon"><i class="bi bi-{{ $workflow['icon'] }}"></i></span>
                    <h3 class="mt-5 text-xl font-semibold text-primary">{{ $workflow['title'] }}</h3>
                    <p class="mt-2 text-sm leading-6 text-secondary">{{ $workflow['copy'] }}</p>
                </a>
            @endforeach
        </div>
    </section>

    <section id="instalacao" class="doc-dashboard-grid doc-dashboard-grid-install">
        <article class="doc-stat-card">
            <div class="doc-stat-icon bg-primary">
                <i class="bi bi-box-seam"></i>
            </div>
            <div>
                <p class="doc-kicker">Instalação</p>
                <h2 class="doc-heading">Composer, install e build</h2>
                <p class="doc-copy">
                    Instale o pacote, publique config/assets e compile o app consumidor. O instalador registra os imports do CSS e JS no Vite.
                </p>
            </div>
        </article>

        <article class="doc-code-card">
<pre><code>composer require sampaui/sampaui
php artisan package:discover --ansi
php artisan sampaui:install --force --no-interaction
npm run build</code></pre>
        </article>
    </section>

    <section class="doc-component-board">
        <div class="doc-section-header">
            <div>
                <p class="doc-kicker">Exemplos completos</p>
                <h2 class="doc-heading">Páginas para copiar e adaptar</h2>
                <p class="doc-copy">
                    Cada exemplo mostra uma tela funcional com Blade, Livewire, Alpine, Bootstrap Icons e componentes reais do pacote.
                </p>
            </div>
            <x-sampaui::button variant="outline" icon="arrow-right" icon-position="right" onclick="window.location='{{ route('examples.index') }}'">
                Ver todos
            </x-sampaui::button>
        </div>

        <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($exampleLinks as $example)
                <a href="{{ $example['route'] }}" class="group flex items-center gap-4 rounded-default border border-light bg-white p-5 shadow-default transition hover:-translate-y-0.5 hover:border-primary/30 hover:shadow-2xl">
                    <span class="inline-flex h-12 w-12 shrink-0 items-center justify-center rounded-default bg-light text-xl text-primary transition group-hover:bg-primary group-hover:text-white">
                        <i class="bi bi-{{ $example['icon'] }}"></i>
                    </span>
                    <span class="font-semibold text-primary">{{ $example['label'] }}</span>
                    <i class="bi bi-arrow-right ml-auto text-secondary transition group-hover:text-primary"></i>
                </a>
            @endforeach
        </div>
    </section>

    <section class="doc-component-board">
        <div class="doc-section-header">
            <div>
                <p class="doc-kicker">Componentes</p>
                <h2 class="doc-heading">Catálogo objetivo</h2>
                <p class="doc-copy">
                    Consulte props, estados e snippets. Para IA, prefira os nomes abaixo e os exemplos versionados no registry.
                </p>
            </div>
            <span class="doc-chip">{{ $componentTotal }} componentes</span>
        </div>

        <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($components as $component)
                <a href="{{ route('documentation.components.show', $component['slug']) }}" class="doc-component-tile">
                    <div class="flex items-start justify-between gap-4">
                        <span class="doc-tile-icon">
                            <i @class([
                                'bi',
                                'bi-cursor' => $component['slug'] === 'button',
                                'bi-input-cursor-text' => $component['slug'] === 'input',
                                'bi-key' => $component['slug'] === 'pin',
                                'bi-menu-button-wide' => $component['slug'] === 'select',
                                'bi-search' => $component['slug'] === 'select-search',
                                'bi-textarea-t' => $component['slug'] === 'textarea',
                                'bi-check2-square' => $component['slug'] === 'checkbox',
                                'bi-calendar3' => $component['slug'] === 'date-picker',
                                'bi-person-bounding-box' => $component['slug'] === 'avatar-upload',
                                'bi-chat-dots' => str_starts_with($component['slug'], 'chat-'),
                                'bi-window-stack' => $component['slug'] === 'modal',
                                'bi-layout-sidebar-inset-reverse' => $component['slug'] === 'drawer',
                                'bi-menu-button' => $component['slug'] === 'dropdown',
                                'bi-table' => $component['slug'] === 'table',
                                'bi-window' => $component['slug'] === 'card',
                                'bi-ui-radios' => ! in_array($component['slug'], ['button', 'input', 'pin', 'select', 'select-search', 'textarea', 'checkbox', 'date-picker', 'avatar-upload', 'modal', 'drawer', 'dropdown', 'table', 'card']) && ! str_starts_with($component['slug'], 'chat-'),
                            ])></i>
                        </span>
                        <span class="doc-chip">{{ count($component['props']) }} props</span>
                    </div>
                    <h3 class="mt-5 text-xl font-semibold text-primary">{{ $component['name'] }}</h3>
                    <p class="mt-2 text-sm leading-6 text-secondary">{{ $component['summary'] }}</p>
                </a>
            @endforeach
        </div>
    </section>
@endsection
