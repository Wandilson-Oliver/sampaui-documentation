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
            'components' => [
                'name' => 'Componentes SampaUI',
                'description' => 'Formulário moderno com inputs, selects com busca, toggle, checkbox, pin e feedback.',
                'html' => <<<'BLADE'
<div class="flex min-h-screen items-center justify-center bg-slate-50 p-6">
    <x-sampaui::card
        title="Cadastro de Oportunidade"
        description="Utilize todos os componentes oficiais do SampaUI no Playground."
        padding="lg"
        class="w-full max-w-2xl shadow-xl"
    >
        <x-slot:actions>
            <x-sampaui::badge variant="primary" icon="stars">SampaUI v0.1</x-sampaui::badge>
        </x-slot:actions>

        <div class="space-y-4">
            <x-sampaui::alert variant="info" icon="info-circle" title="Dica de Desenvolvimento">
                Você pode usar tags como <code>&lt;x-sampaui::input&gt;</code>, <code>&lt;x-sampaui::select-search&gt;</code> e slots Blade em tempo real!
            </x-sampaui::alert>

            <div class="grid gap-4 sm:grid-cols-2">
                <x-sampaui::input
                    name="client_name"
                    label="Nome do Cliente"
                    placeholder="Ex: Ana Clara Souza"
                    icon="person"
                    required
                />

                <x-sampaui::input
                    name="client_email"
                    type="email"
                    label="Email Corporativo"
                    placeholder="ana.souza@empresa.com"
                    icon="envelope"
                    required
                />
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <x-sampaui::select-search
                    name="segment"
                    label="Segmento de Atuação"
                    placeholder="Selecione um segmento"
                    :options="[
                        'tech' => 'Tecnologia & Software',
                        'health' => 'Saúde & Farmacêutica',
                        'finance' => 'Financeiro & Fintech',
                        'retail' => 'Varejo & E-commerce',
                    ]"
                />

                <x-sampaui::select
                    name="priority"
                    label="Prioridade do Atendimento"
                    :options="[
                        'low' => 'Baixa',
                        'medium' => 'Média',
                        'high' => 'Alta Prioridade',
                    ]"
                />
            </div>

            <x-sampaui::textarea
                name="notes"
                label="Observações do Atendimento"
                placeholder="Detalhes adicionais sobre a oportunidade..."
                rows="3"
                auto-resize
                counter
                maxlength="200"
            />

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-2">
                <x-sampaui::toggle
                    name="notify_email"
                    label="Enviar resumo por email"
                    checked
                />

                <x-sampaui::checkbox
                    name="notify_whatsapp"
                    label="Notificar via WhatsApp"
                    checked
                />
            </div>
        </div>

        <x-slot:footer>
            <div class="flex items-center justify-between w-full">
                <x-sampaui::button variant="outline" icon="x-lg">Cancelar</x-sampaui::button>
                <x-sampaui::button variant="primary" icon="check2-circle" wire:click="save">Salvar Registro</x-sampaui::button>
            </div>
        </x-slot:footer>
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
            'modal_drawer' => [
                'name' => 'Modal & Drawer Interativo',
                'description' => 'Controle de estado Livewire para abertura e fechamento de modais e painéis laterais.',
                'html' => <<<'BLADE'
<div class="flex min-h-screen flex-col items-center justify-center gap-4 bg-slate-100 p-6 font-sans">
  <div class="flex flex-wrap items-center justify-center gap-3">
    <x-sampaui::button variant="primary" icon="window-stack" wire:click="$set('showCustomerModal', true)">
      Abrir Modal de Cadastro
    </x-sampaui::button>

    <x-sampaui::button variant="secondary" icon="layout-sidebar-inset-reverse" wire:click="$set('showFilterDrawer', true)">
      Abrir Gaveta Lateral de Filtros
    </x-sampaui::button>
  </div>

  <!-- Modal Interativo -->
  <x-sampaui::modal
    model="showCustomerModal"
    title="Novo Cliente"
    subtitle="Cadastre as informações principais para iniciar o atendimento."
    size="lg"
  >
    <div class="space-y-4">
      <x-sampaui::input name="nome" label="Nome Completo" placeholder="Digite o nome..." icon="person" required />
      <x-sampaui::input name="email" type="email" label="Email Corporativo" placeholder="cliente@empresa.com" icon="envelope" required />
      <x-sampaui::select-search
        name="segmento"
        label="Segmento"
        placeholder="Escolha um segmento"
        :options="['tech' => 'Tecnologia', 'retail' => 'Varejo', 'service' => 'Serviços']"
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

  <!-- Drawer Lateral -->
  <x-sampaui::drawer
    model="showFilterDrawer"
    placement="right"
    title="Filtros Avançados"
    subtitle="Refine os resultados da listagem"
    size="md"
  >
    <div class="space-y-4">
      <x-sampaui::input name="busca" label="Termo de Busca" icon="search" placeholder="Nome, email ou documento..." />
      <x-sampaui::select name="status" label="Status" :options="['all' => 'Todos', 'active' => 'Ativos', 'pending' => 'Pendentes']" />
      <x-sampaui::toggle name="urgent" label="Apenas urgentes" checked />
    </div>

    <x-slot:actions>
      <x-sampaui::button variant="outline" wire:click="$set('showFilterDrawer', false)">
        Fechar
      </x-sampaui::button>
      <x-sampaui::button variant="primary" wire:click="$set('showFilterDrawer', false)">
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
            'title' => 'Cliente salvo!',
            'message' => 'O cadastro foi finalizado com sucesso.',
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
                'name' => 'DataTable Profissional',
                'description' => 'Tabela rica com busca, ordenação de colunas, paginação e ações.',
                'html' => <<<'BLADE'
<div class="min-h-screen bg-slate-50 p-6 font-sans">
    <div class="mx-auto max-w-5xl space-y-6">
        <x-sampaui::table
            title="Gestão de Clientes"
            description="Listagem completa com busca e ordenação sincronizadas via Livewire."
            searchable
            search-model="search"
            selectable
            export-href="#"
            per-page="5"
            :columns="[
                'name' => ['label' => 'Nome do Cliente', 'sortable' => true],
                'email' => 'Email',
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
            'chat' => [
                'name' => 'Central de Atendimento (Chat)',
                'description' => 'Interface moderna de atendimento com lista de conversas, mensagens e compositor.',
                'html' => <<<'BLADE'
<div class="h-screen bg-slate-100 p-4 font-sans">
    <div class="h-full rounded-2xl border border-slate-200 bg-white shadow-xl overflow-hidden flex flex-col md:flex-row">
        <!-- Sidebar de Conversas -->
        <div class="w-full md:w-80 border-r border-slate-200 bg-slate-50/50 flex flex-col">
            <div class="p-4 border-b border-slate-200">
                <x-sampaui::input name="chat_search" placeholder="Buscar conversas..." icon="search" />
            </div>
            <div class="flex-1 overflow-y-auto divide-y divide-slate-100 p-2 space-y-1">
                <div class="flex items-center gap-3 p-3 rounded-xl bg-primary/10 border border-primary/20 cursor-pointer">
                    <x-sampaui::avatar name="Ana Souza" size="md" status="online" />
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <strong class="text-sm font-semibold text-secondary truncate">Ana Souza</strong>
                            <span class="text-[10px] text-slate-400">10:42</span>
                        </div>
                        <p class="text-xs text-slate-500 truncate">Olá! Preciso tirar uma dúvida sobre a proposta.</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-100 transition cursor-pointer">
                    <x-sampaui::avatar name="Bruno Lima" size="md" status="away" />
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <strong class="text-sm font-semibold text-secondary truncate">Bruno Lima</strong>
                            <span class="text-[10px] text-slate-400">09:15</span>
                        </div>
                        <p class="text-xs text-slate-500 truncate">Perfeito, contrato assinado!</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Área Principal de Mensagens -->
        <div class="flex-1 flex flex-col min-w-0 bg-white">
            <!-- Header do Chat -->
            <div class="h-16 px-6 border-b border-slate-200 flex items-center justify-between bg-white">
                <div class="flex items-center gap-3">
                    <x-sampaui::avatar name="Ana Souza" size="sm" status="online" />
                    <div>
                        <strong class="block text-sm font-semibold text-secondary">Ana Souza</strong>
                        <span class="text-xs text-emerald-600 font-medium">Online agora</span>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <x-sampaui::button size="sm" variant="outline" icon="telephone" />
                    <x-sampaui::button size="sm" variant="outline" icon="three-dots-vertical" />
                </div>
            </div>

            <!-- Corpo de Mensagens -->
            <div class="flex-1 overflow-y-auto p-6 space-y-4 bg-slate-50/30">
                <x-sampaui::chat-message
                    sender="Ana Souza"
                    time="10:40"
                    message="Bom dia! Tudo bem? Gostaria de saber se o desconto promocional ainda está ativo."
                />
                <x-sampaui::chat-message
                    sender="Você"
                    time="10:42"
                    message="Olá Ana! Sim, conseguimos manter as condições especiais para fechamento hoje."
                    outgoing
                />
            </div>

            <!-- Compositor de Mensagem -->
            <div class="p-4 border-t border-slate-200 bg-white">
                <x-sampaui::chat-composer
                    placeholder="Digite sua resposta..."
                    wire-model="message"
                    send-action="sendMessage"
                />
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

class ChatCenter extends Component
{
    public string $message = '';

    public function sendMessage(): void
    {
        if (trim($this->message) === '') return;

        $this->message = '';
    }

    public function render()
    {
        return view('livewire.chat-center');
    }
}
PHP,
            ],
            'login' => [
                'name' => 'Formulário de Autenticação',
                'description' => 'Card de login elegante com validações, revealable password e botão de submissão.',
                'html' => <<<'BLADE'
<div class="flex min-h-screen items-center justify-center bg-slate-100 p-4 font-sans">
  <x-sampaui::card title="Acesse sua Conta" description="Entre com suas credenciais para acessar o painel" class="w-full max-w-md shadow-2xl">
    <div class="space-y-4">
      <x-sampaui::input name="email" type="email" label="Email Corporativo" placeholder="seu.email@empresa.com" icon="envelope" required />
      <x-sampaui::input name="password" type="password" label="Senha de Acesso" placeholder="••••••••" icon="lock" revealable required />
      
      <div class="flex items-center justify-between text-xs">
        <x-sampaui::checkbox name="remember" label="Lembrar deste dispositivo" />
        <a href="#" class="font-medium text-primary hover:underline">Esqueceu a senha?</a>
      </div>
    </div>

    <x-slot:actions>
      <x-sampaui::button class="w-full" size="lg" icon="box-arrow-in-right" wire:click="authenticate">
        Entrar na Plataforma
      </x-sampaui::button>
    </x-slot:actions>
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

    public function authenticate(): void
    {
        $this->validate();

        $this->dispatch('toast', [
            'type' => 'success',
            'title' => 'Login realizado!',
            'message' => 'Redirecionando para o dashboard...',
        ]);
    }

    public function render()
    {
        return view('livewire.login');
    }
}
PHP,
            ],
            'card' => [
                'name' => 'Card de Perfil',
                'description' => 'Card moderno com avatar, badges de status, métricas e botões de ação.',
                'html' => <<<'BLADE'
<div class="flex min-h-screen items-center justify-center bg-slate-50 p-6 font-sans">
  <div class="w-full max-w-sm overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl transition-all duration-300 hover:shadow-2xl">
    <div class="h-28 bg-gradient-to-r from-primary to-purple p-4 relative">
      <span class="absolute top-4 right-4 inline-flex items-center gap-1.5 rounded-full bg-white/20 backdrop-blur-md px-3 py-1 text-xs font-semibold text-white">
        <i class="bi bi-stars"></i> Pro
      </span>
    </div>

    <div class="relative px-6 pb-6 pt-0">
      <div class="-mt-12 mb-4 flex items-end justify-between">
        <div class="relative">
          <x-sampaui::avatar name="Mariana Albuquerque" size="lg" status="online" />
        </div>
        <x-sampaui::button size="sm" icon="person-plus" wire:click="toggleConnect">
          Conectar
        </x-sampaui::button>
      </div>

      <div>
        <h3 class="text-xl font-bold text-secondary">Mariana Albuquerque</h3>
        <p class="text-sm font-medium text-slate-500">Lead UI/UX Designer @ SampaUI</p>
        <p class="mt-2 text-xs leading-relaxed text-slate-600">
          Especialista em design systems, prototipação ágil e interfaces web focadas em experiência do usuário.
        </p>
      </div>

      <div class="mt-5 grid grid-cols-3 divide-x divide-slate-100 rounded-xl border border-slate-100 bg-slate-50/50 p-3 text-center">
        <div>
          <strong class="block text-lg font-bold text-secondary">1.2k</strong>
          <span class="text-[11px] font-medium text-slate-500">Seguidores</span>
        </div>
        <div>
          <strong class="block text-lg font-bold text-secondary">84</strong>
          <span class="text-[11px] font-medium text-slate-500">Projetos</span>
        </div>
        <div>
          <strong class="block text-lg font-bold text-secondary">4.9</strong>
          <span class="text-[11px] font-medium text-slate-500">Avaliação</span>
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

        if (! str_contains($code, '<x-') && ! str_contains($code, '@') && ! str_contains($code, '$this')) {
            return response()->json([
                'success' => true,
                'html' => $code,
            ]);
        }

        try {
            $data = $this->extractLivewireProperties($livewire);
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
