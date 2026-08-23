@props([
    'title',
    'description',
    'previewHtml',
    'codeExamples' => [],
])

@php($tabs = array_keys($codeExamples))

<article class="doc-example doc-example-card" x-data="{ activeTab: @js($tabs[0] ?? 'Blade') }">
    <header class="doc-example-header">
        <div class="doc-example-header-title">
            <h3>{{ $title }}</h3>
            @if ($description)
                <p>{{ $description }}</p>
            @endif
        </div>

        @if (count($tabs) > 1)
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
        @endif
    </header>

    <div class="doc-example-preview">
        {!! $previewHtml !!}
    </div>

    @foreach ($codeExamples as $label => $code)
        <div class="doc-example-code" x-show="activeTab === @js($label)" x-cloak>
            <x-docs.code-block :code="$code" :label="$label" tone="light" />
        </div>
    @endforeach
</article>
