@extends('docs.layout', ['title' => $title ?? 'Formulário administrativo · Documentação SampaUI'])

@php
    $snippet = <<<'BLADE'
<form wire:submit.prevent="save" class="space-y-7">
    <x-sampaui::input name="name" label="Nome do cliente" icon="person" wire:model.live="name" required />
    <x-sampaui::phone name="phone" label="WhatsApp" wire:model.live="phone" />
    <x-sampaui::currency-br name="budget" label="Orcamento" wire:model.live="budget" />
    <x-sampaui::cep name="cep" label="CEP" wire:model.live="cep" />
    <x-sampaui::select-search name="owner" label="Responsavel" :options="$owners" wire:model.live="owner" />
    <x-sampaui::select-multiple name="tags" label="Interesses" :options="$tags" wire:model.live="tags" />
    <x-sampaui::textarea name="notes" label="Observacoes" wire:model.live.debounce.500ms="notes" />
    <x-sampaui::button type="submit" icon="check2-circle">Salvar cadastro</x-sampaui::button>
</form>
BLADE;

    $owners = [
        ['label' => 'Ana Martins', 'value' => 'ana'],
        ['label' => 'Bruno Lima', 'value' => 'bruno'],
        ['label' => 'Carla Souza', 'value' => 'carla'],
    ];
    $tags = [
        ['label' => 'Apartamento', 'value' => 'apartment'],
        ['label' => 'Casa', 'value' => 'house'],
        ['label' => 'Alto padrão', 'value' => 'premium'],
        ['label' => 'Financiamento', 'value' => 'finance'],
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
                    <x-sampaui::select-multiple name="interests" label="Interesses" :options="$tags" :value="['apartment', 'finance']" />
                </div>

                <x-sampaui::textarea name="notes" label="Observações" rows="5" placeholder="Detalhe preferências, restrições de agenda e próximos passos." />

                <div class="flex flex-col-reverse gap-3 border-t border-light pt-6 sm:flex-row sm:justify-end">
                    <x-sampaui::button type="button" variant="outline" icon="x-lg">Cancelar</x-sampaui::button>
                    <x-sampaui::button type="submit" icon="check2-circle">Salvar cadastro</x-sampaui::button>
                </div>
            </form>
        </x-sampaui::card>

        @include('pages.examples.partials.code', ['snippet' => $snippet])
    </section>
@endsection
