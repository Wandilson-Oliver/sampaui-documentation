@extends('docs.layout', ['title' => $componentDoc['name'].' · Documentação SampaUI'])

@section('content')
    @php
        $showcases = $componentDoc['showcases'] ?? $componentDoc['examples'];
        $category = \App\Support\DocumentationGuidance::category($componentDoc['slug']);
        $guidance = \App\Support\DocumentationGuidance::for($componentDoc);
        $relatedLivewireExample = collect($componentDoc['examples'] ?? [])->first(
            fn (array $example): bool => str_contains($example['code'] ?? '', 'wire:')
        );
        $relatedPhpExample = collect($componentDoc['examples'] ?? [])->first(
            fn (array $example): bool => str_contains($example['code'] ?? '', 'public function')
                || str_contains($example['code'] ?? '', 'public string')
                || str_contains($example['title'] ?? '', 'Classe Livewire')
        );
        $componentNavigation = collect($components)->values();
        $currentComponentIndex = $componentNavigation->search(fn (array $component): bool => $component['slug'] === $componentDoc['slug']);
        $previousComponent = $currentComponentIndex !== false && $currentComponentIndex > 0 ? $componentNavigation->get($currentComponentIndex - 1) : null;
        $nextComponent = $currentComponentIndex !== false ? $componentNavigation->get($currentComponentIndex + 1) : null;
    @endphp

    <section id="visao-geral" class="doc-page-hero">
        <x-docs.breadcrumbs :items="[
            ['label' => 'Componentes', 'href' => route('documentation')],
            ['label' => $category, 'href' => route('documentation').'#componentes'],
            ['label' => $componentDoc['name']],
        ]" />

        <div class="doc-page-hero-copy">
            <span class="doc-component-tag">{{ $componentDoc['tag'] }}</span>
            <h1>{{ $componentDoc['name'] }}</h1>
            <p>{{ $componentDoc['summary'] }}</p>
            <p>{{ $componentDoc['description'] }}</p>
        </div>

        <dl class="doc-page-facts">
            <div><dt>Categoria</dt><dd>{{ $category }}</dd></div>
            <div><dt>Props</dt><dd>{{ count($componentDoc['props']) }}</dd></div>
            <div><dt>Stack</dt><dd>Blade + Livewire</dd></div>
        </dl>
    </section>

    <section id="orientacoes" class="doc-section">
        <div class="doc-section-heading">
            <span>Decisão de uso</span>
            <h2>Quando este componente faz sentido</h2>
            <p>Critérios curtos para manter a interface consistente e evitar implementações redundantes.</p>
        </div>

        <x-docs.guidance :guidance="$guidance" />
    </section>

    <section id="playground" class="doc-section">
        <div class="doc-section-heading">
            <span>Playground</span>
            <h2>Preview e implementação</h2>
            <p>Compare o resultado renderizado com o código adequado à stack usada no exemplo.</p>
        </div>

        <div class="doc-playground-list">
            @foreach ($showcases as $showcase)
                @php
                    $previewCode = $showcase['preview'] ?? $showcase['code'];
                    $previewHtml = \Illuminate\Support\Facades\Blade::render($previewCode);
                    $codeExamples = ['Blade' => trim($showcase['code'])];

                    if (str_contains($showcase['code'], 'wire:')) {
                        $codeExamples = ['Livewire' => trim($showcase['code'])];
                    } elseif ($relatedLivewireExample) {
                        $codeExamples['Livewire'] = trim($relatedLivewireExample['code']);
                    }

                    if ($relatedPhpExample) {
                        $codeExamples['PHP'] = trim($relatedPhpExample['code']);
                    }
                @endphp

                <x-docs.playground
                    :title="$showcase['title']"
                    :description="$showcase['description']"
                    :preview-html="$previewHtml"
                    :code-examples="$codeExamples"
                />
            @endforeach
        </div>

        @if (! empty($componentDoc['examples']))
            <div class="doc-recipes">
                <div class="doc-section-heading doc-section-heading-compact">
                    <span>Receitas rápidas</span>
                    <h2>Copiar, colar e adaptar</h2>
                </div>

                @foreach ($componentDoc['examples'] as $example)
                    @php
                        $language = str_contains($example['code'], 'public function') || str_contains($example['title'], 'Classe Livewire') ? 'PHP' : (str_contains($example['code'], 'wire:') ? 'Livewire' : 'Blade');
                    @endphp
                    <article class="doc-recipe">
                        <div>
                            <h3>{{ $example['title'] }}</h3>
                            <p>{{ $example['description'] }}</p>
                        </div>
                        <x-docs.code-block :code="$example['code']" :label="$language" />
                    </article>
                @endforeach
            </div>
        @endif
    </section>

    <section id="props" class="doc-section">
        <div class="doc-section-heading">
            <span>API</span>
            <h2>Props e atributos</h2>
            <p>Contrato público do componente, com exemplos mínimos para acelerar a implementação.</p>
        </div>

        @if (! empty($componentDoc['attributes']))
            <div class="doc-attributes" aria-label="Atributos preservados">
                <strong>Atributos preservados</strong>
                <div>
                    @foreach ($componentDoc['attributes'] as $attribute)
                        <code>{{ $attribute }}</code>
                    @endforeach
                </div>
            </div>
        @endif

        <x-docs.props-table :props="$componentDoc['props']" />
    </section>

    <section id="acessibilidade" class="doc-section">
        <div class="doc-section-heading">
            <span>Acessibilidade</span>
            <h2>Checklist mínimo</h2>
            <p>Validações essenciais antes de colocar o componente em produção.</p>
        </div>

        <div class="doc-accessibility-list">
            @foreach ($componentDoc['accessibility'] as $guideline)
                <div>
                    <span class="doc-severity-icon"><i class="bi bi-universal-access-circle" aria-hidden="true"></i></span>
                    <p>{{ $guideline }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <x-docs.page-navigation
        :previous="$previousComponent ? ['label' => $previousComponent['name'], 'url' => route('documentation.components.show', $previousComponent['slug'])] : null"
        :next="$nextComponent ? ['label' => $nextComponent['name'], 'url' => route('documentation.components.show', $nextComponent['slug'])] : null"
    />
@endsection
