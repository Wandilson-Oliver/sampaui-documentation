<div class="space-y-4">
    <x-sampaui::alert title="Container de exemplo">
        O Toast deve ser instalado uma vez no layout e acionado pelo evento browser `toast`.
    </x-sampaui::alert>

    <div class="flex flex-wrap gap-3">
        <x-sampaui::button
            size="sm"
            icon="bell"
            onclick="window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'success', title: 'Toast aberto', message: 'O componente foi acionado pelo botao.' } }))"
        >
            Abrir toast
        </x-sampaui::button>

        <x-sampaui::button
            size="sm"
            variant="outline"
            icon="exclamation-triangle"
            onclick="window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'warning', title: 'Atencao', message: 'Revise antes de continuar.', duration: 5000 } }))"
        >
            Aviso
        </x-sampaui::button>
    </div>

    <x-sampaui::toast position="bottom-right" max="3" />
</div>
