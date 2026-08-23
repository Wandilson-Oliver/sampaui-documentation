@extends('docs.layout', ['title' => $title ?? 'Dashboard operacional · Documentação SampaUI'])

@php
    $snippet = <<<'BLADE'
<div class="flex min-h-screen bg-light">
    {{-- Sidebar de navegação lateral fixa ou expansível --}}
    <x-sampaui::sidebar
        logo-src="/images/logo_sampaui.png"
        logo-alt="SampaUI"
        :items="[
            ['label' => 'Dashboard', 'href' => '#', 'icon' => 'speedometer2', 'active' => true],
            ['label' => 'Clientes', 'href' => '#', 'icon' => 'people'],
            ['label' => 'Projetos', 'href' => '#', 'icon' => 'briefcase'],
            ['label' => 'Relatórios', 'href' => '#', 'icon' => 'bar-chart'],
        ]"
        :user="['name' => 'Sampa Admin', 'email' => 'admin@sampa.dev']"
        logout-href="#"
    />

    <main class="min-w-0 flex-1 bg-light/60">
        {{-- Cabeçalho com busca, notificações e ações --}}
        <x-sampaui::header
            title="Painel comercial"
            subtitle="Resumo operacional de hoje"
            search
            search-placeholder="Buscar cliente ou conta"
            notifications
            notification-count="3"
        >
            <x-slot:actions>
                <x-sampaui::button icon="plus" class="whitespace-nowrap">Novo cliente</x-sampaui::button>
            </x-slot:actions>
        </x-sampaui::header>

        <div class="space-y-6 p-6">
            {{-- Cards de métricas rápidas --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <x-sampaui::card title="Leads novos" padding="md">
                    <p class="text-3xl font-semibold text-primary">128</p>
                    <p class="mt-1 text-sm text-secondary">+18% na semana</p>
                </x-sampaui::card>

                <x-sampaui::card title="Conversão" padding="md">
                    <p class="text-3xl font-semibold text-success">34%</p>
                    <p class="mt-1 text-sm text-secondary">Meta mensal 40%</p>
                </x-sampaui::card>

                <x-sampaui::card title="Receita prevista" padding="md">
                    <p class="text-3xl font-semibold text-accent">R$ 2,4 mi</p>
                    <p class="mt-1 text-sm text-secondary">Pipeline aberto</p>
                </x-sampaui::card>

                <x-sampaui::card title="Pendências" padding="md">
                    <p class="text-3xl font-semibold text-danger">17</p>
                    <p class="mt-1 text-sm text-secondary">Exigem retorno</p>
                </x-sampaui::card>
            </div>

            {{-- Grid principal com Pipeline e Metas --}}
            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_22rem]">
                <x-sampaui::card title="Pipeline" description="Oportunidades prioritárias" padding="lg">
                    <x-sampaui::table compact>
                        <x-slot:head>
                            <thead class="bg-light/70 text-left text-xs font-semibold uppercase tracking-[0.18em] text-secondary">
                                <tr>
                                    <th class="px-6 py-3">Lead</th>
                                    <th class="px-6 py-3">Etapa</th>
                                    <th class="px-6 py-3">Valor</th>
                                    <th class="px-6 py-3">Status</th>
                                </tr>
                            </thead>
                        </x-slot:head>
                        <x-slot:body>
                            <tbody class="divide-y divide-border">
                                <tr>
                                    <td class="px-6 py-4 font-semibold text-primary">Ana Costa</td>
                                    <td class="px-6 py-4 text-secondary">Demonstração marcada</td>
                                    <td class="px-6 py-4 text-secondary">R$ 82.000</td>
                                    <td class="px-6 py-4"><x-sampaui::badge variant="success">Quente</x-sampaui::badge></td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 font-semibold text-primary">Bruno Lima</td>
                                    <td class="px-6 py-4 text-secondary">Análise técnica</td>
                                    <td class="px-6 py-4 text-secondary">R$ 54.000</td>
                                    <td class="px-6 py-4"><x-sampaui::badge variant="accent">Morno</x-sampaui::badge></td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 font-semibold text-primary">Carla Souza</td>
                                    <td class="px-6 py-4 text-secondary">Proposta enviada</td>
                                    <td class="px-6 py-4 text-secondary">R$ 112.000</td>
                                    <td class="px-6 py-4"><x-sampaui::badge variant="success">Quente</x-sampaui::badge></td>
                                </tr>
                            </tbody>
                        </x-slot:body>
                    </x-sampaui::table>
                </x-sampaui::card>

                <x-sampaui::card title="Meta mensal" description="Fechamento projetado" padding="lg">
                    <x-sampaui::progress label="Receita" :value="68" show-value variant="success" />
                    <div class="mt-6 space-y-4">
                        <div class="flex items-center gap-3 rounded-default border border-border p-3">
                            <x-sampaui::indicator variant="accent" />
                            <span class="text-sm text-secondary">Revisar propostas pendentes</span>
                        </div>
                        <div class="flex items-center gap-3 rounded-default border border-border p-3">
                            <x-sampaui::indicator variant="accent" />
                            <span class="text-sm text-secondary">Confirmar demonstrações de amanhã</span>
                        </div>
                        <div class="flex items-center gap-3 rounded-default border border-border p-3">
                            <x-sampaui::indicator variant="accent" />
                            <span class="text-sm text-secondary">Atualizar prioridades do funil</span>
                        </div>
                    </div>
                </x-sampaui::card>
            </div>
        </div>
    </main>
</div>
BLADE;

    $menu = [
        ['label' => 'Dashboard', 'href' => '#', 'icon' => 'speedometer2', 'active' => true],
        ['label' => 'Clientes', 'href' => '#', 'icon' => 'people'],
        ['label' => 'Projetos', 'href' => '#', 'icon' => 'briefcase'],
        ['label' => 'Relatorios', 'href' => '#', 'icon' => 'bar-chart'],
    ];
    $rows = [
        ['lead' => 'Ana Costa', 'stage' => 'Demonstração marcada', 'value' => 'R$ 82.000', 'status' => 'Quente'],
        ['lead' => 'Bruno Lima', 'stage' => 'Análise técnica', 'value' => 'R$ 54.000', 'status' => 'Morno'],
        ['lead' => 'Carla Souza', 'stage' => 'Proposta enviada', 'value' => 'R$ 112.000', 'status' => 'Quente'],
    ];
@endphp

@section('content')
    <section class="doc-component-intro-grid">
        <article class="doc-hero-card">
            <div class="relative z-[1] flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="doc-kicker">Exemplo</p>
                    <h1 class="mt-3 text-3xl font-semibold tracking-tight text-primary md:text-4xl">Dashboard operacional</h1>
                    <p class="mt-4 max-w-3xl text-sm leading-6 text-secondary">
                        Composição SaaS com navegação, busca, métricas, progresso e tabela de oportunidades usando componentes Sampa UI.
                    </p>
                </div>
                <x-sampaui::badge variant="primary" icon="speedometer2">Dashboard</x-sampaui::badge>
            </div>
        </article>
    </section>

    <section class="space-y-7">
        <div class="overflow-x-auto rounded-[1.35rem] border border-border bg-light/60 p-4 shadow-default">
            <div class="grid min-h-[42rem] min-w-[82rem] overflow-hidden rounded-[1.15rem] border border-border bg-white shadow-sm" style="grid-template-columns: 18rem minmax(0, 1fr);">
                <x-sampaui::sidebar
                    position="static"
                    logo-src="{{ asset('images/logo_sampaui.png') }}"
                    logo-alt="Sampa UI"
                    :collapsible="false"
                    :items="$menu"
                    :user="['name' => 'Sampa Admin', 'email' => 'admin@sampa.dev']"
                    logout-href="#"
                />

                <main class="min-w-0 bg-light/60">
                    <x-sampaui::header
                        title="Painel comercial"
                        subtitle="Resumo operacional de hoje"
                        search
                        search-placeholder="Buscar cliente ou conta"
                        notifications
                        notification-count="3"
                        class="rounded-none border-x-0 border-t-0"
                    >
                        <x-slot:actions>
                            <x-sampaui::button icon="plus" class="whitespace-nowrap">Novo cliente</x-sampaui::button>
                        </x-slot:actions>
                    </x-sampaui::header>

                    <div class="space-y-5 p-6">
                        <div class="grid grid-cols-4 gap-4">
                            @foreach ([
                                ['title' => 'Leads novos', 'value' => '128', 'copy' => '+18% na semana', 'variant' => 'primary'],
                                ['title' => 'Conversão', 'value' => '34%', 'copy' => 'Meta mensal 40%', 'variant' => 'success'],
                                ['title' => 'Receita prevista', 'value' => 'R$ 2,4 mi', 'copy' => 'Pipeline aberto', 'variant' => 'accent'],
                                ['title' => 'Pendências', 'value' => '17', 'copy' => 'Exigem retorno', 'variant' => 'danger'],
                            ] as $metric)
                                <x-sampaui::card title="{{ $metric['title'] }}" padding="md">
                                    <p class="text-3xl font-semibold text-{{ $metric['variant'] }}">{{ $metric['value'] }}</p>
                                    <p class="mt-1 text-sm text-secondary">{{ $metric['copy'] }}</p>
                                </x-sampaui::card>
                            @endforeach
                        </div>

                        <div class="grid gap-5" style="grid-template-columns: minmax(0, 1fr) 22rem;">
                            <x-sampaui::card title="Pipeline" description="Oportunidades prioritárias" padding="lg">
                                <div class="-mx-6">
                                    <x-sampaui::table class="!rounded-none !border-x-0" compact>
                                        <x-slot:head>
                                            <thead class="bg-light/70 text-left text-xs font-semibold uppercase tracking-[0.18em] text-secondary">
                                                <tr>
                                                    <th class="px-6 py-3">Lead</th>
                                                    <th class="px-6 py-3">Etapa</th>
                                                    <th class="px-6 py-3">Valor</th>
                                                    <th class="px-6 py-3">Status</th>
                                                </tr>
                                            </thead>
                                        </x-slot:head>
                                        <x-slot:body>
                                            <tbody class="divide-y divide-border">
                                                @foreach ($rows as $row)
                                                    <tr>
                                                        <td class="px-6 py-4 font-semibold text-primary">{{ $row['lead'] }}</td>
                                                        <td class="px-6 py-4 text-secondary">{{ $row['stage'] }}</td>
                                                        <td class="px-6 py-4 text-secondary">{{ $row['value'] }}</td>
                                                        <td class="px-6 py-4">
                                                            <x-sampaui::badge :variant="$row['status'] === 'Quente' ? 'success' : 'accent'">{{ $row['status'] }}</x-sampaui::badge>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </x-slot:body>
                                    </x-sampaui::table>
                                </div>
                            </x-sampaui::card>

                            <x-sampaui::card title="Meta mensal" description="Fechamento projetado" padding="lg">
                                <x-sampaui::progress label="Receita" :value="68" show-value variant="success" />
                                <div class="mt-6 space-y-4">
                                    @foreach (['Revisar propostas pendentes', 'Confirmar demonstrações de amanhã', 'Atualizar prioridades do funil'] as $task)
                                        <div class="flex items-center gap-3 rounded-default border border-border p-3">
                                            <x-sampaui::indicator variant="accent" />
                                            <span class="text-sm text-secondary">{{ $task }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </x-sampaui::card>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        @include('pages.examples.partials.code', [
            'snippet' => $snippet,
            'codeTitle' => 'Código do Dashboard',
            'description' => 'Layout completo composto por Sidebar, Header, Cards de Métricas, Table e Progress.',
            'components' => ['sidebar', 'header', 'card', 'table', 'badge', 'progress', 'indicator', 'button', 'input'],
        ])
    </section>
@endsection
