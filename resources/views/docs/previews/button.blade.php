<div class="space-y-4">
    <x-sampaui::button icon="plus-circle">Novo atendimento</x-sampaui::button>

    <div class="grid gap-3 sm:grid-cols-2">
        <x-sampaui::button variant="outline" icon="box-arrow-up-right" icon-position="right">
            Abrir portal
        </x-sampaui::button>

        <x-sampaui::button variant="secondary" icon="gear" rounded>
            Configurar
        </x-sampaui::button>

        <x-sampaui::button href="/examples" wire:navigate variant="outline" icon="arrow-right">
            Ver exemplos
        </x-sampaui::button>
    </div>

    <div class="grid gap-3 sm:grid-cols-2">
        <x-sampaui::button loading>Sincronizando</x-sampaui::button>
        <x-sampaui::button icon="heart-fill" aria-label="Favoritar atendimento" />
    </div>
</div>
