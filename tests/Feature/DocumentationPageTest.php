<?php

use App\Livewire\Examples\UsersIndex;
use App\Support\DocumentationComponents;
use App\Support\DocumentationGuidance;
use Livewire\Livewire;
use SampaUI\Support\ComponentRegistry;

it('renders the overview with installation guidance and component links', function () {
    $response = $this->get(route('documentation'));

    $response
        ->assertOk()
        ->assertSee('Documentação SampaUI')
        ->assertSee('Componentes Blade para produtos digitais')
        ->assertSee('profissionais.')
        ->assertSee('Quatro comandos até o primeiro componente.')
        ->assertSee('Todos os componentes')
        ->assertSee('Componentes organizados para acelerar CRMs, ERPs e sistemas internos em Laravel.')
        ->assertSee('Roadmap')
        ->assertSee('npm run build')
        ->assertSee('bi bi-diagram-3', false)
        ->assertSee('doc-app-frame', false)
        ->assertSee('doc-topbar', false)
        ->assertSee('docs-sidebar', false)
        ->assertSee('sampaui-docs-theme', false)
        ->assertSee('Docs v'.config('docs.version'))
        ->assertSee('Todos')
        ->assertSee('doc-catalog-meta-row', false)
        ->assertSee('doc-category-pill', false)
        ->assertSee('Blocks/Templates')
        ->assertSee('images/logo_sampaui.png', false)
        ->assertSee('images/icon_favicon_sampaui.png', false)
        ->assertSee('Links do rodapé', false)
        ->assertSee('GitHub')
        ->assertSee('Voltar ao topo')
        ->assertDontSee('doc-rail', false)
        ->assertDontSee('asset(\'vendor/sampaui/sampaui.css\')', false)
        ->assertSee('Button')
        ->assertSee('Checkbox')
        ->assertSee('Avatar Upload')
        ->assertSee(route('documentation.components.show', 'avatar-upload'), false)
        ->assertSee('bi-person-circle', false)
        ->assertSee('Alert')
        ->assertSee('Card')
        ->assertSee('Drawer')
        ->assertSee('Toast')
        ->assertDontSee('Por que usar SampaUI')
        ->assertDontSee('Os blocos mais usados, renderizados de verdade.')
        ->assertDontSee('Blocks e templates essenciais')
        ->assertDontSee('Fluxos completos, sem exemplos redundantes.')
        ->assertDontSee('Real Estate')
        ->assertDontSee('Property Card')
        ->assertDontSee('Lead Pipeline')
        ->assertDontSee('Ver padrões imobiliários')
        ->assertDontSee('doc-real-estate-preview', false);
});

it('does not expose the removed real estate patterns documentation page', function () {
    $this->get(route('documentation.pages.show', 'real-estate-patterns'))
        ->assertNotFound();
});

it('renders a dedicated documentation page for each component', function () {
    $components = array_keys(DocumentationComponents::all());

    foreach ($components as $component) {
        $response = $this->get(route('documentation.components.show', $component))
            ->assertOk()
            ->assertSee('Acessibilidade')
            ->assertSee('doc-content-with-toc', false)
            ->assertSee('doc-reading-column', false)
            ->assertSee('doc-toc', false)
            ->assertSee('doc-props-table', false)
            ->assertSee('doc-example', false)
            ->assertSee('doc-code-block', false)
            ->assertSee('x-sampaui::'.$component, false)
            ->assertDontSee('Decisão de uso')
            ->assertDontSee('Quando este componente faz sentido')
            ->assertDontSee('componentPlayground', false);

        if (DocumentationGuidance::status(DocumentationComponents::all()[$component]) === 'Planejado') {
            $response
                ->assertSee('API prevista')
                ->assertSee('Preview conceitual')
                ->assertSee('Componente planejado, ainda não disponível no pacote.')
                ->assertSee('Planejado');
        } else {
            $response->assertSee('Exemplos de uso');
        }
    }
});

