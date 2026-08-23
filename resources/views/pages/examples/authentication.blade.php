@extends('docs.layout', ['title' => $title ?? 'Exemplo de autenticação · Documentação SampaUI'])

@php
    $snippet = <<<'BLADE'
<div class="mx-auto flex min-h-screen max-w-lg items-center justify-center p-4">
    <x-sampaui::card padding="lg" class="w-full shadow-default">
        <div class="mb-8 text-center">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-default bg-light">
                <x-sampaui::brand-mark />
            </div>
            <p class="mt-5 text-sm font-semibold uppercase tracking-[0.24em] text-primary">SampaUI</p>
            <h2 class="mt-3 text-3xl font-semibold tracking-tight text-primary">Acesse sua conta</h2>
            <p class="mt-2 text-sm text-secondary">Entre no painel operacional.</p>
        </div>

        <form class="space-y-5" wire:submit.prevent="authenticate">
            @if ($hasError)
                <x-sampaui::alert variant="danger" title="Credenciais inválidas" wire:dirty.remove>
                    Confira seu e-mail e senha antes de tentar novamente.
                </x-sampaui::alert>
            @endif

            <x-sampaui::input
                name="email"
                type="email"
                label="Email"
                icon="envelope"
                placeholder="admin@sampa.dev"
                wire:model.live="email"
                required
            />

            <x-sampaui::input
                name="password"
                type="password"
                label="Senha"
                icon="lock"
                placeholder="Digite sua senha"
                wire:model="password"
                required
            />

            <div class="flex flex-wrap items-center justify-between gap-3">
                <x-sampaui::checkbox name="remember" label="Lembrar de mim" color="primary" wire:model="remember" />
                <a href="#" class="text-sm font-semibold text-primary transition hover:text-primary/80">Esqueceu a senha?</a>
            </div>

            <x-sampaui::button type="submit" icon="box-arrow-in-right" :loading="$isAuthenticating" full>
                Entrar
            </x-sampaui::button>
        </form>

        <p class="mt-7 text-center text-sm text-secondary">
            Novo por aqui?
            <a href="#" class="font-semibold text-primary">Criar conta</a>
        </p>
    </x-sampaui::card>
</div>
BLADE;

    $livewireSnippet = <<<'PHP'
namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public bool $remember = false;
    public bool $isAuthenticating = false;
    public bool $hasError = false;

    public function authenticate(): void
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $this->isAuthenticating = true;
        $this->hasError = false;

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            $this->redirectIntended(route('dashboard'));
            return;
        }

        $this->isAuthenticating = false;
        $this->hasError = true;
    }

    public function render()
    {
        return view('livewire.login');
    }
}
PHP;
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
        <div class="rounded-[2rem] border border-border bg-light p-4 md:p-8">
            <div class="mx-auto flex min-h-[42rem] max-w-lg items-center justify-center">
                <x-sampaui::card padding="lg" class="w-full shadow-default">
                    <div class="mb-8 text-center">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-default bg-light">
                            <x-sampaui::brand-mark />
                        </div>
                        <p class="mt-5 text-sm font-semibold uppercase tracking-[0.24em] text-primary">SampaUI</p>
                        <h2 class="mt-3 text-3xl font-semibold tracking-tight text-primary">Acesse sua conta</h2>
                        <p class="mt-2 text-sm text-secondary">Entre no painel operacional.</p>
                    </div>

                    <form class="space-y-5" wire:submit.prevent="authenticate">
                        <x-sampaui::alert variant="danger" title="Credenciais inválidas">
                            Confira email e senha antes de tentar novamente.
                        </x-sampaui::alert>

                        <x-sampaui::input name="email" type="email" label="Email" icon="envelope" placeholder="admin@sampa.dev" wire:model.live="email" />

                        <x-sampaui::input name="password" type="password" label="Senha" icon="lock" placeholder="Digite sua senha" wire:model="password" />

                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <x-sampaui::checkbox name="remember" label="Lembrar de mim" color="primary" wire:model="remember" />
                            <a href="#" class="text-sm font-semibold text-primary transition hover:text-primary/80">Esqueceu a senha?</a>
                        </div>

                        <x-sampaui::button type="submit" icon="box-arrow-in-right" loading full>
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

        @include('pages.examples.partials.code', [
            'snippet' => $snippet,
            'livewireSnippet' => $livewireSnippet,
            'codeTitle' => 'Código de Autenticação',
            'description' => 'Tela de login completa com card centralizado, alertas de validação, inputs com ícones e submit assíncrono.',
            'components' => ['card', 'brand-mark', 'alert', 'input', 'checkbox', 'button'],
        ])
    </section>
@endsection
