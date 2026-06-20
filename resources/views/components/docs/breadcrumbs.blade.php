@props(['items' => []])

<nav class="doc-breadcrumb" aria-label="Breadcrumb">
    <ol>
        @foreach ($items as $item)
            <li>
                @if (! $loop->last && filled($item['href'] ?? null))
                    <a href="{{ $item['href'] }}">{{ $item['label'] }}</a>
                    <i class="bi bi-chevron-right" aria-hidden="true"></i>
                @else
                    <span aria-current="page">{{ $item['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
