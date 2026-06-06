<x-sampaui::card
    title="Publicacao"
    description="Status do componente no pacote"
    variant="primary"
>
    <x-slot:actions>
        <x-sampaui::button size="sm" variant="outline" icon="box-arrow-up-right" icon-position="right">
            Abrir
        </x-sampaui::button>
    </x-slot:actions>

    <div class="space-y-3 text-sm text-secondary">
        <div class="flex items-center justify-between gap-4">
            <span>Build CSS</span>
            <strong class="text-primary">Pronto</strong>
        </div>
        <div class="flex items-center justify-between gap-4">
            <span>Documentacao</span>
            <strong class="text-primary">Atualizada</strong>
        </div>
    </div>

    <x-slot:footer>
        <span class="text-sm text-secondary">Ultima verificacao agora.</span>
    </x-slot:footer>
</x-sampaui::card>
