<?php

use App\Livewire\Examples\UsersIndex;
use App\Support\DocumentationComponents;
use Livewire\Livewire;

it('renders the overview with installation guidance and component links', function () {
    $response = $this->get(route('documentation'));

    $response
        ->assertOk()
        ->assertSee('Documentação SampaUI')
        ->assertSee('Componentes Blade para produtos imobiliários profissionais.')
        ->assertSee('CRM imobiliário')
        ->assertSee('Ver padrões imobiliários')
        ->assertSee('Composer, install e build')
        ->assertSee('Fluxos imobiliários')
        ->assertSee('Páginas para copiar e adaptar')
        ->assertSee('npm run build')
        ->assertSee('bi bi-buildings', false)
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

it('renders the real estate patterns documentation page', function () {
    $this->get(route('documentation.pages.show', 'real-estate-patterns'))
        ->assertOk()
        ->assertSee('Padrões imobiliários')
        ->assertSee('CRM imobiliário')
        ->assertSee('Lead comprador')
        ->assertSee('Trechos recomendados para IA')
        ->assertSee('x-sampaui::card', false)
        ->assertSee('x-sampaui::currency-br', false);
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
        ->assertSee('x-modelable="value"', false)
        ->assertSee('role="listbox"', false)
        ->assertSee('shadow-2xl shadow-secondary/10', false)
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
        ->assertSee('Páginas reais para produtos imobiliários')
        ->assertSee('Exemplos')
        ->assertSee('Login completo')
        ->assertSee('Dashboard operacional')
        ->assertSee('CRUD de usuários')
        ->assertSee('Formulário administrativo')
        ->assertSee('Modal destrutivo')
        ->assertSee('Drawer de filtros')
        ->assertSee('Tabela avançada')
        ->assertSee('Upload e perfil')
        ->assertSee('Verificação 2FA')
        ->assertSee('Command palette')
        ->assertSee('Configurações em abas')
        ->assertSee('Estados de feedback')
        ->assertSee('Chat atendimento')
        ->assertSee('Bootstrap Icons')
        ->assertSee('Abrir exemplo');
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

it('renders the form profile example with upload contact and password fields', function () {
    $this->get(route('examples.profile'))
        ->assertOk()
        ->assertSee('Upload e perfil')
        ->assertSee('Salvar perfil')
        ->assertSee('Avatar')
        ->assertSee('Documentos do perfil')
        ->assertSee('WhatsApp')
        ->assertSee('Confirmação de senha')
        ->assertSee('Trecho de uso')
        ->assertSee('wire:submit.prevent=&quot;saveProfile&quot;', false)
        ->assertSee('wire:model.live=&quot;name&quot;', false)
        ->assertSee('x-sampaui::avatar-upload', false)
        ->assertSee('x-sampaui::file-upload', false)
        ->assertSee('x-sampaui::phone', false);
});

it('renders the bootstrap icons search example', function () {
    $this->get(route('examples.icons'))
        ->assertOk()
        ->assertSee('Bootstrap Icons')
        ->assertSee('Buscar classe Bootstrap Icons')
        ->assertSee('plus')
        ->assertSee('`bi-${icon}`', false)
        ->assertSee('`bi bi-${icon}`', false)
        ->assertSee('x-model="query"', false);
});

it('renders the new complete example pages', function () {
    $examples = [
        'examples.dashboard' => ['Dashboard operacional', 'Painel comercial', 'x-sampaui::sidebar'],
        'examples.admin-form' => ['Formulário administrativo', 'Cadastro de cliente', 'x-sampaui::select-multiple'],
        'examples.destructive-modal' => ['Modal destrutivo', 'Excluir cliente?', 'x-sampaui::modal'],
        'examples.filter-drawer' => ['Drawer de filtros', 'Listagem comercial', 'x-sampaui::drawer'],
        'examples.advanced-table' => ['Tabela avançada', 'Clientes', 'x-sampaui::dropdown'],
        'examples.verification' => ['Verificação 2FA', 'Confirme seu acesso', 'x-sampaui::pin'],
        'examples.command-palette' => ['Command palette', 'Central de comandos', 'x-sampaui::command-palette'],
        'examples.settings' => ['Configurações em abas', 'Configurações da conta', 'x-sampaui::tabs'],
        'examples.feedback' => ['Estados de feedback', 'Ações com toast', 'x-sampaui::toast'],
        'examples.chat' => ['Chat atendimento', 'Mensagem para Ana', 'x-sampaui::chat-layout'],
    ];

    foreach ($examples as $route => [$heading, $preview, $snippet]) {
        $this->get(route($route))
            ->assertOk()
            ->assertSee($heading)
            ->assertSee($preview)
            ->assertSee('Trecho de uso')
            ->assertSee($snippet, false);
    }
});

it('renders the users listing example with filters table actions and pagination', function () {
    $this->get(route('examples.users.index'))
        ->assertOk()
        ->assertSee('Listagem de usuários')
        ->assertSee('Cadastrar')
        ->assertSee('Buscar por nome, email, WhatsApp ou cargo')
        ->assertSee('Todos os status')
        ->assertSee('Ana Martins')
        ->assertSee('Ativo')
        ->assertSee('Pendente')
        ->assertSee('Inativo')
        ->assertDontSee('Resumo de status')
        ->assertSee('Trecho de uso')
        ->assertSee('&lt;livewire:examples.users-index /&gt;', false)
        ->assertSee('wire:click="sortBy(\'name\')"', false)
        ->assertSee('bi bi-sort-up', false)
        ->assertSee('bi bi-arrow-down-up', false)
        ->assertSee('wire:model.live.debounce.300ms="search"', false)
        ->assertSee('bi bi-eye', false)
        ->assertSee('bi bi-trash3', false)
        ->assertDontSee('toggle-on');
});

it('runs the users listing interactions through Livewire', function () {
    Livewire::test(UsersIndex::class)
        ->assertSee('Ana Martins')
        ->set('search', 'helena')
        ->assertSee('Helena Prado')
        ->assertDontSee('Ana Martins')
        ->set('search', '')
        ->set('status', 'Pendente')
        ->assertSee('Bruno Lima')
        ->assertDontSee('Ana Martins')
        ->call('sortBy', 'email')
        ->assertSet('sortBy', 'email')
        ->call('toggleStatus', 2)
        ->assertSee('Status atualizado.')
        ->call('openCreateModal')
        ->set('formName', 'Patricia Gomes')
        ->set('formEmail', 'patricia@sampa.dev')
        ->set('formWhatsapp', '+55 11 99999-1099')
        ->set('formStatus', 'Ativo')
        ->call('saveUser')
        ->assertSee('Usuário cadastrado.')
        ->set('status', '')
        ->set('search', 'patricia')
        ->assertSee('Patricia Gomes')
        ->call('deleteUser', 13)
        ->assertSee('Usuário removido.')
        ->assertDontSee('Patricia Gomes');
});

it('returns not found for unknown components', function () {
    $this->get(route('documentation.components.show', 'unknown-component'))
        ->assertNotFound();
});
