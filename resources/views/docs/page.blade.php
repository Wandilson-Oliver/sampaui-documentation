@extends('docs.layout', ['title' => $page['name'].' · SampaUI Pages'])

@section('content')
    @php
        $pageNavigation = collect($navigationPages)->values();
        $currentPageIndex = $pageNavigation->search(fn (array $navigationPage): bool => $navigationPage['slug'] === $page['slug']);
        $previousPage = $currentPageIndex !== false && $currentPageIndex > 0 ? $pageNavigation->get($currentPageIndex - 1) : null;
        $nextPage = $currentPageIndex !== false ? $pageNavigation->get($currentPageIndex + 1) : null;
    @endphp

    <section id="visao-geral" class="doc-page-hero">
        <x-docs.breadcrumbs :items="[
            ['label' => 'Documentação', 'href' => route('documentation')],
            ['label' => 'Guias', 'href' => route('documentation')],
            ['label' => $page['name']],
        ]" />

        <div class="doc-page-hero-copy">
            <span class="doc-component-tag">{{ $page['tag'] }}</span>
            <h1>{{ $page['name'] }}</h1>
            <p>{{ $page['summary'] }}</p>
            <p>{{ $page['description'] }}</p>
        </div>
    </section>

    <section id="preview" class="doc-section">
        <div class="doc-section-heading">
            <span>Preview</span>
            <h2>Página composta com SampaUI</h2>
            <p>Conteúdo renderizado com componentes oficiais e classes utilitárias do layout consumidor.</p>
        </div>

        <div class="doc-page-board">
            <div class="doc-section-header">
                <span class="doc-chip">{{ $page['tag'] }}</span>
                <x-sampaui::button
                    variant="outline"
                    size="sm"
                    icon="box-arrow-up-right"
                    icon-position="right"
                    onclick="window.open('{{ route('documentation.pages.preview', $page['slug']) }}', '_blank')"
                >
                    Abrir página completa
                </x-sampaui::button>
            </div>

            <div class="doc-page-preview">
                {!! \Illuminate\Support\Facades\Blade::render($page['preview']) !!}
            </div>
        </div>
    </section>

    <section id="implementacao" class="doc-section">
        <div class="doc-section-heading">
            <span>Implementação</span>
            <h2>Código base</h2>
            <p>Adapte rotas, propriedades Livewire, validações e dados reais conforme a aplicação.</p>
        </div>

        <div class="doc-page-board">
            <div class="doc-section-header">
                <span class="doc-chip">Blade</span>
            </div>
            <x-docs.code-block :code="$page['code']" label="Blade" />
        </div>
    </section>

    <x-docs.page-navigation
        :previous="$previousPage ? ['label' => $previousPage['name'], 'url' => route('documentation.pages.show', $previousPage['slug'])] : null"
        :next="$nextPage ? ['label' => $nextPage['name'], 'url' => route('documentation.pages.show', $nextPage['slug'])] : null"
    />
@endsection
