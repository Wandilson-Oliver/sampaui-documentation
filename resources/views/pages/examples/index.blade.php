@extends('docs.layout', ['title' => $title ?? 'Exemplos · Documentação SampaUI'])

@section('content')
    <section class="doc-component-intro-grid">
        <article class="doc-hero-card">
            <div class="relative z-[1] flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="doc-kicker">Exemplos</p>
                    <h1 class="mt-3 text-3xl font-semibold tracking-tight text-primary md:text-4xl">Páginas reais para produtos imobiliários</h1>
                    <p class="mt-4 max-w-3xl text-sm leading-6 text-secondary">
                        Exemplos para CRM, captação, atendimento, propostas, configurações e autenticação, construídos com Laravel 13, Livewire 4, Tailwind CSS 4, AlpineJS e Bootstrap Icons.
                    </p>
                </div>

                <x-sampaui::badge variant="primary" icon="window-sidebar">Estilo de produção</x-sampaui::badge>
            </div>
        </article>
    </section>

    <section class="grid gap-5 lg:grid-cols-2 xl:grid-cols-3">
        @foreach ($examples as $example)
            <a href="{{ route($example['route']) }}" class="group flex min-h-64 flex-col rounded-[1.35rem] border border-light bg-white p-6 shadow-default transition hover:-translate-y-0.5 hover:border-primary/30 hover:shadow-2xl">
                <div class="flex items-start justify-between gap-4">
                    <span class="inline-flex h-14 w-14 items-center justify-center rounded-default bg-light text-2xl text-primary transition group-hover:bg-primary group-hover:text-white">
                        <i class="bi bi-{{ $example['icon'] }}" aria-hidden="true"></i>
                    </span>
                    <x-sampaui::badge variant="light">{{ $example['tag'] }}</x-sampaui::badge>
                </div>

                <div class="mt-6 flex flex-1 flex-col">
                    <h2 class="text-xl font-semibold text-primary">{{ $example['title'] }}</h2>
                    <p class="mt-3 flex-1 text-sm leading-6 text-secondary">{{ $example['copy'] }}</p>
                    <span class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-primary">
                        Abrir exemplo
                        <i class="bi bi-arrow-right" aria-hidden="true"></i>
                    </span>
                </div>
            </a>
        @endforeach
    </section>
@endsection
