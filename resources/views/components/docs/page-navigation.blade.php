@props(['previous' => null, 'next' => null])

@if ($previous || $next)
    <nav class="doc-page-navigation" aria-label="Navegação entre páginas">
        @if ($previous)
            <a href="{{ $previous['url'] }}" rel="prev">
                <span><i class="bi bi-arrow-left" aria-hidden="true"></i> Anterior</span>
                <strong>{{ $previous['label'] }}</strong>
            </a>
        @else
            <span></span>
        @endif

        @if ($next)
            <a href="{{ $next['url'] }}" rel="next" class="doc-page-navigation-next">
                <span>Próximo <i class="bi bi-arrow-right" aria-hidden="true"></i></span>
                <strong>{{ $next['label'] }}</strong>
            </a>
        @endif
    </nav>
@endif
