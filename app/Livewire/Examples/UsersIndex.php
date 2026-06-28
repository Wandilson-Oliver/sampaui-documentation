<?php

namespace App\Livewire\Examples;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Livewire\Component;

class UsersIndex extends Component
{
    public string $search = '';

    public string $status = '';

    public int $page = 1;

    public int $perPage = 5;

    public string $sortBy = 'name';

    public string $sortDirection = 'asc';

    public bool $showUserModal = false;

    public bool $showPreviewModal = false;

    public ?int $editingId = null;

    public ?int $previewId = null;

    public string $flashMessage = '';

    /** @var array<int, array<string, mixed>> */
    public array $users = [];

    public string $formName = '';

    public string $formEmail = '';

    public string $formWhatsapp = '';

    public string $formStatus = 'Ativo';

    public function mount(): void
    {
        $this->users = [
            ['id' => 1, 'name' => 'Ana Martins', 'email' => 'ana@sampa.dev', 'whatsapp' => '+55 11 99999-1001', 'status' => 'Ativo', 'role' => 'Consultora comercial', 'photo' => 'https://i.pravatar.cc/160?img=47'],
            ['id' => 2, 'name' => 'Bruno Lima', 'email' => 'bruno@sampa.dev', 'whatsapp' => '+55 11 99999-1002', 'status' => 'Pendente', 'role' => 'Consultor comercial', 'photo' => 'https://i.pravatar.cc/160?img=12'],
            ['id' => 3, 'name' => 'Carla Souza', 'email' => 'carla@sampa.dev', 'whatsapp' => '+55 11 99999-1003', 'status' => 'Inativo', 'role' => 'Coordenadora comercial', 'photo' => 'https://i.pravatar.cc/160?img=32'],
            ['id' => 4, 'name' => 'Diego Ramos', 'email' => 'diego@sampa.dev', 'whatsapp' => '+55 11 99999-1004', 'status' => 'Ativo', 'role' => 'Consultor comercial', 'photo' => 'https://i.pravatar.cc/160?img=68'],
            ['id' => 5, 'name' => 'Fernanda Costa', 'email' => 'fernanda@sampa.dev', 'whatsapp' => '+55 11 99999-1005', 'status' => 'Pendente', 'role' => 'Atendimento', 'photo' => 'https://i.pravatar.cc/160?img=45'],
            ['id' => 6, 'name' => 'Gabriel Rocha', 'email' => 'gabriel@sampa.dev', 'whatsapp' => '+55 11 99999-1006', 'status' => 'Ativo', 'role' => 'Gerente de contas', 'photo' => 'https://i.pravatar.cc/160?img=59'],
            ['id' => 7, 'name' => 'Helena Prado', 'email' => 'helena@sampa.dev', 'whatsapp' => '+55 11 99999-1007', 'status' => 'Inativo', 'role' => 'Consultora comercial', 'photo' => 'https://i.pravatar.cc/160?img=5'],
            ['id' => 8, 'name' => 'Igor Neves', 'email' => 'igor@sampa.dev', 'whatsapp' => '+55 11 99999-1008', 'status' => 'Ativo', 'role' => 'Pré-vendas', 'photo' => 'https://i.pravatar.cc/160?img=52'],
            ['id' => 9, 'name' => 'Juliana Alves', 'email' => 'juliana@sampa.dev', 'whatsapp' => '+55 11 99999-1009', 'status' => 'Pendente', 'role' => 'Consultora comercial', 'photo' => 'https://i.pravatar.cc/160?img=25'],
            ['id' => 10, 'name' => 'Lucas Barros', 'email' => 'lucas@sampa.dev', 'whatsapp' => '+55 11 99999-1010', 'status' => 'Ativo', 'role' => 'Consultor comercial', 'photo' => 'https://i.pravatar.cc/160?img=60'],
            ['id' => 11, 'name' => 'Marina Teixeira', 'email' => 'marina@sampa.dev', 'whatsapp' => '+55 11 99999-1011', 'status' => 'Ativo', 'role' => 'Atendimento', 'photo' => 'https://i.pravatar.cc/160?img=41'],
            ['id' => 12, 'name' => 'Rafael Mendes', 'email' => 'rafael@sampa.dev', 'whatsapp' => '+55 11 99999-1012', 'status' => 'Inativo', 'role' => 'Consultor comercial', 'photo' => 'https://i.pravatar.cc/160?img=61'],
        ];
    }

    public function updatedSearch(): void
    {
        $this->page = 1;
    }

    public function updatedStatus(): void
    {
        $this->page = 1;
    }

    public function updatedPerPage(): void
    {
        $this->page = 1;
    }

    public function sortBy(string $key): void
    {
        if (! in_array($key, ['name', 'email', 'whatsapp', 'status'], true)) {
            return;
        }

        if ($this->sortBy === $key) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $key;
            $this->sortDirection = 'asc';
        }

