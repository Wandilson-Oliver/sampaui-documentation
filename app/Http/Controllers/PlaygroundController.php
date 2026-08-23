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
                'description' => 'Formulário completo utilizando os componentes oficiais x-sampaui::.',
                'html' => <<<'BLADE'
<div class="flex min-h-screen items-center justify-center bg-slate-50 p-6">
    <x-sampaui::card
        title="Cadastro de Oportunidade"
        description="Utilize todos os componentes Blade oficiais do SampaUI no Playground."
        padding="lg"
        class="w-full max-w-xl shadow-xl"
    >
        <x-slot:actions>
            <x-sampaui::badge variant="primary" icon="stars">SampaUI v0.1</x-sampaui::badge>
        </x-slot:actions>

        <div class="space-y-4">
            <x-sampaui::alert variant="info" icon="info-circle" title="Dica">
                Você pode usar tags como <code>&lt;x-sampaui::button&gt;</code>, <code>&lt;x-sampaui::input&gt;</code> e slots Blade em tempo real!
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

            <x-sampaui::select
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

            <x-sampaui::checkbox
                name="notify_whatsapp"
                label="Enviar notificação e proposta por WhatsApp"
                checked
            />
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
<?php

namespace App\Livewire;

use Livewire\Component;

class Playground extends Component
{
    public string $client_name = '';
    public string $client_email = '';
    public string $segment = '';
    public bool $notify_whatsapp = true;

    public function save()
    {
        // Salvar oportunidade
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
                'description' => 'Controle de estado Livewire para abertura e fechamento de janelas modais e gavetas laterais.',
                'html' => <<<'BLADE'
<div class="flex min-h-screen items-center justify-center gap-4 bg-slate-100 p-6 font-sans">
  <x-sampaui::button variant="primary" icon="window-stack" wire:click="$set('showCustomerModal', true)">
    Abrir Modal
  </x-sampaui::button>

  <x-sampaui::button variant="secondary" icon="layout-sidebar-inset-reverse" wire:click="$toggle('showFilterDrawer')">
    Abrir Gaveta Lateral
  </x-sampaui::button>

  <!-- Modal Interativo -->
  <x-sampaui::modal model="showCustomerModal" title="Novo Cliente" subtitle="Cadastre as informações principais">
    <div class="space-y-4">
      <x-sampaui::input name="nome" label="Nome Completo" placeholder="Digite o nome..." required />
      <x-sampaui::input name="email" type="email" label="Email" placeholder="cliente@email.com" required />
    </div>

    <x-slot:actions>
      <x-sampaui::button variant="outline" wire:click="$set('showCustomerModal', false)">
        Cancelar
      </x-sampaui::button>
      <x-sampaui::button variant="primary" wire:click="save">
        Salvar Cliente
      </x-sampaui::button>
    </x-slot:actions>
  </x-sampaui::modal>

  <!-- Drawer Lateral -->
  <x-sampaui::drawer model="showFilterDrawer" position="right" title="Filtros Rápidos">
    <div class="space-y-4">
      <x-sampaui::select name="status" label="Status" :options="['all' => 'Todos', 'active' => 'Ativos', 'pending' => 'Pendentes']" />
      <x-sampaui::checkbox name="urgent" label="Apenas urgentes" />
    </div>

    <x-slot:footer>
      <x-sampaui::button variant="primary" class="w-full" wire:click="$set('showFilterDrawer', false)">
        Aplicar Filtros
      </x-sampaui::button>
    </x-slot:footer>
  </x-sampaui::drawer>
</div>
BLADE,
                'css' => '',
                'js' => '',
                'livewire' => <<<'PHP'
<?php

namespace App\Livewire;

use Livewire\Component;

class Playground extends Component
{
    public bool $showCustomerModal = false;
    public bool $showFilterDrawer = false;
    public string $nome = '';
    public string $email = '';

    public function save()
    {
        $this->showCustomerModal = false;
    }

    public function render()
    {
        return view('livewire.playground');
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
    <!-- Header com gradiente -->
    <div class="h-28 bg-gradient-to-r from-primary to-purple p-4 relative">
      <span class="absolute top-4 right-4 inline-flex items-center gap-1.5 rounded-full bg-white/20 backdrop-blur-md px-3 py-1 text-xs font-semibold text-white">
        <i class="bi bi-stars"></i> Pro
      </span>
    </div>

    <!-- Conteúdo do Perfil -->
    <div class="relative px-6 pb-6 pt-0">
      <!-- Avatar -->
      <div class="-mt-12 mb-4 flex items-end justify-between">
        <div class="relative">
          <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150" alt="Avatar" class="h-24 w-24 rounded-2xl border-4 border-white object-cover shadow-md" />
          <span class="absolute bottom-1 right-1 h-4 w-4 rounded-full border-2 border-white bg-success"></span>
        </div>
        <x-sampaui::button size="sm" icon="person-plus" wire:click="toggleConnect">
          Conectar
        </x-sampaui::button>
      </div>

      <!-- Informações -->
      <div>
        <h3 class="text-xl font-bold text-secondary">Mariana Albuquerque</h3>
        <p class="text-sm font-medium text-slate-500">Lead UI/UX Designer @ SampaUI</p>
        <p class="mt-2 text-xs leading-relaxed text-slate-600">
          Especialista em design systems, prototipação ágil e interfaces web focadas em experiência do usuário.
        </p>
      </div>

      <!-- Estatísticas -->
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
<?php

namespace App\Livewire;

use Livewire\Component;

class Playground extends Component
{
    public string $name = 'Mariana Albuquerque';
    public string $role = 'Lead UI/UX Designer @ SampaUI';
    public bool $connected = false;

    public function toggleConnect()
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
            'login' => [
                'name' => 'Formulário de Login',
                'description' => 'Card de autenticação com componentes SampaUI e inputs estilizados.',
                'html' => <<<'BLADE'
<div class="flex min-h-screen items-center justify-center bg-slate-100 p-4 font-sans">
  <x-sampaui::card title="Bem-vindo de volta" description="Entre com seu email e senha para continuar" class="w-full max-w-md shadow-2xl">
    <div class="space-y-4">
      <x-sampaui::input name="email" type="email" label="Email corporativo" placeholder="seu.email@empresa.com" icon="envelope" required />
      <x-sampaui::input name="password" type="password" label="Senha" placeholder="••••••••" icon="lock" revealable required />
      <x-sampaui::checkbox name="remember" label="Lembrar deste dispositivo" />
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
<?php

namespace App\Livewire;

use Livewire\Component;

class Playground extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;

    public function authenticate()
    {
        // Validar e autenticar usuário
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
