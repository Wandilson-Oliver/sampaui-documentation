<footer class="doc-footer">
    <div class="doc-footer-intro">
        <a href="{{ route('documentation') }}" class="doc-footer-brand" aria-label="SampaUI - início da documentação">
            <span class="doc-brand-mark">S</span>
            <span><strong>SampaUI</strong><small>Componentes premium para Laravel</small></span>
        </a>
        <p>Documentação para criar CRMs, dashboards, autenticação e sistemas internos consistentes, com foco real em produtos imobiliários.</p>
        <span class="doc-footer-version">Versão {{ config('docs.version') }}</span>
    </div>

    <nav aria-label="Links do rodapé">
        <div>
            <strong>Produto</strong>
            <a href="{{ route('documentation') }}#componentes">Catálogo</a>
            <a href="{{ route('documentation') }}#blocks">Blocks/Templates</a>
            <a href="{{ route('documentation') }}#roadmap">Roadmap</a>
        </div>
        <div>
            <strong>Documentação</strong>
            <a href="{{ route('documentation') }}#instalacao">Instalação</a>
            <a href="{{ route('documentation.pages.show', 'design-system') }}">Design System</a>
            <a href="{{ route('documentation.components.show', 'button') }}">Button</a>
        </div>
        <div>
            <strong>Componentes</strong>
            <a href="{{ route('documentation.components.show', 'input') }}">Formulários</a>
            <a href="{{ route('documentation.components.show', 'table') }}">DataTable</a>
            <a href="{{ route('documentation.components.show', 'modal') }}">Overlays</a>
        </div>
        <div>
            <strong>Templates</strong>
            <a href="{{ route('examples.dashboard') }}">CRM Dashboard</a>
            <a href="{{ route('examples.authentication') }}">Login completo</a>
            <a href="{{ route('examples.chat') }}">Atendimento/Chat</a>
        </div>
        <div>
            <strong>Real Estate</strong>
            <a href="{{ route('documentation.pages.show', 'real-estate-patterns') }}">Padrões imobiliários</a>
            <a href="{{ route('documentation.components.show', 'property-card') }}">Property Card</a>
            <a href="{{ route('documentation.components.show', 'lead-pipeline') }}">Lead Pipeline</a>
        </div>
        <div>
            <strong>Projeto</strong>
            <a href="https://github.com/Wandilson-Oliver/sampaui-documentation" target="_blank" rel="noopener noreferrer">GitHub <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i></a>
            <a href="https://github.com/Wandilson-Oliver/sampaUI/blob/main/LICENSE" target="_blank" rel="noopener noreferrer">Licença MIT</a>
            <span>Laravel 13 · Livewire 4</span>
        </div>
    </nav>
</footer>
