<?php

use App\Support\DocumentationComponents;

it('renders the overview with installation guidance and component links', function () {
    $response = $this->get(route('documentation'));

    $response
        ->assertOk()
        ->assertSee('Documentação SampaUI')
        ->assertSee('dist/sampaui.css')
        ->assertSee('dist/sampaui.js')
        ->assertSee('Composer, publish e CSS')
        ->assertSee('Explorar componentes')
        ->assertSee('npm run build')
        ->assertSee('bi bi-rocket-takeoff', false)
        ->assertSee('doc-app-frame', false)
        ->assertDontSee('doc-rail', false)
        ->assertDontSee('asset(\'vendor/sampaui/sampaui.css\')', false)
        ->assertSee('Button')
        ->assertSee('Checkbox')
        ->assertSee('Avatar Upload')
        ->assertSee(route('documentation.components.show', 'avatar-upload'), false)
        ->assertSee('bi-person-bounding-box', false)
        ->assertSee('Alert')
        ->assertSee('Card')
        ->assertSee('Drawer')
        ->assertSee('Toast');
});

it('renders a dedicated documentation page for each component', function () {
    $components = array_keys(DocumentationComponents::all());

    foreach ($components as $component) {
        $this->get(route('documentation.components.show', $component))
            ->assertOk()
            ->assertSee('Acessibilidade')
            ->assertSee('Variacoes e implementacao')
            ->assertSee('Como implementar')
            ->assertSee('doc-component-layout', false)
            ->assertSee('doc-examples-column', false)
            ->assertSee('doc-explanations-column', false)
            ->assertSee('doc-prop-list', false)
            ->assertSee('doc-showcase-card', false)
            ->assertSee('doc-copy-button', false)
            ->assertSee('x-sampaui::'.$component, false);
    }
});

it('documents the new feedback and surface components', function () {
    $this->get(route('documentation.components.show', 'alert'))
        ->assertOk()
        ->assertSee('variant')
        ->assertSee('Informacao')
        ->assertSee('role');

    $this->get(route('documentation.components.show', 'card'))
        ->assertOk()
        ->assertSee('actions')
        ->assertSee('footer')
        ->assertSee('variant=&quot;primary&quot;', false);

    $this->get(route('documentation.components.show', 'modal'))
        ->assertOk()
        ->assertSee('model')
        ->assertSee('persistent')
        ->assertSee('close-event')
        ->assertSee('Abrir sm')
        ->assertSee('Abrir full')
        ->assertSee('x-sampaui::modal', false);

    $this->get(route('documentation.components.show', 'drawer'))
        ->assertOk()
        ->assertSee('placement')
        ->assertSee('Direita')
        ->assertSee('panel-class')
        ->assertSee('filters-applied')
        ->assertSee('x-sampaui::drawer', false);

    $this->get(route('documentation.components.show', 'toast'))
        ->assertOk()
        ->assertSee('position')
        ->assertSee('Abrir toast')
        ->assertSee('Controller Livewire')
        ->assertSee('$this-&gt;dispatch', false)
        ->assertSee('window.dispatchEvent')
        ->assertSee('x-sampaui::toast', false);
});

it('renders the select preview with the real SampaUI select markup', function () {
    $this->get(route('documentation.components.show', 'select'))
        ->assertOk()
        ->assertSee('appearance-none', false)
        ->assertSee('bi bi-chevron-down', false)
        ->assertSee('name="pipeline"', false);
});

it('documents checkbox SampaUI color variants', function () {
    $this->get(route('documentation.components.show', 'checkbox'))
        ->assertOk()
        ->assertSee('color')
        ->assertSee('primary|secondary|accent|danger|success|warning|info|purple|muted|light')
        ->assertSee('color=&quot;accent&quot;', false)
        ->assertSee('accent-accent', false);
});

it('documents textarea native usage', function () {
    $this->get(route('documentation.components.show', 'textarea'))
        ->assertOk()
        ->assertSee('Usos principais')
        ->assertSee('Estados')
        ->assertSee('wire:model.live.debounce.500ms=&quot;message&quot;', false);
});

