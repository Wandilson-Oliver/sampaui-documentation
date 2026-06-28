@props(['searchItems' => []])

<header class="doc-topbar">
    <div class="doc-topbar-start">
        <button
            type="button"
            class="doc-icon-button lg:hidden"
            x-on:click="sidebarOpen = true"
            aria-controls="docs-sidebar"
            x-bind:aria-expanded="sidebarOpen.toString()"
            aria-label="Abrir menu"
        >
            <i class="bi bi-list" aria-hidden="true"></i>
        </button>

        <a href="{{ route('documentation') }}" class="doc-topbar-brand lg:hidden" aria-label="SampaUI">
            <img src="{{ asset('images/icon_favicon_sampaui.png') }}" alt="" class="doc-brand-icon">
            <strong>Documentação</strong>
        </a>
    </div>

    <div
        class="doc-search-wrap"
        x-data="docSearch(@js($searchItems))"
        x-on:keydown.down.prevent="next()"
        x-on:keydown.up.prevent="previous()"
        x-on:keydown.enter.prevent="select()"
        x-on:keydown.escape.window="open = false"
        x-on:keydown.window.prevent.meta.k="$refs.searchInput.focus(); open = true"
        x-on:keydown.window.prevent.ctrl.k="$refs.searchInput.focus(); open = true"
        x-on:click.outside="open = false"
    >
        <label class="doc-search" for="doc-search-input">
            <i class="bi bi-search" aria-hidden="true"></i>
            <input
                id="doc-search-input"
                x-ref="searchInput"
                type="search"
                x-model="query"
                x-on:focus="open = true"
                x-on:input="open = true; activeIndex = 0"
                placeholder="Buscar componentes, props e exemplos"
                autocomplete="off"
                aria-controls="doc-search-panel"
                x-bind:aria-expanded="open.toString()"
            >
            <kbd class="doc-search-shortcut">⌘K</kbd>
        </label>

        <div id="doc-search-panel" class="doc-search-panel" x-cloak x-show="open" x-transition.opacity.duration.180ms role="dialog" aria-label="Busca da documentação">
            <div class="doc-search-discovery" x-show="! query">
                <section>
                    <h3>Recentes</h3>
                    <template x-for="item in recentItems" x-bind:key="'recent-' + item.url">
                        <button type="button" class="doc-search-result" x-on:click="go(item)">
                            <span class="doc-search-result-meta"><span x-text="item.type"></span><span x-text="item.tag"></span></span>
                            <span class="doc-search-result-title" x-text="item.title"></span>
                        </button>
                    </template>
                </section>
                <section>
                    <h3>Componentes populares</h3>
                    <template x-for="item in popularItems" x-bind:key="'popular-' + item.url">
                        <button type="button" class="doc-search-result" x-on:click="go(item)">
                            <span class="doc-search-result-meta"><span x-text="item.type"></span><span x-text="item.tag"></span></span>
                            <span class="doc-search-result-title" x-text="item.title"></span>
                        </button>
                    </template>
                </section>
                <section>
                    <h3>Exemplos</h3>
                    <template x-for="item in exampleItems" x-bind:key="'example-' + item.url">
                        <button type="button" class="doc-search-result" x-on:click="go(item)">
                            <span class="doc-search-result-meta"><span x-text="item.type"></span><span x-text="item.tag"></span></span>
                            <span class="doc-search-result-title" x-text="item.title"></span>
                        </button>
                    </template>
                </section>
                <p class="doc-search-help"><kbd>⌘K</kbd> abre a busca. Use ↑ ↓ para navegar e Enter para abrir.</p>
            </div>

            <template x-if="hasResults">
                <div class="doc-search-results">
                    <template x-for="(item, index) in results" x-bind:key="item.url">
                        <button
                            type="button"
                            class="doc-search-result"
                            x-bind:class="index === activeIndex ? 'doc-search-result-active' : ''"
                            x-on:mouseenter="activeIndex = index"
                            x-on:click="select(index)"
                        >
                            <span class="doc-search-result-meta"><span x-text="item.type"></span><span x-text="item.tag"></span></span>
                            <span class="doc-search-result-title" x-text="item.title"></span>
                            <span class="doc-search-result-copy" x-text="item.subtitle"></span>
                        </button>
                    </template>
                </div>
            </template>

            <div class="doc-search-empty" x-show="query && ! hasResults">
                <i class="bi bi-search" aria-hidden="true"></i>
                <div>
                    <strong>Nenhum resultado encontrado.</strong>
                    <span>Tente buscar por componente, prop, exemplo ou categoria.</span>
                </div>
            </div>
        </div>
    </div>

    <button
        type="button"
        class="doc-icon-button"
        x-on:click="toggleTheme()"
        x-bind:aria-label="theme === 'dark' ? 'Usar tema claro' : 'Usar tema escuro'"
        x-bind:title="theme === 'dark' ? 'Tema claro' : 'Tema escuro'"
    >
        <i class="bi" x-bind:class="theme === 'dark' ? 'bi-sun' : 'bi-moon-stars'" aria-hidden="true"></i>
    </button>
</header>
