@extends('docs.layout', ['title' => $component['name'].' · Documentação SampaUI'])

@section('content')
    @php
        $showcases = $component['showcases'] ?? $component['examples'];
    @endphp

    <div class="doc-component-layout">
        <main class="doc-examples-column">
            <section class="doc-component-intro-grid">
                <article class="doc-hero-card doc-component-hero">
                    <div class="relative z-[1]">
                        <p class="doc-kicker">{{ $component['tag'] }}</p>
                        <h1 class="mt-3 text-3xl font-semibold tracking-tight text-primary md:text-4xl">{{ $component['name'] }}</h1>
                        <p class="mt-4 max-w-3xl text-sm leading-6 text-secondary">{{ $component['summary'] }}</p>
                        <p class="mt-3 max-w-3xl text-sm leading-6 text-secondary">{{ $component['description'] }}</p>
                    </div>
                </article>
            </section>

            <section class="doc-component-board">
                <div class="doc-section-header">
                    <div>
                        <p class="doc-kicker">Exemplos</p>
                        <h2 class="doc-heading">Variacoes e implementacao</h2>
                        <p class="doc-copy">
                            Cada bloco mostra o componente renderizado e o codigo Blade usado para reproduzir a variacao.
                        </p>
                    </div>
                    <span class="doc-chip">{{ $component['tag'] }}</span>
                </div>

                <div class="doc-showcase-list">
                    @foreach ($showcases as $showcase)
                        @php
                            $previewCode = $showcase['preview'] ?? $showcase['code'];
                            $previewHtml = \Illuminate\Support\Facades\Blade::render($previewCode);
                        @endphp

                        <article class="doc-showcase-card">
                            <div class="doc-showcase-header">
                                <div>
                                    <h2>{{ $showcase['title'] }}</h2>
                                    <p>{{ $showcase['description'] }}</p>
                                </div>
                                <span class="doc-chip">Blade</span>
                            </div>

                            <div class="doc-showcase-preview">
                                {!! $previewHtml !!}
                            </div>

                            <div class="doc-showcase-code-wrap" x-data="{ copied: false }">
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

                                <div class="doc-code-label">Implementacao</div>
                                <pre class="doc-showcase-code"><code x-ref="code">{{ trim($showcase['code']) }}</code></pre>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>

            @if (! empty($component['examples']))
                <section class="doc-component-board">
                    <div class="doc-section-header">
                        <div>
                            <p class="doc-kicker">Receitas rapidas</p>
                            <div class="mt-2 flex flex-wrap items-center gap-3">
                                <h2 class="text-2xl font-semibold leading-tight text-primary">Copiar, colar e adaptar</h2>
                                <span class="doc-chip">{{ count($component['examples']) }} exemplos</span>
                            </div>
                            <p class="doc-copy">
                                Exemplos objetivos para casos comuns. Eles mostram a chamada Blade minima e as props que normalmente mudam por tela.
                            </p>
                        </div>
                    </div>

                    <div class="doc-recipe-list">
                        @foreach ($component['examples'] as $example)
                            <article class="doc-recipe-row">
                                <div class="doc-recipe-copy">
                                    <h3>{{ $example['title'] }}</h3>
                                    <p>{{ $example['description'] }}</p>
                                </div>

                                <div class="doc-recipe-code" x-data="{ copied: false }">
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
                                    <pre><code x-ref="code">{{ trim($example['code']) }}</code></pre>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        </main>

        <aside class="doc-explanations-column" aria-label="Explicacoes do componente">
            <article class="doc-explanation-card">
                <p class="doc-kicker">Explicacoes</p>
                <h2 class="doc-heading">Como implementar</h2>
                <ol class="mt-5 space-y-3 text-sm leading-6 text-secondary">
                    <li><strong class="text-primary">1.</strong> Use <code>{{ $component['tag'] }}</code> direto no Blade ou em views Livewire.</li>
                    <li><strong class="text-primary">2.</strong> Configure as props documentadas na API.</li>
                    <li><strong class="text-primary">3.</strong> Passe atributos HTML, Alpine ou <code>wire:*</code> no componente.</li>
                    <li><strong class="text-primary">4.</strong> Ajuste visualmente com <code>class=""</code> e tokens oficiais.</li>
                </ol>
            </article>

            <section class="doc-api-section doc-api-section-compact">
                <article class="doc-stat-card doc-api-intro">
                    <div class="doc-stat-icon bg-primary">
                        <i class="bi bi-braces"></i>
                    </div>
                    <div>
                        <p class="doc-kicker">API</p>
                        <h2 class="doc-heading">Props e atributos</h2>
                        <p class="doc-copy">
                            Props consumidas pelo Blade e atributos preservados no elemento principal ou controle nativo.
                        </p>
                    </div>
                </article>

                @if (! empty($component['attributes']))
                    <div class="doc-attribute-strip doc-attribute-strip-compact">
                        <span>Atributos preservados</span>
                        <div>
                            @foreach ($component['attributes'] as $attribute)
                                <code>{{ $attribute }}</code>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="doc-prop-list">
                    @foreach ($component['props'] as $prop)
                        <article class="doc-prop-item">
                            <div class="flex items-start justify-between gap-3">
                                <h3>{{ $prop['name'] }}</h3>
                                <code>{{ $prop['default'] }}</code>
                            </div>
                            <p class="doc-prop-type">{{ $prop['type'] }}</p>
                            <p>{{ $prop['notes'] }}</p>
                        </article>
                    @endforeach
                </div>
            </section>

            <section class="doc-explanation-card">
                <p class="doc-kicker">Acessibilidade</p>
                <h2 class="doc-heading">Checklist minimo</h2>
                <div class="mt-5 grid gap-3">
                    @foreach ($component['accessibility'] as $guideline)
                        <div class="doc-check-card">
                            <i class="bi bi-universal-access-circle"></i>
                            <span>{{ $guideline }}</span>
                        </div>
                    @endforeach
                </div>
            </section>
        </aside>
    </div>
@endsection
