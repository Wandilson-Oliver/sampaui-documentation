@extends('docs.layout', ['title' => $title ?? 'Exemplo de listagem de usuários · Documentação SampaUI'])

@php
    $users = [
        ['name' => 'Ana Martins', 'email' => 'ana@sampa.dev', 'whatsapp' => '+55 11 99999-1001', 'status' => 'Ativo', 'variant' => 'success', 'initials' => 'AM'],
        ['name' => 'Bruno Lima', 'email' => 'bruno@sampa.dev', 'whatsapp' => '+55 11 99999-1002', 'status' => 'Pendente', 'variant' => 'accent', 'initials' => 'BL'],
        ['name' => 'Carla Souza', 'email' => 'carla@sampa.dev', 'whatsapp' => '+55 11 99999-1003', 'status' => 'Inativo', 'variant' => 'secondary', 'initials' => 'CS'],
        ['name' => 'Diego Ramos', 'email' => 'diego@sampa.dev', 'whatsapp' => '+55 11 99999-1004', 'status' => 'Ativo', 'variant' => 'success', 'initials' => 'DR'],
        ['name' => 'Fernanda Costa', 'email' => 'fernanda@sampa.dev', 'whatsapp' => '+55 11 99999-1005', 'status' => 'Pendente', 'variant' => 'accent', 'initials' => 'FC'],
    ];
    $snippet = <<<'BLADE'
<x-sampaui::card title="Usuários">
    <x-slot:actions>
        <x-sampaui::button icon="plus">Novo usuário</x-sampaui::button>
    </x-slot:actions>

    <x-sampaui::input name="search" icon="search" placeholder="Buscar usuários" wire:model.live.debounce.300ms="search" />
    <x-sampaui::table>
        {{-- linhas com avatar, badge de status e botoes de acao --}}
    </x-sampaui::table>
</x-sampaui::card>
BLADE;
@endphp

@section('content')
    <section class="doc-component-intro-grid">
        <article class="doc-hero-card">
            <div class="relative z-[1] flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="doc-kicker">Exemplo</p>
                    <h1 class="mt-3 text-3xl font-semibold tracking-tight text-primary md:text-4xl">Listagem de usuários</h1>
                    <p class="mt-4 max-w-3xl text-sm leading-6 text-secondary">
                        Interface CRUD responsiva com busca, filtro de status, tabela SampaUI, badges, ações e paginação.
                    </p>
                </div>
                <x-sampaui::button icon="plus">Novo usuário</x-sampaui::button>
            </div>
        </article>
    </section>

    <section class="space-y-7">
        <x-sampaui::card title="Usuários" description="Dados simulados para demonstrar uma interface CRUD de dashboard" padding="lg" class="shadow-default">
            <div class="mb-6 grid gap-4 lg:grid-cols-[minmax(0,1fr)_15rem]">
                <x-sampaui::input name="search" icon="search" placeholder="Buscar por nome, email ou WhatsApp" wire:model.live.debounce.300ms="search" />

                <x-sampaui::select name="status" wire:model.live="status">
                    <option value="">Todos os status</option>
                    <option value="active">Ativo</option>
                    <option value="inactive">Inativo</option>
                    <option value="pending">Pendente</option>
                </x-sampaui::select>
            </div>

            <div class="-mx-6 overflow-x-auto">
                <x-sampaui::table class="min-w-[52rem] !rounded-none !border-x-0" compact>
                    <x-slot:head>
                        <thead class="bg-light/70 text-left text-xs font-semibold uppercase tracking-[0.18em] text-secondary">
                            <tr>
                                <th class="px-6 py-3">Foto</th>
                                <th class="px-6 py-3">Nome</th>
                                <th class="px-6 py-3">Email</th>
                                <th class="px-6 py-3">WhatsApp</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3 text-right">Ações</th>
                            </tr>
                        </thead>
                    </x-slot:head>

                    <x-slot:body>
                        <tbody class="divide-y divide-light">
                            @foreach ($users as $user)
                                <tr class="transition hover:bg-light/60">
                                    <td class="px-6 py-4">
                                        <x-sampaui::avatar name="{{ $user['name'] }}" />
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-semibold text-primary">{{ $user['name'] }}</p>
                                        <p class="text-xs text-secondary">Consultor imobiliário</p>
                                    </td>
                                    <td class="px-6 py-4 text-secondary">{{ $user['email'] }}</td>
                                    <td class="px-6 py-4 text-secondary">{{ $user['whatsapp'] }}</td>
                                    <td class="px-6 py-4">
                                        <x-sampaui::badge :variant="$user['variant']">{{ $user['status'] }}</x-sampaui::badge>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-end gap-2.5">
                                            <x-sampaui::tooltip text="Visualizar">
                                                <x-sampaui::button size="sm" variant="light" icon="eye" aria-label="Visualizar {{ $user['name'] }}" />
                                            </x-sampaui::tooltip>
                                            <x-sampaui::tooltip text="Editar">
                                                <x-sampaui::button size="sm" variant="outline" icon="pencil" aria-label="Editar {{ $user['name'] }}" />
                                            </x-sampaui::tooltip>
                                            <x-sampaui::tooltip text="Status">
                                                <x-sampaui::button size="sm" variant="ghost" :icon="$user['status'] === 'Ativo' ? 'toggle-on' : 'toggle-off'" class="text-primary hover:bg-primary/10 hover:text-primary" aria-label="Alterar status de {{ $user['name'] }}" />
                                            </x-sampaui::tooltip>
                                            <x-sampaui::tooltip text="Excluir">
                                                <x-sampaui::button size="sm" variant="ghost" icon="trash3" class="text-danger hover:bg-danger/10 hover:text-danger" aria-label="Excluir {{ $user['name'] }}" />
                                            </x-sampaui::tooltip>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </x-slot:body>
                </x-sampaui::table>
            </div>

            <x-slot:footer>
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <p class="text-sm text-secondary"><strong class="text-primary">128 usuários</strong> · 10 por página</p>
                    <x-sampaui::pagination :current-page="2" :last-page="8" :total="128" :per-page="10" />
                </div>
            </x-slot:footer>
        </x-sampaui::card>

        <x-sampaui::card title="Trecho de uso" description="Busca, filtros, tabela e ações" padding="lg">
            <pre class="overflow-x-auto rounded-default bg-primary p-5 text-xs leading-6 text-white"><code>{{ trim($snippet) }}</code></pre>
        </x-sampaui::card>
    </section>
@endsection
