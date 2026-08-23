@extends('docs.layout', ['title' => $title ?? 'Listagem avançada · Documentação SampaUI'])

@php
    $snippet = <<<'BLADE'
<x-sampaui::card title="Clientes" description="Base comercial unificada com filtros, busca e paginação" padding="lg">
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
        pagination-type="numbers"
        row-key="id"
        :rows="$rows"
        compact
    >
        {{-- Slot de Filtros Customizados --}}
        <x-slot:filters>
            <x-sampaui::select
                name="table_status"
                :options="[
                    ['label' => 'Todos os status', 'value' => ''],
                    ['label' => 'Ativo', 'value' => 'active'],
                    ['label' => 'Pendente', 'value' => 'pending'],
                ]"
            />
        </x-slot:filters>

        {{-- Ações Principais do Cabeçalho --}}
        <x-slot:actions>
            <x-sampaui::button icon="plus" size="sm" variant="primary">Novo Cliente</x-sampaui::button>
        </x-slot:actions>

        {{-- Ações em Lote para Linhas Selecionadas --}}
        <x-slot:selectionActions>
            <x-sampaui::button size="sm" variant="danger" icon="trash">Excluir selecionados</x-sampaui::button>
        </x-slot:selectionActions>

        {{-- Cabeçalho da Tabela --}}
        <x-slot:head>
            <thead class="bg-light/70 text-left text-xs font-semibold uppercase tracking-[0.18em] text-secondary">
                <tr>
                    <th class="px-6 py-3">
                        <x-sampaui::checkbox
                            value="all"
                            x-bind:checked="allVisibleSelected()"
                            x-on:change="toggleAll($event.target.checked)"
                            aria-label="Selecionar todos"
                        />
                    </th>
                    <th class="px-6 py-3">Cliente</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Receita</th>
                    <th class="px-6 py-3 text-right">Ações</th>
                </tr>
            </thead>
        </x-slot:head>

        {{-- Corpo da Tabela com Linhas Reativas --}}
        <x-slot:body>
            <tbody class="divide-y divide-border">
                @foreach ($rows as $row)
                    <tr
                        class="transition hover:bg-light/60"
                        x-bind:class="isSelected('{{ $row['id'] }}') ? '!bg-primary/5' : ''"
                    >
                        <td class="px-6 py-4">
                            <x-sampaui::checkbox
                                :value="$row['id']"
                                x-bind:checked="isSelected($el.value)"
                                x-on:change="toggleRow($el.value, $event.target.checked)"
                                aria-label="Selecionar {{ $row['name'] }}"
                            />
                        </td>
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
                            <div class="flex items-center justify-end gap-1.5">
                                <x-sampaui::button size="sm" variant="outline" icon="pencil" rounded aria-label="Editar" />
                                <x-sampaui::button size="sm" variant="outline" icon="trash" class="text-danger hover:border-danger hover:bg-danger/10" rounded aria-label="Excluir" />
                                <x-sampaui::dropdown label="" icon="three-dots-vertical" align="right">
                                    <x-sampaui::dropdown-item icon="eye">Visualizar</x-sampaui::dropdown-item>
                                    <x-sampaui::dropdown-item icon="archive">Arquivar</x-sampaui::dropdown-item>
                                </x-sampaui::dropdown>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </x-slot:body>
    </x-sampaui::table>
</x-sampaui::card>
BLADE;

    $rows = [
        ['id' => 1, 'name' => 'Ana Martins', 'email' => 'ana@sampa.dev', 'status' => 'Ativo', 'variant' => 'success', 'value' => 'R$ 12.400'],
        ['id' => 2, 'name' => 'Bruno Lima', 'email' => 'bruno@sampa.dev', 'status' => 'Pendente', 'variant' => 'accent', 'value' => 'R$ 8.900'],
        ['id' => 3, 'name' => 'Carla Souza', 'email' => 'carla@sampa.dev', 'status' => 'Bloqueado', 'variant' => 'danger', 'value' => 'R$ 3.200'],
    ];
@endphp

