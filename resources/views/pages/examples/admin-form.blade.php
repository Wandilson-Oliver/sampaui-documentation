@extends('docs.layout', ['title' => $title ?? 'Formulário administrativo · Documentação SampaUI'])

@php
    $snippet = <<<'BLADE'
<x-sampaui::card title="Cadastro de cliente" description="Dados comerciais, contato, endereço e preferências" padding="lg">
    <form wire:submit.prevent="save" class="space-y-7">
        {{-- Dados Pessoais / Principais --}}
        <div class="grid gap-5 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-sampaui::input
                    name="client_name"
                    label="Nome do cliente"
                    icon="person"
                    placeholder="Mariana Oliveira"
                    wire:model.live="name"
                    required
                />
            </div>

            <x-sampaui::select
                name="client_status"
                label="Status"
                :options="[
                    ['label' => 'Novo lead', 'value' => 'new'],
                    ['label' => 'Em atendimento', 'value' => 'active'],
                    ['label' => 'Contrato', 'value' => 'contract'],
                ]"
                wire:model.live="status"
            />

            <x-sampaui::input
                name="client_email"
                type="email"
                label="Email"
                icon="envelope"
                placeholder="mariana@email.com"
                wire:model.live="email"
                required
            />

            <x-sampaui::phone
                name="client_phone"
                label="WhatsApp"
                icon="whatsapp"
                placeholder="(11) 9 9999-0000"
                wire:model.live="phone"
            />

            <x-sampaui::currency-br
                name="client_budget"
                label="Orçamento previsto"
                icon="cash-coin"
                placeholder="R$ 850.000,00"
                wire:model.live="budget"
            />
        </div>

        {{-- Endereço com CEP com auto-busca --}}
        <div class="grid gap-5 lg:grid-cols-[12rem_minmax(0,1fr)_12rem]">
            <x-sampaui::cep
                name="client_cep"
                label="CEP"
                placeholder="01001-000"
                wire:model.live="cep"
            />

            <x-sampaui::input
                name="client_address"
                label="Endereço"
                icon="geo-alt"
                placeholder="Rua Boa Vista"
                wire:model.live="address"
            />

            <x-sampaui::input
                name="client_number"
                label="Número"
                placeholder="120"
                wire:model.live="number"
            />
        </div>

        {{-- Seletores Especializados --}}
        <div class="grid gap-5 lg:grid-cols-2">
            <x-sampaui::select-search
                name="owner"
                label="Responsável"
                :options="[
                    ['label' => 'Ana Martins', 'value' => 'ana'],
                    ['label' => 'Bruno Lima', 'value' => 'bruno'],
                    ['label' => 'Carla Souza', 'value' => 'carla'],
                ]"
                search-placeholder="Buscar consultor"
                wire:model.live="owner"
            />

            <x-sampaui::select-multiple
                name="interests"
                label="Interesses / Tags"
                :options="[
                    ['label' => 'Implantação', 'value' => 'implementation'],
                    ['label' => 'Integração', 'value' => 'integration'],
                    ['label' => 'Enterprise', 'value' => 'enterprise'],
                    ['label' => 'Treinamento', 'value' => 'training'],
                ]"
                wire:model.live="interests"
            />
        </div>

        {{-- Observações --}}
        <x-sampaui::textarea
            name="notes"
            label="Observações"
            rows="5"
            placeholder="Detalhe preferências, restrições de agenda e próximos passos."
            wire:model.live.debounce.500ms="notes"
        />

        {{-- Ações do Formulário --}}
        <div class="flex flex-col-reverse gap-3 border-t border-border pt-6 sm:flex-row sm:justify-end">
            <x-sampaui::button type="button" variant="outline" icon="x-lg" wire:click="cancel">Cancelar</x-sampaui::button>
            <x-sampaui::button type="submit" icon="check2-circle">Salvar cadastro</x-sampaui::button>
        </div>
    </form>
</x-sampaui::card>
BLADE;

    $livewireSnippet = <<<'PHP'
namespace App\Livewire;

use Livewire\Component;

class ClientForm extends Component
{
    public string $name = '';
    public string $status = 'active';
    public string $email = '';
    public string $phone = '';
    public string $budget = '';
    public string $cep = '';
    public string $address = '';
    public string $number = '';
    public string $owner = 'ana';
    public array $interests = ['implementation', 'training'];
    public string $notes = '';

