@props(['slug'])

@php($enabledSlugs = ['button', 'input', 'select', 'badge', 'table', 'modal'])

@if (in_array($slug, $enabledSlugs, true))
    <article class="doc-interactive-playground" x-data="componentPlayground(@js($slug))">
        <header>
            <div>
                <span class="doc-kicker">Playground interativo</span>
                <h3>Teste estados comuns</h3>
                <p>Os controles abaixo alteram o preview e o snippet exibido. A estrutura está preparada para evoluir componente por componente.</p>
            </div>
            <x-sampaui::badge variant="info" size="sm">Alpine.js</x-sampaui::badge>
        </header>

        <div class="doc-interactive-grid">
            <div class="doc-interactive-controls">
                <label>
                    <span>Variante</span>
                    <select x-model="variant">
                        <template x-for="option in variants" x-bind:key="option">
                            <option x-bind:value="option" x-text="option"></option>
                        </template>
                    </select>
                </label>

                <label x-show="sizes.length">
                    <span>Tamanho</span>
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

                <div class="doc-interactive-switches">
                    <label><input type="checkbox" x-model="loading"> Loading</label>
                    <label><input type="checkbox" x-model="disabled"> Disabled</label>
                </div>
            </div>

            <div class="doc-interactive-preview">
                <template x-if="slug === 'button'">
                    <button type="button" x-bind:class="buttonClass" x-bind:disabled="disabled || loading">
                        <i x-show="loading" class="bi bi-arrow-repeat animate-spin" aria-hidden="true"></i>
                        <span x-text="label"></span>
                    </button>
                </template>

                <template x-if="slug === 'input'">
                    <label class="doc-live-field">
                        <span x-text="label"></span>
                        <input type="text" placeholder="Ana Souza" x-bind:disabled="disabled || loading">
                    </label>
                </template>

                <template x-if="slug === 'select'">
                    <label class="doc-live-field">
                        <span x-text="label"></span>
                        <select x-bind:disabled="disabled || loading">
                            <option>Novo lead</option>
                            <option>Visita agendada</option>
                            <option>Proposta enviada</option>
                        </select>
                    </label>
                </template>

                <template x-if="slug === 'badge'">
                    <span x-bind:class="badgeClass" x-text="label"></span>
                </template>

                <template x-if="slug === 'table'">
                    <div class="doc-live-table" x-bind:aria-busy="loading.toString()">
                        <div><strong>Cliente</strong><strong>Status</strong></div>
                        <div><span>Ana Souza</span><span>Proposta</span></div>
                        <div><span>Bruno Lima</span><span>Visita</span></div>
                    </div>
                </template>

                <template x-if="slug === 'modal'">
                    <div class="doc-live-modal">
                        <strong x-text="label"></strong>
                        <p>Confirme a ação antes de continuar.</p>
                        <button type="button" x-bind:disabled="disabled || loading">Confirmar</button>
                    </div>
                </template>
            </div>
        </div>

        <pre class="doc-live-code"><code x-text="code"></code></pre>
    </article>
@endif
