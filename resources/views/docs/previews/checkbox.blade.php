<div class="space-y-4">
    <x-sampaui::checkbox
        name="receive_updates"
        checked
        color="accent"
        label="Receber atualizacoes do produto"
    />

    <x-sampaui::checkbox name="terms" color="secondary">
        Concordo com os <a href="#" class="font-medium text-primary underline">termos de uso</a>.
    </x-sampaui::checkbox>

    <x-sampaui::checkbox
        name="privacy"
        color="danger"
        error="Voce precisa aceitar a politica para continuar."
        label="Confirmo o tratamento dos meus dados"
    />
</div>
