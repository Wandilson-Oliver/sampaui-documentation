@extends('layouts.playground', ['title' => 'Playground · Editor & Live Preview SampaUI'])

@php
    $initialTemplatesJson = json_encode($templates, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_SLASHES);
    $sampauiJsPath = public_path('vendor/sampaui/sampaui.js');
    $sampauiJsCode = file_exists($sampauiJsPath) ? file_get_contents($sampauiJsPath) : '';
@endphp

@section('content')
<div
    class="flex h-screen w-screen flex-col overflow-hidden bg-[#0d1117] text-slate-100"
    x-data="playgroundShell({{ $initialTemplatesJson }}, { compileUrl: '{{ route('playground.compile') }}', assetsUrl: '{{ asset('vendor/sampaui') }}', sampauiJs: @js($sampauiJsCode) })"
    x-on:keydown.window="if (($event.ctrlKey || $event.metaKey) && $event.key.toLowerCase() === 's') { $event.preventDefault(); saveState(); updatePreview(); savedFeedback = true; setTimeout(() => savedFeedback = false, 1500); }"
>
    <!-- TOP NAVBAR (Barra de Ferramentas Superior) -->
    <header class="flex h-14 shrink-0 items-center justify-between border-b border-slate-800 bg-[#161b22] px-4 sm:px-6">
        <!-- Esquerda: Voltar para a Documentação -->
        <div class="flex items-center gap-3">
            <a
                href="{{ route('documentation') }}"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-700/80 bg-slate-800/90 px-3.5 py-1.5 text-xs font-semibold text-slate-200 shadow-sm transition hover:border-primary/60 hover:bg-slate-700 hover:text-white cursor-pointer"
                title="Voltar para a documentação do SampaUI"
            >
                <i class="bi bi-arrow-left text-primary text-sm"></i>
                <span class="font-medium">Voltar para documentação</span>
            </a>
        </div>

        <!-- Centro: Seletor de Template -->
        <div class="flex items-center">
            <div class="relative" x-data="{ openTemplateMenu: false }">
                <button
                    type="button"
                    class="inline-flex items-center gap-2 rounded-xl border border-slate-700/80 bg-[#0d1117] px-3.5 py-1.5 text-xs font-semibold text-slate-200 shadow-sm transition hover:border-primary/40 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-primary/30 cursor-pointer"
                    x-on:click="openTemplateMenu = !openTemplateMenu"
                    x-on:click.outside="openTemplateMenu = false"
                >
                    <i class="bi bi-collection text-primary"></i>
                    <span x-text="`Template: ${templates[activeTemplate]?.name || 'Personalizado'}`"></span>
                    <i class="bi bi-chevron-down text-[10px] text-slate-400"></i>
                </button>

                <div
                    x-show="openTemplateMenu"
                    x-cloak
                    x-transition.opacity.duration.150ms
                    class="absolute left-1/2 z-50 mt-1.5 w-72 -translate-x-1/2 rounded-xl border border-slate-700 bg-[#161b22] p-1.5 shadow-2xl"
                >
                    <template x-for="(tpl, key) in templates" :key="key">
                        <button
                            type="button"
                            class="flex w-full flex-col rounded-lg px-3 py-2 text-left text-xs transition hover:bg-slate-700/60 cursor-pointer"
                            x-bind:class="{ 'bg-primary/15 text-primary font-bold': activeTemplate === key, 'text-slate-300': activeTemplate !== key }"
                            x-on:click="loadTemplate(key); openTemplateMenu = false"
                        >
                            <span class="font-semibold" x-text="tpl.name"></span>
                            <span class="text-[11px] text-slate-400 line-clamp-1" x-text="tpl.description"></span>
                        </button>
                    </template>
                </div>
            </div>
        </div>

        <!-- Direita: Ações Rápidas (Formatar, Baixar, Resetar, Limpar, Copiar, Layout) -->
        <div class="flex items-center gap-2">
            <!-- Formatar Código -->
            <button
                type="button"
                class="inline-flex h-8 w-8 items-center justify-center rounded-xl border border-slate-800 bg-[#0d1117] text-slate-300 transition hover:bg-slate-800 hover:text-white focus:outline-none cursor-pointer"
                title="Formatar código"
                x-on:click="formatCode()"
            >
                <i class="bi" x-bind:class="formatted ? 'bi-check2 text-success' : 'bi-magic'"></i>
            </button>

            <!-- Baixar HTML -->
            <button
                type="button"
                class="inline-flex h-8 w-8 items-center justify-center rounded-xl border border-slate-800 bg-[#0d1117] text-slate-300 transition hover:bg-slate-800 hover:text-white focus:outline-none cursor-pointer"
                title="Baixar arquivo HTML completo"
                x-on:click="downloadHtml()"
            >
                <i class="bi bi-download text-xs"></i>
            </button>

            <!-- Resetar -->
            <button
                type="button"
                class="inline-flex h-8 w-8 items-center justify-center rounded-xl border border-slate-800 bg-[#0d1117] text-slate-300 transition hover:bg-slate-800 hover:text-danger focus:outline-none cursor-pointer"
                title="Restaurar template original"
                x-on:click="resetCurrentTemplate()"
            >
                <i class="bi bi-arrow-counterclockwise text-xs"></i>
            </button>

            <!-- Limpar -->
            <button
                type="button"
                class="inline-flex h-8 w-8 items-center justify-center rounded-xl border border-slate-800 bg-[#0d1117] text-slate-300 transition hover:bg-slate-800 hover:text-white focus:outline-none cursor-pointer"
                title="Limpar código"
                x-on:click="clearCode()"
            >
                <i class="bi bi-trash3 text-xs"></i>
            </button>

            <!-- Copiar Código -->
            <button
                type="button"
                class="inline-flex items-center gap-1.5 rounded-xl bg-primary px-3 py-1.5 text-xs font-semibold text-white shadow-sm transition hover:bg-primary/90 cursor-pointer"
                title="Copiar código da aba ativa"
                x-on:click="copyCode()"
            >
                <i class="bi" x-bind:class="copied ? 'bi-check2' : 'bi-copy'"></i>
                <span x-text="copied ? 'Copiado!' : 'Copiar'"></span>
            </button>

            <div class="h-4 w-px bg-slate-800 mx-0.5"></div>

            <!-- Alternar Divisão Horizontal / Vertical -->
            <button
                type="button"
                class="inline-flex h-8 w-8 items-center justify-center rounded-xl border border-slate-800 bg-[#0d1117] text-slate-300 transition hover:bg-slate-800 hover:text-white cursor-pointer"
                title="Alternar divisão da tela (Horizontal/Vertical)"
                x-on:click="toggleLayout()"
            >
                <i class="bi" x-bind:class="layout === 'horizontal' ? 'bi-layout-split' : 'bi-layout-sidebar'"></i>
            </button>
        </div>
    </header>

    <!-- CORPO PRINCIPAL (Split View Interativo com Redimensionamento por Arrasto) -->
    <div
        x-ref="splitWorkspace"
        class="flex flex-1 min-h-0 w-full overflow-hidden"
        x-bind:class="{
            'flex-row': layout === 'horizontal',
            'flex-col': layout === 'vertical',
            'select-none': isDragging
        }"
    >
        <!-- PAINEL DO EDITOR DE CÓDIGO (Largura Dinâmica via splitPercent) -->
        <div
            class="flex flex-col border-slate-800 bg-[#0d1117] min-w-[180px] min-h-[120px] overflow-hidden"
            x-bind:style="layout === 'horizontal' ? ('width: ' + splitPercent + '%; flex-basis: ' + splitPercent + '%;') : ('height: ' + splitPercent + '%; flex-basis: ' + splitPercent + '%;')"
        >
            <!-- Sub-Header do Editor (Abas HTML, CSS, JS - Altura Aumentada em 15px: h-[59px]) -->
            <div class="flex h-[59px] shrink-0 items-center justify-between border-b border-slate-800 bg-[#161b22] px-4">
                <div class="flex items-center gap-1.5">
                    <button
                        type="button"
                        class="inline-flex items-center gap-2 rounded-lg px-3.5 py-1.5 text-xs font-semibold transition cursor-pointer"
                        x-bind:class="activeTab === 'html' ? 'bg-[#21262d] text-primary shadow-sm ring-1 ring-primary/40' : 'text-slate-400 hover:bg-[#21262d]/50 hover:text-slate-200'"
                        x-on:click="setActiveTab('html')"
                    >
                        <i class="bi bi-filetype-html text-amber-500 text-sm"></i>
                        <span>HTML</span>
                        <span class="text-[10px] opacity-60" x-text="`(${getLineCount(html)} lin)`"></span>
                    </button>

                    <button
                        type="button"
                        class="inline-flex items-center gap-2 rounded-lg px-3.5 py-1.5 text-xs font-semibold transition cursor-pointer"
                        x-bind:class="activeTab === 'css' ? 'bg-[#21262d] text-primary shadow-sm ring-1 ring-primary/40' : 'text-slate-400 hover:bg-[#21262d]/50 hover:text-slate-200'"
                        x-on:click="setActiveTab('css')"
                    >
                        <i class="bi bi-filetype-css text-sky-400 text-sm"></i>
                        <span>CSS</span>
                        <span class="text-[10px] opacity-60" x-text="`(${getLineCount(css)} lin)`"></span>
                    </button>

                    <button
                        type="button"
                        class="inline-flex items-center gap-2 rounded-lg px-3.5 py-1.5 text-xs font-semibold transition cursor-pointer"
                        x-bind:class="activeTab === 'js' ? 'bg-[#21262d] text-primary shadow-sm ring-1 ring-primary/40' : 'text-slate-400 hover:bg-[#21262d]/50 hover:text-slate-200'"
                        x-on:click="setActiveTab('js')"
                    >
                        <i class="bi bi-filetype-js text-yellow-400 text-sm"></i>
                        <span>JavaScript</span>
                        <span class="text-[10px] opacity-60" x-text="`(${getLineCount(js)} lin)`"></span>
                    </button>

                    <button
                        type="button"
                        class="inline-flex items-center gap-2 rounded-lg px-3.5 py-1.5 text-xs font-semibold transition cursor-pointer"
                        x-bind:class="activeTab === 'livewire' ? 'bg-[#21262d] text-rose-400 shadow-sm ring-1 ring-rose-500/40' : 'text-slate-400 hover:bg-[#21262d]/50 hover:text-slate-200'"
                        x-on:click="setActiveTab('livewire')"
                    >
                        <i class="bi bi-lightning-charge-fill text-rose-500 text-sm"></i>
                        <span>Livewire</span>
                        <span class="text-[10px] opacity-60" x-text="`(${getLineCount(livewire)} lin)`"></span>
                    </button>
                </div>

                <div class="text-[11px] text-slate-500 font-mono">
                    <span x-text="`${currentCode().length} caracteres`"></span>
                </div>
            </div>

            <!-- Área de Código com Numeração Lateral e Syntax Highlighting -->
            <div class="relative flex min-h-0 flex-1 overflow-hidden font-mono text-[13px] leading-6">
                <!-- Coluna de Números de Linha -->
                <div
                    class="select-none border-r border-slate-800 bg-[#090d13] px-3 py-4 text-right font-mono text-xs text-slate-600 overflow-hidden"
                    x-ref="lineNumbers"
                >
                    <pre class="font-mono text-xs leading-6 select-none" x-text="getLineNumbersString(currentCode())"></pre>
                </div>

                <!-- Camada de Cores de Sintaxe e Textareas Transparentes -->
                <div class="relative flex-1 overflow-hidden bg-[#0d1117]">
                    <!-- Camada de Sintaxe Colorida (Renderizada em Tempo Real) -->
                    <pre
                        x-ref="codeHighlight"
                        class="pointer-events-none absolute inset-0 m-0 h-full w-full overflow-hidden p-4 font-mono text-[13px] leading-6 whitespace-pre text-slate-100 select-none z-0"
                        aria-hidden="true"
                    ><code class="font-mono text-[13px] leading-6" x-html="getHighlightedCode()"></code></pre>

                    <!-- Aba HTML -->
                    <textarea
                        x-show="activeTab === 'html'"
                        x-model="html"
                        x-on:input="debouncedUpdate(); syncScroll($event); checkAutocomplete($event.target)"
                        x-on:keyup="checkAutocomplete($event.target)"
                        x-on:click="checkAutocomplete($event.target)"
                        x-on:keydown="handleKeydown($event)"
                        x-on:scroll="syncScroll($event)"
                        spellcheck="false"
                        autocomplete="off"
                        autocorrect="off"
                        autocapitalize="off"
                        placeholder="<!-- Digite seu código HTML ou componentes SampaUI aqui... -->"
                        class="absolute inset-0 z-10 h-full w-full resize-none border-0 bg-transparent p-4 font-mono text-[13px] leading-6 text-transparent caret-white outline-none selection:bg-primary/30 placeholder:text-slate-600 focus:ring-0 whitespace-pre overflow-auto"
                    ></textarea>

                    <!-- Aba CSS -->
                    <textarea
                        x-show="activeTab === 'css'"
                        x-model="css"
                        x-on:input="debouncedUpdate(); syncScroll($event); checkAutocomplete($event.target)"
                        x-on:keyup="checkAutocomplete($event.target)"
                        x-on:click="checkAutocomplete($event.target)"
                        x-on:keydown="handleKeydown($event)"
                        x-on:scroll="syncScroll($event)"
                        spellcheck="false"
                        autocomplete="off"
                        autocorrect="off"
                        autocapitalize="off"
                        placeholder="/* Digite suas regras de CSS customizadas aqui... */"
                        class="absolute inset-0 z-10 h-full w-full resize-none border-0 bg-transparent p-4 font-mono text-[13px] leading-6 text-transparent caret-white outline-none selection:bg-primary/30 placeholder:text-slate-600 focus:ring-0 whitespace-pre overflow-auto"
                    ></textarea>

                    <!-- Aba JS -->
                    <textarea
                        x-show="activeTab === 'js'"
                        x-model="js"
                        x-on:input="debouncedUpdate(); syncScroll($event); checkAutocomplete($event.target)"
                        x-on:keyup="checkAutocomplete($event.target)"
                        x-on:click="checkAutocomplete($event.target)"
                        x-on:keydown="handleKeydown($event)"
                        x-on:scroll="syncScroll($event)"
                        spellcheck="false"
                        autocomplete="off"
                        autocorrect="off"
                        autocapitalize="off"
                        placeholder="// Digite seus scripts JavaScript aqui..."
                        class="absolute inset-0 z-10 h-full w-full resize-none border-0 bg-transparent p-4 font-mono text-[13px] leading-6 text-transparent caret-white outline-none selection:bg-primary/30 placeholder:text-slate-600 focus:ring-0 whitespace-pre overflow-auto"
                    ></textarea>

                    <!-- Aba Livewire (Volt / Single-File) -->
                    <textarea
                        x-show="activeTab === 'livewire'"
                        x-model="livewire"
                        x-on:input="debouncedUpdate(); syncScroll($event); checkAutocomplete($event.target)"
                        x-on:keyup="checkAutocomplete($event.target)"
                        x-on:click="checkAutocomplete($event.target)"
                        x-on:keydown="handleKeydown($event)"
                        x-on:scroll="syncScroll($event)"
                        spellcheck="false"
                        autocomplete="off"
                        autocorrect="off"
                        autocapitalize="off"
                        placeholder="// Digite a classe ou componente Volt do Livewire aqui..."
                        class="absolute inset-0 z-10 h-full w-full resize-none border-0 bg-transparent p-4 font-mono text-[13px] leading-6 text-transparent caret-white outline-none selection:bg-primary/30 placeholder:text-slate-600 focus:ring-0 whitespace-pre overflow-auto"
                    ></textarea>

                    <!-- POPUP DE AUTOCOMPLETE / INTELLISENSE FLUTUANTE -->
                    <div
                        x-show="autocompleteVisible && autocompleteSuggestions.length > 0"
                        x-cloak
                        x-transition.opacity.duration.100ms
                        class="absolute bottom-4 right-4 z-40 w-96 max-h-72 flex flex-col rounded-2xl border border-slate-700 bg-[#161b22]/95 backdrop-blur-md shadow-2xl overflow-hidden font-sans"
                    >
                        <!-- Topo do Menu Autocomplete -->
                        <div class="flex items-center justify-between border-b border-slate-800 bg-[#0d1117]/80 px-3.5 py-1.5 text-[11px] text-slate-400">
                            <span class="flex items-center gap-1.5 font-semibold text-slate-300">
                                <i class="bi bi-lightning-charge-fill text-primary"></i>
                                <span>Sugestões Inteligentes</span>
                            </span>
                            <span class="text-[10px] text-slate-500 font-mono">
                                <kbd class="rounded bg-[#21262d] px-1 text-slate-300">↑↓</kbd> navegar · <kbd class="rounded bg-[#21262d] px-1 text-slate-300">↵</kbd> inserir
                            </span>
                        </div>

                        <!-- Lista de Sugestões -->
                        <div class="flex-1 overflow-y-auto p-1.5 space-y-1 max-h-56">
                            <template x-for="(item, idx) in autocompleteSuggestions" :key="idx">
                                <div
                                    class="flex items-center justify-between gap-2 rounded-xl px-3 py-2 text-xs transition cursor-pointer"
                                    x-bind:class="{
                                        'bg-primary/20 text-white font-bold ring-1 ring-primary/40': autocompleteIndex === idx,
                                        'text-slate-300 hover:bg-slate-800/80': autocompleteIndex !== idx
                                    }"
                                    x-on:click="applyAutocomplete(item)"
                                    x-on:mouseenter="autocompleteIndex = idx"
                                >
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <span
                                            class="inline-flex h-6 w-6 shrink-0 items-center justify-center rounded-lg text-xs"
                                            x-bind:class="{
                                                'bg-purple-500/20 text-purple-400': item.type === 'sampaui',
                                                'bg-sky-500/20 text-sky-400': item.type === 'tailwind',
                                                'bg-amber-500/20 text-amber-400': item.type === 'html',
                                                'bg-rose-500/20 text-rose-400': item.type === 'blade',
                                                'bg-emerald-500/20 text-emerald-400': item.type === 'css' || item.type === 'js'
                                            }"
                                        >
                                            <i class="bi" x-bind:class="item.icon || 'bi-code-slash'"></i>
                                        </span>
                                        <div class="min-w-0">
                                            <div class="font-mono text-xs font-semibold text-slate-100 truncate" x-text="item.label"></div>
                                            <div class="text-[10px] text-slate-400 truncate" x-text="item.desc"></div>
                                        </div>
                                    </div>

                                    <span
                                        class="shrink-0 rounded-md px-1.5 py-0.5 text-[9px] font-bold uppercase tracking-wider"
                                        x-bind:class="{
                                            'bg-purple-500/20 text-purple-300 border border-purple-500/30': item.type === 'sampaui',
                                            'bg-sky-500/20 text-sky-300 border border-sky-500/30': item.type === 'tailwind',
                                            'bg-amber-500/20 text-amber-300 border border-amber-500/30': item.type === 'html',
                                            'bg-rose-500/20 text-rose-300 border border-rose-500/30': item.type === 'blade',
                                            'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30': item.type === 'css' || item.type === 'js'
                                        }"
                                        x-text="item.type"
                                    ></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer do Editor (Dica de Atalhos & Status) -->
            <div class="flex items-center justify-between border-t border-slate-800 bg-[#161b22] px-4 py-1.5 text-[11px] text-slate-400">
                <span class="flex items-center gap-1.5">
                    <i class="bi bi-keyboard text-primary"></i>
                    <kbd class="rounded bg-[#21262d] px-1.5 py-0.5 text-[10px] text-slate-300 font-mono">Tab</kbd> indentação · <kbd class="rounded bg-[#21262d] px-1.5 py-0.5 text-[10px] text-slate-300 font-mono">Ctrl+S</kbd> / <kbd class="rounded bg-[#21262d] px-1.5 py-0.5 text-[10px] text-slate-300 font-mono">⌘S</kbd> salvar
                </span>
                <span class="flex items-center gap-1.5 transition-colors duration-200" x-bind:class="savedFeedback ? 'text-emerald-400 font-bold' : 'text-slate-400'">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400" x-bind:class="{ 'animate-ping': savedFeedback }"></span>
                    <span x-text="savedFeedback ? 'Salvo agora!' : 'Salvo no LocalStorage'"></span>
                </span>
            </div>
        </div>

        <!-- DIVISOR INTERATIVO ARRASTÁVEL (Splitter Handle) -->
        <div
            class="group relative z-30 shrink-0 select-none flex items-center justify-center transition-colors duration-150"
            x-bind:class="{
                'w-2 cursor-col-resize hover:bg-primary/50 active:bg-primary border-x border-slate-800 bg-[#090d13]': layout === 'horizontal',
                'h-2 cursor-row-resize hover:bg-primary/50 active:bg-primary border-y border-slate-800 bg-[#090d13]': layout === 'vertical',
                'bg-primary border-primary ring-2 ring-primary/40': isDragging
            }"
            x-on:mousedown="startDragging($event)"
            x-on:touchstart="startDragging($event)"
            title="Arraste para redimensionar as colunas"
        >
            <div
                class="rounded-full transition-colors duration-150"
                x-bind:class="{
                    'h-8 w-1 bg-slate-600 group-hover:bg-white group-active:bg-white': layout === 'horizontal',
                    'w-8 h-1 bg-slate-600 group-hover:bg-white group-active:bg-white': layout === 'vertical',
                    'bg-white': isDragging
                }"
            ></div>
        </div>

        <!-- PAINEL DO LIVE PREVIEW (Largura Dinâmica via 100 - splitPercent) -->
        <div
            class="flex flex-col bg-[#0b101b] text-slate-100 min-w-[180px] min-h-[120px] overflow-hidden"
            x-bind:style="layout === 'horizontal' ? ('width: ' + (100 - splitPercent) + '%; flex-basis: ' + (100 - splitPercent) + '%;') : ('height: ' + (100 - splitPercent) + '%; flex-basis: ' + (100 - splitPercent) + '%;')"
        >
            <!-- Sub-Header do Preview (Live Preview + Select de Dispositivo + Controles - Altura Aumentada em 15px: h-[59px]) -->
            <div class="flex h-[59px] shrink-0 items-center justify-between border-b border-slate-800 bg-[#161b22] px-4">
                <div class="flex items-center gap-3">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Live Preview</span>

                    <!-- Select de Dispositivos (iPhone 15/16/17, MacBooks, iPads, Desktop) -->
                    <div class="relative">
                        <select
                            x-model="currentDevice"
                            x-on:change="setDevice($event.target.value)"
                            class="h-8 rounded-xl border border-primary/70 bg-[#0d1117] py-0 pl-3.5 pr-8 text-xs font-semibold text-white outline-none transition hover:border-primary focus:border-primary focus:ring-2 focus:ring-primary/30 cursor-pointer appearance-none shadow-sm"
                            title="Selecionar dispositivo ou resolução para o preview"
                        >
                            <optgroup label="💻 Telas & MacBooks" class="bg-[#161b22] text-slate-300 font-semibold">
                                <option value="desktop">Desktop Fluido (100%)</option>
                                <option value="macbook_pro_16">MacBook Pro 16" (1728px)</option>
                                <option value="macbook_pro_14">MacBook Pro 14" (1512px)</option>
                                <option value="macbook_air">MacBook Air 13" (1280px)</option>
                            </optgroup>
                            <optgroup label="📱 iPhones" class="bg-[#161b22] text-slate-300 font-semibold">
                                <option value="iphone_17_pro_max">iPhone 17 Pro Max (440px)</option>
                                <option value="iphone_17">iPhone 17 (393px)</option>
                                <option value="iphone_16_pro_max">iPhone 16 Pro Max (440px)</option>
                                <option value="iphone_16">iPhone 16 (393px)</option>
                                <option value="iphone_15_pro_max">iPhone 15 Pro Max (430px)</option>
                                <option value="iphone_15">iPhone 15 (393px)</option>
                            </optgroup>
                            <optgroup label="📟 iPads & Tablets" class="bg-[#161b22] text-slate-300 font-semibold">
                                <option value="ipad_pro_12">iPad Pro 12.9" (1024px)</option>
                                <option value="ipad_air">iPad Air 11" (834px)</option>
                                <option value="ipad_mini">iPad Mini (744px)</option>
                            </optgroup>
                        </select>
                        <i class="bi bi-chevron-down pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-slate-400"></i>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <!-- Alternador de Fundo do Canvas (Claro, Neutro, Escuro) -->
                    <div class="flex items-center rounded-xl border border-slate-700/80 bg-[#0d1117] p-1 shadow-inner">
                        <button
                            type="button"
                            class="inline-flex h-7 w-7 items-center justify-center rounded-lg text-xs font-semibold transition-all cursor-pointer"
                            x-bind:class="canvasBg === 'light' ? 'bg-primary text-white shadow-md ring-1 ring-primary/50' : 'text-slate-400 hover:text-white hover:bg-slate-800/60'"
                            x-on:click="setCanvasBg('light')"
                            title="Fundo Claro (Light)"
                        >
                            <i class="bi bi-sun text-[13px]"></i>
                        </button>
                        <button
                            type="button"
                            class="inline-flex h-7 w-7 items-center justify-center rounded-lg text-xs font-semibold transition-all cursor-pointer"
                            x-bind:class="canvasBg === 'neutral' ? 'bg-primary text-white shadow-md ring-1 ring-primary/50' : 'text-slate-400 hover:text-white hover:bg-slate-800/60'"
                            x-on:click="setCanvasBg('neutral')"
                            title="Fundo Neutro (Slate)"
                        >
                            <i class="bi bi-square-half text-[13px]"></i>
                        </button>
                        <button
                            type="button"
                            class="inline-flex h-7 w-7 items-center justify-center rounded-lg text-xs font-semibold transition-all cursor-pointer"
                            x-bind:class="canvasBg === 'dark' ? 'bg-primary text-white shadow-md ring-1 ring-primary/50' : 'text-slate-400 hover:text-white hover:bg-slate-800/60'"
                            x-on:click="setCanvasBg('dark')"
                            title="Fundo Escuro (Dark Mode)"
                        >
                            <i class="bi bi-moon-stars text-[13px]"></i>
                        </button>
                    </div>

                    <!-- Recarregar Preview -->
                    <button
                        type="button"
                        class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-800 bg-[#0d1117] text-slate-300 transition hover:bg-slate-800 hover:text-white cursor-pointer"
                        title="Recarregar preview"
                        x-on:click="updatePreview()"
                    >
                        <i class="bi bi-arrow-clockwise text-xs"></i>
                    </button>

                    <!-- Abrir em Nova Janela -->
                    <button
                        type="button"
                        class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-800 bg-[#0d1117] text-slate-300 transition hover:bg-slate-800 hover:text-white cursor-pointer"
                        title="Abrir preview em tela cheia"
                        x-on:click="openInNewWindow()"
                    >
                        <i class="bi bi-box-arrow-up-right text-xs"></i>
                    </button>
                </div>
            </div>

            <!-- Canvas Central com Iframe Isolado -->
            <div
                class="flex min-h-0 flex-1 overflow-auto transition-colors duration-300"
                x-bind:class="{
                    'items-stretch justify-stretch p-0': currentDevice === 'desktop',
                    'items-center justify-start xl:justify-center p-4 sm:p-8': currentDevice !== 'desktop',
                    'bg-slate-200': canvasBg === 'neutral',
                    'bg-slate-100': canvasBg === 'light',
                    'bg-[#06090e]': canvasBg === 'dark'
                }"
            >
                <div
                    class="h-full overflow-hidden transition-all duration-300 mx-auto"
                    x-bind:class="{
                        'w-full rounded-none border-0': currentDevice === 'desktop',
                        'rounded-2xl border border-slate-300/80 shadow-2xl': currentDevice !== 'desktop' && canvasBg !== 'dark',
                        'rounded-2xl border border-slate-700/80 shadow-2xl': currentDevice !== 'desktop' && canvasBg === 'dark'
                    }"
                    x-bind:style="getViewportStyles()"
                >
                    <iframe
                        x-ref="previewFrame"
                        class="h-full w-full border-0 transition-colors duration-300"
                        x-bind:class="{
                            'bg-white': canvasBg === 'light',
                            'bg-slate-100': canvasBg === 'neutral',
                            'bg-[#0b0f17]': canvasBg === 'dark',
                            'pointer-events-none': isDragging
                        }"
                        sandbox="allow-scripts allow-modals allow-forms allow-popups allow-same-origin"
                        title="Live Preview"
                    ></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
