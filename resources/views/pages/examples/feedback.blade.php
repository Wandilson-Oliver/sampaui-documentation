@extends('docs.layout', ['title' => $title ?? 'Estados de feedback · Documentação SampaUI'])

@php
    $snippet = <<<'BLADE'
<x-sampaui::toast position="top-right" />

<x-sampaui::button
    icon="check2-circle"
    x-on:click="window.dispatchEvent(new CustomEvent('sampaui:toast', {
        detail: { type: 'success', title: 'Salvo', message: 'Alterações publicadas.' }
    }))"
>
    Disparar toast
</x-sampaui::button>

<x-sampaui::alert variant="warning" title="Ação pendente">Revise os dados antes de continuar.</x-sampaui::alert>
<x-sampaui::progress label="Upload" :value="72" show-value />
<x-sampaui::skeleton lines="3" />
<x-sampaui::empty-state title="Nenhum registro" />
BLADE;
@endphp

@section('content')
    <section class="doc-component-intro-grid">
        <article class="doc-hero-card">
            <div class="relative z-[1]">
                <p class="doc-kicker">Exemplo</p>
                <h1 class="mt-3 text-3xl font-semibold tracking-tight text-primary md:text-4xl">Estados de feedback</h1>
                <p class="mt-4 max-w-3xl text-sm leading-6 text-secondary">
                    Combinação de toast, alertas, progresso, skeleton e empty state para respostas claras do sistema.
                </p>
            </div>
        </article>
    </section>

    <section class="space-y-7">
        <x-sampaui::toast position="top-right" />

        <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_22rem]">
            <x-sampaui::card title="Ações com toast" description="Dispare eventos para simular retornos do sistema" padding="lg" class="shadow-default">
                <div class="flex flex-wrap gap-3">
                    <x-sampaui::button icon="check2-circle" x-on:click="window.dispatchEvent(new CustomEvent('sampaui:toast', { detail: { type: 'success', title: 'Salvo', message: 'Alterações publicadas.' } }))">
                        Sucesso
                    </x-sampaui::button>
                    <x-sampaui::button variant="danger" icon="exclamation-octagon" x-on:click="window.dispatchEvent(new CustomEvent('sampaui:toast', { detail: { type: 'error', title: 'Erro', message: 'Não foi possível concluir.' } }))">
                        Erro
                    </x-sampaui::button>
                    <x-sampaui::button variant="outline" icon="info-circle" x-on:click="window.dispatchEvent(new CustomEvent('sampaui:toast', { detail: { type: 'info', title: 'Aviso', message: 'Nova atualização disponível.' } }))">
                        Aviso
                    </x-sampaui::button>
                </div>

                <div class="mt-7 grid gap-4">
                    <x-sampaui::alert variant="success" title="Sincronizado">
                        Os dados foram atualizados com sucesso.
                    </x-sampaui::alert>
                    <x-sampaui::alert variant="warning" title="Ação pendente">
                        Revise os dados antes de continuar.
                    </x-sampaui::alert>
                </div>
            </x-sampaui::card>

            <x-sampaui::card title="Processamento" description="Estados intermediários" padding="lg">
                <div class="space-y-6">
                    <x-sampaui::progress label="Upload de documentos" :value="72" show-value variant="primary" />
                    <div class="space-y-3">
                        <x-sampaui::skeleton class="h-4 w-full" />
                        <x-sampaui::skeleton class="h-4 w-5/6" />
                        <x-sampaui::skeleton class="h-4 w-2/3" />
                    </div>
                </div>
            </x-sampaui::card>
        </div>

        <x-sampaui::card title="Estado vazio" padding="lg">
            <x-sampaui::empty-state icon="inbox" title="Nenhum registro encontrado" description="Quando a lista estiver vazia, ofereça uma ação clara para retomar o fluxo.">
                <x-sampaui::button icon="plus">Criar registro</x-sampaui::button>
            </x-sampaui::empty-state>
        </x-sampaui::card>

        @include('pages.examples.partials.code', ['snippet' => $snippet])
    </section>
@endsection
