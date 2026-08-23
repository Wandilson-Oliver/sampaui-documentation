<?php

namespace App\Http\Controllers;

use App\Support\DocumentationComponents;
use App\Support\DocumentationPages;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;

class PlaygroundController extends Controller
{
    public function index(): View
    {
        $components = array_values(DocumentationComponents::all());
        $pages = array_values(DocumentationPages::all());
        $examples = ExampleController::navigationExamples();

        $templates = [
            'card' => [
                'name' => 'Card Profile',
                'description' => 'Card de perfil com avatar, badges, banner gradiente, métricas e botões de ação.',
                'html' => <<<'BLADE'
<div class="flex min-h-screen items-center justify-center bg-slate-50/80 p-6 font-sans">
    <div class="w-full max-w-sm overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-xl transition-all duration-300 hover:shadow-2xl">
        <!-- Banner Gradiente com Badge -->
        <div class="h-28 bg-gradient-to-r from-primary via-info to-purple p-4 relative">
            <span class="absolute top-3 right-3 inline-flex items-center gap-1.5 rounded-full bg-white/20 backdrop-blur-md px-3 py-1 text-xs font-semibold text-white">
                <i class="bi bi-stars"></i> Pro Member
            </span>
        </div>

        <div class="relative px-6 pb-6 pt-0">
            <!-- Avatar e Ações Rápidas -->
            <div class="-mt-12 mb-4 flex items-end justify-between">
                <div class="relative rounded-full ring-4 ring-white bg-white">
                    <x-sampaui::avatar name="Mariana Albuquerque" size="lg" status="online" />
                </div>
                <div class="flex gap-2">
                    <x-sampaui::button size="sm" variant="outline" icon="chat-dots" wire:click="toggleConnect">
                        Mensagem
                    </x-sampaui::button>
                    <x-sampaui::button size="sm" variant="primary" icon="person-plus" wire:click="toggleConnect">
                        Conectar
                    </x-sampaui::button>
                </div>
            </div>

            <!-- Informações Principais -->
            <div>
                <h3 class="text-lg font-bold text-slate-800">Mariana Albuquerque</h3>
                <p class="text-xs font-semibold text-primary">Lead UI/UX Designer & Frontend Dev</p>
                <p class="mt-2 text-xs leading-relaxed text-slate-500">
                    Especialista em design systems modernos, componentes acessíveis e interfaces web com Laravel & Livewire.
                </p>
            </div>

            <!-- Tags de Especialidades -->
            <div class="mt-4 flex flex-wrap gap-1.5">
                <x-sampaui::badge variant="light" size="sm">Design System</x-sampaui::badge>
                <x-sampaui::badge variant="light" size="sm">Tailwind CSS</x-sampaui::badge>
                <x-sampaui::badge variant="light" size="sm">Livewire 3</x-sampaui::badge>
            </div>

            <!-- Métricas em Colunas -->
            <div class="mt-5 grid grid-cols-3 divide-x divide-slate-100 rounded-xl border border-slate-100 bg-slate-50/60 p-3 text-center">
                <div>
                    <strong class="block text-base font-bold text-slate-800">1.2k</strong>
                    <span class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">Seguidores</span>
                </div>
                <div>
                    <strong class="block text-base font-bold text-slate-800">84</strong>
                    <span class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">Projetos</span>
                </div>
                <div>
                    <strong class="block text-base font-bold text-slate-800">4.9 ★</strong>
                    <span class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">Avaliação</span>
                </div>
            </div>
        </div>
    </div>
</div>
BLADE,
                'css' => '',
                'js' => '',
                'livewire' => <<<'PHP'
namespace App\Livewire;

use Livewire\Component;

class Playground extends Component
{
    public string $name = 'Mariana Albuquerque';
    public string $role = 'Lead UI/UX Designer @ SampaUI';
    public bool $connected = false;

    public function toggleConnect(): void
    {
        $this->connected = ! $this->connected;
        $this->dispatch('toast', [
            'type' => 'info',
            'title' => $this->connected ? 'Conexão enviada!' : 'Conexão desfeita.',
            'message' => 'Status de relacionamento atualizado.',
        ]);
    }

    public function render()
    {
        return view('livewire.playground');
    }
}
PHP,
            ],
            'datatable' => [
                'name' => 'Tabela Completa',
                'description' => 'Tabela rica com busca, ordenação de colunas, seleção, exportação e paginação.',
                'html' => <<<'BLADE'
<div class="min-h-screen bg-slate-50/80 p-4 sm:p-8 font-sans">
    <div class="mx-auto max-w-5xl space-y-6">
        <!-- Indicadores Rápidos no Topo -->
        <div class="grid gap-4 sm:grid-cols-3">
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total de Clientes</span>
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary/10 text-primary">
                        <i class="bi bi-people"></i>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <strong class="text-2xl font-bold text-slate-800">1.428</strong>
                    <span class="text-xs font-semibold text-emerald-600">+12% este mês</span>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Faturamento Ativo</span>
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-500/10 text-emerald-600">
                        <i class="bi bi-currency-dollar"></i>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <strong class="text-2xl font-bold text-slate-800">R$ 84.920</strong>
                    <span class="text-xs font-semibold text-emerald-600">+8.4%</span>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-500">Taxa de Retenção</span>
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-purple/10 text-purple">
                        <i class="bi bi-graph-up-arrow"></i>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <strong class="text-2xl font-bold text-slate-800">96.8%</strong>
                    <span class="text-xs font-semibold text-slate-500">Alta performance</span>
                </div>
            </div>
        </div>

        <!-- Componente Table Oficial SampaUI -->
        <x-sampaui::table
            title="Gestão de Carteira de Clientes"
            description="Listagem completa com busca, ordenação de colunas e paginação."
            searchable
            search-model="search"
            selectable
            export-href="#"
            per-page="5"
            :columns="[
                'name' => ['label' => 'Nome do Cliente', 'sortable' => true],
                'email' => 'Email Corporativo',
                'status' => 'Status',
                'amount' => ['label' => 'Faturamento', 'key' => 'amount', 'align' => 'right', 'sortable' => true],
            ]"
            :rows="[
                ['id' => 1, 'name' => 'Ana Clara Souza', 'email' => 'ana.souza@empresa.com', 'status' => 'Ativo', 'amount' => 'R$ 4.250,00'],
                ['id' => 2, 'name' => 'Bruno Lima', 'email' => 'bruno.lima@empresa.com', 'status' => 'Pendente', 'amount' => 'R$ 1.890,00'],
                ['id' => 3, 'name' => 'Carla Dias', 'email' => 'carla.dias@empresa.com', 'status' => 'Ativo', 'amount' => 'R$ 7.600,00'],
                ['id' => 4, 'name' => 'Diego Martins', 'email' => 'diego.martins@empresa.com', 'status' => 'Inativo', 'amount' => 'R$ 850,00'],
                ['id' => 5, 'name' => 'Eduarda Rocha', 'email' => 'eduarda@empresa.com', 'status' => 'Ativo', 'amount' => 'R$ 3.120,00'],
            ]"
        />
    </div>
</div>
BLADE,
                'css' => '',
                'js' => '',
                'livewire' => <<<'PHP'
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class CustomerTable extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sortBy = 'name';
    public string $sortDirection = 'asc';

    public function sortBy(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        return view('livewire.customer-table');
    }
}
PHP,
            ],
            'modal_drawer' => [
                'name' => 'Modal, Drawer e Toast',
                'description' => 'Controle completo de overlays acessíveis, painéis laterais e notificações Toast.',
                'html' => <<<'BLADE'
<div class="flex min-h-screen flex-col items-center justify-center bg-slate-50/80 p-6 font-sans">
    <!-- Componente Global de Toast -->
    <x-sampaui::toast position="top-right" />

    <div class="w-full max-w-xl space-y-6 text-center">
        <div>
            <x-sampaui::badge variant="primary" icon="layers" class="mb-2">Overlays Acessíveis</x-sampaui::badge>
            <h2 class="text-2xl font-bold tracking-tight text-slate-800">Modal, Drawer e Toast</h2>
            <p class="mt-1 text-sm text-slate-500">Clique nos botões para abrir modais com focus trap, gavetas laterais e disparar notificações.</p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <!-- Card Gatilho do Modal -->
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm text-left flex flex-col justify-between hover:shadow-md transition">
                <div class="space-y-2 mb-4">
                    <div class="flex items-center gap-2">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary/10 text-primary">
                            <i class="bi bi-window-stack"></i>
                        </span>
                        <strong class="text-sm font-semibold text-slate-800">Modal de Cadastro</strong>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed">Janela modal acessível com focus trap, teclas de atalho e submissão.</p>
                </div>
                <x-sampaui::button variant="primary" icon="person-plus" wire:click="$set('showCustomerModal', true)" full>
                    Abrir Modal
                </x-sampaui::button>
            </div>

            <!-- Card Gatilho do Drawer -->
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm text-left flex flex-col justify-between hover:shadow-md transition">
                <div class="space-y-2 mb-4">
                    <div class="flex items-center gap-2">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-secondary/10 text-secondary">
                            <i class="bi bi-layout-sidebar-inset-reverse"></i>
                        </span>
                        <strong class="text-sm font-semibold text-slate-800">Drawer de Filtros</strong>
                    </div>
                    <p class="text-xs text-slate-500 leading-relaxed">Painel lateral deslizante ideal para filtros, detalhes rápidos e configurações.</p>
                </div>
                <x-sampaui::button variant="secondary" icon="funnel" wire:click="$set('showFilterDrawer', true)" full>
                    Abrir Drawer
                </x-sampaui::button>
            </div>
        </div>
    </div>

    <!-- Modal Oficial SampaUI -->
    <x-sampaui::modal
        model="showCustomerModal"
        title="Novo Cliente"
        subtitle="Preencha as informações principais para iniciar o atendimento."
        size="lg"
    >
        <div class="space-y-4">
            <x-sampaui::input name="nome" label="Nome Completo" placeholder="Digite o nome..." icon="person" required />
            <x-sampaui::input name="email" type="email" label="Email Corporativo" placeholder="cliente@empresa.com" icon="envelope" required />
            <x-sampaui::select-search
                name="segmento"
                label="Segmento de Atuação"
                placeholder="Escolha um segmento"
                :options="['tech' => 'Tecnologia & SaaS', 'retail' => 'Varejo & E-commerce', 'service' => 'Prestação de Serviços']"
            />
        </div>

        <x-slot:actions>
            <x-sampaui::button variant="outline" wire:click="$set('showCustomerModal', false)">
                Cancelar
            </x-sampaui::button>
            <x-sampaui::button variant="primary" icon="check2" wire:click="save">
                Salvar Cliente
            </x-sampaui::button>
        </x-slot:actions>
    </x-sampaui::modal>

    <!-- Drawer Oficial SampaUI -->
    <x-sampaui::drawer
        model="showFilterDrawer"
        placement="right"
        title="Filtros Avançados"
        subtitle="Refine os resultados da listagem operacional."
        size="md"
    >
        <div class="space-y-4">
            <x-sampaui::input name="busca" label="Termo de Busca" icon="search" placeholder="Nome, email ou documento..." />
            <x-sampaui::select name="status" label="Status" :options="['all' => 'Todos os Registros', 'active' => 'Ativos', 'pending' => 'Pendentes', 'archived' => 'Arquivados']" />
            <x-sampaui::toggle name="urgent" label="Exibir apenas urgentes" checked />
        </div>

        <x-slot:actions>
            <x-sampaui::button variant="outline" wire:click="$set('showFilterDrawer', false)">
                Fechar
            </x-sampaui::button>
            <x-sampaui::button variant="primary" icon="check2" wire:click="$set('showFilterDrawer', false)">
                Aplicar Filtros
            </x-sampaui::button>
        </x-slot:actions>
    </x-sampaui::drawer>
</div>
BLADE,
                'css' => '',
                'js' => '',
                'livewire' => <<<'PHP'
namespace App\Livewire;

use Livewire\Component;

class Playground extends Component
{
    public bool $showCustomerModal = false;
    public bool $showFilterDrawer = false;
    public string $nome = '';
    public string $email = '';

    public function save(): void
    {
        $this->showCustomerModal = false;
        $this->dispatch('toast', [
            'type' => 'success',
            'title' => 'Cliente salvo com sucesso!',
            'message' => 'O cadastro foi finalizado e os dados foram processados.',
        ]);
    }

    public function render()
    {
        return view('livewire.playground');
    }
}
PHP,
            ],
            'login' => [
                'name' => 'Login',
                'description' => 'Formulário de autenticação com validações, revealable password e botão de submissão.',
                'html' => <<<'BLADE'
<div class="mx-auto flex min-h-screen max-w-md items-center justify-center p-4 font-sans">
    <x-sampaui::card padding="lg" class="w-full shadow-2xl border-slate-200/80 bg-white">
        <div class="mb-6 text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-primary/10 text-primary mb-3">
                <x-sampaui::brand-mark />
            </div>
            <p class="text-xs font-bold uppercase tracking-[0.24em] text-primary">SampaUI Design</p>
            <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-800">Acesse sua Conta</h2>
            <p class="mt-1 text-xs text-slate-500">Entre com suas credenciais corporativas.</p>
        </div>

        <form class="space-y-4" wire:submit.prevent="authenticate">
            @if ($hasError)
                <x-sampaui::alert variant="danger" title="Credenciais inválidas" wire:dirty.remove>
                    Confira seu e-mail e senha antes de tentar novamente.
                </x-sampaui::alert>
            @endif

            <x-sampaui::input
                name="email"
                type="email"
                label="Email Corporativo"
                icon="envelope"
                placeholder="admin@sampa.dev"
                wire:model.live="email"
                required
            />

            <x-sampaui::input
                name="password"
                type="password"
                label="Senha de Acesso"
                icon="lock"
                revealable
                placeholder="••••••••"
                wire:model="password"
                required
            />

            <div class="flex flex-wrap items-center justify-between gap-3 pt-1">
                <x-sampaui::checkbox name="remember" label="Lembrar de mim" color="primary" wire:model="remember" />
                <a href="#" class="text-xs font-semibold text-primary transition hover:underline">Esqueceu a senha?</a>
            </div>

            <x-sampaui::button type="submit" variant="primary" icon="box-arrow-in-right" :loading="$isAuthenticating" full>
                Entrar na Plataforma
            </x-sampaui::button>
        </form>

        <p class="mt-6 text-center text-xs text-slate-500">
            Ainda não possui acesso?
            <a href="#" class="font-semibold text-primary hover:underline">Solicitar convite</a>
        </p>
    </x-sampaui::card>
</div>
BLADE,
                'css' => '',
                'js' => '',
                'livewire' => <<<'PHP'
namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;

class Login extends Component
{
    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required|min:6')]
    public string $password = '';

    public bool $remember = false;
    public bool $isAuthenticating = false;
    public bool $hasError = false;

    public function authenticate(): void
    {
        $this->validate();

        $this->isAuthenticating = true;
        $this->hasError = false;

        $this->dispatch('toast', [
            'type' => 'success',
            'title' => 'Login realizado!',
            'message' => 'Redirecionando para o painel operacional...',
        ]);
    }

    public function render()
    {
        return view('livewire.login');
    }
}
PHP,
            ],
            'form_tabs_upload' => [
                'name' => 'Formulários com Tabs e Uploads',
                'description' => 'Formulário rico em abas com avatar-upload, file-upload, pin code, inputs e selects.',
                'html' => <<<'BLADE'
<div class="flex min-h-screen items-center justify-center bg-slate-50/80 p-4 sm:p-8 font-sans">
    <x-sampaui::card
        title="Perfil & Configurações da Conta"
        description="Gerencie seus dados cadastrais, foto de perfil, documentos e segurança."
        padding="lg"
        class="w-full max-w-2xl shadow-xl border-slate-200/80 bg-white"
    >
        <x-slot:actions>
            <x-sampaui::badge variant="primary" icon="gear">Configuração</x-sampaui::badge>
        </x-slot:actions>

        <x-sampaui::tabs
            :tabs="[
                'personal' => 'Dados Pessoais',
                'media' => 'Fotos & Arquivos',
                'security' => 'Segurança & PIN',
            ]"
            active="personal"
        >
            <!-- Aba 1: Dados Pessoais -->
            <x-sampaui::tab-panel name="personal">
                <form wire:submit.prevent="save" class="space-y-4 pt-2">
                    <div class="grid gap-4 sm:grid-cols-2">
                        <x-sampaui::input
                            name="name"
                            label="Nome Completo"
                            placeholder="Ex: Carlos Eduardo Silva"
                            icon="person"
                            wire:model.live="name"
                            required
                        />

                        <x-sampaui::input
                            name="email"
                            type="email"
                            label="Email Principal"
                            placeholder="carlos.silva@empresa.com"
                            icon="envelope"
                            wire:model.live="email"
                            required
                        />
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <x-sampaui::input
                            name="phone"
                            label="Telefone / WhatsApp"
                            placeholder="(11) 98765-4321"
                            icon="telephone"
                            wire:model.live="phone"
                        />

                        <x-sampaui::select-search
                            name="role"
                            label="Cargo / Função"
                            placeholder="Selecione o cargo"
                            :options="[
                                'dev' => 'Desenvolvedor Full Stack',
                                'design' => 'UI/UX Designer',
                                'pm' => 'Gerente de Produto',
                                'qa' => 'Analista de Qualidade',
                            ]"
                        />
                    </div>

                    <x-sampaui::textarea
                        name="bio"
                        label="Biografia Profissional"
                        placeholder="Escreva um breve resumo sobre suas experiências e qualificações..."
                        rows="3"
                        auto-resize
                    />

                    <div class="flex justify-end pt-3 border-t border-slate-100">
                        <x-sampaui::button type="submit" variant="primary" icon="check2">
                            Salvar Dados
                        </x-sampaui::button>
                    </div>
                </form>
            </x-sampaui::tab-panel>

            <!-- Aba 2: Fotos & Arquivos -->
            <x-sampaui::tab-panel name="media">
                <div class="space-y-6 pt-2">
                    <div class="flex flex-col sm:flex-row items-center gap-6 rounded-xl border border-slate-100 bg-slate-50/60 p-4">
                        <x-sampaui::avatar-upload
                            name="avatar"
                            label="Foto de Perfil"
                            hint="Formatos aceitos: JPG, PNG ou WEBP (máx. 2MB)"
                            size="lg"
                        />
                        <div class="space-y-1 text-center sm:text-left">
                            <h4 class="text-sm font-semibold text-slate-800">Avatar do Usuário</h4>
                            <p class="text-xs text-slate-500">Essa foto será exibida em seu perfil público e em todas as notificações da plataforma.</p>
                        </div>
                    </div>

                    <x-sampaui::file-upload
                        name="documents"
                        label="Documentos & Comprovantes"
                        hint="Arraste arquivos PDF ou imagens para anexar (máx. 10MB)"
                        multiple
                        preview
                    />

                    <div class="flex justify-end pt-3 border-t border-slate-100">
                        <x-sampaui::button variant="primary" icon="cloud-arrow-up" wire:click="save">
                            Enviar Arquivos
                        </x-sampaui::button>
                    </div>
                </div>
            </x-sampaui::tab-panel>

            <!-- Aba 3: Segurança & PIN -->
            <x-sampaui::tab-panel name="security">
                <div class="space-y-5 pt-2">
                    <x-sampaui::alert variant="warning" icon="shield-lock" title="Autenticação Segura">
                        Defina um código PIN de 4 dígitos para autorizar transações financeiras e alterações críticas de conta.
                    </x-sampaui::alert>

                    <div class="flex flex-col items-center justify-center p-4 rounded-xl border border-slate-100 bg-slate-50/60 space-y-3">
                        <label class="text-xs font-semibold uppercase tracking-wider text-slate-600">Código PIN de Confirmação</label>
                        <x-sampaui::pin length="4" name="security_pin" clearable />
                    </div>

                    <div class="space-y-3 pt-2">
                        <x-sampaui::toggle
                            name="two_factor_auth"
                            label="Ativar Verificação em Duas Etapas (2FA)"
                            checked
                        />
                        <x-sampaui::toggle
                            name="session_alert"
                            label="Alertar novos logins suspeitos por e-mail"
                            checked
                        />
                    </div>

                    <div class="flex justify-end pt-3 border-t border-slate-100">
                        <x-sampaui::button variant="primary" icon="shield-check" wire:click="save">
                            Atualizar Segurança
                        </x-sampaui::button>
                    </div>
                </div>
            </x-sampaui::tab-panel>
        </x-sampaui::tabs>
    </x-sampaui::card>