@section('content')
    <section class="doc-component-intro-grid">
        <article class="doc-hero-card">
            <div class="relative z-[1]">
                <p class="doc-kicker">Exemplo</p>
                <h1 class="mt-3 text-3xl font-semibold tracking-tight text-primary md:text-4xl">Listagem avançada</h1>
                <p class="mt-4 max-w-3xl text-sm leading-6 text-secondary">
                    DataTable premium completa com busca integrada, filtros por slot, seleção múltipla com ações em lote, ordenação, paginação numérica, exportação CSV e layout responsivo.
                </p>
            </div>
        </article>
    </section>

    <section class="space-y-7">
        <x-sampaui::card title="Clientes" description="Exemplo de DataTable rica com o componente único e unificado x-sampaui::table" padding="lg" class="shadow-default">
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
                pagination-type="numbers"
                row-key="id"
                :rows="$rows"
                class="min-w-[58rem]"
                compact
            >
                <x-slot:filters>
                    <x-sampaui::select name="table_status" :options="[
                        ['label' => 'Todos os status', 'value' => ''],
                        ['label' => 'Ativo', 'value' => 'active'],
                        ['label' => 'Pendente', 'value' => 'pending'],
                    ]" />

                    <x-sampaui::input
                        type="search"
                        name="table_search"
                        icon="search"
                        placeholder="Buscar cliente, email ou valor"
                    />
                </x-slot:filters>

                <x-slot:actions>
                    <x-sampaui::button icon="plus" size="sm" variant="primary">Novo Cliente</x-sampaui::button>
                </x-slot:actions>

                <x-slot:selectionActions>
                    <x-sampaui::button size="sm" variant="danger" icon="trash">Excluir selecionados</x-sampaui::button>
                </x-slot:selectionActions>

                <x-slot:head>
                    <thead class="bg-light/70 text-left text-xs font-semibold uppercase tracking-[0.18em] text-secondary">
                        <tr>
                            <th class="px-6 py-3">
                                <x-sampaui::checkbox
                                    value="all"
                                    x-bind:checked="allVisibleSelected()"
                                    x-on:change="toggleAll($event.target.checked)"
                                    aria-label="Selecionar todos"
                                />
                            </th>
                            <th class="px-6 py-3">Cliente</th>
                            <th class="px-6 py-3">Email</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Receita</th>
                            <th class="px-6 py-3 text-right">Ações</th>
                        </tr>
                    </thead>
                </x-slot:head>

                <x-slot:body>
                    <tbody class="divide-y divide-border">
                        @foreach ($rows as $row)
                            <tr
                                class="transition hover:bg-light/60"
                                x-bind:class="isSelected('{{ $row['id'] }}') ? '!bg-primary/5' : ''"
                            >
                                <td class="px-6 py-4">
                                    <x-sampaui::checkbox
                                        :value="$row['id']"
                                        x-bind:checked="isSelected($el.value)"
                                        x-on:change="toggleRow($el.value, $event.target.checked)"
                                        aria-label="Selecionar {{ $row['name'] }}"
                                    />
                                </td>
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
                                    <div class="flex items-center justify-end gap-1.5">
                                        <x-sampaui::button size="sm" variant="outline" icon="pencil" rounded aria-label="Editar" />
                                        <x-sampaui::button size="sm" variant="outline" icon="trash" class="text-danger hover:border-danger hover:bg-danger/10" rounded aria-label="Excluir" />
                                        <x-sampaui::dropdown label="" icon="three-dots-vertical" align="right" placement="{{ $loop->last ? 'top' : 'bottom' }}">
                                            <x-sampaui::dropdown-item icon="eye">Visualizar</x-sampaui::dropdown-item>
                                            <x-sampaui::dropdown-item icon="archive">Arquivar</x-sampaui::dropdown-item>
                                        </x-sampaui::dropdown>
                                    </div>
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

        @include('pages.examples.partials.code', [
            'snippet' => $snippet,
            'codeTitle' => 'Código da Listagem Avançada',
            'description' => 'DataTable completa com busca rápida, filtros em slot, seleção múltipla de linhas, ações em lote e paginação.',
            'components' => ['card', 'table', 'checkbox', 'avatar', 'badge', 'button', 'dropdown', 'skeleton', 'empty-state'],
        ])
    </section>
@endsection
