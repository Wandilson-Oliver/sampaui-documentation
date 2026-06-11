@extends('docs.layout', ['title' => $title ?? 'Exemplo de autenticação · Documentação SampaUI'])

@php
    $snippet = <<<'BLADE'
<form wire:submit.prevent="authenticate" class="space-y-5">
    <x-sampaui::input name="email" type="email" label="Email" icon="envelope" wire:model.live="email" />
    <x-sampaui::input name="password" type="password" label="Senha" icon="lock" wire:model="password" />
    <x-sampaui::checkbox name="remember" label="Lembrar de mim" wire:model="remember" />
    <x-sampaui::button type="submit" icon="box-arrow-in-right" full>Entrar</x-sampaui::button>
</form>
BLADE;
@endphp

@section('content')
    <section class="doc-component-intro-grid">
        <article class="doc-hero-card">
            <div class="relative z-[1]">
                <p class="doc-kicker">Exemplo</p>
                <h1 class="mt-3 text-3xl font-semibold tracking-tight text-primary md:text-4xl">Autenticação</h1>
                <p class="mt-4 max-w-3xl text-sm leading-6 text-secondary">
                    Página de login premium usando componentes de formulário SampaUI, Bootstrap Icons e tokens do pacote.
                </p>
            </div>
        </article>
    </section>

    <section class="space-y-7">
        <div class="rounded-[2rem] border border-light bg-light p-4 md:p-8">
            <div class="mx-auto flex min-h-[42rem] max-w-lg items-center justify-center">
                <x-sampaui::card padding="lg" class="w-full shadow-default">
                    <div class="mb-8 text-center">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-default bg-light">
                            <x-sampaui::brand-mark />
                        </div>
                        <p class="mt-5 text-sm font-semibold uppercase tracking-[0.24em] text-primary">SampaUI</p>
                        <h2 class="mt-3 text-3xl font-semibold tracking-tight text-primary">Acesse sua conta</h2>
                        <p class="mt-2 text-sm text-secondary">Entre no painel operacional imobiliário.</p>
                    </div>

                    <form class="space-y-5" wire:submit.prevent="authenticate">
                        <x-sampaui::input name="email" type="email" label="Email" icon="envelope" placeholder="admin@sampa.dev" wire:model.live="email" />

                        <x-sampaui::input name="password" type="password" label="Senha" icon="lock" placeholder="Digite sua senha" wire:model="password" />

                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <x-sampaui::checkbox name="remember" label="Lembrar de mim" color="primary" wire:model="remember" />
                            <a href="#" class="text-sm font-semibold text-primary transition hover:text-primary/80">Esqueceu a senha?</a>
                        </div>

                        <x-sampaui::button type="submit" icon="box-arrow-in-right" full>
                            Entrar
                        </x-sampaui::button>
                    </form>

                    <p class="mt-7 text-center text-sm text-secondary">
                        Novo por aqui?
                        <a href="#" class="font-semibold text-primary">Criar conta</a>
                    </p>
                </x-sampaui::card>
            </div>
        </div>

        <x-sampaui::card title="Trecho de uso" description="Blade + atributos Livewire usados pela página" padding="lg">
            <div class="doc-showcase-code-wrap rounded-[1.35rem] border border-light" x-data="{ copied: false }">
                <button
                    type="button"
                    class="doc-copy-button"
                    x-bind:aria-label="copied ? 'Codigo copiado' : 'Copiar codigo'"
                    x-on:click="
                        navigator.clipboard?.writeText($refs.code.innerText);
                        copied = true;
                        setTimeout(() => copied = false, 1200);
                    "
                >
                    <i class="bi" x-bind:class="copied ? 'bi-check2' : 'bi-copy'"></i>
                </button>

                <pre class="doc-showcase-code"><code x-ref="code">{{ trim($snippet) }}</code></pre>
            </div>
        </x-sampaui::card>
    </section>
@endsection
