<div class="space-y-4">
    <x-sampaui::textarea
        name="summary"
        label="Resumo do atendimento"
        rows="5"
        placeholder="Registre o contexto do cliente"
    />

    <x-sampaui::textarea name="briefing" label="Briefing interno" rows="4">
Cliente quer centralizar atendimento e comercial em um fluxo unico.
    </x-sampaui::textarea>

    <x-sampaui::textarea
        name="notes"
        label="Observacoes"
        error="Inclua um resumo antes de concluir."
    />
</div>
