@props(['slug'])

@php
    $enabledSlugs = ['button', 'input', 'select', 'badge', 'table', 'modal'];
    $buttonVariants = ['primary', 'secondary', 'accent', 'danger', 'success', 'info', 'purple', 'outline', 'ghost'];
    $badgeVariants = ['primary', 'success', 'warning', 'danger', 'info', 'purple', 'light'];
    $sizes = ['sm', 'md', 'lg'];
@endphp

@if (in_array($slug, $enabledSlugs, true))
    <article class="doc-interactive-playground" x-data="componentPlayground(@js($slug))">
        <header>
            <div>
                <span class="doc-kicker">Playground interativo</span>
                <h3>Teste variações reais</h3>
                <p>O preview usa componentes SampaUI renderizados pelo Blade. Os controles alternam estados e atualizam o código sugerido.</p>
            </div>
            <x-sampaui::badge variant="info" size="sm">Componente real</x-sampaui::badge>
        </header>

        <div class="doc-interactive-grid">
            <div class="doc-interactive-controls">
                <label x-show="supportsVariant">
                    <span>Variant</span>
                    <select x-model="variant">
                        <template x-for="option in variants" x-bind:key="option">
                            <option x-bind:value="option" x-text="option"></option>
                        </template>
                    </select>
                </label>

                <label x-show="supportsSize">
                    <span>Size</span>
                    <select x-model="size">
                        <template x-for="option in sizes" x-bind:key="option">
                            <option x-bind:value="option" x-text="option"></option>
                        </template>
                    </select>
                </label>

                <label>
                    <span>Label</span>
                    <input type="text" x-model="label">
                </label>

                <label x-show="supportsIcon">
                    <span>Icon</span>
                    <select x-model="icon">
                        <option value="">Sem ícone</option>
                        <option value="check2-circle">check2-circle</option>
                        <option value="plus">plus</option>
                        <option value="download">download</option>
                    </select>
                </label>

                <div class="doc-interactive-switches">
                    <label x-show="supportsLoading"><input type="checkbox" x-model="loading"> Loading</label>
                    <label><input type="checkbox" x-model="disabled"> Disabled</label>
                    <label x-show="supportsError"><input type="checkbox" x-model="error"> Error</label>
                    <label x-show="supportsFull"><input type="checkbox" x-model="full"> Full width</label>
                </div>
            </div>

            <div class="doc-interactive-preview" x-bind:class="full ? 'doc-interactive-preview-full' : ''">
                @if ($slug === 'button')
                    @foreach ($buttonVariants as $variant)
                        @foreach ($sizes as $size)
                            <x-sampaui::button
                                :variant="$variant"
                                :size="$size"
                                x-show="variant === '{{ $variant }}' && size === '{{ $size }}'"
                                x-bind:disabled="disabled || loading"
                                x-bind:class="full ? 'w-full justify-center' : ''"
                            >
                                <i x-show="loading" class="bi bi-arrow-repeat animate-spin" aria-hidden="true"></i>
                                <i x-show="icon && ! loading" x-bind:class="'bi bi-' + icon" aria-hidden="true"></i>
                                <span x-text="label"></span>
                            </x-sampaui::button>
                        @endforeach
                    @endforeach
                @elseif ($slug === 'input')
                    <div class="doc-live-real-control">
                        <div x-show="! error">
                            <x-sampaui::input name="playground_name" label="Nome completo" icon="person" placeholder="Ana Souza" x-bind:disabled="disabled || loading" />
                        </div>
                        <div x-show="error">
                            <x-sampaui::input name="playground_name_error" label="Nome completo" icon="person" placeholder="Ana Souza" error="Informe o nome completo." />
                        </div>
                    </div>
                @elseif ($slug === 'select')
                    <div class="doc-live-real-control">
                        <div x-show="! error">
                            <x-sampaui::select name="playground_stage" label="Etapa do funil" placeholder="Selecione" :options="['lead' => 'Novo lead', 'visit' => 'Visita agendada', 'proposal' => 'Proposta enviada']" value="visit" x-bind:disabled="disabled || loading" />
                        </div>
                        <div x-show="error">
                            <x-sampaui::select name="playground_stage_error" label="Etapa do funil" placeholder="Selecione" error="Selecione uma etapa." :options="['lead' => 'Novo lead', 'visit' => 'Visita agendada', 'proposal' => 'Proposta enviada']" />
                        </div>
                    </div>
                @elseif ($slug === 'badge')
                    @foreach ($badgeVariants as $variant)
                        @foreach ($sizes as $size)
                            <x-sampaui::badge
                                :variant="$variant"
                                :size="$size"
                                x-show="variant === '{{ $variant }}' && size === '{{ $size }}'"
                            >
                                <i x-show="icon" x-bind:class="'bi bi-' + icon" aria-hidden="true"></i>
                                <span x-text="label"></span>
                            </x-sampaui::badge>
                        @endforeach
                    @endforeach
                @elseif ($slug === 'table')
                    <div class="doc-live-real-control doc-live-real-control-wide">
                        @foreach ([false, true] as $tableLoading)
                            <div x-show="loading === {{ $tableLoading ? 'true' : 'false' }}">
                                <x-sampaui::table
                                    title="Clientes"
                                    description="Pipeline comercial"
                                    searchable
                                    selectable
                                    export-href="/exports/clientes.csv"
                                    per-page="2"
                                    :loading="$tableLoading"
                                    :columns="[
                                        'name' => 'Cliente',
                                        'status' => 'Status',
                                        'amount' => ['label' => 'Valor', 'align' => 'right'],
                                    ]"
                                    :rows="[
                                        ['id' => 1, 'name' => 'Ana Souza', 'status' => 'Proposta', 'amount' => 'R$ 850 mil'],
                                        ['id' => 2, 'name' => 'Bruno Lima', 'status' => 'Visita', 'amount' => 'R$ 620 mil'],
                                    ]"
                                />
                            </div>
                        @endforeach
                    </div>
                @elseif ($slug === 'modal')
                    <div class="doc-live-real-control">
                        @livewire(\App\Livewire\Docs\ModalPreview::class, ['title' => 'Confirmar proposta'], key('modal-playground'))
                    </div>
                @endif
            </div>
        </div>

        <pre class="doc-live-code"><code x-text="code"></code></pre>
    </article>
@endif
