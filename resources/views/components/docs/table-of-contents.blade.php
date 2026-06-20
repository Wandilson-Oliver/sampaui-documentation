@props(['items' => []])

<aside class="doc-toc" aria-label="Nesta página" x-data="tableOfContents(@js($items))">
    <p>Nesta página</p>
    <nav>
        @foreach ($items as $item)
            <a
                href="#{{ $item['id'] }}"
                x-on:click="activeId = '{{ $item['id'] }}'"
                x-bind:class="activeId === '{{ $item['id'] }}' ? 'doc-toc-link-active' : ''"
            >
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>
</aside>