it('documents input icons badges skeleton and command palette examples', function () {
    $this->get(route('documentation.components.show', 'input'))
        ->assertOk()
        ->assertSee('Com icones')
        ->assertSee('icon=&quot;envelope&quot;', false)
        ->assertSee('revealable')
        ->assertSee('Senha customizada')
        ->assertSee('showPassword = ! showPassword', false)
        ->assertSee('bi-eye-slash', false);

    $this->get(route('documentation.components.show', 'badge'))
        ->assertOk()
        ->assertSee('Status de publicacao')
        ->assertSee('Prioridade e contadores')
        ->assertSee('Classe Livewire')
        ->assertSee('statusVariant');

    $this->get(route('documentation.components.show', 'skeleton'))
        ->assertOk()
        ->assertSee('Card carregando')
        ->assertSee('Lista ou tabela')
        ->assertSee('Com wire:loading')
        ->assertSee('wire:loading.remove', false);

    $this->get(route('documentation.components.show', 'command-palette'))
        ->assertOk()
        ->assertSee('Busca global')
        ->assertSee('Atalho de teclado')
        ->assertSee('Classe Livewire')
        ->assertSee('open-event=&quot;open-dashboard-search&quot;', false);
});

it('renders real-world examples in the documentation navigation', function () {
    $this->get(route('examples.index'))
        ->assertOk()
        ->assertSee('Páginas reais com SampaUI')
        ->assertSee('Exemplos')
        ->assertSee('Autenticação')
        ->assertSee('Dashboard')
        ->assertSee('Cadastro de usuário')
        ->assertSee('Listagem de usuários');
});

it('renders the authentication example with SampaUI and Livewire usage', function () {
    $this->get(route('examples.authentication'))
        ->assertOk()
        ->assertSee('Acesse sua conta')
        ->assertSee('Lembrar de mim')
        ->assertSee('Esqueceu a senha?')
        ->assertSee('wire:submit.prevent=&quot;authenticate&quot;', false)
        ->assertSee('wire:model.live=&quot;email&quot;', false)
        ->assertSee('x-sampaui::input', false)
        ->assertSee('bi bi-envelope', false);
});

it('renders the user create example with upload and validation states', function () {
    $this->get(route('examples.users.create'))
        ->assertOk()
        ->assertSee('Criar usuário')
        ->assertSee('Salvar usuário')
        ->assertSee('Foto')
        ->assertSee('Trecho de uso')
        ->assertDontSee('Notas de implementação')
        ->assertSee('Use pelo menos 8 caracteres.')
        ->assertSee('wire:submit.prevent=&quot;save&quot;', false)
        ->assertSee('wire:model.live=&quot;name&quot;', false)
        ->assertSee('x-sampaui::avatar-upload', false)
        ->assertSee('bi bi-camera', false);
});

it('renders the dashboard example with copyable Blade code', function () {
    $this->get(route('examples.dashboard'))
        ->assertOk()
        ->assertSee('Código Blade do dashboard')
        ->assertSee('x-sampaui::sidebar', false)
        ->assertSee('x-sampaui::card', false)
        ->assertSee('siteVisitsChart', false)
        ->assertSee('ApexCharts + AlpineJS')
        ->assertSee('Preview completo');
});

it('renders the users listing example with filters table actions and pagination', function () {
    $this->get(route('examples.users.index'))
        ->assertOk()
        ->assertSee('Listagem de usuários')
        ->assertSee('Novo usuário')
        ->assertSee('Buscar por nome, email ou WhatsApp')
        ->assertSee('Todos os status')
        ->assertSee('Ana Martins')
        ->assertSee('Ativo')
        ->assertSee('Pendente')
        ->assertSee('Inativo')
        ->assertDontSee('Resumo de status')
        ->assertSee('Trecho de uso')
        ->assertSee('x-sampaui::table', false)
        ->assertSee('x-sampaui::tooltip', false)
        ->assertSee('wire:model.live.debounce.300ms=&quot;search&quot;', false)
        ->assertSee('bi bi-eye', false)
        ->assertSee('bi bi-trash3', false);
});

it('returns not found for unknown components', function () {
    $this->get(route('documentation.components.show', 'unknown-component'))
        ->assertNotFound();
});
