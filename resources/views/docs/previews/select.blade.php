<div class="space-y-4">
    <x-sampaui::select
        name="pipeline_status"
        label="Status do pipeline"
        placeholder="Escolha uma etapa"
    >
        <option value="lead">Lead</option>
        <option value="qualified">Qualificado</option>
        <option value="proposal">Proposta</option>
        <option value="won">Fechado</option>
    </x-sampaui::select>

    <x-sampaui::select
        name="owner"
        label="Responsavel"
        error="Selecione um responsavel para seguir."
    >
        <option value="ana">Ana</option>
        <option value="bruno">Bruno</option>
    </x-sampaui::select>
</div>
