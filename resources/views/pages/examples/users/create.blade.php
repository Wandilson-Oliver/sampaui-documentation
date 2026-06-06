@extends('docs.layout', ['title' => $title ?? 'Exemplo de cadastro de usuário · Documentação SampaUI'])

@php
$snippet = <<<'BLADE'
<form wire:submit.prevent="save" class="space-y-6">
    <x-sampaui::avatar-upload name="photo" wire:model="photo" />
    <x-sampaui::input name="name" label="Nome" icon="person" wire:model.live="name" />
    <x-sampaui::input name="email" type="email" label="Email" icon="envelope" wire:model.live="email" />
    <x-sampaui::input name="whatsapp" label="WhatsApp" icon="whatsapp" wire:model.live="whatsapp" />
    <x-sampaui::input name="password" type="password" label="Senha" icon="lock" wire:model="password" />
    <x-sampaui::input name="password_confirmation" type="password" label="Confirmacao de senha" icon="lock" wire:model="passwordConfirmation" />
    <x-sampaui::button type="submit" icon="check2-circle">Salvar usuário</x-sampaui::button>
</form>
BLADE;
@endphp

@section('content')
    <section class="doc-component-intro-grid">
        <article class="doc-hero-card">
            <div class="relative z-[1] flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="doc-kicker">Exemplo</p>
                    <h1 class="mt-3 text-3xl font-semibold tracking-tight text-primary md:text-4xl">Cadastro de usuário</h1>
                    <p class="mt-4 max-w-3xl text-sm leading-6 text-secondary">
                        Formulário real de dashboard com preview de foto, bindings Livewire e estados visuais de validação.
                    </p>
                </div>
                <x-sampaui::button variant="outline" icon="arrow-left">Voltar para usuários</x-sampaui::button>
            </div>
        </article>
    </section>

    <section class="space-y-7">
        <x-sampaui::card title="Criar usuário" description="Perfil, contato e credenciais de acesso" padding="lg" class="shadow-default">
            <form class="space-y-7" wire:submit.prevent="save">
                <div class="grid gap-8 xl:grid-cols-[22rem_minmax(0,1fr)]">
                    <div class="flex flex-col items-center justify-center rounded-[1.25rem] border border-light bg-light p-6">
                        <div class="mb-4 flex items-center gap-3">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-default bg-primary text-white">
                                <i class="bi bi-camera" aria-hidden="true"></i>
                            </span>
                            <div>
                                <p class="font-semibold text-primary">Foto</p>
                                <p class="text-sm text-secondary">Envie uma imagem quadrada.</p>
                            </div>
                        </div>

                        <x-sampaui::avatar-upload name="photo" wire:model="photo" />
                    </div>

                    <div class="grid gap-5 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <x-sampaui::input name="name" label="Nome" icon="person" placeholder="Ana Martins" wire:model.live="name" required />
                        </div>

                        <x-sampaui::input name="email" type="email" label="Email" icon="envelope" placeholder="ana@sampa.dev" wire:model.live="email" required />

                        <x-sampaui::input name="whatsapp" label="WhatsApp" icon="whatsapp" placeholder="+55 11 99999-0000" wire:model.live="whatsapp" />

                        <x-sampaui::input name="password" type="password" label="Senha" icon="lock" error="Use pelo menos 8 caracteres." wire:model="password" />

                        <x-sampaui::input name="password_confirmation" type="password" label="Confirmação de senha" icon="lock" wire:model="passwordConfirmation" />
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-light pt-6 sm:flex-row sm:justify-end">
                    <x-sampaui::button type="button" variant="outline" icon="x-lg">Cancelar</x-sampaui::button>
                    <x-sampaui::button type="submit" icon="check2-circle">Salvar usuário</x-sampaui::button>
                </div>
            </form>
        </x-sampaui::card>

        <x-sampaui::card title="Trecho de uso" description="Copie esta estrutura para uma página Livewire" padding="lg">
            <pre class="overflow-x-auto rounded-default bg-primary p-5 text-xs leading-6 text-white"><code>{{ trim($snippet) }}</code></pre>
        </x-sampaui::card>
    </section>
@endsection
