@extends('docs.layout', ['title' => $page['name'].' · SampaUI Pages'])

@section('content')
    @php
        $pageNavigation = collect($navigationPages)->values();
        $currentPageIndex = $pageNavigation->search(fn (array $navigationPage): bool => $navigationPage['slug'] === $page['slug']);
        $previousPage = $currentPageIndex !== false && $currentPageIndex > 0 ? $pageNavigation->get($currentPageIndex - 1) : null;
        $nextPage = $currentPageIndex !== false ? $pageNavigation->get($currentPageIndex + 1) : null;
    @endphp

    <section id="visao-geral">
        <article class="doc-hero-card">
            <x-docs.breadcrumbs :items="[
                ['label' => 'Documentação', 'href' => route('documentation')],
                ['label' => 'Guias', 'href' => route('documentation')],
                ['label' => $page['name']],
            ]" />

            <p class="mt-8 text-xs font-semibold uppercase tracking-[0.24em] text-primary">{{ $page['tag'] }}</p>
            <h1 class="mt-3 text-4xl font-semibold tracking-tight text-primary md:text-5xl">{{ $page['name'] }}</h1>
            <p class="mt-5 max-w-3xl text-base leading-7 text-secondary">{{ $page['description'] }}</p>
        </article>
    </section>

    <section id="preview" class="doc-component-board">
        <div class="doc-section-header">
            <div>
                <p class="doc-kicker">Preview</p>
                <h2 class="doc-heading">Pagina composta com SampaUI</h2>
                <p class="doc-copy">
                    O exemplo abaixo usa somente componentes do pacote e classes utilitarias do layout consumidor.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
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
        </div>

        <div class="doc-page-preview">
            {!! \Illuminate\Support\Facades\Blade::render($page['preview']) !!}
        </div>
    </section>

    <section id="implementacao" class="doc-component-board">
        <div class="doc-section-header">
            <div>
                <p class="doc-kicker">Implementacao</p>
                <h2 class="doc-heading">Codigo base</h2>
                <p class="doc-copy">
                    Adapte rotas, propriedades Livewire, validacoes e dados reais conforme a aplicacao.
                </p>
            </div>
            <span class="doc-chip">Blade</span>
        </div>

        <div class="mt-6">
            <x-docs.code-block :code="$page['code']" label="Blade" />
        </div>
    </section>

    <x-docs.page-navigation
        :previous="$previousPage ? ['label' => $previousPage['name'], 'url' => route('documentation.pages.show', $previousPage['slug'])] : null"
        :next="$nextPage ? ['label' => $nextPage['name'], 'url' => route('documentation.pages.show', $nextPage['slug'])] : null"
    />
@endsection
