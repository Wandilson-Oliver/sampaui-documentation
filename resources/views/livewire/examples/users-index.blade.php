@php
    $statusOptions = [
        ['label' => 'Todos os status', 'value' => ''],
        ['label' => 'Ativo', 'value' => 'Ativo'],
        ['label' => 'Pendente', 'value' => 'Pendente'],
        ['label' => 'Inativo', 'value' => 'Inativo'],
    ];
    $perPageOptions = [
        ['label' => '5 por página', 'value' => 5],
        ['label' => '10 por página', 'value' => 10],
        ['label' => '15 por página', 'value' => 15],
    ];
    $sortIcon = fn (string $key): string => $sortBy === $key
        ? ($sortDirection === 'asc' ? 'sort-up' : 'sort-down')
        : 'arrow-down-up';
    $statusVariant = fn (string $status): string => match ($status) {
        'Ativo' => 'success',
        'Pendente' => 'accent',
        default => 'secondary',
    };
    $sortButtonClass = 'inline-flex items-center gap-2 font-semibold uppercase tracking-[0.18em] transition hover:text-primary';
@endphp

<section class="space-y-7">
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

    <x-sampaui::card title="Usuários" description="Dados simulados para demonstrar uma interface CRUD funcional" padding="lg" class="shadow-default">
        <x-slot:actions>
            <x-sampaui::button icon="plus" wire:click="openCreateModal">Cadastrar</x-sampaui::button>
        </x-slot:actions>

        @if ($flashMessage)
            <div class="mb-5">
                <x-sampaui::alert variant="success" icon="check-circle" wire:key="users-flash">
                    {{ $flashMessage }}
                </x-sampaui::alert>
            </div>
        @endif

        <div class="mb-6 grid gap-4 xl:grid-cols-[minmax(0,1fr)_14rem_12rem_auto]">
            <x-sampaui::input
                name="search"
                icon="search"
                placeholder="Buscar por nome, email, WhatsApp ou cargo"
                wire:model.live.debounce.300ms="search"
            />

            <x-sampaui::select
                name="status"
                :options="$statusOptions"
                wire:model.live="status"
            />

            <x-sampaui::select
                name="per_page"
                :options="$perPageOptions"
                wire:model.live="perPage"
            />

            <x-sampaui::button variant="outline" icon="arrow-counterclockwise" wire:click="resetFilters">
                Limpar
            </x-sampaui::button>
        </div>

        <div class="-mx-6 overflow-x-auto">
            <x-sampaui::table class="min-w-[58rem] !rounded-none !border-x-0" compact>
                <x-slot:head>
                    <thead class="bg-light/70 text-left text-xs font-semibold uppercase tracking-[0.18em] text-secondary">
                        <tr>
                            <th class="px-6 py-3">Foto</th>
                            <th class="px-6 py-3">
                                <button type="button" class="{{ $sortButtonClass }}" wire:click="sortBy('name')" @if ($sortBy === 'name') aria-sort="{{ $sortDirection === 'asc' ? 'ascending' : 'descending' }}" @endif>
                                    Nome
                                    <i class="bi bi-{{ $sortIcon('name') }}" aria-hidden="true"></i>
                                </button>
                            </th>
                            <th class="px-6 py-3">
                                <button type="button" class="{{ $sortButtonClass }}" wire:click="sortBy('email')" @if ($sortBy === 'email') aria-sort="{{ $sortDirection === 'asc' ? 'ascending' : 'descending' }}" @endif>
                                    Email
                                    <i class="bi bi-{{ $sortIcon('email') }}" aria-hidden="true"></i>
                                </button>
                            </th>
                            <th class="px-6 py-3">
                                <button type="button" class="{{ $sortButtonClass }}" wire:click="sortBy('whatsapp')" @if ($sortBy === 'whatsapp') aria-sort="{{ $sortDirection === 'asc' ? 'ascending' : 'descending' }}" @endif>
                                    WhatsApp
                                    <i class="bi bi-{{ $sortIcon('whatsapp') }}" aria-hidden="true"></i>
                                </button>
                            </th>
                            <th class="px-6 py-3">
                                <button type="button" class="{{ $sortButtonClass }}" wire:click="sortBy('status')" @if ($sortBy === 'status') aria-sort="{{ $sortDirection === 'asc' ? 'ascending' : 'descending' }}" @endif>
                                    Status
                                    <i class="bi bi-{{ $sortIcon('status') }}" aria-hidden="true"></i>
                                </button>
                            </th>
                            <th class="px-6 py-3 text-right">Ações</th>
                        </tr>
                    </thead>
                </x-slot:head>

                <x-slot:body>
                    <tbody class="divide-y divide-border">
                        @forelse ($rows as $user)
                            <tr wire:key="user-row-{{ $user['id'] }}" class="transition hover:bg-light/60">
                                <td class="px-6 py-4">
                                    <x-sampaui::avatar :src="$user['photo'] ?? null" name="{{ $user['name'] }}" />
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-primary">{{ $user['name'] }}</p>
                                    <p class="text-xs text-secondary">{{ $user['role'] }}</p>
                                </td>
                                <td class="px-6 py-4 text-secondary">{{ $user['email'] }}</td>
                                <td class="px-6 py-4 text-secondary">{{ $user['whatsapp'] }}</td>
                                <td class="px-6 py-4">
                                    <x-sampaui::badge :variant="$statusVariant($user['status'])">{{ $user['status'] }}</x-sampaui::badge>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-end gap-2.5">
                                        <x-sampaui::tooltip text="Visualizar">
                                            <x-sampaui::button size="sm" variant="light" icon="eye" wire:click="previewUser({{ $user['id'] }})" aria-label="Visualizar {{ $user['name'] }}" />
                                        </x-sampaui::tooltip>
                                        <x-sampaui::tooltip text="Editar">
                                            <x-sampaui::button size="sm" variant="outline" icon="pencil" wire:click="editUser({{ $user['id'] }})" aria-label="Editar {{ $user['name'] }}" />
                                        </x-sampaui::tooltip>
                                        <x-sampaui::tooltip text="Status">
                                            <x-sampaui::toggle
                                                name="status_{{ $user['id'] }}"
                                                :checked="$user['status'] === 'Ativo'"
                                                wire:click="toggleStatus({{ $user['id'] }})"
                                                aria-label="Alterar status de {{ $user['name'] }}"
                                            />
                                        </x-sampaui::tooltip>
                                        <x-sampaui::tooltip text="Excluir">
                                            <x-sampaui::button
                                                size="sm"
                                                variant="ghost"
                                                icon="trash3"
                                                class="text-danger hover:bg-danger/10 hover:text-danger"
                                                wire:click="deleteUser({{ $user['id'] }})"
                                                wire:confirm="Remover {{ $user['name'] }}?"
                                                aria-label="Excluir {{ $user['name'] }}"
                                            />
                                        </x-sampaui::tooltip>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10">
                                    <x-sampaui::empty-state
                                        icon="search"
                                        title="Nenhum usuário encontrado"
                                        description="Ajuste a busca ou limpe os filtros para voltar aos registros."
                                    >
                                        <x-sampaui::button variant="outline" wire:click="resetFilters">Limpar filtros</x-sampaui::button>
                                    </x-sampaui::empty-state>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </x-slot:body>
            </x-sampaui::table>
        </div>

        <x-slot:footer>
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <p class="text-sm text-secondary">
                    <strong class="text-primary">{{ $total }} usuários</strong>
                    · página {{ $page }} de {{ $lastPage }}
                </p>
                <x-sampaui::pagination
                    :current-page="$page"
                    :last-page="$lastPage"
                    :total="$total"
                    :per-page="$perPage"
                    wire-method="gotoPage"
                />
            </div>
        </x-slot:footer>
    </x-sampaui::card>

    @php($livewireUsage = chr(60).'livewire:examples.users-index />')
    <x-sampaui::card title="Trecho de uso" description="A página acima é um componente Livewire real" padding="lg">
        <x-docs.code-block :code="$livewireUsage" label="Livewire" />
    </x-sampaui::card>

    <x-sampaui::modal model="showUserModal" title="{{ $editingId ? 'Editar usuário' : 'Cadastrar usuário' }}" subtitle="Os dados ficam em memória para demonstrar o fluxo do componente." size="xl">
        <form id="user-form" wire:submit="saveUser" class="space-y-5">
            <div class="grid gap-4 md:grid-cols-2">
                <x-sampaui::input name="formName" label="Nome" icon="person" wire:model.live="formName" error="{{ $errors->first('formName') }}" />
                <x-sampaui::input name="formEmail" type="email" label="Email" icon="envelope" wire:model.live="formEmail" error="{{ $errors->first('formEmail') }}" />
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <x-sampaui::phone name="formWhatsapp" label="WhatsApp" icon="whatsapp" wire:model.live="formWhatsapp" error="{{ $errors->first('formWhatsapp') }}" />
                <x-sampaui::select name="formStatus" label="Status" :options="array_slice($statusOptions, 1)" wire:model.live="formStatus" error="{{ $errors->first('formStatus') }}" />
            </div>
        </form>

        <x-slot:actions>
            <x-sampaui::button variant="outline" wire:click="$set('showUserModal', false)">Cancelar</x-sampaui::button>
            <x-sampaui::button type="submit" form="user-form" icon="check2" wire:loading.attr="disabled" wire:target="saveUser">
                Salvar
            </x-sampaui::button>
        </x-slot:actions>
    </x-sampaui::modal>

    <x-sampaui::modal model="showPreviewModal" title="Detalhes do usuário" size="md">
        @if ($previewUser)
            <div class="space-y-5">
                <div class="flex items-center gap-4">
                    <x-sampaui::avatar :src="$previewUser['photo'] ?? null" name="{{ $previewUser['name'] }}" size="lg" />
                    <div>
                        <h3 class="text-lg font-semibold text-primary">{{ $previewUser['name'] }}</h3>
                        <p class="text-sm text-secondary">{{ $previewUser['role'] }}</p>
                    </div>
                </div>

                <div class="grid gap-3 text-sm text-secondary">
                    <p><strong class="text-primary">Email:</strong> {{ $previewUser['email'] }}</p>
                    <p><strong class="text-primary">WhatsApp:</strong> {{ $previewUser['whatsapp'] }}</p>
                    <p><strong class="text-primary">Status:</strong> {{ $previewUser['status'] }}</p>
                </div>
            </div>
        @endif

        <x-slot:actions>
            <x-sampaui::button wire:click="$set('showPreviewModal', false)">Fechar</x-sampaui::button>
        </x-slot:actions>
    </x-sampaui::modal>
</section>
