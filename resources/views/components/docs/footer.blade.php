<footer class="doc-footer">
    <div class="doc-footer-intro">
        <a href="{{ route('documentation') }}" class="doc-footer-brand" aria-label="SampaUI - início da documentação">
            <span class="doc-footer-logo-frame">
                <img src="{{ asset('images/logo_sampaui.png') }}" alt="SampaUI">
            </span>
        </a>
        <p>Documentação para criar CRMs, dashboards, autenticação e sistemas internos consistentes, com foco em produtos digitais profissionais.</p>
        <span class="doc-footer-version">Versão {{ config('docs.version') }}</span>
    </div>

    <nav aria-label="Links do rodapé">
        <div>
            <strong>Produto</strong>
            <a href="{{ route('documentation') }}#componentes">Catálogo</a>
            <a href="{{ route('examples.index') }}">Blocks/Templates</a>
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
            <a href="{{ route('examples.dashboard') }}">Dashboard</a>
            <a href="{{ route('examples.users.index') }}">CRUD Livewire</a>
            <a href="{{ route('examples.chat') }}">Atendimento</a>
        </div>
        <div>
            <strong>Projeto</strong>
            <a href="https://github.com/Wandilson-Oliver/sampaui-documentation" target="_blank" rel="noopener noreferrer">GitHub <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i></a>
            <a href="https://github.com/Wandilson-Oliver/sampaUI/blob/main/LICENSE" target="_blank" rel="noopener noreferrer">Licença MIT</a>
            <span>Laravel 13 · Livewire 4</span>
        </div>
    </nav>
</footer>
