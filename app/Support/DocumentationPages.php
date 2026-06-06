<?php

namespace App\Support;

class DocumentationPages
{
    /**
     * @return array<string, array<string, mixed>>
     */
    public static function all(): array
    {
        $pages = [
            'dashboard-home' => [
                'slug' => 'dashboard-home',
                'name' => 'Dashboard inicial',
                'icon' => 'grid',
                'tag' => 'Dashboard',
                'summary' => 'Dashboard operacional para gestao do site imobiliario.',
                'description' => 'Visao de imoveis, categorias, conteudos e visitas usando componentes SampaUI e ApexCharts.',
                'preview' => <<<'BLADE'
@php
    $funnel = [
        ['label' => 'Visitas', 'value' => '18.4k', 'rate' => '100%', 'icon' => 'eye', 'variant' => 'primary', 'progress' => 100],
        ['label' => 'WhatsApp', 'value' => '1.248', 'rate' => '6.8%', 'icon' => 'whatsapp', 'variant' => 'accent', 'progress' => 68],
        ['label' => 'Favoritos', 'value' => '642', 'rate' => '3.5%', 'icon' => 'heart', 'variant' => 'info', 'progress' => 51],
        ['label' => 'Formularios', 'value' => '96', 'rate' => '0.5%', 'icon' => 'send', 'variant' => 'danger', 'progress' => 15],
    ];
    $quality = [
        ['label' => 'Fotos', 'value' => 62, 'variant' => 'accent'],
        ['label' => 'Descricao', 'value' => 58, 'variant' => 'danger'],
        ['label' => 'Preco', 'value' => 92, 'variant' => 'primary'],
        ['label' => 'Features', 'value' => 74, 'variant' => 'info'],
    ];
    $topProperties = [
        ['rank' => 1, 'name' => 'Casa Jardim Europa', 'visits' => '3.284', 'whatsapp' => 86, 'rate' => '2.6%', 'variant' => 'primary'],
        ['rank' => 2, 'name' => 'Apto Vila Mariana', 'visits' => '2.940', 'whatsapp' => 74, 'rate' => '2.5%', 'variant' => 'accent'],
        ['rank' => 3, 'name' => 'Studio Pinheiros', 'visits' => '2.612', 'whatsapp' => 58, 'rate' => '2.2%', 'variant' => 'info'],
        ['rank' => 4, 'name' => 'Cobertura Moema', 'visits' => '2.184', 'whatsapp' => 42, 'rate' => '1.9%', 'variant' => 'primary'],
        ['rank' => 5, 'name' => 'Loft Jardins', 'visits' => '1.980', 'whatsapp' => 39, 'rate' => '2.0%', 'variant' => 'accent'],
    ];
    $pendingItems = [
        ['label' => 'Sem foto', 'count' => '7 imoveis', 'priority' => 'Alta', 'variant' => 'danger'],
        ['label' => 'Preco desatualizado', 'count' => '5 imoveis', 'priority' => 'Alta', 'variant' => 'danger'],
        ['label' => 'Sem video', 'count' => '12 imoveis', 'priority' => 'Media', 'variant' => 'accent'],
        ['label' => 'Sem descricao', 'count' => '9 imoveis', 'priority' => 'Media', 'variant' => 'accent'],
        ['label' => 'Sem destaque', 'count' => '18 imoveis', 'priority' => 'Baixa', 'variant' => 'secondary'],
        ['label' => 'Revisao vencida', 'count' => '18 imoveis', 'priority' => 'Alta', 'variant' => 'danger'],
    ];
    $categories = [
        ['name' => 'Casas', 'progress' => 86],
        ['name' => 'Apartamentos', 'progress' => 74],
        ['name' => 'Studios', 'progress' => 52],
        ['name' => 'Comercial', 'progress' => 34],
    ];
    $activities = [
        ['title' => 'Imovel atualizado', 'copy' => 'Casa Jardim Europa recebeu novas fotos.', 'icon' => 'house-check'],
        ['title' => 'Depoimento aprovado', 'copy' => 'Relato de cliente entrou na home.', 'icon' => 'chat-quote'],
        ['title' => 'Categoria editada', 'copy' => 'Apartamentos ganhou nova descricao.', 'icon' => 'tags'],
        ['title' => 'Video publicado', 'copy' => 'Dica sobre financiamento entrou no blog.', 'icon' => 'play-btn'],
    ];
    $todayPriorities = [
        ['label' => 'Revisar imoveis vencidos', 'count' => '18', 'icon' => 'clock-history', 'variant' => 'danger'],
        ['label' => 'Completar midia', 'count' => '12', 'icon' => 'image', 'variant' => 'accent'],
        ['label' => 'Atualizar precos', 'count' => '5', 'icon' => 'tag', 'variant' => 'danger'],
        ['label' => 'Publicar vídeos pendentes', 'count' => '4', 'icon' => 'play-btn', 'variant' => 'info'],
    ];
    $modules = [
        ['name' => 'Imoveis', 'copy' => 'Cards, detalhes e destaques', 'icon' => 'houses', 'status' => 'Revisar', 'variant' => 'accent', 'updated_at' => 'Hoje', 'volume' => 248, 'progress' => 84],
        ['name' => 'Categorias', 'copy' => 'Tipos e navegacao do site', 'icon' => 'tags', 'status' => 'Publicado', 'variant' => 'success', 'updated_at' => 'Ontem', 'volume' => 18, 'progress' => 72],
        ['name' => 'Depoimentos', 'copy' => 'Provas sociais aprovadas', 'icon' => 'chat-quote', 'status' => 'Pendente', 'variant' => 'danger', 'updated_at' => '2 dias', 'volume' => 24, 'progress' => 42],
        ['name' => 'Dicas em Video', 'copy' => 'Conteudos para home e blog', 'icon' => 'play-btn', 'status' => 'Edicao', 'variant' => 'secondary', 'updated_at' => '4 dias', 'volume' => 18, 'progress' => 58],
    ];
    $segments = ['all' => 'Todos', 'content' => 'Conteudo', 'property' => 'Imoveis'];
    $page = 2;
    $lastPage = 8;
    $total = 308;
@endphp

<div
    class="min-h-screen bg-[#F4F6FA] text-primary"
    x-data="{ sidebarWidth: '18rem', isDesktop: window.matchMedia('(min-width: 1024px)').matches }"
    x-init="window.addEventListener('resize', () => isDesktop = window.matchMedia('(min-width: 1024px)').matches)"
    x-on:sampaui:sidebar-state.window="sidebarWidth = $event.detail.width"
>
    <x-sampaui::sidebar
        brand="Sampa"
        initial-state="open"
        :rail="false"
        class="!fixed !inset-y-0 !left-0 !z-40 !h-screen !border-r !border-light !bg-white"
        :user="['name' => 'Wandilson', 'email' => 'wandilson@sampa.dev']"
        :items="[
            ['label' => 'Imoveis', 'href' => '#', 'icon' => 'houses', 'active' => true],
            ['label' => 'Categorias', 'href' => '#', 'icon' => 'tags'],
            ['label' => 'Features', 'href' => '#', 'icon' => 'stars'],
            ['label' => 'Empreendimentos', 'href' => '#', 'icon' => 'buildings'],
            ['label' => 'Grupos', 'href' => '#', 'icon' => 'collection'],
            ['label' => 'Institucional', 'href' => '#', 'icon' => 'building'],
            ['label' => 'Depoimentos', 'href' => '#', 'icon' => 'chat-quote'],
            ['label' => 'Dicas em Video', 'href' => '#', 'icon' => 'play-btn'],
        ]"
    />

    <main class="min-h-screen min-w-0 overflow-hidden bg-[#F4F6FA] transition-[margin] duration-300 ease-out lg:ml-[18rem]" x-bind:style="isDesktop ? { marginLeft: sidebarWidth } : {}">
        <section class="relative overflow-hidden bg-primary pb-20 pt-7 text-white">
            <div class="pointer-events-none absolute -right-20 -top-28 h-72 w-72 rounded-full bg-white/10"></div>
            <div class="flex flex-col gap-5 px-8 lg:flex-row lg:items-start lg:justify-between lg:px-10">
                <div>
                    <div class="flex items-center gap-3">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-white/65">Gestao do site</p>
                    </div>
                    <h1 class="mt-2 text-3xl font-semibold tracking-tight md:text-4xl">Bom dia, Wandilson</h1>
                    <p class="mt-2 max-w-2xl text-sm text-white/70 md:text-base">Acompanhe imoveis, categorias, features, empreendimentos e conteudos institucionais.</p>
                </div>

                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2.5 text-sm font-medium text-white">
                        <i class="bi bi-calendar3 text-white/70" aria-hidden="true"></i>
                        {{ now()->format('d/m/Y') }}
                    </span>
                    <x-sampaui::button
                        type="button"
                        variant="outline"
                        icon="bell"
                        class="border-white/30 bg-white/10 text-white hover:bg-white/20"
                        aria-label="Notificacoes"
                    />
                </div>
            </div>
        </section>

        <section class="relative z-10 -mt-12 pb-8">
            <div class="space-y-5 px-8 lg:px-10">
                <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                    @foreach ([
                        ['label' => 'Imoveis', 'value' => '248', 'copy' => '36 em destaque', 'icon' => 'houses', 'tone' => 'bg-primary'],
                        ['label' => 'Categorias', 'value' => '18', 'copy' => '4 principais', 'icon' => 'tags', 'tone' => 'bg-accent'],
                        ['label' => 'Features', 'value' => '42', 'copy' => '12 mais usadas', 'icon' => 'stars', 'tone' => 'bg-purple'],
                        ['label' => 'Empreendimentos', 'value' => '12', 'copy' => '8 publicados', 'icon' => 'buildings', 'tone' => 'bg-danger'],
                    ] as $metric)
                        <x-sampaui::card padding="md" class="shadow-2xl shadow-primary/10">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm font-semibold text-secondary">{{ $metric['label'] }}</p>
                                    <p class="mt-4 text-3xl font-semibold tracking-tight text-primary">{{ $metric['value'] }}</p>
                                    <p class="mt-2 text-sm font-medium text-primary/80">{{ $metric['copy'] }}</p>
                                </div>
                                <span class="inline-flex h-12 w-12 shrink-0 items-center justify-center rounded-[1rem] {{ $metric['tone'] }} text-xl text-white">
                                    <i class="bi bi-{{ $metric['icon'] }}" aria-hidden="true"></i>
                                </span>
                            </div>
                        </x-sampaui::card>
                    @endforeach
                </div>

                <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_23rem]">
                    <div class="space-y-5">
                        <x-sampaui::card title="Visitas do site" description="ApexCharts: visitas por periodo e imovel mais acessado no mesmo grafico" padding="lg">
                            <x-slot:actions>
                                <x-sampaui::dropdown label="Ultimos 30 dias" icon="calendar3" align="right">
                                    <x-sampaui::dropdown-item icon="calendar-day">Hoje</x-sampaui::dropdown-item>
                                    <x-sampaui::dropdown-item icon="calendar-week">Ultimos 7 dias</x-sampaui::dropdown-item>
                                    <x-sampaui::dropdown-item icon="calendar3">Ultimos 30 dias</x-sampaui::dropdown-item>
                                    <x-sampaui::dropdown-item icon="calendar-range">Este mes</x-sampaui::dropdown-item>
                                </x-sampaui::dropdown>
                            </x-slot:actions>

                            <div class="mt-5 overflow-hidden rounded-[1.35rem] bg-gradient-to-br from-light to-white p-5 md:p-6" x-data="siteVisitsChart">
                                <div class="mb-5 grid gap-4 md:grid-cols-[minmax(0,1fr)_18rem] md:items-start">
                                    <div>
                                        <p class="text-sm font-semibold text-secondary">Visitas no site</p>
                                        <p class="mt-2 text-5xl font-semibold tracking-tight text-primary">18.4k</p>
                                        <div class="mt-3 inline-flex items-center gap-2 rounded-full bg-success/10 px-3 py-1 text-sm font-semibold text-success">
                                            <i class="bi bi-arrow-up-right" aria-hidden="true"></i>
                                            <span>+12% vs. periodo anterior</span>
                                        </div>
                                    </div>
                                    <div class="rounded-[1.15rem] border border-light bg-white/80 p-4 md:justify-self-end">
                                        <p class="text-sm font-semibold text-secondary">Imovel mais visitado</p>
                                        <p class="mt-2 text-lg font-semibold text-primary">Casa Jardim Europa</p>
                                        <p class="text-sm text-secondary">3.284 visitas no periodo</p>
                                    </div>
                                </div>
                                <div class="mb-3 flex flex-wrap items-center gap-5 text-sm font-semibold text-secondary">
                                    <span class="inline-flex items-center gap-2">
                                        <span class="h-3 w-3 rounded-full bg-primary"></span>
                                        Visitas totais
                                    </span>
                                    <span class="inline-flex items-center gap-2">
                                        <span class="h-3 w-3 rounded-full bg-accent"></span>
                                        Casa Jardim Europa
                                    </span>
                                </div>
                                <div x-ref="chart" class="h-[21rem] w-full overflow-hidden"></div>
                            </div>
                        </x-sampaui::card>

                        <x-sampaui::card title="Funil do site" description="Da visita ate as principais acoes do visitante" padding="lg">
                            <div class="grid gap-3 md:grid-cols-4">
                                @foreach ($funnel as $step)
                                    <div class="rounded-default border border-light bg-white p-4">
                                        <div class="flex items-start justify-between gap-3">
                                            <div>
                                                <p class="text-sm font-semibold text-secondary">{{ $step['label'] }}</p>
                                                <p class="mt-3 text-3xl font-semibold tracking-tight text-primary">{{ $step['value'] }}</p>
                                                <p class="mt-1 text-sm text-primary/80">{{ $step['rate'] }}</p>
                                            </div>
                                            <span @class(['inline-flex h-11 w-11 items-center justify-center rounded-full text-lg text-white', 'bg-primary' => $step['variant'] === 'primary', 'bg-accent' => $step['variant'] === 'accent', 'bg-info' => $step['variant'] === 'info', 'bg-danger' => $step['variant'] === 'danger'])>
                                                <i class="bi bi-{{ $step['icon'] }}" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-5 space-y-4">
                                @foreach ($funnel as $step)
                                    @if (! $loop->first)
                                        <x-sampaui::progress :value="$step['progress']" :label="$step['label']" :variant="$step['variant']" show-value />
                                    @endif
                                @endforeach
                            </div>
                        </x-sampaui::card>

                        <x-sampaui::card title="Qualidade do anuncio" description="Score do imovel que mais precisa de ajuste" padding="lg">
                            <div class="mb-5 rounded-default bg-light p-4">
                                <p class="font-semibold text-primary">Apto Vila Mariana</p>
                                <p class="mt-1 text-sm text-secondary">Completar midia e descricao antes de destacar na home.</p>
                                <x-sampaui::badge class="mt-3" variant="accent">Score 71%</x-sampaui::badge>
                            </div>
                            <div class="grid gap-4 md:grid-cols-2">
                                @foreach ($quality as $item)
                                    <x-sampaui::progress :value="$item['value']" :label="$item['label']" :variant="$item['variant']" show-value />
                                @endforeach
                            </div>
                        </x-sampaui::card>

                        <x-sampaui::card title="Prioridade de hoje" description="Ações que mais impactam a publicação e performance do site" padding="lg">
                            <div class="grid gap-3 md:grid-cols-2">
                                @foreach ($todayPriorities as $priority)
                                    <div class="flex items-center justify-between gap-3 rounded-default border border-light bg-white px-4 py-3 transition hover:bg-light">
                                        <div class="flex min-w-0 items-center gap-3">
                                            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-light text-primary">
                                                <i class="bi bi-{{ $priority['icon'] }}" aria-hidden="true"></i>
                                            </span>
                                            <p class="truncate font-semibold text-primary">{{ $priority['label'] }}</p>
                                        </div>
                                        <x-sampaui::badge :variant="$priority['variant']">{{ $priority['count'] }}</x-sampaui::badge>
                                    </div>
                                @endforeach
                            </div>
                        </x-sampaui::card>

                        <x-sampaui::card title="Módulos do site" description="Resumo dos conteúdos principais da home e páginas internas" padding="lg">
                            <x-slot:actions>
                                <x-sampaui::button variant="outline" icon="sliders" class="border-primary text-primary hover:bg-primary hover:text-white">Filtrar</x-sampaui::button>
                            </x-slot:actions>

                            <x-sampaui::table class="-mx-6 -mb-6 mt-4 !rounded-none !border-x-0 !border-b-0" compact>
                                <x-slot:head>
                                    <thead class="bg-light/50 text-xs font-semibold uppercase tracking-[0.18em] text-secondary">
                                        <tr>
                                            <th class="px-6 py-3">Módulo</th>
                                            <th class="px-6 py-3">Status</th>
                                            <th class="px-6 py-3">Atualizado</th>
                                            <th class="px-6 py-3">Volume</th>
                                            <th class="px-6 py-3">Qualidade</th>
                                            <th class="px-6 py-3 text-right">Ação</th>
                                        </tr>
                                    </thead>
                                </x-slot:head>

                                <x-slot:body>
                                    <tbody class="divide-y divide-light">
                                        @foreach ($modules as $module)
                                            <tr class="align-middle transition hover:bg-light">
                                                <td class="min-w-[15rem] px-6 py-3">
                                                    <div class="flex items-center gap-3">
                                                        <span class="inline-flex h-12 w-12 shrink-0 items-center justify-center rounded-default bg-light text-lg text-primary">
                                                            <i class="bi bi-{{ $module['icon'] }}" aria-hidden="true"></i>
                                                        </span>
                                                        <div>
                                                            <p class="font-semibold text-primary">{{ $module['name'] }}</p>
                                                            <p class="text-sm text-secondary">{{ $module['copy'] }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-3"><x-sampaui::badge :variant="$module['variant']">{{ $module['status'] }}</x-sampaui::badge></td>
                                                <td class="px-6 py-3 text-secondary">{{ $module['updated_at'] }}</td>
                                                <td class="px-6 py-3 font-semibold text-primary">{{ $module['volume'] }}</td>
                                                <td class="min-w-[10rem] px-6 py-3"><x-sampaui::progress :value="$module['progress']" show-value /></td>
                                                <td class="px-6 py-3 text-right">
                                                    <x-sampaui::button size="sm" variant="ghost" icon="arrow-right" aria-label="Abrir {{ $module['name'] }}" />
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </x-slot:body>
                            </x-sampaui::table>

                            <x-slot:footer>
                                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                                    <p class="text-sm text-secondary"><strong class="text-primary">308 registros</strong> · 80 registros por página</p>
                                    <x-sampaui::pagination :current-page="$page" :last-page="$lastPage" :total="$total" :per-page="10" />
                                </div>
                            </x-slot:footer>
                        </x-sampaui::card>
                    </div>

                    <aside class="space-y-5">
                        <x-sampaui::card title="Saúde da carteira" description="Qualidade geral dos anúncios" padding="md">
                            <div class="rounded-default bg-light p-4">
                                <x-sampaui::progress :value="84" label="Carteira revisada" show-value />
                            </div>
                            <div class="mt-4 grid gap-3 sm:grid-cols-2 xl:grid-cols-2">
                                <div class="rounded-default border border-light bg-white p-4">
                                    <p class="text-sm text-secondary">Vencidos</p>
                                    <p class="mt-1 text-2xl font-semibold text-danger">18</p>
                                    <p class="text-xs text-secondary">sem revisao</p>
                                </div>
                                <div class="rounded-default border border-light bg-white p-4">
                                    <p class="text-sm text-secondary">Midia incompleta</p>
                                    <p class="mt-1 text-2xl font-semibold text-accent">12</p>
                                    <p class="text-xs text-secondary">sem fotos/video</p>
                                </div>
                            </div>
                            <div class="mt-4 space-y-4">
                                <x-sampaui::progress :value="78" label="Midia completa" variant="primary" show-value />
                                <x-sampaui::progress :value="69" label="Dados comerciais" variant="accent" show-value />
                            </div>
                        </x-sampaui::card>

                        <x-sampaui::card title="Pendências da carteira" description="Itens que bloqueiam publicação completa" padding="md">
                            <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-2">
                                @foreach ([
                                    ['label' => 'Revisão vencida', 'count' => 18, 'variant' => 'danger'],
                                    ['label' => 'Sem vídeo', 'count' => 12, 'variant' => 'accent'],
                                    ['label' => 'Sem foto', 'count' => 7, 'variant' => 'danger'],
                                    ['label' => 'Preço desatualizado', 'count' => 5, 'variant' => 'secondary'],
                                ] as $summary)
                                    <div class="rounded-default border border-light bg-light p-3">
                                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-secondary">{{ $summary['label'] }}</p>
                                        <p class="mt-2 text-2xl font-semibold text-primary">{{ $summary['count'] }}</p>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-4 space-y-2">
                                @foreach ($pendingItems as $pending)
                                    <div class="flex items-center justify-between gap-3 rounded-default border border-light bg-white px-3 py-2.5">
                                        <div>
                                            <p class="text-sm font-semibold text-primary">{{ $pending['label'] }}</p>
                                            <p class="text-xs text-secondary">{{ $pending['count'] }}</p>
                                        </div>
                                        <x-sampaui::badge :variant="$pending['variant']">{{ $pending['priority'] }}</x-sampaui::badge>
                                    </div>
                                @endforeach
                            </div>

                            <x-sampaui::button class="mt-4 w-full" icon="check2-circle">Resolver pendências</x-sampaui::button>
                        </x-sampaui::card>

                        <x-sampaui::card title="Top imóveis" description="Mais acessados no período" padding="md">
                            <div class="space-y-3">
                                @foreach ($topProperties as $property)
                                    <div class="flex items-center justify-between gap-3 rounded-default bg-light px-4 py-3">
                                        <div class="min-w-0">
                                            <p class="truncate font-semibold text-primary"><span class="text-primary/70">#{{ $property['rank'] }}</span> {{ $property['name'] }}</p>
                                            <p class="text-sm text-secondary">{{ $property['visits'] }} visitas · {{ $property['whatsapp'] }} WhatsApp</p>
                                        </div>
                                        <x-sampaui::badge :variant="$property['variant']">{{ $property['rate'] }}</x-sampaui::badge>
                                    </div>
                                @endforeach
                            </div>
                        </x-sampaui::card>

                        <x-sampaui::card title="Performance por categoria" description="Visitas e interacoes por segmento" padding="md">
                            <div class="space-y-3">
                                @foreach ($categories as $category)
                                    <x-sampaui::progress :value="$category['progress']" :label="$category['name']" show-value />
                                @endforeach
                            </div>
                        </x-sampaui::card>

                        <x-sampaui::card title="Ultimas atividades" description="Movimentos recentes da equipe" padding="md">
                            <div class="space-y-3">
                                @foreach ($activities as $activity)
                                    <div class="flex gap-3">
                                        <span class="mt-1 inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-light text-sm text-primary">
                                            <i class="bi bi-{{ $activity['icon'] }}" aria-hidden="true"></i>
                                        </span>
                                        <div>
                                            <p class="text-sm font-semibold text-primary">{{ $activity['title'] }}</p>
                                            <p class="text-sm leading-5 text-secondary">{{ $activity['copy'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </x-sampaui::card>
                    </aside>
                </div>

            </div>
        </section>
    </main>
</div>
BLADE,
            ],
            'design-system' => [
                'slug' => 'design-system',
                'name' => 'Design system',
                'icon' => 'palette2',
                'tag' => 'Foundations',
                'summary' => 'Paleta personalizada, tokens semanticos e orientacao para manter o visual consistente.',
                'description' => 'Guia rapido para ajustar as cores personalizadas do SampaUI usando os tokens do pacote.',
                'preview' => <<<'BLADE'
<div class="space-y-6">
    <x-sampaui::card padding="lg">
        <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_22rem]">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-primary">Paleta de cores</p>
                <h2 class="mt-3 text-3xl font-semibold tracking-tight text-primary">Paleta personalizada do SampaUI</h2>
                <p class="mt-4 max-w-2xl text-sm leading-6 text-secondary">
                    O pacote usa tokens semanticos definidos em <code>config/sampaui.php</code> e no bloco <code>@theme</code> do CSS. Para trocar a identidade visual, altere os mesmos tokens nos dois lugares, recompile o pacote e publique os assets no app consumidor.
                </p>
            </div>

            <x-sampaui::alert title="Regra do tema" variant="success">
                Mantenha as cores centralizadas nos tokens do SampaUI para preservar consistencia entre componentes e documentacao.
            </x-sampaui::alert>
        </div>
    </x-sampaui::card>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        @foreach ([
            ['name' => 'Primary', 'className' => 'bg-primary', 'hex' => '#5574C9', 'class' => 'bg-primary'],
            ['name' => 'Secondary', 'className' => 'bg-secondary', 'hex' => '#2E314A', 'class' => 'bg-secondary'],
            ['name' => 'Success', 'className' => 'bg-success', 'hex' => '#79C8BC', 'class' => 'bg-success'],
            ['name' => 'Accent', 'className' => 'bg-accent', 'hex' => '#FDB82E', 'class' => 'bg-accent'],
            ['name' => 'Purple', 'className' => 'bg-purple', 'hex' => '#895FC4', 'class' => 'bg-purple'],
            ['name' => 'Danger', 'className' => 'bg-danger', 'hex' => '#E84586', 'class' => 'bg-danger'],
            ['name' => 'Warning', 'className' => 'bg-warning', 'hex' => '#FF7D3D', 'class' => 'bg-warning'],
            ['name' => 'Info', 'className' => 'bg-info', 'hex' => '#43BEE3', 'class' => 'bg-info'],
            ['name' => 'Light', 'className' => 'bg-light', 'hex' => '#F4F6FA', 'class' => 'bg-light'],
            ['name' => 'Muted', 'className' => 'bg-muted', 'hex' => '#B7B8C5', 'class' => 'bg-muted'],
            ['name' => 'Surface', 'className' => 'bg-white', 'hex' => '#FFFFFF', 'class' => 'bg-white'],
            ['name' => 'Border', 'className' => 'border-light', 'hex' => '#F4F6FA', 'class' => 'bg-white'],
        ] as $color)
            <x-sampaui::card padding="lg">
                <div class="flex items-start gap-4">
                    <span class="h-14 w-14 shrink-0 rounded-[1.1rem] border border-light {{ $color['class'] }}"></span>
                    <div class="min-w-0">
                        <p class="font-semibold text-primary">{{ $color['name'] }}</p>
                        <p class="mt-1 text-sm text-secondary">{{ $color['className'] }}</p>
                        <p class="mt-1 font-mono text-xs font-semibold text-secondary">{{ $color['hex'] }}</p>
                        <p class="mt-2 text-xs font-semibold uppercase tracking-[0.18em] text-primary">Token SampaUI</p>
                    </div>
                </div>
            </x-sampaui::card>
        @endforeach
    </div>

    <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_24rem]">
        <x-sampaui::card title="Como alterar a paleta" description="Altere config e CSS juntos para manter pacote, docs e app consumidor sincronizados" padding="lg">
            <div class="space-y-4">
                @foreach ([
                    ['title' => '1. Edite sampaui/config/sampaui.php', 'copy' => 'Atualize o array theme com os hexadecimais oficiais da marca. Esses valores documentam a paleta que o pacote expõe.'],
                    ['title' => '2. Edite sampaui/resources/css/sampaui.css', 'copy' => 'Repita os mesmos valores no bloco @theme para o Tailwind gerar bg-primary, text-secondary, border-light e demais utilitarias.'],
                    ['title' => '3. Recompile o pacote', 'copy' => 'Rode npm run build dentro de sampaui para atualizar dist/sampaui.css.'],
                    ['title' => '4. Publique no app consumidor', 'copy' => 'Rode php artisan vendor:publish --tag=sampaui-assets --force e php artisan view:clear no projeto Laravel que usa o pacote.'],
                ] as $step)
                    <div class="rounded-[1.1rem] border border-light bg-white p-4">
                        <p class="font-semibold text-primary">{{ $step['title'] }}</p>
                        <p class="mt-1 text-sm leading-6 text-secondary">{{ $step['copy'] }}</p>
                    </div>
                @endforeach
            </div>
        </x-sampaui::card>

        <x-sampaui::card title="Arquivos que controlam as cores" description="Use os mesmos hexadecimais nos dois arquivos" padding="lg">
            <div class="space-y-4">
                <div>
                    <p class="mb-2 text-xs font-semibold uppercase tracking-[0.18em] text-primary">config/sampaui.php</p>
                    <pre class="overflow-x-auto rounded-[1rem] bg-primary p-4 text-xs leading-6 text-white"><code>'theme' => [
    'primary' => '#5574C9',
    'secondary' => '#2E314A',
    'accent' => '#FDB82E',
    'danger' => '#E84586',
    'light' => '#F4F6FA',
    'success' => '#79C8BC',
    'warning' => '#FF7D3D',
    'info' => '#43BEE3',
    'purple' => '#895FC4',
    'muted' => '#B7B8C5',
],</code></pre>
                </div>

                <div>
                    <p class="mb-2 text-xs font-semibold uppercase tracking-[0.18em] text-primary">resources/css/sampaui.css</p>
                    <pre class="overflow-x-auto rounded-[1rem] bg-secondary p-4 text-xs leading-6 text-white"><code>@theme {
  --color-primary: #5574C9;
  --color-secondary: #2E314A;
  --color-accent: #FDB82E;
  --color-danger: #E84586;
  --color-light: #F4F6FA;
  --color-success: #79C8BC;
  --color-warning: #FF7D3D;
  --color-info: #43BEE3;
  --color-purple: #895FC4;
  --color-muted: #B7B8C5;
}</code></pre>
                </div>
            </div>
        </x-sampaui::card>
    </div>

    <x-sampaui::card title="Comandos depois da alteracao" description="Fluxo minimo para validar e publicar a nova paleta" padding="lg">
        <pre class="overflow-x-auto rounded-[1rem] bg-primary p-4 text-xs leading-6 text-white"><code>cd sampaui
npm run build
composer test

cd ../sampaui-documentation
npm run build
php artisan test
php artisan view:clear

# no app consumidor
php artisan vendor:publish --tag=sampaui-assets --force
php artisan view:clear</code></pre>
    </x-sampaui::card>
</div>
BLADE,
                'code' => <<<'BLADE'
{{-- Use tokens customizados do SampaUI --}}
<x-sampaui::button class="bg-primary text-white hover:bg-primary/90">
    Salvar
</x-sampaui::button>

{{-- Depois de alterar classes no pacote --}}
{{-- cd sampaui && npm run build --}}

{{-- Depois, no app consumidor --}}
{{-- php artisan vendor:publish --tag=sampaui-assets --force --}}
{{-- php artisan view:clear --}}
BLADE,
            ],
        ];

        $pages['dashboard-home']['code'] = $pages['dashboard-home']['preview'];

        return $pages;
    }
}
