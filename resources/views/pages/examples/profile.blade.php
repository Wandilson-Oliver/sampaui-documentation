@extends('docs.layout', ['title' => $title ?? 'Perfil e arquivos · Documentação SampaUI'])

@php
$snippet = <<<'BLADE'
<x-sampaui::card title="Perfil" description="Avatar, contato e credenciais" padding="lg">
    <form wire:submit.prevent="saveProfile" class="space-y-7">
        <div class="grid gap-8 xl:grid-cols-[22rem_minmax(0,1fr)]">
            {{-- Upload de Avatar com Preview e Recorte --}}
            <div class="flex flex-col items-center justify-center rounded-[1.25rem] border border-border bg-light p-6">
                <x-sampaui::avatar-upload
                    name="avatar"
                    label="Avatar"
                    help="PNG ou JPG quadrado até 2MB."
                    wire:model="avatar"
                />
            </div>

            {{-- Informações Pessoais e Senha --}}
            <div class="grid gap-5 md:grid-cols-2">
                <div class="md:col-span-2">
                    <x-sampaui::input
                        name="name"
                        label="Nome completo"
                        icon="person"
                        placeholder="Ana Martins"
                        wire:model.live="name"
                        required
                    />
                </div>

                <x-sampaui::input
                    name="email"
                    type="email"
                    label="Email"
                    icon="envelope"
                    placeholder="ana@sampa.dev"
                    wire:model.live="email"
                    required
                />

                <x-sampaui::phone
                    name="whatsapp"
                    label="WhatsApp"
                    icon="whatsapp"
                    placeholder="(11) 9 9999-0000"
                    wire:model.live="whatsapp"
                />

                <x-sampaui::input
                    name="password"
                    type="password"
                    label="Nova senha"
                    icon="lock"
                    placeholder="Digite caso queira alterar"
                    wire:model="password"
                />

                <x-sampaui::input
                    name="password_confirmation"
                    type="password"
                    label="Confirmação de senha"
                    icon="lock"
                    placeholder="Repita a nova senha"
                    wire:model="passwordConfirmation"
                />
            </div>
        </div>

        {{-- Upload Múltiplo de Documentos com Drag & Drop --}}
        <x-sampaui::file-upload
            name="documents"
            label="Documentos do perfil"
            accept="image/*,.pdf"
            multiple
            preview
            wire:model="documents"
        >
            Anexe comprovante, contratos ou arquivos complementares.
        </x-sampaui::file-upload>

        {{-- Botões de Ação --}}
        <div class="flex flex-col-reverse gap-3 border-t border-border pt-6 sm:flex-row sm:justify-end">
            <x-sampaui::button type="button" variant="outline" icon="x-lg" wire:click="cancel">Cancelar</x-sampaui::button>
            <x-sampaui::button type="submit" icon="check2-circle">Salvar perfil</x-sampaui::button>
        </div>
    </form>
</x-sampaui::card>
BLADE;

$livewireSnippet = <<<'PHP'
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class ProfileManager extends Component
{
    use WithFileUploads;

    public $avatar;
    public array $documents = [];
    public string $name = 'Ana Martins';
    public string $email = 'ana@sampa.dev';
    public string $whatsapp = '(11) 99999-0000';
    public string $password = '';
    public string $passwordConfirmation = '';

    public function saveProfile(): void
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'avatar' => 'nullable|image|max:2048',
            'documents.*' => 'nullable|file|max:5120',
            'password' => 'nullable|min:8|same:passwordConfirmation',
        ]);

        // Salvar avatar, arquivos e atualizar usuário...
        session()->flash('success', 'Perfil atualizado com sucesso!');
    }

    public function cancel(): void
    {
        $this->reset(['avatar', 'documents', 'password', 'passwordConfirmation']);
    }

    public function render()
    {
        return view('livewire.profile-manager');
    }
}
PHP;
@endphp

@section('content')
    <section class="doc-component-intro-grid">
        <article class="doc-hero-card">
            <div class="relative z-[1] flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="doc-kicker">Exemplo</p>
                    <h1 class="mt-3 text-3xl font-semibold tracking-tight text-primary md:text-4xl">Perfil e arquivos</h1>
                    <p class="mt-4 max-w-3xl text-sm leading-6 text-secondary">
                        Formulário de perfil com avatar, documentos, dados de contato e campos de senha usando componentes SampaUI.
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
                    <div class="flex flex-col items-center justify-center rounded-[1.25rem] border border-border bg-light p-6">
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

                <x-sampaui::file-upload
                    name="documents"
                    label="Documentos do perfil"
                    accept="image/*,.pdf"
                    multiple
                    preview
                    wire:model="documents"
                >
                    Anexe RG, comprovante ou imagem complementar.
                </x-sampaui::file-upload>

                <div class="flex flex-col-reverse gap-3 border-t border-border pt-6 sm:flex-row sm:justify-end">
                    <x-sampaui::button type="button" variant="outline" icon="x-lg">Cancelar</x-sampaui::button>
                    <x-sampaui::button type="submit" icon="check2-circle">Salvar perfil</x-sampaui::button>
                </div>
            </form>
        </x-sampaui::card>

        @include('pages.examples.partials.code', [
            'snippet' => $snippet,
            'livewireSnippet' => $livewireSnippet,
            'codeTitle' => 'Código de Perfil e Arquivos',
            'description' => 'Formulário completo com avatar com upload dinâmico, upload múltiplo de documentos, dados pessoais e senha.',
            'components' => ['card', 'avatar-upload', 'file-upload', 'input', 'phone', 'button'],
        ])
    </section>
@endsection
