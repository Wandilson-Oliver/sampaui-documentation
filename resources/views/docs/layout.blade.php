<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Documentação SampaUI para produtos digitais em Laravel 13, Livewire 4 e Tailwind 4.">

        <title>{{ $title ?? 'Documentação SampaUI' }}</title>
        <link rel="icon" type="image/png" href="{{ asset('images/icon_favicon_sampaui.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/icon_favicon_sampaui.png') }}">

        <script>
            (() => {
                const savedTheme = localStorage.getItem('sampaui-docs-theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                document.documentElement.classList.toggle('dark', savedTheme ? savedTheme === 'dark' : prefersDark);
            })();
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="doc-shell" x-data="docsShell()">
        @php
            $navigationExamples = collect($navigationExamples ?? []);
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
                        'popular' => \App\Support\DocumentationGuidance::isPopular($component['slug'] ?? ''),
                        'recent' => \App\Support\DocumentationGuidance::isNew($component['slug'] ?? ''),
                        'search' => implode(' ', [$component['name'] ?? '', $component['slug'] ?? '', $component['tag'] ?? '', $component['summary'] ?? '', $component['description'] ?? '', $props, $examples]),
                    ];
                })
                ->merge(collect($navigationPages ?? [])->map(fn (array $page): array => [
                    'type' => 'Página',
                    'title' => $page['name'],
                    'subtitle' => $page['summary'] ?? $page['description'] ?? '',
                    'tag' => $page['tag'] ?? 'Página',
                    'url' => route('documentation.pages.show', $page['slug']),
                    'popular' => false,
                    'recent' => false,
                    'search' => implode(' ', [$page['name'] ?? '', $page['slug'] ?? '', $page['tag'] ?? '', $page['summary'] ?? '', $page['description'] ?? '', $page['code'] ?? '']),
                ]))
                ->merge($navigationExamples->map(fn (array $example): array => [
                    'type' => 'Exemplo',
                    'title' => $example['name'],
                    'subtitle' => $example['summary'] ?? '',
                    'tag' => $example['tag'] ?? 'Exemplo',
                    'url' => route($example['route']),
                    'popular' => in_array($example['route'] ?? '', ['examples.dashboard', 'examples.advanced-table', 'examples.authentication'], true),
                    'recent' => in_array($example['route'] ?? '', ['examples.chat', 'examples.users.index'], true),
                    'search' => implode(' ', [$example['name'] ?? '', $example['slug'] ?? '', $example['tag'] ?? '', $example['summary'] ?? '']),
                ]))
                ->push([
                    'type' => 'Ferramenta',
                    'title' => 'Playground',
                    'subtitle' => 'Editor de código interativo com Live Preview e Tailwind CSS em tempo real.',
                    'tag' => 'Playground',
                    'url' => route('playground'),
                    'popular' => true,
                    'recent' => true,
                    'search' => 'playground editor live preview codepen tailwind play html css js',
                ])
                ->values();

            $tableOfContents = $tableOfContents ?? match (true) {
                request()->routeIs('documentation') => [
                    ['id' => 'home-title', 'label' => 'Visão geral'],
                    ['id' => 'instalacao', 'label' => 'Instalação'],
                    ['id' => 'templates-title', 'label' => 'Templates'],
                    ['id' => 'componentes', 'label' => 'Componentes'],
                    ['id' => 'roadmap', 'label' => 'Roadmap'],
                ],
                request()->routeIs('documentation.components.show') => [
                    ['id' => 'visao-geral', 'label' => 'Visão geral'],
                    ['id' => 'exemplos', 'label' => 'Exemplos'],
                    ['id' => 'boas-praticas', 'label' => 'Boas práticas'],
                    ['id' => 'props', 'label' => 'Props e atributos'],
                    ['id' => 'api-eventos', 'label' => 'API e eventos'],
                    ['id' => 'acessibilidade', 'label' => 'Acessibilidade'],
                ],
                request()->routeIs('documentation.pages.show') => [
                    ['id' => 'visao-geral', 'label' => 'Visão geral'],
                    ['id' => 'preview', 'label' => 'Preview'],
                    ['id' => 'implementacao', 'label' => 'Implementação'],
                ],
                default => [],
            };
        @endphp

        <div class="doc-app-frame">
            <div
                class="doc-sidebar-backdrop"
                x-cloak
                x-show="sidebarOpen"
                x-transition.opacity.duration.180ms
                x-on:click="sidebarOpen = false"
                aria-hidden="true"
            ></div>

            <x-docs.sidebar
                :navigation-components="$navigationComponents ?? []"
                :navigation-pages="$navigationPages ?? []"
                :navigation-examples="$navigationExamples"
            />

            <div
                class="doc-main-scroll"
                x-ref="scrollArea"
                x-on:scroll.throttle.80ms="showBackToTop = $event.target.scrollTop > 560"
            >
                <x-docs.topbar :search-items="$searchItems" />

                <main @class(['doc-content', 'doc-content-with-toc' => filled($tableOfContents)])>
                    <div class="doc-reading-column">
                        @yield('content')
                    </div>

                    @if (filled($tableOfContents))
                        <x-docs.table-of-contents :items="$tableOfContents" />
                    @endif
                </main>

                <x-docs.footer />
            </div>
        </div>

        <button
            type="button"
            class="doc-back-to-top"
            x-cloak
            x-show="showBackToTop"
            x-transition.opacity.duration.180ms
            x-on:click="scrollToTop()"
            aria-label="Voltar ao topo"
            title="Voltar ao topo"
        >
            <i class="bi bi-arrow-up" aria-hidden="true"></i>
        </button>

        @livewireScriptConfig
    </body>
</html>
