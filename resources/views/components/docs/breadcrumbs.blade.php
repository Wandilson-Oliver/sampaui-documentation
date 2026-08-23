@props(['items' => []])

<nav class="doc-breadcrumb" aria-label="Breadcrumb">
    <ol class="doc-breadcrumb-list">
        @foreach ($items as $item)
            <li class="doc-breadcrumb-item">
                @if (! $loop->last && filled($item['href'] ?? null))
                    <a href="{{ $item['href'] }}" class="doc-breadcrumb-link">{{ $item['label'] }}</a>
                    <i class="bi bi-chevron-right doc-breadcrumb-sep" aria-hidden="true"></i>
                @else
                    <span class="doc-breadcrumb-current" aria-current="page">{{ $item['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
