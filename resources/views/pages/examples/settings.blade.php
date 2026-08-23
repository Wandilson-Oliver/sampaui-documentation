@extends('docs.layout', ['title' => $title ?? 'Configurações em abas · Documentação SampaUI'])

@php
    $snippet = <<<'BLADE'
<x-sampaui::card title="Configurações da conta" description="Perfil, segurança e notificações" padding="lg">
    <x-sampaui::tabs
        :tabs="[
            'profile' => 'Perfil',
            'security' => 'Segurança',
            'notifications' => 'Notificações',
        ]"
        active="profile"
    >
        {{-- Aba 1: Perfil --}}
        <x-sampaui::tab-panel name="profile">
            <div class="grid gap-5 lg:grid-cols-[16rem_minmax(0,1fr)]">
                <div class="rounded-default border border-border bg-light p-5">
                    <x-sampaui::avatar-upload
                        name="settings_avatar"
                        label="Foto de perfil"
                        help="Imagem quadrada até 2MB."
                        wire:model="avatar"
                    />
                </div>
                <div class="grid gap-5 md:grid-cols-2">
                    <x-sampaui::input
                        name="settings_name"
                        label="Nome"
                        icon="person"
                        wire:model.live="name"
                        required
                    />
                    <x-sampaui::input
                        name="settings_email"
                        type="email"
                        label="Email"
                        icon="envelope"
                        wire:model.live="email"
                        required
                    />
                    <div class="md:col-span-2">
                        <x-sampaui::textarea
                            name="settings_bio"
                            label="Biografia"
                            rows="4"
                            wire:model.live.debounce.500ms="bio"
                        />
                    </div>
                </div>
            </div>
        </x-sampaui::tab-panel>

        {{-- Aba 2: Segurança --}}
        <x-sampaui::tab-panel name="security">
            <div class="grid gap-5 lg:grid-cols-2">
                <x-sampaui::input
                    name="current_password"
                    type="password"
                    label="Senha atual"
                    icon="lock"
                    wire:model="currentPassword"
                />
                <x-sampaui::input
                    name="new_password"
                    type="password"
                    label="Nova senha"
                    icon="shield-lock"
                    wire:model="newPassword"
                />
                <div class="lg:col-span-2">
                    <x-sampaui::card title="Autenticação em duas etapas (2FA)" padding="md">
                        <div class="flex items-center justify-between gap-4">
                            <p class="text-sm text-secondary">Exigir código OTP a cada novo login em dispositivos desconhecidos.</p>
                            <x-sampaui::toggle name="two_factor" wire:model.live="twoFactor" />
                        </div>
                    </x-sampaui::card>
                </div>
            </div>
        </x-sampaui::tab-panel>

        {{-- Aba 3: Notificações --}}
        <x-sampaui::tab-panel name="notifications">
            <div class="grid gap-4">
                <x-sampaui::checkbox name="notify_leads" label="Novos leads comerciais recebidos" wire:model.live="notifyLeads" />
                <x-sampaui::checkbox name="notify_contracts" label="Atualizações de contrato e propostas" wire:model.live="notifyContracts" />
                <x-sampaui::checkbox name="notify_weekly" label="Resumo semanal de desempenho por e-mail" wire:model.live="notifyWeekly" />
            </div>
        </x-sampaui::tab-panel>
    </x-sampaui::tabs>

    <div class="mt-7 flex flex-col-reverse gap-3 border-t border-border pt-6 sm:flex-row sm:justify-end">
        <x-sampaui::button variant="outline" wire:click="cancel">Cancelar</x-sampaui::button>
        <x-sampaui::button icon="check2-circle" wire:click="save">Salvar alterações</x-sampaui::button>
    </div>
</x-sampaui::card>
BLADE;

    $livewireSnippet = <<<'PHP'
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class AccountSettings extends Component
{
    use WithFileUploads;

    public $avatar;
    public string $name = 'Ana Martins';
    public string $email = 'ana@sampa.dev';
    public string $bio = 'Especialista em operações comerciais e atendimento premium.';
    public string $currentPassword = '';
    public string $newPassword = '';
    public bool $twoFactor = true;
    public bool $notifyLeads = true;
    public bool $notifyContracts = true;
    public bool $notifyWeekly = false;

    public function save(): void
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'bio' => 'nullable|max:500',
            'currentPassword' => 'nullable|min:6',
            'newPassword' => 'nullable|min:8',
        ]);

        session()->flash('success', 'Configurações atualizadas com sucesso!');
    }

    public function cancel(): void
    {
        $this->reset(['currentPassword', 'newPassword']);
    }

    public function render()
    {
        return view('livewire.account-settings');
    }
}
PHP;
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
                        <div class="rounded-default border border-border bg-light p-5">
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

            <div class="mt-7 flex flex-col-reverse gap-3 border-t border-border pt-6 sm:flex-row sm:justify-end">
                <x-sampaui::button variant="outline">Cancelar</x-sampaui::button>
                <x-sampaui::button icon="check2-circle">Salvar alterações</x-sampaui::button>
            </div>
        </x-sampaui::card>

        @include('pages.examples.partials.code', [
            'snippet' => $snippet,
            'livewireSnippet' => $livewireSnippet,
            'codeTitle' => 'Código de Configurações em Abas',
            'description' => 'Layout organizado em abas para Perfil, Segurança com 2FA e Notificações.',
            'components' => ['card', 'tabs', 'tab-panel', 'avatar-upload', 'input', 'textarea', 'toggle', 'checkbox', 'button'],
        ])
    </section>
@endsection
