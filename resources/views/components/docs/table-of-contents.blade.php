@props(['items' => []])

<aside class="doc-toc" aria-label="Nesta página" x-data="tableOfContents(@js($items))">
    <div class="doc-toc-title">
        <i class="bi bi-list-nested" aria-hidden="true"></i>
        <span>Nesta página</span>
    </div>
    <nav class="doc-toc-list">
        @foreach ($items as $item)
            <a
                href="#{{ $item['id'] }}"
                x-on:click="activeId = '{{ $item['id'] }}'"
                x-bind:class="activeId === '{{ $item['id'] }}' ? 'doc-toc-link-active' : ''"
                class="doc-toc-link"
            >
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>
</aside>
