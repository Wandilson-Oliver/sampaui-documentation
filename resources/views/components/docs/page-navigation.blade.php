@props(['previous' => null, 'next' => null])

@if ($previous || $next)
    <nav class="doc-page-navigation" aria-label="Navegação entre páginas">
        @if ($previous)
            <a href="{{ $previous['url'] }}" rel="prev" class="doc-page-nav-card doc-page-nav-prev">
                <span class="doc-page-nav-icon"><i class="bi bi-arrow-left" aria-hidden="true"></i></span>
                <div class="doc-page-nav-body">
                    <span class="doc-page-nav-dir">Anterior</span>
                    <strong class="doc-page-nav-title">{{ $previous['label'] }}</strong>
                </div>
            </a>
        @else
            <div></div>
        @endif

        @if ($next)
            <a href="{{ $next['url'] }}" rel="next" class="doc-page-nav-card doc-page-nav-next">
                <div class="doc-page-nav-body text-right">
                    <span class="doc-page-nav-dir">Próximo</span>
                    <strong class="doc-page-nav-title">{{ $next['label'] }}</strong>
                </div>
                <span class="doc-page-nav-icon"><i class="bi bi-arrow-right" aria-hidden="true"></i></span>
            </a>
        @endif
    </nav>
@endif
