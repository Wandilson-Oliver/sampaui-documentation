@extends('docs.layout', ['title' => $title ?? 'Configurações em abas · Documentação SampaUI'])

@php
    $snippet = <<<'BLADE'
<x-sampaui::tabs :tabs="['profile' => 'Perfil', 'security' => 'Segurança', 'notifications' => 'Notificações']" active="profile">
    <x-sampaui::tab-panel name="profile">...</x-sampaui::tab-panel>
    <x-sampaui::tab-panel name="security">...</x-sampaui::tab-panel>
    <x-sampaui::tab-panel name="notifications">...</x-sampaui::tab-panel>
</x-sampaui::tabs>
BLADE;
@endphp

@section('content')
    <section class="doc-component-intro-grid">
        <article class="doc-hero-card">
            <div class="relative z-[1]">
                <p class="doc-kicker">Exemplo</p>
                <h1 class="mt-3 text-3xl font-semibold tracking-tight text-primary md:text-4xl">Configurações em abas</h1>
                <p class="mt-4 max-w-3xl text-sm leading-6 text-secondary">
                    Organização de preferências com tabs, cards, toggles, checkboxes e campos de edição.
                </p>
            </div>
        </article>
    </section>

    <section class="space-y-7">
        <x-sampaui::card title="Configurações da conta" description="Perfil, segurança e notificações" padding="lg" class="shadow-default">
            <x-sampaui::tabs :tabs="['profile' => 'Perfil', 'security' => 'Segurança', 'notifications' => 'Notificações']" active="profile">
                <x-sampaui::tab-panel name="profile">
                    <div class="grid gap-5 lg:grid-cols-[16rem_minmax(0,1fr)]">
                        <div class="rounded-default border border-light bg-light p-5">
                            <x-sampaui::avatar-upload name="settings_avatar" label="Foto" help="Imagem quadrada até 2MB." />
                        </div>
                        <div class="grid gap-5 md:grid-cols-2">
                            <x-sampaui::input name="settings_name" label="Nome" icon="person" value="Ana Martins" />
                            <x-sampaui::input name="settings_email" type="email" label="Email" icon="envelope" value="ana@sampa.dev" />
                            <div class="md:col-span-2">
                                <x-sampaui::textarea name="settings_bio" label="Bio" rows="4">Especialista em operações comerciais e atendimento premium.</x-sampaui::textarea>
                            </div>
                        </div>
                    </div>
                </x-sampaui::tab-panel>

                <x-sampaui::tab-panel name="security">
                    <div class="grid gap-5 lg:grid-cols-2">
                        <x-sampaui::input name="current_password" type="password" label="Senha atual" icon="lock" />
                        <x-sampaui::input name="new_password" type="password" label="Nova senha" icon="shield-lock" />
                        <x-sampaui::card title="Acesso em duas etapas" padding="md">
                            <div class="flex items-center justify-between gap-4">
                                <p class="text-sm text-secondary">Exigir código a cada novo dispositivo.</p>
                                <x-sampaui::toggle name="two_factor" checked />
                            </div>
                        </x-sampaui::card>
                    </div>
                </x-sampaui::tab-panel>

                <x-sampaui::tab-panel name="notifications">
                    <div class="grid gap-4">
                        <x-sampaui::checkbox name="notify_leads" label="Novos leads" checked />
                        <x-sampaui::checkbox name="notify_contracts" label="Atualizações de contrato" checked />
                        <x-sampaui::checkbox name="notify_weekly" label="Resumo semanal por email" />
                    </div>
                </x-sampaui::tab-panel>
            </x-sampaui::tabs>

            <div class="mt-7 flex flex-col-reverse gap-3 border-t border-light pt-6 sm:flex-row sm:justify-end">
                <x-sampaui::button variant="outline">Cancelar</x-sampaui::button>
                <x-sampaui::button icon="check2-circle">Salvar alterações</x-sampaui::button>
            </div>
        </x-sampaui::card>

        @include('pages.examples.partials.code', ['snippet' => $snippet])
    </section>
@endsection
