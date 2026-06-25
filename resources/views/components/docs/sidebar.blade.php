@props([
    'navigationComponents' => [],
    'navigationPages' => [],
    'navigationExamples' => [],
])

@php
    $groupIcons = [
        'Formulários' => 'ui-checks-grid',
        'Design de UI' => 'grid-1x2',
        'Data' => 'table',
        'Overlay' => 'window-stack',
        'Navigation' => 'signpost-split',
        'Feedback' => 'chat-square-heart',
        'Layout' => 'layout-three-columns',
        'Real Estate' => 'buildings',
    ];
    $componentGroups = [
        'Formulários' => collect($navigationComponents)->filter(fn (array $component): bool => \App\Support\DocumentationGuidance::category($component['slug']) === 'Formulários')->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE),
        'Design de UI' => collect($navigationComponents)->filter(fn (array $component): bool => \App\Support\DocumentationGuidance::category($component['slug']) === 'Design de UI')->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE),
        'Data' => collect($navigationComponents)->filter(fn (array $component): bool => \App\Support\DocumentationGuidance::category($component['slug']) === 'Data')->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE),
        'Overlay' => collect($navigationComponents)->filter(fn (array $component): bool => \App\Support\DocumentationGuidance::category($component['slug']) === 'Overlay')->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE),
        'Navigation' => collect($navigationComponents)->filter(fn (array $component): bool => \App\Support\DocumentationGuidance::category($component['slug']) === 'Navigation')->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE),
        'Feedback' => collect($navigationComponents)->filter(fn (array $component): bool => \App\Support\DocumentationGuidance::category($component['slug']) === 'Feedback')->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE),
        'Layout' => collect($navigationComponents)->filter(fn (array $component): bool => \App\Support\DocumentationGuidance::category($component['slug']) === 'Layout')->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE),
        'Real Estate' => collect($navigationComponents)->filter(fn (array $component): bool => \App\Support\DocumentationGuidance::category($component['slug']) === 'Real Estate')->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE),
    ];
    $designSystemPage = collect($navigationPages)->firstWhere('slug', 'design-system');
    $sideNavigationPages = collect($navigationPages)
        ->reject(fn (array $page): bool => ($page['slug'] ?? null) === 'design-system')
        ->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
        ->values();
    $navigationExamples = collect($navigationExamples)->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)->values();
@endphp

<aside
    id="docs-sidebar"
    class="doc-menu-panel"
    x-bind:class="sidebarOpen ? 'doc-menu-panel-open' : ''"
    x-on:click="if ($event.target.closest('a')) sidebarOpen = false"
    aria-label="Navegação da documentação"
>
    <div class="doc-sidebar-header">
        <a href="{{ route('documentation') }}" class="doc-brand" aria-label="SampaUI - início da documentação">
            <span class="doc-brand-mark">S</span>
            <span>
                <strong>SampaUI</strong>
                <small>Documentação</small>
            </span>
        </a>

        <button type="button" class="doc-icon-button lg:hidden" x-on:click="sidebarOpen = false" aria-label="Fechar menu">
            <i class="bi bi-x-lg" aria-hidden="true"></i>
        </button>
    </div>

    <nav aria-label="Seções SampaUI" class="doc-sidebar-nav">
        <a href="{{ route('documentation') }}" @class(['doc-menu-link', 'doc-menu-link-active' => request()->routeIs('documentation')])>
            <i class="bi bi-grid-1x2" aria-hidden="true"></i>
            <span>Visão geral</span>
        </a>

        @if ($designSystemPage)
            <a
                href="{{ route('documentation.pages.show', $designSystemPage['slug']) }}"
                @class([
                    'doc-menu-link',
                    'doc-menu-link-active' => request()->routeIs('documentation.pages.show') && request()->route('page') === $designSystemPage['slug'],
                ])
            >
                <i class="bi bi-palette2" aria-hidden="true"></i>
                <span>Design system</span>
            </a>
        @endif

        @foreach ($componentGroups as $groupName => $groupComponents)
            @if ($groupComponents->isNotEmpty())
                <section class="doc-menu-section" aria-labelledby="sidebar-{{ str($groupName)->slug() }}">
                    <h2 id="sidebar-{{ str($groupName)->slug() }}" class="doc-menu-section-title">
                        <span><i class="bi bi-{{ $groupIcons[$groupName] ?? 'grid-1x2' }}" aria-hidden="true"></i>{{ $groupName }}</span>
                        <small>{{ $groupComponents->count() }}</small>
                    </h2>

                    <div class="doc-menu-items">
                        @foreach ($groupComponents as $navigationComponent)
                            <a
                                href="{{ route('documentation.components.show', $navigationComponent['slug']) }}"
                                @class([
                                    'doc-menu-item',
                                    'doc-menu-item-active' => request()->routeIs('documentation.components.show') && request()->route('component') === $navigationComponent['slug'],
                                ])
                            >
                                <span>{{ $navigationComponent['name'] }}</span>
                                @if ((\App\Support\DocumentationGuidance::status($navigationComponent)) === 'Planejado')
                                    <small class="doc-menu-badge doc-menu-badge-planned">Planejado</small>
                                @elseif (\App\Support\DocumentationGuidance::isPopular($navigationComponent['slug']))
                                    <small class="doc-menu-badge">Popular</small>
                                @elseif (\App\Support\DocumentationGuidance::isNew($navigationComponent['slug']))
                                    <small class="doc-menu-badge doc-menu-badge-new">Novo</small>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif
        @endforeach

        @if ($navigationExamples->isNotEmpty())
            <section class="doc-menu-section" aria-labelledby="sidebar-exemplos">
                <h2 id="sidebar-exemplos" class="doc-menu-section-title">
                    <span><i class="bi bi-window-stack" aria-hidden="true"></i>Blocks/Templates</span>
                    <small>{{ $navigationExamples->count() }}</small>
                </h2>
                <div class="doc-menu-items">
                    <a href="{{ route('examples.index') }}" @class(['doc-menu-item', 'doc-menu-item-active' => request()->routeIs('examples.index')])>Visão geral</a>
                    @foreach ($navigationExamples as $navigationExample)
                        <a href="{{ route($navigationExample['route']) }}" @class(['doc-menu-item', 'doc-menu-item-active' => request()->routeIs($navigationExample['route'])])>
                            {{ $navigationExample['name'] }}
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        @if ($sideNavigationPages->isNotEmpty())
            <section class="doc-menu-section" aria-labelledby="sidebar-guias">
                <h2 id="sidebar-guias" class="doc-menu-section-title">
                    <span><i class="bi bi-journal-text" aria-hidden="true"></i>Guias</span>
                    <small>{{ $sideNavigationPages->count() }}</small>
                </h2>
                <div class="doc-menu-items">
                    @foreach ($sideNavigationPages as $navigationPage)
                        <a
                            href="{{ route('documentation.pages.show', $navigationPage['slug']) }}"
                            @class([
                                'doc-menu-item',
                                'doc-menu-item-active' => request()->routeIs('documentation.pages.show') && request()->route('page') === $navigationPage['slug'],
                            ])
                        >
                            {{ $navigationPage['name'] }}
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </nav>

    <div class="doc-menu-footer">
        <span class="doc-version-badge">Docs v{{ config('docs.version') }}</span>
        <p>Laravel 13 · Livewire 4 · Tailwind 4</p>
    </div>
</aside>