</div>
BLADE,
                'css' => '',
                'js' => '',
                'livewire' => <<<'PHP'
namespace App\Livewire;

use Livewire\Component;

class Playground extends Component
{
    public string $name = 'Carlos Eduardo Silva';
    public string $email = 'carlos.silva@empresa.com';
    public string $phone = '(11) 98765-4321';
    public string $role = 'dev';
    public string $bio = '';
    public string $security_pin = '';
    public bool $two_factor_auth = true;
    public bool $session_alert = true;

    public function save(): void
    {
        $this->dispatch('toast', [
            'type' => 'success',
            'title' => 'Dados atualizados!',
            'message' => 'As informações e arquivos foram salvos com sucesso.',
        ]);
    }

    public function render()
    {
        return view('livewire.playground');
    }
}
PHP,
            ],
            'components' => [
                'name' => 'Componentes SampaUI',
                'description' => 'Formulário geral com inputs, selects com busca, toggle, checkbox, textarea e botões.',
                'html' => <<<'BLADE'
<div class="flex min-h-screen items-center justify-center bg-slate-50/80 p-4 sm:p-8 font-sans">
    <x-sampaui::card
        title="Cadastro de Oportunidade Comercial"
        description="Preencha os dados do cliente e configure as preferências de atendimento."
        padding="lg"
        class="w-full max-w-2xl shadow-xl border-slate-200/80 bg-white"
    >
        <x-slot:actions>
            <x-sampaui::badge variant="primary" icon="stars">SampaUI v0.1</x-sampaui::badge>
        </x-slot:actions>

        <form wire:submit.prevent="save" class="space-y-5">
            <x-sampaui::alert variant="info" icon="info-circle" title="Integração em Tempo Real">
                Edite os campos abaixo. O estado Livewire e os componentes Blade são sincronizados instantaneamente no preview.
            </x-sampaui::alert>

            <div class="grid gap-4 sm:grid-cols-2">
                <x-sampaui::input
                    name="client_name"
                    label="Nome do Cliente"
                    placeholder="Ex: Ana Clara Souza"
                    icon="person"
                    wire:model.live="client_name"
                    required
                />

                <x-sampaui::input
                    name="client_email"
                    type="email"
                    label="Email Corporativo"
                    placeholder="ana.souza@empresa.com"
                    icon="envelope"
                    wire:model.live="client_email"
                    required
                />
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <x-sampaui::select-search
                    name="segment"
                    label="Segmento de Atuação"
                    placeholder="Selecione um segmento"
                    :options="[
                        'tech' => 'Tecnologia & SaaS',
                        'health' => 'Saúde & Farmacêutica',
                        'finance' => 'Financeiro & Fintech',
                        'retail' => 'Varejo & E-commerce',
                        'agro' => 'Agronegócio',
                    ]"
                />

                <x-sampaui::select
                    name="priority"
                    label="Prioridade do Atendimento"
                    :options="[
                        'low' => 'Baixa Prioridade',
                        'medium' => 'Média Prioridade',
                        'high' => 'Alta Prioridade (Urgente)',
                    ]"
                />
            </div>

            <x-sampaui::textarea
                name="notes"
                label="Observações & Escopo do Projeto"
                placeholder="Detalhes adicionais sobre a oportunidade comercial..."
                rows="3"
                auto-resize
                counter
                maxlength="250"
            />

            <div class="rounded-xl border border-slate-100 bg-slate-50/60 p-4 space-y-3">
                <span class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Notificações & Alertas</span>
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <x-sampaui::toggle
                        name="notify_email"
                        label="Enviar resumo detalhado por e-mail"
                        checked
                    />

                    <x-sampaui::checkbox
                        name="notify_whatsapp"
                        label="Notificar equipe via WhatsApp"
                        color="primary"
                        checked
                    />
                </div>
            </div>

            <div class="flex items-center justify-between gap-3 pt-4 border-t border-slate-100">
                <x-sampaui::button type="button" variant="outline" icon="arrow-counterclockwise">
                    Limpar
                </x-sampaui::button>
                <x-sampaui::button type="submit" variant="primary" icon="check2-circle" wire:click="save">
                    Salvar Oportunidade
                </x-sampaui::button>
            </div>
        </form>
    </x-sampaui::card>
