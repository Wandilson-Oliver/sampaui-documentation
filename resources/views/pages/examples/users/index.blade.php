@extends('docs.layout', ['title' => $title ?? 'Exemplo de listagem de usuários · Documentação SampaUI'])

@php
    $snippet = <<<'BLADE'
{{-- 1. Inclusão direta do componente Livewire --}}
<livewire:examples.users-index />

{{-- 2. Ou implementação customizada com componentes SampaUI --}}
<div class="space-y-6">
    {{-- Cards de métricas rápidas --}}
    <div class="grid gap-4 md:grid-cols-3">
        <x-sampaui::card title="Ativos" padding="md">
            <p class="text-3xl font-semibold text-success">{{ $activeCount }}</p>
            <p class="mt-1 text-sm text-secondary">Usuários liberados para atendimento</p>
        </x-sampaui::card>

        <x-sampaui::card title="Pendentes" padding="md">
            <p class="text-3xl font-semibold text-accent">{{ $pendingCount }}</p>
            <p class="mt-1 text-sm text-secondary">Cadastros aguardando revisão</p>
        </x-sampaui::card>

        <x-sampaui::card title="Inativos" padding="md">
            <p class="text-3xl font-semibold text-secondary">{{ $inactiveCount }}</p>
            <p class="mt-1 text-sm text-secondary">Acessos pausados no painel</p>
        </x-sampaui::card>
    </div>

    {{-- Card principal com CRUD --}}
    <x-sampaui::card title="Usuários" description="Gerencie a equipe e permissões de acesso" padding="lg">
        <x-slot:actions>
            <x-sampaui::button icon="plus" wire:click="openCreateModal">Cadastrar usuário</x-sampaui::button>
        </x-slot:actions>

        {{-- Filtros e busca reativa com Livewire --}}
        <div class="mb-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-[minmax(0,1fr)_14rem_12rem_auto]">
            <x-sampaui::input
                name="search"
                icon="search"
                placeholder="Buscar por nome, email ou cargo"
                wire:model.live.debounce.300ms="search"
            />

            <x-sampaui::select
                name="status"
                :options="[
                    ['label' => 'Todos os status', 'value' => ''],
                    ['label' => 'Ativo', 'value' => 'Ativo'],
                    ['label' => 'Pendente', 'value' => 'Pendente'],
                    ['label' => 'Inativo', 'value' => 'Inativo'],
                ]"
                wire:model.live="status"
            />

            <x-sampaui::select
                name="perPage"
                :options="[
                    ['label' => '5 por página', 'value' => 5],
                    ['label' => '10 por página', 'value' => 10],
                    ['label' => '15 por página', 'value' => 15],
                ]"
                wire:model.live="perPage"
            />

            <x-sampaui::button variant="outline" icon="arrow-counterclockwise" wire:click="resetFilters">
                Limpar
            </x-sampaui::button>
        </div>

        {{-- Tabela de listagem --}}
        <x-sampaui::table compact>
            <x-slot:head>
                <thead class="bg-light/70 text-left text-xs font-semibold uppercase tracking-wider text-secondary">
                    <tr>
                        <th class="px-6 py-3">Usuário</th>
                        <th class="px-6 py-3">Contato</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Ações</th>
                    </tr>
                </thead>
            </x-slot:head>
            <x-slot:body>
                <tbody class="divide-y divide-border">
                    @forelse ($paginatedUsers as $user)
                        <tr wire:key="user-row-{{ $user['id'] }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $user['photo'] }}" class="h-9 w-9 rounded-full object-cover" />
                                    <div>
                                        <p class="font-semibold text-primary">{{ $user['name'] }}</p>
                                        <p class="text-xs text-secondary/70">{{ $user['role'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-secondary">
                                <p>{{ $user['email'] }}</p>
                                <p class="text-xs text-secondary/60">{{ $user['whatsapp'] }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <x-sampaui::badge :variant="$user['status'] === 'Ativo' ? 'success' : ($user['status'] === 'Pendente' ? 'accent' : 'secondary')">
                                    {{ $user['status'] }}
                                </x-sampaui::badge>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center gap-1">
                                    <x-sampaui::button size="sm" variant="outline" icon="pencil" wire:click="editUser({{ $user['id'] }})" />
                                    <x-sampaui::button size="sm" variant="danger" icon="trash" wire:click="deleteUser({{ $user['id'] }})" />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-sm text-secondary">
                                Nenhum usuário encontrado para os filtros aplicados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </x-slot:body>
        </x-sampaui::table>
    </x-sampaui::card>

    {{-- Modal de Criação / Edição --}}
    <x-sampaui::modal model="showUserModal" :title="$editingId ? 'Editar usuário' : 'Novo usuário'">
        <form wire:submit.prevent="saveUser" class="space-y-4">
            <x-sampaui::input name="formName" label="Nome completo" wire:model="formName" required />
            <x-sampaui::input name="formEmail" type="email" label="Email corporativo" wire:model="formEmail" required />
            <x-sampaui::phone name="formWhatsapp" label="WhatsApp" wire:model="formWhatsapp" />
            <x-sampaui::select
                name="formStatus"
                label="Status da conta"
                :options="[
                    ['label' => 'Ativo', 'value' => 'Ativo'],
                    ['label' => 'Pendente', 'value' => 'Pendente'],
                    ['label' => 'Inativo', 'value' => 'Inativo'],
                ]"
                wire:model="formStatus"
            />
        </form>

        <x-slot:actions>
            <x-sampaui::button variant="outline" wire:click="$set('showUserModal', false)">Cancelar</x-sampaui::button>
            <x-sampaui::button wire:click="saveUser">Salvar usuário</x-sampaui::button>
        </x-slot:actions>
    </x-sampaui::modal>
</div>
BLADE;

    $livewireSnippet = <<<'PHP'
namespace App\Livewire;

use Livewire\Component;

class UsersIndex extends Component
{
    public string $search = '';
    public string $status = '';
    public int $page = 1;
    public int $perPage = 5;
    public bool $showUserModal = false;
    public ?int $editingId = null;

    public string $formName = '';
    public string $formEmail = '';
    public string $formWhatsapp = '';
    public string $formStatus = 'Ativo';

    public array $users = [];

    public function mount(): void
    {
        $this->users = [
            ['id' => 1, 'name' => 'Ana Martins', 'email' => 'ana@sampa.dev', 'whatsapp' => '(11) 99999-1001', 'status' => 'Ativo', 'role' => 'Consultora comercial'],
            ['id' => 2, 'name' => 'Bruno Lima', 'email' => 'bruno@sampa.dev', 'whatsapp' => '(11) 99999-1002', 'status' => 'Pendente', 'role' => 'Consultor comercial'],
            ['id' => 3, 'name' => 'Carla Souza', 'email' => 'carla@sampa.dev', 'whatsapp' => '(11) 99999-1003', 'status' => 'Inativo', 'role' => 'Coordenadora'],
        ];
    }

    public function openCreateModal(): void
    {
        $this->reset(['formName', 'formEmail', 'formWhatsapp', 'editingId']);
        $this->formStatus = 'Ativo';
        $this->showUserModal = true;
    }

    public function saveUser(): void
    {
        $this->validate([
            'formName' => 'required|min:3',
            'formEmail' => 'required|email',
        ]);

        if ($this->editingId) {
            foreach ($this->users as &$user) {
                if ($user['id'] === $this->editingId) {
                    $user['name'] = $this->formName;
                    $user['email'] = $this->formEmail;
                    $user['whatsapp'] = $this->formWhatsapp;
                    $user['status'] = $this->formStatus;
                }
            }
        } else {
            $this->users[] = [
                'id' => count($this->users) + 1,
                'name' => $this->formName,
                'email' => $this->formEmail,
                'whatsapp' => $this->formWhatsapp,
                'status' => $this->formStatus,
                'role' => 'Usuário',
            ];
        }

        $this->showUserModal = false;
    }

    public function deleteUser(int $id): void
    {
        $this->users = array_values(array_filter($this->users, fn ($u) => $u['id'] !== $id));
    }

    public function render()
    {
        $filtered = array_filter($this->users, function ($u) {
            $matchesSearch = empty($this->search) || str_contains(strtolower($u['name']), strtolower($this->search));
            $matchesStatus = empty($this->status) || $u['status'] === $this->status;
            return $matchesSearch && $matchesStatus;
        });

        return view('livewire.users-index', [
            'paginatedUsers' => array_slice($filtered, ($this->page - 1) * $this->perPage, $this->perPage),
            'activeCount' => count(array_filter($this->users, fn ($u) => $u['status'] === 'Ativo')),
            'pendingCount' => count(array_filter($this->users, fn ($u) => $u['status'] === 'Pendente')),
            'inactiveCount' => count(array_filter($this->users, fn ($u) => $u['status'] === 'Inativo')),
        ]);
    }
}
PHP;
@endphp

@section('content')
    <section class="doc-component-intro-grid">
        <article class="doc-hero-card">
            <div class="relative z-[1]">
                <p class="doc-kicker">Exemplo funcional</p>
                <h1 class="mt-3 text-3xl font-semibold tracking-tight text-primary md:text-4xl">Listagem de usuários</h1>
                <p class="mt-4 max-w-3xl text-sm leading-6 text-secondary">
                    Interface CRUD simulada com Livewire: busca, filtro, ordenação, paginação, cadastro, edição, exclusão e toggle de status funcionam sem recarregar a página.
                </p>
            </div>
        </article>
    </section>

    <div class="space-y-8">
        <livewire:examples.users-index />

        @include('pages.examples.partials.code', [
            'snippet' => $snippet,
            'livewireSnippet' => $livewireSnippet,
            'codeTitle' => 'Código do CRUD de Usuários',
            'description' => 'Componente Livewire completo com busca, filtros, listagem paginada, cadastro e modal reativo.',
            'components' => ['card', 'table', 'badge', 'button', 'input', 'select', 'modal', 'toggle', 'alert'],
        ])
    </div>
@endsection
