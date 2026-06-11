@extends('docs.layout', ['title' => $title ?? 'Command palette · Documentação SampaUI'])

@php
    $snippet = <<<'BLADE'
<x-sampaui::button
    variant="outline"
    icon="command"
    x-on:click="window.dispatchEvent(new CustomEvent('open-dashboard-search'))"
>
    Buscar comando
</x-sampaui::button>

<x-sampaui::command-palette
    open-event="open-dashboard-search"
    placeholder="Buscar cliente, relatório ou ação..."
    :items="$commands"
/>
BLADE;

    $commands = [
        ['label' => 'Novo cliente', 'href' => '#', 'icon' => 'person-plus'],
        ['label' => 'Abrir relatório comercial', 'href' => '#', 'icon' => 'bar-chart'],
        ['label' => 'Criar proposta', 'href' => '#', 'icon' => 'file-earmark-plus'],
        ['label' => 'Configurações da conta', 'href' => '#', 'icon' => 'gear'],
    ];
@endphp

@section('content')
    <section class="doc-component-intro-grid">
        <article class="doc-hero-card">
            <div class="relative z-[1]">
                <p class="doc-kicker">Exemplo</p>
                <h1 class="mt-3 text-3xl font-semibold tracking-tight text-primary md:text-4xl">Command palette</h1>
                <p class="mt-4 max-w-3xl text-sm leading-6 text-secondary">
                    Busca global acionada por evento para navegar rapidamente entre clientes, relatórios e ações do sistema.
                </p>
            </div>
        </article>
    </section>

    <section class="space-y-7">
        <x-sampaui::card title="Central de comandos" description="Clique no botão para abrir a paleta" padding="lg" class="shadow-default">
            <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_18rem]">
                <div>
                    <p class="text-sm leading-6 text-secondary">
                        Use a command palette para operações frequentes em dashboards densos: abrir cadastros, trocar contexto, procurar clientes e acessar relatórios.
                    </p>
                    <div class="mt-5 flex flex-wrap gap-3">
                        <x-sampaui::badge variant="primary" icon="command">Evento Alpine</x-sampaui::badge>
                        <x-sampaui::badge variant="success" icon="search">Busca filtrada</x-sampaui::badge>
                        <x-sampaui::badge variant="accent" icon="keyboard">Atalho pronto</x-sampaui::badge>
                    </div>
                </div>
                <div class="flex items-center justify-start lg:justify-end">
                    <x-sampaui::button variant="outline" icon="command" x-on:click="window.dispatchEvent(new CustomEvent('open-dashboard-search'))">
                        Buscar comando
                    </x-sampaui::button>
                </div>
            </div>
        </x-sampaui::card>

        <x-sampaui::command-palette
            open-event="open-dashboard-search"
            placeholder="Buscar cliente, relatório ou ação..."
            :items="$commands"
            class="shadow-default"
        />

        @include('pages.examples.partials.code', ['snippet' => $snippet])
    </section>
@endsection
