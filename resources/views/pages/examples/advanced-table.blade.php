@extends('docs.layout', ['title' => $title ?? 'Tabela avançada · Documentação SampaUI'])

@php
    $snippet = <<<'BLADE'
<x-sampaui::table compact>
    <x-slot:head>...</x-slot:head>
    <x-slot:body>
        @forelse ($rows as $row)
            <tr>
                <td><x-sampaui::avatar :name="$row['name']" /></td>
                <td><x-sampaui::badge :variant="$row['variant']">{{ $row['status'] }}</x-sampaui::badge></td>
                <td><x-sampaui::dropdown align="right">...</x-sampaui::dropdown></td>
            </tr>
        @empty
            <tr><td colspan="5"><x-sampaui::empty-state title="Nada encontrado" /></td></tr>
        @endforelse
    </x-slot:body>
</x-sampaui::table>
BLADE;

    $rows = [
        ['name' => 'Ana Martins', 'email' => 'ana@sampa.dev', 'status' => 'Ativo', 'variant' => 'success', 'value' => 'R$ 12.400'],
        ['name' => 'Bruno Lima', 'email' => 'bruno@sampa.dev', 'status' => 'Pendente', 'variant' => 'accent', 'value' => 'R$ 8.900'],
        ['name' => 'Carla Souza', 'email' => 'carla@sampa.dev', 'status' => 'Bloqueado', 'variant' => 'danger', 'value' => 'R$ 3.200'],
    ];
@endphp

@section('content')
    <section class="doc-component-intro-grid">
        <article class="doc-hero-card">
            <div class="relative z-[1]">
                <p class="doc-kicker">Exemplo</p>
                <h1 class="mt-3 text-3xl font-semibold tracking-tight text-primary md:text-4xl">Tabela avançada</h1>
                <p class="mt-4 max-w-3xl text-sm leading-6 text-secondary">
                    Listagem administrativa com filtros, avatar, badges, dropdown de ações, paginação e estados de loading/vazio.
                </p>
            </div>
        </article>
    </section>

    <section class="space-y-7">
        <x-sampaui::card title="Clientes" description="Exemplo de tabela rica para áreas internas" padding="lg" class="shadow-default">
            <x-slot:actions>
                <x-sampaui::button icon="download" variant="outline">Exportar</x-sampaui::button>
                <x-sampaui::button icon="plus">Novo</x-sampaui::button>
            </x-slot:actions>

            <div class="mb-6 grid gap-4 lg:grid-cols-[minmax(0,1fr)_13rem_12rem]">
                <x-sampaui::input name="table_search" icon="search" placeholder="Buscar cliente, email ou valor" />
                <x-sampaui::select name="table_status" :options="[
                    ['label' => 'Todos', 'value' => ''],
                    ['label' => 'Ativo', 'value' => 'active'],
                    ['label' => 'Pendente', 'value' => 'pending'],
                ]" />
                <x-sampaui::button variant="outline" icon="arrow-counterclockwise">Limpar</x-sampaui::button>
            </div>

            <div class="-mx-6 overflow-x-auto">
                <x-sampaui::table class="min-w-[58rem] !rounded-none !border-x-0" compact>
                    <x-slot:head>
                        <thead class="bg-light/70 text-left text-xs font-semibold uppercase tracking-[0.18em] text-secondary">
                            <tr>
                                <th class="px-6 py-3">Cliente</th>
                                <th class="px-6 py-3">Email</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Receita</th>
                                <th class="px-6 py-3 text-right">Ações</th>
                            </tr>
                        </thead>
                    </x-slot:head>
                    <x-slot:body>
                        <tbody class="divide-y divide-light">
                            @foreach ($rows as $row)
                                <tr class="transition hover:bg-light/60">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <x-sampaui::avatar name="{{ $row['name'] }}" />
                                            <span class="font-semibold text-primary">{{ $row['name'] }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-secondary">{{ $row['email'] }}</td>
                                    <td class="px-6 py-4"><x-sampaui::badge :variant="$row['variant']">{{ $row['status'] }}</x-sampaui::badge></td>
                                    <td class="px-6 py-4 font-semibold text-primary">{{ $row['value'] }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <x-sampaui::dropdown label="Ações" icon="three-dots" align="right" placement="{{ $loop->last ? 'top' : 'bottom' }}">
                                            <x-sampaui::dropdown-item icon="eye">Visualizar</x-sampaui::dropdown-item>
                                            <x-sampaui::dropdown-item icon="pencil">Editar</x-sampaui::dropdown-item>
                                            <x-sampaui::dropdown-item icon="trash3" class="text-danger">Excluir</x-sampaui::dropdown-item>
                                        </x-sampaui::dropdown>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </x-slot:body>
                </x-sampaui::table>
            </div>

            <x-slot:footer>
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <p class="text-sm text-secondary"><strong class="text-primary">42 registros</strong> encontrados</p>
                    <x-sampaui::pagination :current-page="2" :last-page="8" :total="42" :per-page="5" />
                </div>
            </x-slot:footer>
        </x-sampaui::card>

        <div class="grid gap-5 lg:grid-cols-2">
            <x-sampaui::card title="Estado carregando" padding="lg">
                <div class="space-y-4">
                    <x-sampaui::skeleton class="h-12 w-full" />
                    <x-sampaui::skeleton class="h-12 w-full" />
                    <x-sampaui::skeleton class="h-12 w-4/5" />
                </div>
            </x-sampaui::card>

            <x-sampaui::card title="Estado vazio" padding="lg">
                <x-sampaui::empty-state icon="search" title="Nenhum cliente encontrado" description="Ajuste os filtros ou cadastre um novo cliente.">
                    <x-sampaui::button variant="outline" icon="arrow-counterclockwise">Limpar filtros</x-sampaui::button>
                </x-sampaui::empty-state>
            </x-sampaui::card>
        </div>

        @include('pages.examples.partials.code', ['snippet' => $snippet])
    </section>
@endsection