        $this->page = 1;
    }

    public function gotoPage(int $page): void
    {
        $this->page = max(1, min($page, $this->lastPage()));
    }

    public function resetFilters(): void
    {
        $this->reset('search', 'status');
        $this->page = 1;
    }

    public function openCreateModal(): void
    {
        $this->resetValidation();
        $this->editingId = null;
        $this->formName = '';
        $this->formEmail = '';
        $this->formWhatsapp = '';
        $this->formStatus = 'Ativo';
        $this->showUserModal = true;
    }

    public function editUser(int $id): void
    {
        $user = $this->findUser($id);

        if (! $user) {
            return;
        }

        $this->resetValidation();
        $this->editingId = $id;
        $this->formName = $user['name'];
        $this->formEmail = $user['email'];
        $this->formWhatsapp = $user['whatsapp'];
        $this->formStatus = $user['status'];
        $this->showUserModal = true;
    }

    public function saveUser(): void
    {
        $validated = $this->validate([
            'formName' => ['required', 'string', 'min:3', 'max:80'],
            'formEmail' => ['required', 'email', 'max:120'],
            'formWhatsapp' => ['required', 'string', 'min:10', 'max:24'],
            'formStatus' => ['required', Rule::in(['Ativo', 'Pendente', 'Inativo'])],
        ]);

        if ($this->editingId) {
            $this->users = collect($this->users)
                ->map(fn (array $user): array => $user['id'] === $this->editingId
                    ? array_merge($user, [
                        'name' => $validated['formName'],
                        'email' => $validated['formEmail'],
                        'whatsapp' => $validated['formWhatsapp'],
                        'status' => $validated['formStatus'],
                    ])
                    : $user)
                ->values()
                ->all();

            $this->flashMessage = 'Usuário atualizado.';
        } else {
            $this->users[] = [
                'id' => $this->nextUserId(),
                'name' => $validated['formName'],
                'email' => $validated['formEmail'],
                'whatsapp' => $validated['formWhatsapp'],
                'status' => $validated['formStatus'],
                'role' => 'Consultor comercial',
                'photo' => 'https://i.pravatar.cc/160?img=65',
            ];

            $this->flashMessage = 'Usuário cadastrado.';
        }

        $this->showUserModal = false;
        $this->page = 1;
    }

    public function previewUser(int $id): void
    {
        $this->previewId = $id;
        $this->showPreviewModal = true;
    }

    public function toggleStatus(int $id): void
    {
        $this->users = collect($this->users)
            ->map(fn (array $user): array => $user['id'] === $id
                ? array_merge($user, ['status' => $user['status'] === 'Ativo' ? 'Inativo' : 'Ativo'])
                : $user)
            ->values()
            ->all();

        $this->flashMessage = 'Status atualizado.';
    }

    public function deleteUser(int $id): void
    {
        $this->users = collect($this->users)
            ->reject(fn (array $user): bool => $user['id'] === $id)
            ->values()
            ->all();

        $this->page = min($this->page, $this->lastPage());
        $this->flashMessage = 'Usuário removido.';
    }

    public function render(): View
    {
        $filteredUsers = $this->filteredUsers();

        return view('livewire.examples.users-index', [
            'rows' => $filteredUsers
                ->forPage($this->page, $this->perPage)
                ->values()
                ->all(),
            'total' => $filteredUsers->count(),
            'lastPage' => $this->lastPage($filteredUsers),
            'activeCount' => collect($this->users)->where('status', 'Ativo')->count(),
            'pendingCount' => collect($this->users)->where('status', 'Pendente')->count(),
            'inactiveCount' => collect($this->users)->where('status', 'Inativo')->count(),
            'previewUser' => $this->previewId ? $this->findUser($this->previewId) : null,
        ]);
    }

    private function filteredUsers(): Collection
    {
        $term = str($this->search)->ascii()->lower()->toString();

        return collect($this->users)
            ->when($this->status !== '', fn (Collection $users): Collection => $users->where('status', $this->status))
            ->when($term !== '', fn (Collection $users): Collection => $users->filter(function (array $user) use ($term): bool {
                $content = str(implode(' ', [$user['name'], $user['email'], $user['whatsapp'], $user['role']]))->ascii()->lower()->toString();

                return str_contains($content, $term);
            }))
            ->sortBy(fn (array $user): mixed => $user[$this->sortBy] ?? null, SORT_NATURAL | SORT_FLAG_CASE, $this->sortDirection === 'desc')
            ->values();
    }

    private function lastPage(?Collection $users = null): int
    {
        $total = ($users ?? $this->filteredUsers())->count();

        return max(1, (int) ceil($total / $this->perPage));
    }

    /**
     * @return array<string, mixed>|null
     */
    private function findUser(int $id): ?array
    {
        return collect($this->users)->firstWhere('id', $id);
    }

    private function nextUserId(): int
    {
        return ((int) collect($this->users)->max('id')) + 1;
    }
}
