@extends('docs.layout', ['title' => $title ?? 'Bootstrap Icons · Documentação SampaUI'])

@php
    $snippet = <<<'BLADE'
{{-- Exemplo de uso de ícones nos componentes SampaUI --}}
<x-sampaui::button variant="primary" icon="plus-lg">
    Novo registro
</x-sampaui::button>

<x-sampaui::input name="search" label="Busca" icon="search" placeholder="Procurar..." />

<x-sampaui::badge variant="success" icon="check2-circle">
    Confirmado
</x-sampaui::badge>

{{-- Uso direto com tag de ícone --}}
<i class="bi bi-gear text-primary text-xl"></i>
BLADE;

    $icons = [
        'plus', 'plus-lg', 'x-lg', 'check2', 'check2-circle', 'search', 'pencil', 'trash3', 'eye', 'download', 'upload',
        'arrow-left', 'arrow-right', 'arrow-down-up', 'sort-up', 'sort-down', 'chevron-down', 'chevron-right',
        'person', 'person-plus', 'person-badge', 'people', 'shield-lock', 'lock', 'envelope', 'telephone', 'whatsapp',
        'house', 'houses', 'building', 'buildings', 'grid', 'columns-gap', 'window-sidebar', 'layout-sidebar',
        'card-checklist', 'table', 'list-ul', 'filter', 'calendar3', 'clock-history', 'bell', 'gear', 'sliders',
        'bar-chart-line', 'graph-up-arrow', 'pie-chart', 'tags', 'stars', 'image', 'camera', 'bootstrap',
    ];
@endphp

@section('content')
    <section class="doc-component-intro-grid">
        <article class="doc-hero-card">
            <div class="relative z-[1]">
                <p class="doc-kicker">Exemplo</p>
                <h1 class="mt-3 text-3xl font-semibold tracking-tight text-primary md:text-4xl">Bootstrap Icons</h1>
                <p class="mt-4 max-w-3xl text-sm leading-6 text-secondary">
                    Busca rápida dos principais ícones usados nos componentes e exemplos SampaUI.
                </p>
            </div>
        </article>
    </section>

    <section
        class="doc-component-board"
        x-data="{
            query: '',
            copied: null,
            icons: @js($icons),
            get results() {
                const term = this.query.trim().toLowerCase();
                if (! term) return this.icons;
                return this.icons.filter(icon => icon.includes(term));
            },
            copy(icon) {
                const value = `bi bi-${icon}`;
                navigator.clipboard?.writeText(value);
                this.copied = icon;
                setTimeout(() => this.copied = null, 1200);
            },
        }"
    >
        <div class="doc-section-header">
            <div>
                <p class="doc-kicker">Ícones</p>
                <h2 class="doc-heading">Buscar classe Bootstrap Icons</h2>
                <p class="doc-copy">Use a classe exibida em botões, headers, menus e exemplos.</p>
            </div>
            <span class="doc-chip">{{ count($icons) }} ícones</span>
        </div>

        <div class="mt-6">
            <x-sampaui::input name="icon_search" icon="search" placeholder="Buscar ícone" x-model="query" />
        </div>

        <div class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            <template x-for="icon in results" x-bind:key="icon">
                <button
                    type="button"
                    class="group flex cursor-pointer items-center gap-3 rounded-default border border-border bg-white p-4 text-left transition hover:border-primary/30 hover:bg-light"
                    x-on:click="copy(icon)"
                >
                    <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-default bg-light text-xl text-primary transition group-hover:bg-primary group-hover:text-white">
                        <i class="bi" x-bind:class="`bi-${icon}`" aria-hidden="true"></i>
                    </span>
                    <span class="min-w-0">
                        <span class="block truncate text-sm font-semibold text-primary" x-text="icon"></span>
                        <code class="mt-1 block truncate text-xs text-secondary" x-text="`bi bi-${icon}`"></code>
                    </span>
                    <i class="bi ms-auto text-secondary" x-bind:class="copied === icon ? 'bi-check2 text-success' : 'bi-copy'" aria-hidden="true"></i>
                </button>
            </template>
        </div>

        <div class="doc-search-empty" x-show="results.length === 0">
            Nenhum ícone encontrado.
        </div>

        @include('pages.examples.partials.code', [
            'snippet' => $snippet,
            'codeTitle' => 'Como utilizar Ícones',
            'description' => 'Os ícones Bootstrap Icons são suportados nativamente através da prop icon="..." nos componentes SampaUI.',
            'components' => ['button', 'input', 'badge', 'card'],
        ])
    </section>
@endsection
