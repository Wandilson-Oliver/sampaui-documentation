@extends('docs.layout', ['title' => $title ?? 'Modal destrutivo · Documentação SampaUI'])

@php
    $snippet = <<<'BLADE'
<x-sampaui::button variant="danger" icon="trash3" wire:click="$set('confirmingDelete', true)">
    Excluir cliente
</x-sampaui::button>

<x-sampaui::modal
    model="confirmingDelete"
    title="Excluir cliente?"
    subtitle="Esta ação não poderá ser desfeita."
    size="md"
    variant="danger"
    persistent
>
    <x-sampaui::alert variant="danger" title="Atenção">
        Todos os dados associados serão removidos permanentemente.
    </x-sampaui::alert>

    <x-slot:actions>
        <x-sampaui::button variant="outline" wire:click="$set('confirmingDelete', false)">Cancelar</x-sampaui::button>
        <x-sampaui::button variant="danger" icon="trash3" wire:click="delete" wire:loading.attr="disabled">Excluir</x-sampaui::button>
    </x-slot:actions>
</x-sampaui::modal>
BLADE;
@endphp

@section('content')
    <section class="doc-component-intro-grid">
        <article class="doc-hero-card">
            <div class="relative z-[1]">
                <p class="doc-kicker">Exemplo</p>
                <h1 class="mt-3 text-3xl font-semibold tracking-tight text-primary md:text-4xl">Modal destrutivo</h1>
                <p class="mt-4 max-w-3xl text-sm leading-6 text-secondary">
                    Confirmação crítica com contraste de perigo, mensagem clara e bloqueio por backdrop para evitar exclusões acidentais.
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
        <x-sampaui::card title="Cliente selecionado" description="Preview funcional do fluxo de exclusão" padding="lg" class="shadow-default">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex items-center gap-4">
                    <x-sampaui::avatar name="Mariana Oliveira" size="lg" status="online" />
                    <div>
                        <h2 class="text-xl font-semibold text-primary">Mariana Oliveira</h2>
                        <p class="text-sm text-secondary">Contrato ativo · mariana@email.com</p>
                    </div>
                </div>
                <x-sampaui::button variant="danger" icon="trash3" x-on:click="showDialog($refs.deleteDialog)">Excluir cliente</x-sampaui::button>
            </div>
        </x-sampaui::card>

        <dialog
            x-ref="deleteDialog"
            class="fixed inset-0 z-[2147483647] m-0 h-screen min-h-dvh w-screen max-h-none max-w-none overflow-y-auto bg-transparent p-0 text-secondary outline-none backdrop:bg-primary/40 backdrop:backdrop-blur-[2px]"
            x-on:cancel.prevent
        >
            <div class="flex min-h-dvh items-center justify-center p-4 sm:p-6">
                <section class="w-full max-w-md rounded-default border border-danger bg-white">
                    <header class="flex items-start justify-between gap-4 px-5 py-5">
                        <div>
                            <h2 class="text-lg font-semibold text-primary">Excluir cliente?</h2>
                            <p class="mt-1 text-sm text-secondary">Esta ação não poderá ser desfeita.</p>
                        </div>
                        <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-full text-secondary hover:text-primary" x-on:click="closeDialog($refs.deleteDialog)" aria-label="Fechar">
                            <i class="bi bi-x-lg" aria-hidden="true"></i>
                        </button>
                    </header>

                    <div class="space-y-5 px-5 py-5">
                        <x-sampaui::alert variant="danger" title="Atenção">
                            Todos os dados associados ao cliente serão removidos permanentemente.
                        </x-sampaui::alert>
                        <x-sampaui::input name="confirm_name" label="Digite EXCLUIR para confirmar" placeholder="EXCLUIR" />
                    </div>

                    <footer class="flex flex-col-reverse gap-3 px-5 py-4 sm:flex-row sm:justify-end">
                        <x-sampaui::button variant="outline" x-on:click="closeDialog($refs.deleteDialog)">Cancelar</x-sampaui::button>
                        <x-sampaui::button variant="danger" icon="trash3" x-on:click="closeDialog($refs.deleteDialog)">Excluir</x-sampaui::button>
                    </footer>
                </section>
            </div>
        </dialog>

        @include('pages.examples.partials.code', ['snippet' => $snippet])
    </section>
@endsection
