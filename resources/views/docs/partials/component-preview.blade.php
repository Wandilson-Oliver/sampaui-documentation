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
    @case('property-card')
    @case('property-gallery')
    @case('property-features')
    @case('property-status')
    @case('property-price')
        <div class="doc-real-estate-preview doc-real-estate-preview-property">
            <div class="doc-real-estate-image-stack"><span></span><span></span><span></span></div>
            <div><strong>{{ str($slug)->headline() }}</strong><small>Imóvel · API proposta</small></div>
            <x-sampaui::badge variant="success" size="sm">Planejado</x-sampaui::badge>
        </div>
        @break
    @case('lead-card')
    @case('lead-pipeline')
    @case('lead-status')
        <div class="doc-real-estate-preview doc-real-estate-preview-lead">
            <div class="doc-real-estate-pipeline"><span></span><span></span><span></span><span></span></div>
            <div><strong>{{ str($slug)->headline() }}</strong><small>Funil comercial</small></div>
            <x-sampaui::badge variant="accent" size="sm">Roadmap</x-sampaui::badge>
        </div>
        @break
    @case('client-card')
    @case('broker-card')
        <div class="doc-real-estate-preview doc-real-estate-preview-person">
            <span class="doc-real-estate-avatar"><i class="bi bi-person-badge" aria-hidden="true"></i></span>
            <div><strong>{{ str($slug)->headline() }}</strong><small>Relacionamento</small></div>
            <x-sampaui::badge variant="info" size="sm">Planejado</x-sampaui::badge>
        </div>
        @break
    @case('proposal-card')
    @case('visit-timeline')
    @case('commission-card')
    @case('real-estate-dashboard-widgets')
        <div class="doc-real-estate-preview doc-real-estate-preview-operation">
            <div class="doc-real-estate-metrics"><span></span><span></span><span></span></div>
            <div><strong>{{ str($slug)->headline() }}</strong><small>Operação imobiliária</small></div>
            <x-sampaui::badge variant="purple" size="sm">Planejado</x-sampaui::badge>
        </div>
        @break
    @default
        <div class="doc-fallback-preview">
            <i class="bi bi-{{ \App\Support\DocumentationGuidance::icon($slug) }}" aria-hidden="true"></i>
            <span>{{ \App\Support\DocumentationGuidance::category($slug) }}</span>
        </div>
@endswitch
