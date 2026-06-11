@extends('docs.layout', ['title' => $page['name'].' · SampaUI Pages'])

@section('content')
    <section>
        <article class="doc-hero-card">
            <div class="doc-breadcrumb">
                <a href="{{ route('documentation') }}" class="transition hover:text-primary">Dashboard</a>
                <i class="bi bi-chevron-right text-xs"></i>
                <span>Pages</span>
                <i class="bi bi-chevron-right text-xs"></i>
                <span>{{ $page['name'] }}</span>
            </div>

            <p class="mt-8 text-xs font-semibold uppercase tracking-[0.24em] text-primary">{{ $page['tag'] }}</p>
            <h1 class="mt-3 text-4xl font-semibold tracking-tight text-primary md:text-5xl">{{ $page['name'] }}</h1>
            <p class="mt-5 max-w-3xl text-base leading-7 text-secondary">{{ $page['description'] }}</p>
        </article>
    </section>

    <section class="doc-component-board">
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

    <section class="doc-component-board">
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

        <div class="doc-showcase-code-wrap mt-6 rounded-[1.35rem] border border-light" x-data="{ copied: false }">
            <button
                type="button"
                class="doc-copy-button"
                x-bind:aria-label="copied ? 'Codigo copiado' : 'Copiar codigo'"
                x-on:click="
                    navigator.clipboard?.writeText($refs.code.innerText);
                    copied = true;
                    setTimeout(() => copied = false, 1200);
                "
            >
                <i class="bi" x-bind:class="copied ? 'bi-check2' : 'bi-copy'"></i>
            </button>

            <pre class="doc-showcase-code"><code x-ref="code">{{ trim($page['code']) }}</code></pre>
        </div>
    </section>
@endsection