</div>
BLADE,
                'css' => '',
                'js' => '',
                'livewire' => <<<'PHP'
namespace App\Livewire;

use Livewire\Component;

class Playground extends Component
{
    public string $client_name = '';
    public string $client_email = '';
    public string $segment = '';
    public string $priority = 'medium';
    public string $notes = '';
    public bool $notify_email = true;
    public bool $notify_whatsapp = true;

    public function save(): void
    {
        $this->dispatch('toast', [
            'type' => 'success',
            'title' => 'Oportunidade salva!',
            'message' => 'O registro foi cadastrado com sucesso.',
        ]);
    }

    public function render()
    {
        return view('livewire.playground');
    }
}
PHP,
            ],
        ];

        return view('docs.playground', [
            'components' => $components,
            'navigationComponents' => $components,
            'navigationPages' => $pages,
            'navigationExamples' => $examples,
            'templates' => $templates,
        ]);
    }

    public function compile(Request $request): JsonResponse
    {
        $code = (string) $request->input('code', '');
        $livewire = (string) $request->input('livewire', '');

        if (! str_contains($code, '<x-') && ! str_contains($code, '@') && ! str_contains($code, '$this') && ! str_contains($code, '$')) {
            return response()->json([
                'success' => true,
                'html' => $code,
            ]);
        }

        try {
            $data = $this->extractLivewireProperties($livewire);

            // Injetar variáveis essenciais do ecossistema Blade/Laravel
            $data['errors'] = $data['errors'] ?? new \Illuminate\Support\ViewErrorBag();
            $data['slot'] = $data['slot'] ?? new \Illuminate\Support\HtmlString('');
            $data['attributes'] = $data['attributes'] ?? new \Illuminate\View\ComponentAttributeBag();

            // Identificar automaticamente todas as variáveis $nomeVar usadas no template Blade
            if (preg_match_all('/\$([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)/', $code, $matches)) {
                $builtinVars = ['this', 'errors', 'slot', 'attributes', 'loop', '__env', 'app', '_instance', '_currentLoopData'];
                foreach ($matches[1] as $varName) {
                    if (! in_array($varName, $builtinVars, true) && ! array_key_exists($varName, $data)) {
                        $lower = strtolower($varName);
                        if (in_array($lower, ['users', 'items', 'rows', 'options', 'clients', 'customers', 'products', 'steps', 'tabs', 'list', 'data'], true) || str_ends_with($lower, 's')) {
                            $data[$varName] = [];
                        } elseif (str_starts_with($varName, 'is') || str_starts_with($varName, 'has') || str_starts_with($varName, 'show') || str_starts_with($varName, 'can')) {
                            $data[$varName] = false;
                        } else {
                            $data[$varName] = false;
                        }
                    }
                }
            }

            $normalizedCode = preg_replace('/\$this->([a-zA-Z0-9_]+)/', '$$1', $code);
            $rendered = Blade::render($normalizedCode, $data);

            return response()->json([
                'success' => true,
                'html' => $rendered,
                'state' => $data,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'html' => $code,
            ]);
        }
    }

    protected function extractLivewireProperties(string $phpCode): array
    {
        $properties = [];
        if (! $phpCode) {
            return $properties;
        }

        if (preg_match_all('/public\s+(?:[a-zA-Z0-9_|\\\\?]+\s+)?\$([a-zA-Z0-9_]+)(?:\s*=\s*([^;]+))?;/', $phpCode, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $name = $match[1];
                $rawVal = isset($match[2]) ? trim($match[2]) : 'null';

                if ($rawVal === 'true') {
                    $val = true;
                } elseif ($rawVal === 'false') {
                    $val = false;
                } elseif ($rawVal === 'null') {
                    $val = null;
                } elseif (is_numeric($rawVal)) {
                    $val = str_contains($rawVal, '.') ? (float) $rawVal : (int) $rawVal;
                } elseif ((str_starts_with($rawVal, "'") && str_ends_with($rawVal, "'")) || (str_starts_with($rawVal, '"') && str_ends_with($rawVal, '"'))) {
                    $val = substr($rawVal, 1, -1);
                } elseif ($rawVal === '[]' || $rawVal === 'array()') {
                    $val = [];
                } else {
                    $val = $rawVal;
                }

                $properties[$name] = $val;
            }
        }

        return $properties;
    }
}
