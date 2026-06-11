@extends('docs.layout', ['title' => $title ?? 'Form Profile · Documentação SampaUI'])

@php
$snippet = <<<'BLADE'
<form wire:submit.prevent="saveProfile" class="space-y-6">
    <x-sampaui::avatar-upload name="avatar" label="Avatar" wire:model="avatar" />
    <x-sampaui::input name="name" label="Nome" icon="person" wire:model.live="name" required />
    <x-sampaui::input name="email" type="email" label="Email" icon="envelope" wire:model.live="email" required />
    <x-sampaui::phone name="whatsapp" label="WhatsApp" icon="whatsapp" wire:model.live="whatsapp" />
    <x-sampaui::input name="password" type="password" label="Senha" icon="lock" wire:model="password" />
    <x-sampaui::input name="password_confirmation" type="password" label="Confirmacao de senha" icon="lock" wire:model="passwordConfirmation" />
    <x-sampaui::button type="submit" icon="check2-circle">Salvar perfil</x-sampaui::button>
</form>
BLADE;
@endphp

@section('content')
    <section class="doc-component-intro-grid">
        <article class="doc-hero-card">
            <div class="relative z-[1] flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="doc-kicker">Exemplo</p>
                    <h1 class="mt-3 text-3xl font-semibold tracking-tight text-primary md:text-4xl">Form Profile</h1>
                    <p class="mt-4 max-w-3xl text-sm leading-6 text-secondary">
                        Formulário de perfil com avatar upload, dados de contato e campos de senha usando componentes SampaUI.
                    </p>
                </div>
                <x-sampaui::button variant="outline" icon="arrow-left">Voltar</x-sampaui::button>
            </div>
        </article>
    </section>

    <section class="space-y-7">
        <x-sampaui::card title="Perfil" description="Avatar, contato e credenciais" padding="lg" class="shadow-default">
            <form class="space-y-7" wire:submit.prevent="saveProfile">
                <div class="grid gap-8 xl:grid-cols-[22rem_minmax(0,1fr)]">
                    <div class="flex flex-col items-center justify-center rounded-[1.25rem] border border-light bg-light p-6">
                        <x-sampaui::avatar-upload
                            name="avatar"
                            label="Avatar"
                            help="PNG ou JPG quadrado."
                            wire:model="avatar"
                        />
                    </div>

                    <div class="grid gap-5 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <x-sampaui::input name="name" label="Nome" icon="person" placeholder="Ana Martins" wire:model.live="name" required />
                        </div>

                        <x-sampaui::input name="email" type="email" label="Email" icon="envelope" placeholder="ana@sampa.dev" wire:model.live="email" required />

                        <x-sampaui::phone name="whatsapp" label="WhatsApp" icon="whatsapp" placeholder="(11) 9 9999-0000" wire:model.live="whatsapp" />

                        <x-sampaui::input name="password" type="password" label="Senha" icon="lock" placeholder="Nova senha" wire:model="password" />

                        <x-sampaui::input name="password_confirmation" type="password" label="Confirmação de senha" icon="lock" placeholder="Repita a senha" wire:model="passwordConfirmation" />
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-light pt-6 sm:flex-row sm:justify-end">
                    <x-sampaui::button type="button" variant="outline" icon="x-lg">Cancelar</x-sampaui::button>
                    <x-sampaui::button type="submit" icon="check2-circle">Salvar perfil</x-sampaui::button>
                </div>
            </form>
        </x-sampaui::card>

        <x-sampaui::card title="Trecho de uso" description="Copie esta estrutura para uma página Livewire" padding="lg">
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
