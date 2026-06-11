@extends('docs.layout', ['title' => $title ?? 'Dashboard operacional · Documentação SampaUI'])

@php
    $snippet = <<<'BLADE'
<div class="flex min-h-screen bg-light">
    <x-sampaui::sidebar :items="$menu" :user="$user" brand="Sampa CRM" />

    <main class="min-w-0 flex-1">
        <x-sampaui::header title="Dashboard" subtitle="Resumo comercial em tempo real">
            <x-slot:actions>
                <x-sampaui::input name="search" icon="search" placeholder="Buscar lead" />
                <x-sampaui::button icon="plus">Novo lead</x-sampaui::button>
            </x-slot:actions>
        </x-sampaui::header>

        <section class="grid gap-5 lg:grid-cols-4">
            <x-sampaui::card title="Leads novos">...</x-sampaui::card>
            <x-sampaui::card title="Conversao">...</x-sampaui::card>
            <x-sampaui::card title="Receita">...</x-sampaui::card>
            <x-sampaui::card title="Pendencias">...</x-sampaui::card>
        </section>
    </main>
</div>
BLADE;

    $menu = [
        ['label' => 'Dashboard', 'href' => '#', 'icon' => 'speedometer2', 'active' => true],
        ['label' => 'Leads', 'href' => '#', 'icon' => 'people'],
        ['label' => 'Imoveis', 'href' => '#', 'icon' => 'buildings'],
        ['label' => 'Relatorios', 'href' => '#', 'icon' => 'bar-chart'],
    ];
    $rows = [
        ['lead' => 'Ana Costa', 'stage' => 'Visita marcada', 'value' => 'R$ 820.000', 'status' => 'Quente'],
        ['lead' => 'Bruno Lima', 'stage' => 'Analise de credito', 'value' => 'R$ 540.000', 'status' => 'Morno'],
        ['lead' => 'Carla Souza', 'stage' => 'Proposta enviada', 'value' => 'R$ 1.120.000', 'status' => 'Quente'],
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
        <div class="overflow-x-auto rounded-[1.35rem] border border-light bg-light/60 p-4 shadow-default">
            <div class="grid min-h-[42rem] min-w-[76rem] overflow-hidden rounded-[1.15rem] border border-light bg-white shadow-sm" style="grid-template-columns: 16rem minmax(0, 1fr);">
                <aside class="flex min-h-0 flex-col border-r border-light bg-white">
                    <div class="border-b border-light p-5">
                        <div class="flex items-center gap-3">
                            <span class="flex h-11 w-11 items-center justify-center rounded-default bg-light">
                                <x-sampaui::brand-mark />
                            </span>
                            <div class="min-w-0">
                                <p class="font-semibold text-primary">Sampa CRM</p>
                                <p class="truncate text-xs text-secondary">Operação comercial</p>
                            </div>
                        </div>
                    </div>

                    <nav class="min-h-0 flex-1 space-y-1 overflow-y-auto p-4">
                        @foreach ($menu as $item)
                            <a href="{{ $item['href'] }}" class="flex items-center gap-3 rounded-default px-3 py-2.5 text-sm font-medium transition {{ $item['active'] ?? false ? 'bg-primary text-white' : 'text-secondary hover:bg-light hover:text-primary' }}">
                                <i class="bi bi-{{ $item['icon'] }}" aria-hidden="true"></i>
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </nav>

                    <div class="border-t border-light p-4">
                        <div class="flex items-center gap-3 rounded-default bg-light p-3">
                            <x-sampaui::avatar name="Sampa Admin" status="online" />
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-primary">Sampa Admin</p>
                                <p class="truncate text-xs text-secondary">admin@sampa.dev</p>
                            </div>
                        </div>
                    </div>
                </aside>

                <main class="min-w-0 bg-light/60">
                    <div class="border-b border-light bg-white px-6 py-5">
                        <div class="flex items-center justify-between gap-5">
                            <div class="min-w-0">
                                <p class="doc-kicker">Hoje</p>
                                <h2 class="mt-1 text-2xl font-semibold text-primary">Painel comercial</h2>
                            </div>

                            <div class="flex shrink-0 items-center gap-3">
                                <x-sampaui::input name="dashboard_search" icon="search" placeholder="Buscar lead ou imóvel" class="w-72" />
                                <x-sampaui::button variant="outline" icon="bell" class="whitespace-nowrap">Alertas</x-sampaui::button>
                                <x-sampaui::button icon="plus" class="whitespace-nowrap">Novo lead</x-sampaui::button>
                            </div>
                        </div>
                    </div>

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
                                            <tbody class="divide-y divide-light">
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
                                    @foreach (['Revisar propostas pendentes', 'Confirmar visitas de amanhã', 'Atualizar funil de crédito'] as $task)
                                        <div class="flex items-center gap-3 rounded-default border border-light p-3">
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

        @include('pages.examples.partials.code', ['snippet' => $snippet])
    </section>
@endsection
