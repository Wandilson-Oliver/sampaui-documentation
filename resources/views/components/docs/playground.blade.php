@props([
    'title',
    'description',
    'previewHtml',
    'codeExamples' => [],
])

@php($tabs = array_keys($codeExamples))

<article class="doc-playground" x-data="{ activeTab: @js($tabs[0] ?? 'Blade') }">
    <header class="doc-playground-header">
        <div>
            <h3>{{ $title }}</h3>
            <p>{{ $description }}</p>
        </div>

        <div class="doc-code-tabs" role="tablist" aria-label="Linguagem do exemplo">
            @foreach ($tabs as $tab)
                <button
                    type="button"
                    role="tab"
                    x-on:click="activeTab = @js($tab)"
                    x-bind:aria-selected="(activeTab === @js($tab)).toString()"
                    x-bind:class="activeTab === @js($tab) ? 'doc-code-tab-active' : ''"
                >
                    {{ $tab }}
                </button>
            @endforeach
        </div>
    </header>

    <div class="doc-playground-preview">
        {!! $previewHtml !!}
    </div>

    @foreach ($codeExamples as $label => $code)
        <div x-show="activeTab === @js($label)" x-cloak>
            <x-docs.code-block :code="$code" :label="$label" tone="light" />
        </div>
    @endforeach
</article>
