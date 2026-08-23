@extends('docs.layout', ['title' => $title ?? 'Verificação 2FA · Documentação SampaUI'])

@php
    $snippet = <<<'BLADE'
<div class="mx-auto max-w-xl p-4">
    <x-sampaui::card padding="lg" class="shadow-default">
        <div class="mb-7 text-center">
            <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-default bg-light text-3xl text-primary">
                <i class="bi bi-shield-check" aria-hidden="true"></i>
            </span>
            <h2 class="mt-5 text-2xl font-semibold text-primary">Confirme seu acesso</h2>
            <p class="mt-2 text-sm leading-6 text-secondary">Digite o código de 6 dígitos enviado para seu telefone.</p>
        </div>

        <form wire:submit.prevent="confirmCode" class="space-y-6">
            <x-sampaui::alert variant="info" title="Código enviado com sucesso">
                O código expira em 5 minutos. Solicite outro caso não tenha recebido.
            </x-sampaui::alert>

            <x-sampaui::pin
                name="verification_code"
                label="Código de verificação"
                hint="Digite os 6 dígitos numéricos"
                length="6"
                numbers
                clear
                wire:model.live="code"
                required
            />

            <x-sampaui::progress
                label="Tempo restante para expiração"
                :value="$timeRemainingPercentage"
                show-value
                variant="warning"
            />

            <x-sampaui::button type="submit" icon="shield-check" :loading="$isVerifying" full>
                Validar acesso
            </x-sampaui::button>

            <x-sampaui::button type="button" variant="outline" icon="arrow-clockwise" wire:click="resendCode" full>
                Reenviar código
            </x-sampaui::button>
        </form>
    </x-sampaui::card>
</div>
BLADE;

    $livewireSnippet = <<<'PHP'
namespace App\Livewire;

use Livewire\Component;

class TwoFactorVerification extends Component
{
    public string $code = '';
    public int $timeRemainingPercentage = 65;
    public bool $isVerifying = false;

    public function confirmCode(): void
    {
        $this->validate([
            'code' => 'required|min:6|max:6',
        ]);

        $this->isVerifying = true;

        if ($this->code === '123456') {
            session()->flash('success', 'Acesso validado com sucesso!');
            $this->redirect(route('dashboard'));
            return;
        }

        $this->isVerifying = false;
        $this->addError('code', 'Código de verificação inválido ou expirado.');
    }

    public function resendCode(): void
    {
        // Reenviar SMS/WhatsApp...
        $this->reset('code');
        session()->flash('info', 'Um novo código foi enviado.');
    }

    public function render()
    {
        return view('livewire.two-factor-verification');
    }
}
PHP;
@endphp

@section('content')
    <section class="doc-component-intro-grid">
        <article class="doc-hero-card">
            <div class="relative z-[1]">
                <p class="doc-kicker">Exemplo</p>
                <h1 class="mt-3 text-3xl font-semibold tracking-tight text-primary md:text-4xl">Verificação 2FA</h1>
                <p class="mt-4 max-w-3xl text-sm leading-6 text-secondary">
                    Fluxo de confirmação com código PIN, feedback de envio, progresso e ações de reenvio.
                </p>
            </div>
        </article>
    </section>

    <section class="space-y-7">
        <div class="mx-auto max-w-xl">
            <x-sampaui::card padding="lg" class="shadow-default">
                <div class="mb-7 text-center">
                    <span class="mx-auto flex h-16 w-16 items-center justify-center rounded-default bg-light text-3xl text-primary">
                        <i class="bi bi-shield-check" aria-hidden="true"></i>
                    </span>
                    <h2 class="mt-5 text-2xl font-semibold text-primary">Confirme seu acesso</h2>
                    <p class="mt-2 text-sm leading-6 text-secondary">Digite o código enviado para o WhatsApp final 8421.</p>
                </div>

                <form class="space-y-6">
                    <x-sampaui::alert variant="info" title="Código enviado">
                        O código expira em poucos minutos. Solicite outro caso não receba.
                    </x-sampaui::alert>

                    <x-sampaui::pin name="verification_code" label="Código de verificação" hint="Use somente números" length="6" numbers clear />

                    <x-sampaui::progress label="Tempo restante" :value="62" show-value variant="warning" />

                    <x-sampaui::button type="submit" icon="shield-check" full>Validar acesso</x-sampaui::button>
                    <x-sampaui::button type="button" variant="outline" icon="arrow-clockwise" full>Reenviar código</x-sampaui::button>
                </form>
            </x-sampaui::card>
        </div>

        @include('pages.examples.partials.code', [
            'snippet' => $snippet,
            'livewireSnippet' => $livewireSnippet,
            'codeTitle' => 'Código de Verificação 2FA (PIN)',
            'description' => 'Tela de confirmação de código OTP de 6 dígitos com máscara, barra de expiração e reenvio assíncrono.',
            'components' => ['card', 'alert', 'pin', 'progress', 'button'],
        ])
    </section>
@endsection