it('documents every component registered by the SampaUI package', function () {
    $packageComponents = array_keys(ComponentRegistry::all());
    $documentationComponents = array_keys(DocumentationComponents::all());

    sort($packageComponents);
    sort($documentationComponents);

    expect($documentationComponents)->toBe($packageComponents);
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
        ->assertSee('overflow visivel e o padrao')
        ->assertSee('visible|hidden|auto')
        ->assertSee('variant=&quot;primary&quot;', false);

    $this->get(route('documentation.components.show', 'dropdown'))
        ->assertOk()
        ->assertSee('portal fixo que evita recorte')
        ->assertSee('Menu teletransportado e alinhado ao trigger');

    $this->get(route('documentation.components.show', 'modal'))
        ->assertOk()
        ->assertSee('model')
        ->assertSee('persistent')
        ->assertSee('close-event')
        ->assertSee('Abrir modal')
        ->assertSee('Preview Livewire real do SampaUI')
        ->assertSee('Formulario completo')
        ->assertSee('Novo lead')
        ->assertSee('x-sampaui::toggle', false)
        ->assertSee('x-sampaui::select-search', false)
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
        ->assertSee('x-data="SampaUI.select', false)
        ->assertSee('x-model="value"', false)
        ->assertSee('role="listbox"', false)
        ->assertSee('shadow-2xl shadow-secondary/10', false)
        ->assertSee('bi bi-chevron-down', false)
        ->assertSee('name="pipeline"', false);
});

it('ships the Alpine controllers required by the documentation shell', function () {
    $javascript = file_get_contents(resource_path('js/app.js'));

    expect($javascript)
        ->toContain("Alpine.data('docsShell'")
        ->toContain("Alpine.data('tableOfContents'")
        ->toContain("Alpine.data('docSearch'")
        ->not->toContain("Alpine.data('componentPlayground'");
});

it('documents the File Upload lifecycle and manual Livewire bootstrap order', function () {
    $this->get(route('documentation.components.show', 'file-upload'))
        ->assertOk()
        ->assertSee('cleanup seguro de previews locais')
        ->assertSee('libera URLs no destroy/beforeunload')
        ->assertSee('Crop e reordenacao nao fazem parte da API')
        ->assertSee('importe o SampaUI antes de iniciar o Livewire')
        ->assertSee("x-on:beforeunload.window=\"typeof revokePreviewUrls === 'function' && revokePreviewUrls()\"", false)
        ->assertSee('SampaUI.fileUpload', false);
});

it('documents Button and DatePicker class customizations', function () {
    $this->get(route('documentation.components.show', 'button'))
        ->assertOk()
        ->assertSee('substitui utilitarios visuais conflitantes')
        ->assertSee('Customizacao por classe')
        ->assertSee('bg-danger text-white px-8 py-4 rounded-full shadow-none', false);

    $this->get(route('documentation.components.show', 'date-picker'))
        ->assertOk()
        ->assertSee('text-slate-600')
        ->assertSee('teletransportado para o body')
        ->assertSee('Cor customizada')
        ->assertSee('bg-slate-50 text-emerald-600 shadow-none', false);
});

it('renders reusable navigation examples and props patterns', function () {
    $this->get(route('documentation.components.show', 'input'))
        ->assertOk()
        ->assertSee('Componentes')
        ->assertSee('Formulários')
        ->assertSee('Input')
        ->assertSee('Nesta página')
        ->assertSee('Exemplos')
        ->assertSee('Boas práticas')
        ->assertSee('Exemplos de uso')
        ->assertDontSee('componentPlayground', false)
        ->assertDontSee('Cenário')
        ->assertDontSee('Canvas')
        ->assertDontSee('Fundo')
        ->assertSee('Variant')
        ->assertSee('Placeholder')
        ->assertSee('Error')
        ->assertSee('Blade')
        ->assertSee('Livewire')
        ->assertSee('Prop')
        ->assertSee('Tipo')
        ->assertSee('Default')
        ->assertSee('Descrição')
        ->assertSee('Exemplo')
        ->assertSee('Copiar')
        ->assertSee('Navegação entre páginas', false)
        ->assertSee('Anterior')
        ->assertSee('Próximo');
});

it('does not render playground controls on component pages', function () {
    foreach (array_keys(DocumentationComponents::all()) as $component) {
        $this->get(route('documentation.components.show', $component))
            ->assertOk()
            ->assertSee('Exemplos')
            ->assertDontSee('componentPlayground', false)
            ->assertDontSee('doc-interactive-playground', false)
            ->assertDontSee('Cenário')
            ->assertDontSee('Canvas')
            ->assertDontSee('Fundo');
    }
});

