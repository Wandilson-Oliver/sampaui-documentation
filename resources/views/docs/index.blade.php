@extends('docs.layout', ['title' => 'Documentação SampaUI'])

@section('content')
    <section class="doc-dashboard-grid">
        <article class="doc-hero-card doc-home-hero">
            <div class="relative z-[1] flex flex-wrap items-center gap-2">
                <span class="doc-chip">v0.1.0</span>
                <span class="doc-chip">Composer path</span>
                <span class="doc-chip">Vite integrado</span>
            </div>

            <div class="relative z-[1] mt-8">
                <div class="min-w-0">
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-primary">Documentação SampaUI</p>
                    <h2 class="mt-3 max-w-3xl text-4xl font-semibold leading-tight text-primary xl:text-[3.35rem]">
                        Biblioteca de componentes Blade com preview real do pacote.
                    </h2>
                    <p class="mt-5 max-w-2xl text-base leading-7 text-secondary">
                        A documentacao usa `sampaui/sampaui` instalado via Composer, importa `dist/sampaui.css` e `dist/sampaui.js` no build do Vite e renderiza cada exemplo com componentes Blade reais para Laravel 13, Livewire 4, Tailwind 4 e AlpineJS.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <x-sampaui::button icon="rocket-takeoff" onclick="window.location='{{ route('documentation.components.show', 'button') }}'">
                            Explorar componentes
                        </x-sampaui::button>
                        <x-sampaui::button variant="outline" icon="box-arrow-in-down-right" icon-position="right" onclick="window.location='#instalacao'">
                            Ver instalacao
                        </x-sampaui::button>
                    </div>

                    <div class="doc-hero-facts">
                        <div>
                            <strong>{{ count($components) }}</strong>
                            <span>componentes</span>
                        </div>
                        <div>
                            <strong>Vite</strong>
                            <span>CSS e JS no app</span>
                        </div>
                        <div>
                            <strong>2026</strong>
                            <span>API padronizada</span>
                        </div>
                    </div>
                </div>
            </div>
        </article>

        <aside class="doc-preview-column">
            <div class="doc-package-panel">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="doc-kicker">Provider</p>
                        <h2 class="mt-2 text-2xl font-semibold text-primary">Instalado localmente</h2>
                    </div>
                    <span class="doc-status-badge">OK</span>
                </div>

                <div class="mt-7 space-y-3">
                    <div class="doc-health-row">
                        <span>Views</span>
                        <strong>sampaui::components</strong>
                    </div>
                    <div class="doc-health-row">
                        <span>Assets</span>
                        <strong>app.css/app.js</strong>
                    </div>
                    <div class="doc-health-row">
                        <span>Artisan</span>
                        <strong>sampaui:install</strong>
                    </div>
                </div>
            </div>

            <div class="doc-dashed-card">
                <span>Componentes</span>
                <i class="bi bi-plus-lg"></i>
            </div>

            <div class="doc-team-card">
                <div class="flex items-center justify-between">
                    <x-sampaui::button icon="speedometer2" class="px-8">
                        Dashboard
                    </x-sampaui::button>
                    <button class="doc-round-button" type="button" aria-label="Expandir">
                        <i class="bi bi-chevron-down"></i>
                    </button>
                </div>

                <h3 class="mt-7 text-2xl font-semibold text-primary">Design system</h3>
                <div class="mt-5 flex -space-x-3">
                    <span class="doc-face bg-primary">B</span>
                    <span class="doc-face bg-accent">I</span>
                    <span class="doc-face bg-secondary">S</span>
                    <span class="doc-face bg-danger">C</span>
                    <span class="doc-face bg-black text-white"><i class="bi bi-plus-lg"></i></span>
                </div>
            </div>
        </aside>
    </section>

    <section id="instalacao" class="doc-dashboard-grid doc-dashboard-grid-install">
        <article class="doc-stat-card">
            <div class="doc-stat-icon bg-danger">
                <i class="bi bi-box-seam"></i>
            </div>
            <div>
                <p class="doc-kicker">Instalacao</p>
                <h2 class="doc-heading">Composer, publish e CSS</h2>
                <p class="doc-copy">
                    Instale o pacote, descubra o provider e registre os assets compilados no `app.css` e `app.js` da aplicacao consumidora.
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
                <p class="doc-kicker">Componentes</p>
                <h2 class="doc-heading">Escolha uma area para testar</h2>
            </div>
            <span class="doc-chip">{{ count($components) }} componentes</span>
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
                                'bi-ui-radios' => $component['slug'] === 'radio',
                                'bi-toggle-on' => $component['slug'] === 'toggle',
                                'bi-calendar3' => $component['slug'] === 'date-picker',
                                'bi-upload' => $component['slug'] === 'file-upload',
                                'bi-person-bounding-box' => $component['slug'] === 'avatar-upload',
                                'bi-tag' => $component['slug'] === 'badge',
                                'bi-person-circle' => $component['slug'] === 'avatar',
                                'bi-circle-fill' => $component['slug'] === 'indicator',
                                'bi-info-circle' => $component['slug'] === 'alert',
                                'bi-window' => $component['slug'] === 'card',
                                'bi-layout-text-window-reverse' => $component['slug'] === 'header',
                                'bi-layout-sidebar' => $component['slug'] === 'sidebar',
                                'bi-window-stack' => $component['slug'] === 'modal',
                                'bi-layout-sidebar-inset-reverse' => $component['slug'] === 'drawer',
                                'bi-bell' => $component['slug'] === 'toast',
                                'bi-menu-button' => $component['slug'] === 'dropdown',
                                'bi-segmented-nav' => $component['slug'] === 'tabs',
                                'bi-question-circle' => $component['slug'] === 'tooltip',
                                'bi-chevron-double-right' => $component['slug'] === 'breadcrumb',
                                'bi-table' => $component['slug'] === 'table',
                                'bi-three-dots' => $component['slug'] === 'pagination',
                                'bi-hourglass-split' => $component['slug'] === 'skeleton',
                                'bi-inbox' => $component['slug'] === 'empty-state',
                                'bi-bar-chart-line' => $component['slug'] === 'progress',
                                'bi-list-ol' => $component['slug'] === 'stepper',
                                'bi-view-list' => $component['slug'] === 'accordion',
                                'bi-command' => $component['slug'] === 'command-palette',
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

    <section class="doc-component-board">
        <div class="doc-section-header">
            <div>
                <p class="doc-kicker">Pesquisa 2025</p>
                <h2 class="doc-heading">O que foi aplicado no SampaUI</h2>
                <p class="doc-copy">
                    O pacote continua Blade-first, mas absorve os padroes mais fortes dos frameworks modernos: API previsivel, acessibilidade, tokens, exemplos completos, composicao e compatibilidade direta com Livewire/Alpine.
                </p>
            </div>
            <span class="doc-chip">10 referencias</span>
        </div>

        <div class="doc-influence-grid">
            @foreach ($influences as $influence)
                <article class="doc-influence-card">
                    <h3>{{ $influence['name'] }}</h3>
                    <p>{{ $influence['takeaway'] }}</p>
                </article>
            @endforeach
        </div>
    </section>
@endsection
