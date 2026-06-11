@extends('docs.layout', ['title' => $title ?? 'Exemplo de listagem de usuários · Documentação SampaUI'])

@section('content')
    <section class="doc-component-intro-grid">
        <article class="doc-hero-card">
            <div class="relative z-[1]">
                <p class="doc-kicker">Exemplo funcional</p>
                <h1 class="mt-3 text-3xl font-semibold tracking-tight text-primary md:text-4xl">Listagem de usuários</h1>
                <p class="mt-4 max-w-3xl text-sm leading-6 text-secondary">
                    Interface CRUD simulada com Livewire: busca, filtro, ordenação, paginação, cadastro, edição, exclusão e toggle de status funcionam sem recarregar a página.
                </p>
            </div>
        </article>
    </section>

    <livewire:examples.users-index />
@endsection
