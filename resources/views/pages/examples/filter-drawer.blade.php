@extends('docs.layout', ['title' => $title ?? 'Drawer de filtros · Documentação SampaUI'])

@php
    $snippet = <<<'BLADE'
<div class="space-y-6">
    {{-- Card com Botão de Abertura do Drawer --}}
    <x-sampaui::card title="Listagem comercial" description="Use o drawer lateral para filtrar oportunidades" padding="lg">
        <x-slot:actions>
            <x-sampaui::button variant="outline" icon="sliders2" wire:click="$set('showFilters', true)">
                Filtros avançados
            </x-sampaui::button>
        </x-slot:actions>

        {{-- Badges de Filtros Ativos --}}
        <div class="flex flex-wrap gap-2">
            <x-sampaui::badge variant="primary" icon="funnel">Status: ativo</x-sampaui::badge>
            <x-sampaui::badge variant="accent" icon="calendar-event">Últimos 30 dias</x-sampaui::badge>
            <x-sampaui::badge variant="success" icon="stars">Leads quentes</x-sampaui::badge>
        </div>
    </x-sampaui::card>

    {{-- Gaveta Lateral (Drawer) com Formulário de Filtros --}}
    <x-sampaui::drawer
        model="showFilters"
        title="Filtros avançados"
        subtitle="Refine a listagem de oportunidades em tempo real"
        placement="right"
        size="lg"
    >
        <div class="space-y-5">
            <x-sampaui::select
                name="status"
                label="Status do lead"
                :options="[
                    ['label' => 'Todos os status', 'value' => ''],
                    ['label' => 'Ativo', 'value' => 'active'],
                    ['label' => 'Pendente', 'value' => 'pending'],
                    ['label' => 'Convertido', 'value' => 'converted'],
                ]"
                wire:model.live="status"
            />

            <div class="grid gap-4 sm:grid-cols-2">
                <x-sampaui::date-picker
                    name="start_date"
                    label="Data inicial"
                    placeholder="dd/mm/aaaa"
                    clearable
                    wire:model.live="startDate"
                />
                <x-sampaui::date-picker
                    name="end_date"
                    label="Data final"
                    placeholder="dd/mm/aaaa"
                    clearable
                    wire:model.live="endDate"
                />
            </div>

            <x-sampaui::checkbox
                name="only_hot"
                label="Somente leads com alta prioridade"
                wire:model.live="onlyHot"
            />

            <x-sampaui::checkbox
                name="with_visit"
                label="Com reunião/visita agendada"
                wire:model.live="withVisit"
            />

            <x-sampaui::select-multiple
                name="channels"
                label="Canais de aquisição"
                :options="[
                    ['label' => 'WhatsApp', 'value' => 'whatsapp'],
                    ['label' => 'Site Orgânico', 'value' => 'site'],
                    ['label' => 'Indicação', 'value' => 'referral'],
                    ['label' => 'Google Ads', 'value' => 'ads'],
                ]"
                wire:model.live="channels"
            />
        </div>

        <x-slot:actions>
            <x-sampaui::button variant="outline" wire:click="resetFilters">Limpar</x-sampaui::button>
            <x-sampaui::button wire:click="applyFilters">Aplicar filtros</x-sampaui::button>
        </x-slot:actions>
    </x-sampaui::drawer>
</div>
BLADE;

    $livewireSnippet = <<<'PHP'
namespace App\Livewire;

use Livewire\Component;

class OpportunitiesList extends Component
{
    public bool $showFilters = false;
    public string $status = '';
    public string $startDate = '';
    public string $endDate = '';
    public bool $onlyHot = true;
    public bool $withVisit = false;
    public array $channels = ['whatsapp'];

    public function applyFilters(): void
    {
        // Aplicar filtros na consulta...
        $this->showFilters = false;
    }

    public function resetFilters(): void
    {
        $this->reset(['status', 'startDate', 'endDate', 'onlyHot', 'withVisit', 'channels']);
    }

    public function render()
    {
        return view('livewire.opportunities-list');
    }
}
PHP;
@endphp