it('documents checkbox SampaUI color variants', function () {
    $this->get(route('documentation.components.show', 'checkbox'))
        ->assertOk()
        ->assertSee('color')
        ->assertSee('primary|secondary|accent|danger|success|warning|info|purple|muted|light')
        ->assertSee('color=&quot;accent&quot;', false)
        ->assertSee('accent-accent', false);
});

it('renders the complete sidebar reference with properties active', function () {
    $this->get(route('documentation.components.show', 'sidebar'))
        ->assertOk()
        ->assertSee('h-[62rem]', false)
        ->assertSee('src')
        ->assertSee('logo-alt')
        ->assertSee('Imóveis')
        ->assertSee('gap-3.5 rounded-default !bg-transparent', false)
        ->assertSee('bg-light text-purple', false)
        ->assertDontSee('-right-10 hidden w-10 bg-light', false)
        ->assertSee('border border-danger bg-transparent', false)
        ->assertSee('text-danger shadow-none', false)
        ->assertSee('Sair do sistema');
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
        ->assertSee('size=&quot;xs&quot;', false)
        ->assertSee('Classe Livewire')
        ->assertSee('statusVariant');

    $this->get(route('documentation.components.show', 'stepper'))
        ->assertOk()
        ->assertSee('Formulario com validacao')
        ->assertSee('wire:submit.prevent=&quot;save&quot;', false)
        ->assertSee('Validar e salvar');

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
        ->assertSee('Blocks / Templates')
        ->assertSee('Composições SampaUI')
        ->assertSee('Login completo')
        ->assertSee('Dashboard operacional')
        ->assertSee('CRUD de usuários')
        ->assertSee('Formulário administrativo')
        ->assertSee('Listagem avançada')
        ->assertSee('Perfil e arquivos')
        ->assertSee('Configurações em abas')
        ->assertSee('Central de atendimento')
        ->assertDontSee(route('examples.destructive-modal'), false)
        ->assertDontSee(route('examples.filter-drawer'), false)
        ->assertDontSee(route('examples.verification'), false)
        ->assertDontSee(route('examples.command-palette'), false)
        ->assertDontSee(route('examples.feedback'), false)
        ->assertDontSee(route('examples.icons'), false)
        ->assertSee('Explorar template');
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
        ->assertSee('Perfil e arquivos')
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
        'examples.advanced-table' => ['Listagem avançada', 'Clientes', 'x-sampaui::dropdown'],
        'examples.verification' => ['Verificação 2FA', 'Confirme seu acesso', 'x-sampaui::pin'],
        'examples.command-palette' => ['Command palette', 'Central de comandos', 'x-sampaui::command-palette'],
        'examples.settings' => ['Configurações em abas', 'Configurações da conta', 'x-sampaui::tabs'],
        'examples.feedback' => ['Estados de feedback', 'Ações com toast', 'x-sampaui::toast'],
        'examples.chat' => ['Central de atendimento', 'Mensagem para Ana', 'x-sampaui::chat-layout'],
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

it('renders the advanced table with SampaUI checkboxes filters and numbered pagination', function () {
    $this->get(route('examples.advanced-table'))
        ->assertOk()
        ->assertSee('placeholder="Buscar cliente, email ou valor"', false)
        ->assertSee('h-5 w-5 cursor-pointer', false)
        ->assertSee('x-bind:checked="allVisibleSelected()"', false)
        ->assertSee('x-on:change="toggleRow($el.value, $event.target.checked)"', false)
        ->assertSee('data-pagination-type="numbers"', false)
        ->assertSee('aria-current="page"', false);
});

it('renders chat customer photos and a toggleable context panel', function () {
    $this->get(route('examples.chat'))
        ->assertOk()
        ->assertSee('data-chat-context-toggle', false)
        ->assertSee('data-chat-context-panel', false)
        ->assertSee('data-chat-context-grid', false)
        ->assertSee('data-context-open="true"', false)
        ->assertSee('https://i.pravatar.cc/160?img=47', false)
        ->assertSee('https://i.pravatar.cc/160?img=12', false)
        ->assertSee('https://i.pravatar.cc/160?img=32', false)
        ->assertSee('https://i.pravatar.cc/160?img=68', false)
        ->assertSee('Fechar dados do cliente')
        ->assertSee('Alternar dados do cliente');
});

it('renders the users listing example with filters table actions and pagination', function () {
    $this->get(route('examples.users.index'))
        ->assertOk()
        ->assertSee('Listagem de usuários')
        ->assertSee('Cadastrar')
        ->assertSee('Buscar por nome, email, WhatsApp ou cargo')
        ->assertSee('Todos os status')
        ->assertSee('Ana Martins')
        ->assertSee('https://i.pravatar.cc/160?img=47', false)
        ->assertSee('https://i.pravatar.cc/160?img=12', false)
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

it('renders the interactive playground with split view tabs and live preview', function () {
    $this->get(route('playground'))
        ->assertOk()
        ->assertSee('Voltar para documentação')
        ->assertSee(route('documentation'), false)
        ->assertDontSee('doc-sidebar-nav', false)
        ->assertSee('Playground')
        ->assertSee('Componentes SampaUI')
        ->assertSee('Card de Perfil')
        ->assertSee('HTML')
        ->assertSee('CSS')
        ->assertSee('JavaScript')
        ->assertSee('Livewire')
        ->assertSee('Desktop')
        ->assertSee('Tablet')
        ->assertSee('playgroundShell', false)
        ->assertSee('x-ref="previewFrame"', false)
        ->assertSee('sandbox="allow-scripts', false);
});

it('compiles SampaUI Blade components dynamically via playground compile endpoint', function () {
    $response = $this->postJson(route('playground.compile'), [
        'code' => '<x-sampaui::button variant="primary" icon="check2">Confirmar</x-sampaui::button>',
    ]);

    $response
        ->assertOk()
        ->assertJson([
            'success' => true,
        ])
        ->assertSee('Confirmar')
        ->assertSee('bi bi-check2', false)
        ->assertSee('bg-primary', false);
});

it('compiles Blade code with $this object context from Livewire class', function () {
    $bladeCode = <<<'BLADE'
<x-sampaui::button type="submit" icon="box-arrow-in-right" :loading="$this->isAuthenticating">
    Entrar
</x-sampaui::button>
BLADE;

    $livewireCode = <<<'PHP'
namespace App\Livewire;

use Livewire\Component;

class Playground extends Component
{
    public bool $isAuthenticating = true;
}
PHP;

    $response = $this->postJson(route('playground.compile'), [
        'code' => $bladeCode,
        'livewire' => $livewireCode,
    ]);

    $response
        ->assertOk()
        ->assertJson([
            'success' => true,
        ])
        ->assertSee('animate-spin', false)
        ->assertSee('Entrar');
});

it('compiles complex SampaUI cards and selects dynamically', function () {
    $bladeCode = <<<'BLADE'
<x-sampaui::card title="Oportunidade" padding="md">
    <x-sampaui::badge variant="success">Ativo</x-sampaui::badge>
    <x-sampaui::input name="lead" label="Nome do Lead" />
</x-sampaui::card>
BLADE;

    $response = $this->postJson(route('playground.compile'), [
        'code' => $bladeCode,
    ]);

    $response
        ->assertOk()
        ->assertJson([
            'success' => true,
        ])
        ->assertSee('Oportunidade')
        ->assertSee('Ativo')
        ->assertSee('Nome do Lead');
});

it('compiles Blade code with undeclared variables safely without throwing undefined variable errors', function () {
    $bladeCode = <<<'BLADE'
<div>
    @if ($hasError)
        <x-sampaui::alert variant="danger" title="Erro">Falha no login</x-sampaui::alert>
    @endif
    <x-sampaui::input name="email" label="Email" :disabled="$isAuthenticating" />
</div>
BLADE;

    $response = $this->postJson(route('playground.compile'), [
        'code' => $bladeCode,
    ]);

    $response
        ->assertOk()
        ->assertJson([
            'success' => true,
        ])
        ->assertDontSee('Undefined variable', false)
        ->assertSee('Email');
});