    public function save(): void
    {
        $validated = $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'status' => 'required',
            'phone' => 'nullable',
            'budget' => 'nullable',
            'cep' => 'nullable|min:8',
            'address' => 'nullable',
            'owner' => 'required',
            'interests' => 'array',
            'notes' => 'nullable|max:1000',
        ]);

        // Persistir dados no banco...
        session()->flash('success', 'Cliente cadastrado com sucesso!');
    }

    public function cancel(): void
    {
        $this->reset();
    }

    public function render()
    {
        return view('livewire.client-form');
    }
}
PHP;

    $owners = [
        ['label' => 'Ana Martins', 'value' => 'ana'],
        ['label' => 'Bruno Lima', 'value' => 'bruno'],
        ['label' => 'Carla Souza', 'value' => 'carla'],
    ];
    $tags = [
        ['label' => 'Implantação', 'value' => 'implementation'],
        ['label' => 'Integração', 'value' => 'integration'],
        ['label' => 'Enterprise', 'value' => 'enterprise'],
        ['label' => 'Treinamento', 'value' => 'training'],
    ];
@endphp

@section('content')
    <section class="doc-component-intro-grid">
        <article class="doc-hero-card">
            <div class="relative z-[1]">
                <p class="doc-kicker">Exemplo</p>
                <h1 class="mt-3 text-3xl font-semibold tracking-tight text-primary md:text-4xl">Formulário administrativo</h1>
                <p class="mt-4 max-w-3xl text-sm leading-6 text-secondary">
                    Cadastro amplo com campos especializados, validação visual e layout responsivo para fluxos internos.
                </p>
            </div>
        </article>
    </section>

    <section class="space-y-7">
        <x-sampaui::card title="Cadastro de cliente" description="Dados comerciais, contato, endereco e preferencias" padding="lg" class="shadow-default">
            <form class="space-y-7">
                <div class="grid gap-5 lg:grid-cols-3">
                    <div class="lg:col-span-2">
                        <x-sampaui::input name="client_name" label="Nome do cliente" icon="person" placeholder="Mariana Oliveira" required />
                    </div>
                    <x-sampaui::select name="client_status" label="Status" :options="[
                        ['label' => 'Novo lead', 'value' => 'new'],
                        ['label' => 'Em atendimento', 'value' => 'active'],
                        ['label' => 'Contrato', 'value' => 'contract'],
                    ]" value="active" />
                    <x-sampaui::input name="client_email" type="email" label="Email" icon="envelope" placeholder="mariana@email.com" />
                    <x-sampaui::phone name="client_phone" label="WhatsApp" icon="whatsapp" placeholder="(11) 9 9999-0000" />
                    <x-sampaui::currency-br name="client_budget" label="Orçamento" icon="cash-coin" placeholder="R$ 850.000,00" />
                </div>

                <div class="grid gap-5 lg:grid-cols-[12rem_minmax(0,1fr)_12rem]">
                    <x-sampaui::cep name="client_cep" label="CEP" placeholder="01001-000" />
                    <x-sampaui::input name="client_address" label="Endereco" icon="geo-alt" placeholder="Rua Boa Vista" />
                    <x-sampaui::input name="client_number" label="Numero" placeholder="120" />
                </div>

                <div class="grid gap-5 lg:grid-cols-2">
                    <x-sampaui::select-search name="owner" label="Responsável" :options="$owners" value="ana" search-placeholder="Buscar consultor" />
                    <x-sampaui::select-multiple name="interests" label="Interesses" :options="$tags" :value="['implementation', 'training']" />
                </div>

                <x-sampaui::textarea name="notes" label="Observações" rows="5" placeholder="Detalhe preferências, restrições de agenda e próximos passos." />

                <div class="flex flex-col-reverse gap-3 border-t border-border pt-6 sm:flex-row sm:justify-end">
                    <x-sampaui::button type="button" variant="outline" icon="x-lg">Cancelar</x-sampaui::button>
                    <x-sampaui::button type="submit" icon="check2-circle">Salvar cadastro</x-sampaui::button>
                </div>
            </form>
        </x-sampaui::card>

        @include('pages.examples.partials.code', [
            'snippet' => $snippet,
            'livewireSnippet' => $livewireSnippet,
            'codeTitle' => 'Código do Formulário Administrativo',
            'description' => 'Formulário completo com auto-completar de CEP, máscara de WhatsApp, moeda brasileira, select search e multiselect.',
            'components' => ['card', 'input', 'select', 'phone', 'currency-br', 'cep', 'select-search', 'select-multiple', 'textarea', 'button'],
        ])
    </section>
@endsection
