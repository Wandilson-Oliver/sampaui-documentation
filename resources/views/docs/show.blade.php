@extends('docs.layout', ['title' => $componentDoc['name'].' · Documentação SampaUI'])

@section('content')
    @php
        $showcases = $componentDoc['showcases'] ?? $componentDoc['examples'];
        $category = \App\Support\DocumentationGuidance::category($componentDoc['slug']);
        $guidance = \App\Support\DocumentationGuidance::for($componentDoc);
        $status = \App\Support\DocumentationGuidance::status($componentDoc);
        $isPlanned = $status === 'Planejado';
        $showcaseCodes = collect($showcases)->map(function (array $s): ?string {
            return $s['code'] ?? ($s['code_examples']['Blade'] ?? ($s['code_examples']['Livewire'] ?? null));
        })->filter();
        $recipes = collect($componentDoc['examples'] ?? [])
            ->reject(fn (array $example): bool => $showcaseCodes->contains($example['code'] ?? ($example['code_examples']['Blade'] ?? null)))
            ->unique(fn (array $example): string => $example['code'] ?? ($example['code_examples']['Blade'] ?? ($example['code_examples']['Livewire'] ?? $example['title'])));
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
            <div class="doc-component-tag-wrap" x-data="copyCode()">
                <span class="doc-component-tag" x-ref="code">{{ $componentDoc['tag'] }}</span>
                <button type="button" class="doc-copy-tag-btn" x-on:click="copy($refs.code.innerText)" title="Copiar tag">
                    <i class="bi" x-bind:class="copied ? 'bi-check2 text-emerald-500' : 'bi-copy'" aria-hidden="true"></i>
                    <span x-text="copied ? 'Copiado!' : 'Copiar'"></span>
                </button>
            </div>
            <h1>{{ $componentDoc['name'] }}</h1>
            @php
                $summary = trim($componentDoc['summary'] ?? '');
                $description = trim($componentDoc['description'] ?? '');
                $hasDifferentDescription = $description && strtolower($summary) !== strtolower($description) && ! str_starts_with(strtolower($description), strtolower($summary));
            @endphp
            <p class="doc-hero-summary">{{ $summary }}</p>
            @if ($hasDifferentDescription)
                <p class="doc-hero-description">{{ $description }}</p>
            @endif
            <div class="doc-component-badges" aria-label="Metadados do componente">
                <span class="doc-badge-pill"><i class="bi bi-folder" aria-hidden="true"></i>{{ $category }}</span>
                <span class="doc-badge-pill"><i class="bi bi-sliders" aria-hidden="true"></i>{{ count($componentDoc['props']) }} props</span>
                <span class="doc-badge-pill"><i class="bi bi-{{ $isPlanned ? 'clock-history' : 'check2-circle' }}" aria-hidden="true"></i>{{ $status }}</span>
                @if (\App\Support\DocumentationGuidance::isPopular($componentDoc['slug']))
                    <span class="doc-badge-pill doc-badge-popular"><i class="bi bi-star-fill" aria-hidden="true"></i>Popular</span>
                @endif
            </div>
        </div>
    </section>

    @if ($isPlanned)
        <section class="doc-planned-callout" aria-labelledby="planned-title">
            <span><i class="bi bi-{{ $componentDoc['planned_icon'] ?? 'buildings' }}" aria-hidden="true"></i></span>
            <div>
                <h2 id="planned-title">Componente planejado, ainda não disponível no pacote.</h2>
                <p>Esta página documenta direção de produto e intenção de API. Não copie a tag como implementação final até o componente existir no pacote SampaUI.</p>
            </div>
        </section>
    @endif

    <section id="exemplos" class="doc-section">
        <div class="doc-section-heading">
            <span>Exemplos</span>
            <h2>{{ $isPlanned ? 'API prevista' : 'Exemplos de uso' }}</h2>
            <p>{{ $isPlanned ? 'Preview conceitual e snippet ilustrativo para guiar a futura implementação. Não representa componente pronto.' : 'Implementações objetivas com o componente renderizado e o código correspondente.' }}</p>
        </div>

        <div class="doc-example-list">
            @foreach ($showcases as $showcase)
                @php
                    $previewCode = $showcase['preview'] ?? ($showcase['code'] ?? ($showcase['code_examples']['Blade'] ?? ($showcase['code_examples']['Livewire'] ?? '')));
                    $previewHtml = match (true) {
                        $isPlanned => '<div class="doc-planned-preview-large">'.view('docs.partials.component-preview', ['slug' => $componentDoc['slug']])->render().'</div>',
                        $componentDoc['slug'] === 'modal' => view('docs.partials.modal-livewire-preview', [
                            'title' => $showcase['title'],
                            'index' => $loop->index,
                        ])->render(),
                        default => \Illuminate\Support\Facades\Blade::render($previewCode),
                    };
                    if (isset($showcase['code_examples']) && is_array($showcase['code_examples'])) {
                        $codeExamples = $showcase['code_examples'];
                    } else {
                        $codeExamples = [];
                        if (isset($showcase['blade'])) {
                            $codeExamples['Blade'] = trim($showcase['blade']);
                        } elseif (isset($showcase['code']) && ! str_contains($showcase['code'], 'wire:')) {
                            $codeExamples['Blade'] = trim($showcase['code']);
                        }

                        if (isset($showcase['livewire'])) {
                            $codeExamples['Livewire'] = trim($showcase['livewire']);
                        } elseif (isset($showcase['code']) && str_contains($showcase['code'], 'wire:')) {
                            $codeExamples['Livewire'] = trim($showcase['code']);
                        }

                        if (isset($showcase['livewire_php'])) {
                            $codeExamples['PHP (Componente)'] = trim($showcase['livewire_php']);
                        }

                        if (empty($codeExamples)) {
                            $codeExamples['Blade'] = trim($showcase['code'] ?? '');
                        }
                    }
                @endphp

                <x-docs.example
                    :title="$showcase['title']"
                    :description="$showcase['description']"
                    :preview-html="$previewHtml"
                    :code-examples="$codeExamples"
                />
            @endforeach
        </div>

        @if ($recipes->isNotEmpty())
            <div class="doc-recipes">
                <div class="doc-section-heading doc-section-heading-compact">
                    <span>Receitas rápidas</span>
                    <h2>Copiar, colar e adaptar</h2>
                </div>

                @foreach ($recipes as $example)
                    @php
                        $exampleCode = $example['code'] ?? ($example['code_examples']['Blade'] ?? ($example['code_examples']['Livewire'] ?? ''));
                        $language = str_contains($exampleCode, 'public function') || str_contains($example['title'], 'Classe Livewire') ? 'PHP' : (str_contains($exampleCode, 'wire:') ? 'Livewire' : 'Blade');
                    @endphp
                    <article class="doc-recipe">
                        <div>
                            <h3>{{ $example['title'] }}</h3>
                            <p>{{ $example['description'] }}</p>
                        </div>
                        <x-docs.code-block :code="$exampleCode" :label="$language" />
                    </article>
                @endforeach
            </div>
        @endif
    </section>

    <section id="boas-praticas" class="doc-section">
        <div class="doc-section-heading">
            <span>Boas práticas</span>
            <h2>Como usar sem perder consistência</h2>
            <p>Decisões rápidas para manter API, acessibilidade e visual alinhados ao framework.</p>
        </div>

        <div class="doc-practice-grid">
            <article>
                <h3>Use quando</h3>
                <ul>
                    @foreach ($guidance['use'] as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </article>
            <article>
                <h3>Evite</h3>
                <ul>
                    @foreach ($guidance['avoid'] as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </article>
            <article>
                <h3>Erros comuns</h3>
                <ul>
                    @foreach ($guidance['errors'] as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </article>
        </div>
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

    <section id="api-eventos" class="doc-section">
        <div class="doc-section-heading">
            <span>API e eventos</span>
            <h2>Integração com Blade, Livewire e Alpine</h2>
            <p>Resumo dos pontos de extensão que devem continuar estáveis no consumo do pacote.</p>
        </div>

        <div class="doc-api-grid">
            <div>
                <strong>Atributos</strong>
                <p>{{ implode(', ', $componentDoc['attributes'] ?? ['class', 'wire:*', 'x-*']) }}</p>
            </div>
            <div>
                <strong>Variantes</strong>
                <p>{{ collect($componentDoc['props'])->firstWhere('name', 'variant')['type'] ?? ($isPlanned ? 'Planejado' : 'Consulte props') }}</p>
            </div>
            <div>
                <strong>Eventos</strong>
                <p>{{ str_contains(collect($componentDoc['examples'])->pluck('code')->implode(' '), '$dispatch') || str_contains(collect($componentDoc['examples'])->pluck('code')->implode(' '), 'dispatch') ? 'Possui exemplos com eventos Alpine/Livewire.' : 'Sem evento público obrigatório documentado.' }}</p>
            </div>
        </div>
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
