@extends('docs.layout', ['title' => $title ?? 'Tabela avançada · Documentação SampaUI'])

@php
    $snippet = <<<'BLADE'
<x-sampaui::table
    title="Clientes"
    description="Base comercial"
    searchable
    selectable
    export-href="/exports/clientes.csv"
    per-page="10"
    :columns="$columns"
    :rows="$rows"
>
    <x-slot:filters>...</x-slot:filters>
    <x-slot:actions>...</x-slot:actions>
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
                    DataTable premium com busca, filtros, seleção múltipla, ações por linha, ações em massa, paginação, exportação CSV, loading/skeleton, estado vazio e layout responsivo.
                </p>
            </div>
        </article>
    </section>

    <section class="space-y-7">
        <x-sampaui::card title="Clientes" description="Exemplo de DataTable rica para áreas internas" padding="lg" class="shadow-default">
            <x-sampaui::table
                title="Base comercial"
                description="42 registros encontrados"
                searchable
                search-placeholder="Buscar cliente, email ou valor"
                selectable
                export-href="/exports/clientes.csv"
                export-label="Exportar CSV"
                per-page="5"
                page="2"
                total="42"
                class="min-w-[58rem]"
                compact
            >
                <x-slot:filters>
                    <x-sampaui::select name="table_status" :options="[
                        ['label' => 'Todos', 'value' => ''],
                        ['label' => 'Ativo', 'value' => 'active'],
                        ['label' => 'Pendente', 'value' => 'pending'],
                    ]" />
                </x-slot:filters>

                <x-slot:actions>
                    <x-sampaui::button icon="plus" size="sm">Novo</x-sampaui::button>
                </x-slot:actions>

                    <x-slot:head>
                        <thead class="bg-light/70 text-left text-xs font-semibold uppercase tracking-[0.18em] text-secondary">
                            <tr>
                                <th class="px-6 py-3"><input type="checkbox" class="rounded border-secondary/40 text-primary focus:ring-primary/20" aria-label="Selecionar todos"></th>
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
                                    <td class="px-6 py-4"><input type="checkbox" class="rounded border-secondary/40 text-primary focus:ring-primary/20" aria-label="Selecionar {{ $row['name'] }}"></td>
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
