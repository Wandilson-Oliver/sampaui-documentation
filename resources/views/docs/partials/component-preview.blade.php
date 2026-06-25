@switch($slug)
    @case('button')
        <div class="doc-mini-actions">
            <x-sampaui::button size="sm">Salvar</x-sampaui::button>
            <x-sampaui::button size="sm" variant="outline">Editar</x-sampaui::button>
            <x-sampaui::button size="sm" variant="danger" icon="trash3" aria-label="Excluir" />
        </div>
        @break
    @case('input')
        <x-sampaui::input name="preview_name" label="Nome completo" icon="person" placeholder="Ana Souza" />
        @break
    @case('select')
        <x-sampaui::select name="preview_stage" label="Etapa do funil" :options="['lead' => 'Novo lead', 'visit' => 'Visita', 'proposal' => 'Proposta']" value="visit" />
        @break
    @case('badge')
        <div class="doc-mini-badges">
            <x-sampaui::badge variant="success">Disponível</x-sampaui::badge>
            <x-sampaui::badge variant="warning">Visita</x-sampaui::badge>
            <x-sampaui::badge variant="danger">Urgente</x-sampaui::badge>
        </div>
        @break
    @case('table')
        <div class="doc-mini-table">
            <div><span>Cliente</span><span>Status</span></div>
            <div><span>Ana Souza</span><x-sampaui::badge variant="success" size="sm">Ativo</x-sampaui::badge></div>
            <div><span>Bruno Lima</span><x-sampaui::badge variant="accent" size="sm">Proposta</x-sampaui::badge></div>
        </div>
        @break
    @case('modal')
        <div class="doc-mini-modal">
            <span><i class="bi bi-check2-circle" aria-hidden="true"></i></span>
            <div><strong>Proposta aprovada</strong><small>O cliente será notificado.</small></div>
        </div>
        @break
    @default
        <div class="doc-fallback-preview">
            <i class="bi bi-{{ \App\Support\DocumentationGuidance::icon($slug) }}" aria-hidden="true"></i>
            <span>{{ \App\Support\DocumentationGuidance::category($slug) }}</span>
        </div>
@endswitch
