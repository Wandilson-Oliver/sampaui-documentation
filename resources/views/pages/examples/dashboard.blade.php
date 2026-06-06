@extends('docs.layout', ['title' => $title ?? 'Exemplo de dashboard · Documentação SampaUI'])

@section('content')
    <section class="doc-component-intro-grid">
        <article class="doc-hero-card">
            <div class="relative z-[1] flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="doc-kicker">Exemplo</p>
                    <h1 class="mt-3 text-3xl font-semibold tracking-tight text-primary md:text-4xl">Dashboard</h1>
                    <p class="mt-4 max-w-3xl text-sm leading-6 text-secondary">
                        Dashboard imobiliário completo com Sidebar, Card, Badge, Button, Dropdown, Progress, Table, Pagination e ApexCharts do SampaUI.
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <x-sampaui::button
                        variant="outline"
                        icon="box-arrow-up-right"
                        onclick="window.open('{{ route('documentation.pages.show', 'dashboard-home') }}', '_blank')"
                    >
                        Abrir dashboard
                    </x-sampaui::button>
                    <x-sampaui::button
                        icon="window-sidebar"
                        onclick="window.open('{{ route('documentation.pages.preview', 'dashboard-home') }}', '_blank')"
                    >
                        Preview completo
                    </x-sampaui::button>
                </div>
            </div>
        </article>
    </section>

    <section class="grid gap-7 xl:grid-cols-[24rem_minmax(0,1fr)]">
        <aside class="space-y-5">
            <x-sampaui::card title="O que este exemplo usa" description="Componentes do pacote e stack" padding="lg">
                <div class="space-y-3">
                    @foreach ([
                        'x-sampaui::sidebar',
                        'x-sampaui::card',
                        'x-sampaui::dropdown',
                        'x-sampaui::progress',
                        'x-sampaui::table',
                        'x-sampaui::pagination',
                        'ApexCharts + AlpineJS',
                    ] as $item)
                        <div class="flex items-center gap-3 rounded-default bg-light px-4 py-3 text-sm font-semibold text-secondary">
                            <i class="bi bi-check2-circle text-primary" aria-hidden="true"></i>
                            <span>{{ $item }}</span>
                        </div>
                    @endforeach
                </div>
            </x-sampaui::card>

            <x-sampaui::card title="Nota de implementação" description="Copie o Blade e adapte os arrays para o estado do Livewire" padding="lg">
                <p class="text-sm leading-6 text-secondary">
                    O dashboard é intencionalmente estático na documentação. Em uma página real com Laravel 13 + Livewire 4, mova os arrays para a classe Livewire e mantenha a estrutura Blade.
                </p>
            </x-sampaui::card>
        </aside>

        <x-sampaui::card title="Código Blade do dashboard" description="Copie este código para uma view Blade ou Livewire" padding="lg">
            <div class="doc-showcase-code-wrap rounded-[1.35rem] border border-light" x-data="{ copied: false }">
                <button
                    type="button"
                    class="doc-copy-button"
                    x-bind:aria-label="copied ? 'Código copiado' : 'Copiar código'"
                    x-on:click="
                        navigator.clipboard?.writeText($refs.code.innerText);
                        copied = true;
                        setTimeout(() => copied = false, 1200);
                    "
                >
                    <i class="bi" x-bind:class="copied ? 'bi-check2' : 'bi-copy'"></i>
                </button>

                <pre class="doc-showcase-code max-h-[52rem]"><code x-ref="code">{{ trim($dashboard['code']) }}</code></pre>
            </div>
        </x-sampaui::card>
    </section>
@endsection