@section('content')
    <section class="doc-component-intro-grid">
        <article class="doc-hero-card">
            <div class="relative z-[1]">
                <p class="doc-kicker">Exemplo</p>
                <h1 class="mt-3 text-3xl font-semibold tracking-tight text-primary md:text-4xl">Drawer de filtros</h1>
                <p class="mt-4 max-w-3xl text-sm leading-6 text-secondary">
                    Painel lateral para filtrar uma listagem sem tirar o usuário da tabela principal.
                </p>
            </div>
        </article>
    </section>

    <section
        class="space-y-7"
        x-data="{
            showDialog(dialog) {
                if (typeof dialog.showModal === 'function') {
                    dialog.showModal();
                    return;
                }

                dialog.setAttribute('open', '');
            },
            closeDialog(dialog) {
                if (typeof dialog.close === 'function') {
                    dialog.close();
                    return;
                }

                dialog.removeAttribute('open');
            },
        }"
    >
        <x-sampaui::card title="Listagem comercial" description="Use o drawer para segmentar os registros" padding="lg" class="shadow-default">
            <x-slot:actions>
                <x-sampaui::button variant="outline" icon="sliders2" x-on:click="showDialog($refs.filterDrawer)">Filtros</x-sampaui::button>
            </x-slot:actions>

            <div class="mb-5 flex flex-wrap gap-2">
                <x-sampaui::badge variant="primary" icon="funnel">Status: ativo</x-sampaui::badge>
                <x-sampaui::badge variant="accent" icon="calendar-event">Últimos 30 dias</x-sampaui::badge>
                <x-sampaui::badge variant="success" icon="stars">Leads quentes</x-sampaui::badge>
            </div>

            <div class="grid gap-4 md:grid-cols-3">
                <x-sampaui::card title="Encontrados" padding="md"><p class="text-3xl font-semibold text-primary">248</p></x-sampaui::card>
                <x-sampaui::card title="Alta prioridade" padding="md"><p class="text-3xl font-semibold text-danger">31</p></x-sampaui::card>
                <x-sampaui::card title="Com visita" padding="md"><p class="text-3xl font-semibold text-success">74</p></x-sampaui::card>
            </div>
        </x-sampaui::card>

        <dialog
            x-ref="filterDrawer"
            class="fixed inset-0 z-[2147483647] m-0 h-screen min-h-dvh w-screen max-h-none max-w-none overflow-hidden bg-transparent p-0 text-secondary outline-none backdrop:bg-secondary/25 backdrop:backdrop-blur-[2px]"
        >
            <div class="flex min-h-dvh justify-end">
                <section class="flex h-dvh w-full max-w-lg flex-col rounded-l-default border-l border-border bg-white">
                    <header class="flex items-start justify-between gap-4 px-5 py-5">
                        <div>
                            <h2 class="text-lg font-semibold text-primary">Filtros</h2>
                            <p class="mt-1 text-sm text-secondary">Refine a listagem de oportunidades.</p>
                        </div>
                        <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-full text-secondary hover:text-primary" x-on:click="closeDialog($refs.filterDrawer)" aria-label="Fechar">
                            <i class="bi bi-x-lg" aria-hidden="true"></i>
                        </button>
                    </header>

                    <div class="min-h-0 flex-1 space-y-5 overflow-y-auto px-5 py-5">
                        <x-sampaui::select name="drawer_status" label="Status" :options="[
                            ['label' => 'Todos', 'value' => ''],
                            ['label' => 'Ativo', 'value' => 'active'],
                            ['label' => 'Pendente', 'value' => 'pending'],
                        ]" />
                        <div class="grid gap-4 sm:grid-cols-2">
                            <x-sampaui::date-picker name="drawer_start" label="Data inicial" clearable />
                            <x-sampaui::date-picker name="drawer_end" label="Data final" clearable />
                        </div>
                        <x-sampaui::checkbox name="drawer_hot" label="Somente leads quentes" checked />
                        <x-sampaui::checkbox name="drawer_visit" label="Com visita agendada" />
                        <x-sampaui::select-multiple name="drawer_channels" label="Canais" :options="[
                            ['label' => 'WhatsApp', 'value' => 'whatsapp'],
                            ['label' => 'Site', 'value' => 'site'],
                            ['label' => 'Indicação', 'value' => 'referral'],
                        ]" :value="['whatsapp']" />
                    </div>

                    <footer class="flex flex-col-reverse gap-3 px-5 py-4 sm:flex-row sm:justify-end">
                        <x-sampaui::button variant="outline">Limpar</x-sampaui::button>
                        <x-sampaui::button x-on:click="closeDialog($refs.filterDrawer)">Aplicar filtros</x-sampaui::button>
                    </footer>
                </section>
            </div>
        </dialog>

        @include('pages.examples.partials.code', [
            'snippet' => $snippet,
            'livewireSnippet' => $livewireSnippet,
            'codeTitle' => 'Código do Drawer de Filtros',
            'description' => 'Gaveta lateral deslizante integrada ao Livewire com seletores de data, checkboxes e múltiplos canais.',
            'components' => ['card', 'button', 'drawer', 'select', 'date-picker', 'checkbox', 'select-multiple', 'badge'],
        ])
    </section>
@endsection
