<footer class="doc-footer">
    <div>
        <a href="{{ route('documentation') }}" class="doc-footer-brand" aria-label="SampaUI - início da documentação">
            <span class="doc-brand-mark">S</span>
            <span><strong>SampaUI</strong><small>Componentes premium para Laravel</small></span>
        </a>
        <p>Documentação para criar CRMs, dashboards, autenticação e sistemas internos consistentes.</p>
    </div>

    <nav aria-label="Links do rodapé">
        <div>
            <strong>Documentação</strong>
            <a href="{{ route('documentation') }}#instalacao">Instalação</a>
            <a href="{{ route('documentation') }}#componentes">Componentes</a>
            <a href="{{ route('examples.index') }}">Exemplos</a>
        </div>
        <div>
            <strong>Ecossistema</strong>
            <a href="{{ route('documentation.pages.show', 'real-estate-patterns') }}">Padrões imobiliários</a>
            <a href="https://github.com/Wandilson-Oliver/sampaui-documentation" target="_blank" rel="noopener noreferrer">GitHub <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i></a>
            <span>Docs v{{ config('docs.version') }}</span>
        </div>
    </nav>
</footer>
