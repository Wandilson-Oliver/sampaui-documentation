<div class="doc-modal-live-preview">
    <x-sampaui::button wire:click="$set('open', true)">Abrir modal</x-sampaui::button>

    <x-sampaui::modal model="open" :title="$title" subtitle="Preview Livewire real do SampaUI.">
        Confirme os dados antes de enviar a proposta ao cliente.

        <x-slot:actions>
            <x-sampaui::button variant="outline" wire:click="$set('open', false)">Cancelar</x-sampaui::button>
            <x-sampaui::button wire:click="$set('open', false)">Confirmar</x-sampaui::button>
        </x-slot:actions>
    </x-sampaui::modal>
</div>
