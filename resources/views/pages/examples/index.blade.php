@extends('docs.layout', ['title' => $title ?? 'Exemplos · Documentação SampaUI'])

@section('content')
    <section class="doc-component-intro-grid">
        <article class="doc-hero-card">
            <div class="relative z-[1] flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="doc-kicker">Exemplos</p>
                    <h1 class="mt-3 text-3xl font-semibold tracking-tight text-primary md:text-4xl">Páginas reais com SampaUI</h1>
                    <p class="mt-4 max-w-3xl text-sm leading-6 text-secondary">
                        Exemplos construídos com Laravel 13, atributos Livewire 4, tokens Tailwind CSS 4, AlpineJS e Bootstrap Icons.
                    </p>
                </div>

                <x-sampaui::badge variant="primary" icon="window-sidebar">Estilo de produção</x-sampaui::badge>
            </div>
        </article>
    </section>

    <section class="grid gap-5 lg:grid-cols-2 xl:grid-cols-4">
        @foreach ([
            [
                'title' => 'Autenticação',
                'copy' => 'Tela de login premium com card centralizado, inputs SampaUI e ações de conta.',
                'icon' => 'shield-lock',
                'route' => 'examples.authentication',
            ],
            [
                'title' => 'Form Profile',
                'copy' => 'Formulário de perfil com avatar upload, nome, email, WhatsApp e troca de senha.',
                'icon' => 'person-badge',
                'route' => 'examples.profile',
            ],
            [
                'title' => 'Bootstrap Icons',
                'copy' => 'Busca rápida dos principais ícones Bootstrap Icons com classes copiáveis.',
                'icon' => 'bootstrap',
                'route' => 'examples.icons',
            ],
            [
                'title' => 'Listagem de usuários',
                'copy' => 'Tabela CRUD responsiva com filtros, badges de status, ações e paginação.',
                'icon' => 'people',
                'route' => 'examples.users.index',
            ],
        ] as $example)
            <a href="{{ route($example['route']) }}" class="group rounded-[1.75rem] border border-light bg-white p-6 shadow-default transition hover:-translate-y-0.5 hover:border-primary/30 hover:shadow-2xl">
                <span class="inline-flex h-14 w-14 items-center justify-center rounded-default bg-light text-2xl text-primary transition group-hover:bg-primary group-hover:text-white">
                    <i class="bi bi-{{ $example['icon'] }}" aria-hidden="true"></i>
                </span>
                <h2 class="mt-6 text-xl font-semibold text-primary">{{ $example['title'] }}</h2>
                <p class="mt-3 text-sm leading-6 text-secondary">{{ $example['copy'] }}</p>
                <span class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-primary">
                    Abrir exemplo
                    <i class="bi bi-arrow-right" aria-hidden="true"></i>
                </span>
            </a>
        @endforeach
    </section>
@endsection
