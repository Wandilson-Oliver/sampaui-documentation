<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Documentação SampaUI para produtos imobiliários em Laravel 13, Livewire 4 e Tailwind 4.">

        <title>{{ $title ?? 'Documentação SampaUI' }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="doc-shell">
        <div class="min-h-screen overflow-hidden">
            <div class="doc-app-frame">
                <aside class="doc-menu-panel">
                    <div class="doc-brand-block">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-primary">SampaUI</p>
                        <h1 class="mt-2 text-2xl font-semibold text-primary">Componentes para imobiliárias</h1>
                        <p class="mt-3 text-sm leading-6 text-secondary">
                            Pacote Laravel para CRM, captação, atendimento, dashboards e auth com componentes Blade reais.
                        </p>
                    </div>

                    @php
                        $formComponentSlugs = ['input', 'phone', 'currency-br', 'cep', 'pin', 'select', 'select-multiple', 'select-search', 'textarea', 'checkbox', 'radio', 'toggle', 'date-picker', 'file-upload', 'avatar-upload'];
                        $uiComponentSlugs = ['button', 'badge', 'avatar', 'indicator', 'alert', 'card', 'header', 'sidebar', 'modal', 'drawer', 'toast', 'dropdown', 'tabs', 'tooltip', 'breadcrumb', 'table', 'pagination', 'skeleton', 'empty-state', 'progress', 'stepper', 'accordion', 'command-palette'];
                        $componentGroups = [
                            'Formulários' => collect($navigationComponents)->whereIn('slug', $formComponentSlugs)->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE),
                            'Design de UI' => collect($navigationComponents)->whereIn('slug', $uiComponentSlugs)->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE),
                        ];
                        $designSystemPage = collect($navigationPages ?? [])->firstWhere('slug', 'design-system');
                        $sideNavigationPages = collect($navigationPages ?? [])
                            ->reject(fn (array $page): bool => ($page['slug'] ?? null) === 'design-system')
                            ->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
                            ->values();
                        $navigationExamples = collect($navigationExamples ?? [
                            [
                                'name' => 'Autenticação',
                                'slug' => 'authentication',
                                'tag' => 'Exemplo',
                                'summary' => 'Página de login premium com inputs, checkbox e ações SampaUI.',
                                'route' => 'examples.authentication',
                                'icon' => 'shield-lock',
                            ],
                            [
                                'name' => 'Form Profile',
                                'slug' => 'profile',
                                'tag' => 'Exemplo',
                                'summary' => 'Perfil com avatar upload, contato e troca de senha.',
                                'route' => 'examples.profile',
                                'icon' => 'person-badge',
                            ],
                            [
                                'name' => 'Bootstrap Icons',
                                'slug' => 'icons',
                                'tag' => 'Exemplo',
                                'summary' => 'Busca dos principais ícones Bootstrap Icons usados nos componentes.',
                                'route' => 'examples.icons',
                                'icon' => 'bootstrap',
                            ],
                            [
                                'name' => 'Listagem de usuários',
                                'slug' => 'users-index',
                                'tag' => 'Exemplo',
                                'summary' => 'Listagem CRUD responsiva com filtros, tabela, badges e paginação.',
                                'route' => 'examples.users.index',
                                'icon' => 'people',
                            ],
                        ])->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)->values();
                    @endphp

                    <nav aria-label="Componentes SampaUI" class="mt-8 space-y-5">
                        <a href="{{ route('documentation') }}" @class(['doc-menu-link', 'doc-menu-link-active' => request()->routeIs('documentation')])>
                            <span class="doc-menu-icon"><i class="bi bi-columns-gap"></i></span>
                            <span>Dashboard</span>
                        </a>

                        @if ($designSystemPage)
                            <a
                                href="{{ route('documentation.pages.show', $designSystemPage['slug']) }}"
                                @class([
                                    'doc-menu-link',
                                    'doc-menu-link-active' => request()->routeIs('documentation.pages.show')
                                        && request()->route('page') === $designSystemPage['slug'],
                                ])
                            >
                                <span class="doc-menu-icon"><i class="bi bi-palette2"></i></span>
                                <span>Design system</span>
                            </a>
                        @endif

                        @foreach ($componentGroups as $groupName => $groupComponents)
                            @if ($groupComponents->isNotEmpty())
                                <div class="doc-menu-section">
                                    <p class="doc-menu-section-title">
                                        <span class="doc-menu-section-icon">
                                            <i @class([
                                                'bi',
                                                'bi-input-cursor-text' => $groupName === 'Formulários',
                                                'bi-palette2' => $groupName === 'Design de UI',
                                            ])></i>
                                        </span>
                                        <span>{{ $groupName }}</span>
                                    </p>

                                    <div class="mt-2 space-y-1">
                                        @foreach ($groupComponents as $navigationComponent)
                                            <a
                                                href="{{ route('documentation.components.show', $navigationComponent['slug']) }}"
                                                @class([
                                                    'doc-menu-item',
                                                    'doc-menu-item-active' => request()->routeIs('documentation.components.show')
                                                        && request()->route('component') === $navigationComponent['slug'],
                                                ])
                                            >
                                                <span>{{ $navigationComponent['name'] }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        @if ($navigationExamples->isNotEmpty())
                            <div class="doc-menu-section">
                                <p class="doc-menu-section-title">
                                    <span class="doc-menu-section-icon"><i class="bi bi-window-sidebar"></i></span>
                                    <span>Exemplos</span>
                                </p>

                                <div class="mt-2 space-y-1">
                                    <a
                                        href="{{ route('examples.index') }}"
                                        @class([
                                            'doc-menu-item',
                                            'doc-menu-item-active' => request()->routeIs('examples.index'),
                                        ])
                                    >
                                        <span>Visão geral</span>
                                    </a>

                                    @foreach ($navigationExamples as $navigationExample)
                                        <a
                                            href="{{ route($navigationExample['route']) }}"
                                            @class([
                                                'doc-menu-item',
                                                'doc-menu-item-active' => request()->routeIs($navigationExample['route']),
                                            ])
                                        >
                                            <span>{{ $navigationExample['name'] }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if ($sideNavigationPages->isNotEmpty())
                            <div class="doc-menu-section">
                                <p class="doc-menu-section-title">
                                    <span class="doc-menu-section-icon"><i class="bi bi-file-earmark-richtext"></i></span>
                                    <span>Guias</span>
                                </p>

                                <div class="mt-2 space-y-1">
                                    @foreach ($sideNavigationPages as $navigationPage)
                                        <a
                                            href="{{ route('documentation.pages.show', $navigationPage['slug']) }}"
                                            @class([
                                                'doc-menu-item',
                                                'doc-menu-item-active' => request()->routeIs('documentation.pages.show')
                                                    && request()->route('page') === $navigationPage['slug'],
                                            ])
                                        >
                                            <span>{{ $navigationPage['name'] }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </nav>

                    <div class="doc-menu-footer">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-secondary/70">Stack</p>
                        <div class="mt-3 space-y-2">
                            <span class="doc-stack-pill">Laravel 13</span>
                            <span class="doc-stack-pill">Livewire 4</span>
                            <span class="doc-stack-pill">Tailwind 4</span>
                            <span class="doc-stack-pill">AlpineJS</span>
                        </div>
                    </div>
                </aside>

                <div class="h-full min-w-0 flex-1 overflow-y-auto">
                    @php
                        $searchItems = collect($navigationComponents ?? [])
                            ->map(function (array $component): array {
                                $props = collect($component['props'] ?? [])
                                    ->map(fn (array $prop): string => implode(' ', [$prop['name'] ?? '', $prop['type'] ?? '', $prop['notes'] ?? '']))
                                    ->implode(' ');
                                $examples = collect($component['examples'] ?? [])
                                    ->merge($component['showcases'] ?? [])
                                    ->map(fn (array $example): string => implode(' ', [$example['title'] ?? '', $example['description'] ?? '', $example['code'] ?? '']))
                                    ->implode(' ');

                                return [
                                    'type' => 'Componente',
                                    'title' => $component['name'],
                                    'subtitle' => $component['summary'] ?? $component['description'] ?? '',
                                    'tag' => $component['tag'] ?? '',
                                    'url' => route('documentation.components.show', $component['slug']),
                                    'search' => implode(' ', [
                                        $component['name'] ?? '',
                                        $component['slug'] ?? '',
                                        $component['tag'] ?? '',
                                        $component['summary'] ?? '',
                                        $component['description'] ?? '',
                                        $props,
                                        $examples,
                                    ]),
                                ];
                            })
                            ->merge(collect($navigationPages ?? [])->map(fn (array $page): array => [
                                'type' => 'Página',
                                'title' => $page['name'],
                                'subtitle' => $page['summary'] ?? $page['description'] ?? '',
                                'tag' => $page['tag'] ?? 'Página',
                                'url' => route('documentation.pages.show', $page['slug']),
                                'search' => implode(' ', [
                                    $page['name'] ?? '',
                                    $page['slug'] ?? '',
                                    $page['tag'] ?? '',
                                    $page['summary'] ?? '',
                                    $page['description'] ?? '',
                                    $page['code'] ?? '',
                                ]),
                            ]))
                            ->merge($navigationExamples->map(fn (array $example): array => [
                                'type' => 'Exemplo',
                                'title' => $example['name'],
                                'subtitle' => $example['summary'] ?? '',
                                'tag' => $example['tag'] ?? 'Exemplo',
                                'url' => route($example['route']),
                                'search' => implode(' ', [
                                    $example['name'] ?? '',
                                    $example['slug'] ?? '',
                                    $example['tag'] ?? '',
                                    $example['summary'] ?? '',
                                ]),
                            ]))
                            ->values();
                    @endphp

                    <header class="doc-topbar">
                        <div
                            class="doc-search-wrap"
                            x-data="docSearch(@js($searchItems))"
                            x-on:keydown.down.prevent="next()"
                            x-on:keydown.up.prevent="previous()"
                            x-on:keydown.enter.prevent="select()"
                            x-on:keydown.escape.window="open = false"
                            x-on:click.outside="open = false"
                        >
                            <label class="doc-search" for="doc-search-input">
                                <i class="bi bi-search"></i>
                                <input
                                    id="doc-search-input"
                                    type="search"
                                    x-model="query"
                                    x-on:focus="open = true"
                                    x-on:input="open = true; activeIndex = 0"
                                    placeholder="Buscar componentes, props e exemplos"
                                    autocomplete="off"
                                >
                            </label>

                            <div class="doc-search-panel" x-cloak x-show="open" x-transition.opacity.duration.150ms>
                                <template x-if="hasResults">
                                    <div class="divide-y divide-light">
                                        <template x-for="(item, index) in results" x-bind:key="item.url">
                                            <button
                                                type="button"
                                                class="doc-search-result"
                                                x-bind:class="index === activeIndex ? 'doc-search-result-active' : ''"
                                                x-on:mouseenter="activeIndex = index"
                                                x-on:click="select(index)"
                                            >
                                                <span class="doc-search-result-meta">
                                                    <span x-text="item.type"></span>
                                                    <span x-text="item.tag"></span>
                                                </span>
                                                <span class="doc-search-result-title" x-text="item.title"></span>
                                                <span class="doc-search-result-copy" x-text="item.subtitle"></span>
                                            </button>
                                        </template>
                                    </div>
                                </template>

                                <div class="doc-search-empty" x-show="! hasResults">
                                    Nenhuma informacao encontrada.
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <span class="hidden text-sm text-secondary md:inline">Pacote conectado</span>
                            <span class="doc-status-dot"></span>
                        </div>
                    </header>

                    <main class="doc-content">
                        @yield('content')
                    </main>
                </div>
            </div>
        </div>

        @livewireScriptConfig
    </body>
</html>
