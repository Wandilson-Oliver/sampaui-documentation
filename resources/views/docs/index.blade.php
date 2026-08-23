@extends('docs.layout', ['title' => 'Documentação SampaUI'])

@section('content')
    @php
        $sampaVersion = config('docs.version');
        $componentTotal = count($components);
        $templateTotal = count($navigationExamples ?? []);
        $roadmap = [
            ['title' => 'Mais padrões de CRM', 'copy' => 'Receitas para pipeline, atendimento, propostas e pós-venda.', 'icon' => 'diagram-3', 'status' => 'Em evolução'],
            ['title' => 'Exemplos completos', 'copy' => 'Mais fluxos Livewire documentados e prontos para adaptar.', 'icon' => 'sliders2', 'status' => 'Planejado'],
            ['title' => 'Catálogo para IA', 'copy' => 'Registry e contexto estruturado para agentes de código.', 'icon' => 'stars', 'status' => 'Contínuo'],
        ];
        $catalogFilters = [
            ['key' => 'all', 'label' => 'Todos'],
            ['key' => 'popular', 'label' => 'Popular'],
            ['key' => 'new', 'label' => 'Novos'],
            ['key' => 'forms', 'label' => 'Formulários'],
            ['key' => 'ui', 'label' => 'Design de UI'],
            ['key' => 'data', 'label' => 'Data'],
            ['key' => 'overlay', 'label' => 'Overlay'],
            ['key' => 'navigation', 'label' => 'Navigation'],
            ['key' => 'feedback', 'label' => 'Feedback'],
            ['key' => 'layout', 'label' => 'Layout'],
            ['key' => 'communication', 'label' => 'Comunicação'],
        ];
        $featuredTemplates = [
            [
                'route' => 'examples.dashboard',
                'title' => 'Dashboard Analytics',
                'category' => 'Analytics & KPI',
                'description' => 'Painel analítico completo com cards de métricas, gráficos e tabela financeira.',
                'icon' => 'grid-1x2',
            ],
            [
                'route' => 'examples.chat',
                'title' => 'Central de Atendimento & Chat',
                'category' => 'Comunicação',
                'description' => 'Layout responsivo em tempo real com busca de contatos, timeline e composer.',
                'icon' => 'chat-dots',
            ],
            [
                'route' => 'examples.advanced-table',
                'title' => 'DataTable Avançada',
                'category' => 'Dados & Listagens',
                'description' => 'Tabela rica com busca em tempo real, seleção em lote, filtros e paginação.',
                'icon' => 'table',
            ],
            [
                'route' => 'examples.users.index',
                'title' => 'Gestão de Usuários & CRUD',
                'category' => 'Administrativo',
                'description' => 'Listagem de usuários com pesquisa, filtros de status, ordenação e modais de ação.',
                'icon' => 'people',
            ],
        ];
    @endphp

    {{-- Hero Principal --}}
    <section class="doc-home-hero" aria-labelledby="home-title">
        <div class="doc-home-hero-copy">
            <span class="doc-home-logo-frame">
                <img src="{{ asset('images/logo_sampaui.png') }}" alt="SampaUI">
            </span>

            <div class="doc-home-eyebrow">
                <span class="doc-version-pill"><i class="bi bi-stars" aria-hidden="true"></i> Docs v{{ $sampaVersion }}</span>
                <span class="text-xs font-semibold text-secondary/70">Pacote Oficial de Componentes Blade & Livewire</span>
            </div>

            <h1 id="home-title">Componentes Blade para produtos digitais <span>profissionais.</span></h1>
            <p>
                Um ecossistema completo de componentes modernos, consistentes, acessíveis (WAI-ARIA) e de alta performance para acelerar CRMs, dashboards, portais e sistemas administrativos em Laravel e Livewire.
            </p>

            <div class="doc-home-actions">
                <x-sampaui::button size="md" icon="grid" onclick="document.getElementById('componentes').scrollIntoView({behavior: 'smooth'})">
                    Explorar componentes ({{ $componentTotal }})
                </x-sampaui::button>
                <x-sampaui::button size="md" variant="secondary" icon="code-square" onclick="window.location='{{ route('playground') }}'">
                    Playground Interativo
                </x-sampaui::button>
                <x-sampaui::button size="md" variant="outline" icon="window-sidebar" onclick="window.location='{{ route('examples.index') }}'">
                    Templates & Blocks
                </x-sampaui::button>
            </div>

            <div class="doc-quick-install" x-data="copyCode()">
                <span class="doc-quick-install-prompt">$</span>
                <code x-ref="code">composer require sampaui/sampaui</code>
                <button type="button" class="doc-quick-install-btn" x-on:click="copy('composer require sampaui/sampaui')" title="Copiar comando">
                    <i class="bi" x-bind:class="copied ? 'bi-check2 text-emerald-500' : 'bi-copy'" aria-hidden="true"></i>
                    <span x-text="copied ? 'Copiado!' : 'Copiar'"></span>
                </button>
            </div>

            <div class="doc-stack-badges" aria-label="Tecnologias compatíveis">
                @foreach ([
                    ['label' => 'Composer', 'icon' => 'box-seam'],
                    ['label' => 'Laravel 13', 'icon' => 'braces-asterisk'],
                    ['label' => 'Livewire 4', 'icon' => 'lightning-charge'],
                    ['label' => 'Tailwind 4', 'icon' => 'wind'],
                    ['label' => 'Alpine.js', 'icon' => 'code-slash'],
                    ['label' => 'WAI-ARIA 1.2', 'icon' => 'universal-access'],
                ] as $technology)
                    <span><i class="bi bi-{{ $technology['icon'] }}" aria-hidden="true"></i>{{ $technology['label'] }}</span>
                @endforeach
            </div>
        </div>

        {{-- 4 Pilares de Engenharia do SampaUI --}}
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 pt-2">
            <div class="rounded-xl border border-border bg-surface p-4 shadow-xs transition hover:border-primary/40">
                <div class="flex items-center gap-3">
                    <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary/10 text-primary">
                        <i class="bi bi-universal-access text-lg"></i>
                    </span>
                    <div>
                        <h3 class="text-sm font-bold text-heading">Acessibilidade Nativa</h3>
                        <p class="text-[11px] text-secondary/60 font-semibold">WAI-ARIA 1.2 Compliant</p>
                    </div>
                </div>
                <p class="mt-3 text-xs leading-relaxed text-secondary/80 border-t border-border/60 pt-2.5">
                    Focus trap nativo em modais, IDs automáticos vinculando labels e papéis semânticos.
                </p>
            </div>

            <div class="rounded-xl border border-border bg-surface p-4 shadow-xs transition hover:border-primary/40">
                <div class="flex items-center gap-3">
                    <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-accent/10 text-accent">
                        <i class="bi bi-lightning-charge-fill text-lg"></i>
                    </span>
                    <div>
                        <h3 class="text-sm font-bold text-heading">Client-First Performance</h3>
                        <p class="text-[11px] text-secondary/60 font-semibold">Zero Network Overhead</p>
                    </div>
                </div>
                <p class="mt-3 text-xs leading-relaxed text-secondary/80 border-t border-border/60 pt-2.5">
                    Modais, abas, selects e drawers 100% rápidos no cliente com Alpine.js sem round-trips desnecessários.
                </p>
            </div>

            <div class="rounded-xl border border-border bg-surface p-4 shadow-xs transition hover:border-primary/40">
                <div class="flex items-center gap-3">
                    <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-purple/10 text-purple">
                        <i class="bi bi-palette2 text-lg"></i>
                    </span>
                    <div>
                        <h3 class="text-sm font-bold text-heading">Theming & sampaui_cn</h3>
                        <p class="text-[11px] text-secondary/60 font-semibold">Tailwind CSS v4</p>
                    </div>
                </div>
                <p class="mt-3 text-xs leading-relaxed text-secondary/80 border-t border-border/60 pt-2.5">
                    Design tokens via <code>@theme</code>, dark mode instantâneo e resolução de conflitos de classes.
                </p>
            </div>

            <div class="rounded-xl border border-border bg-surface p-4 shadow-xs transition hover:border-primary/40">
                <div class="flex items-center gap-3">
                    <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-success/10 text-success">
                        <i class="bi bi-terminal-fill text-lg"></i>
                    </span>
                    <div>
                        <h3 class="text-sm font-bold text-heading">CLI de Ejeção</h3>
                        <p class="text-[11px] text-secondary/60 font-semibold">php artisan sampaui:add</p>
                    </div>
                </div>
                <p class="mt-3 text-xs leading-relaxed text-secondary/80 border-t border-border/60 pt-2.5">
                    Use como dependência ou copie o código-fonte Blade diretamente para o seu projeto.
                </p>
            </div>
        </div>
    </section>

    {{-- Visão Geral em Números --}}
    <section class="doc-home-overview" aria-label="Resumo da documentação">
        <div class="doc-home-stat-card">
            <span class="doc-home-stat-icon"><i class="bi bi-grid-fill"></i></span>
            <div class="doc-home-stat-info">
                <strong>{{ $componentTotal }}</strong>
                <span>componentes documentados</span>
            </div>
        </div>

        <div class="doc-home-stat-card">
            <span class="doc-home-stat-icon"><i class="bi bi-window-stack"></i></span>
            <div class="doc-home-stat-info">
                <strong>{{ $templateTotal }}</strong>
                <span>templates documentados</span>
            </div>
        </div>

        <div class="doc-home-stat-card">
            <span class="doc-home-stat-icon"><i class="bi bi-cpu-fill"></i></span>
            <div class="doc-home-stat-info">
                <strong>4</strong>
                <span>tecnologias integradas</span>
            </div>
        </div>

        <div class="doc-home-stat-card">
            <span class="doc-home-stat-icon"><i class="bi bi-stars"></i></span>
            <div class="doc-home-stat-info">
                <strong>IA</strong>
                <span>registry e llms.txt</span>
            </div>
        </div>
    </section>

    {{-- Seção de Instalação Completa & Recursos --}}
    <section id="instalacao" class="doc-home-section" aria-labelledby="install-title" x-data="{ installTab: 'artisan' }">
        <div class="doc-home-section-heading">
            <span class="doc-kicker">Instalação & Configuração</span>
            <h2 id="install-title">Integração completa com todos os recursos do ecossistema.</h2>
            <p>Escolha o fluxo ideal para o seu projeto: instalação automática via Composer ou ejeção seletiva de componentes Blade (estilo shadcn add) para controle total do código.</p>
        </div>

        {{-- Abas de Métodos de Instalação --}}
        <div class="mt-6">
            <div class="flex flex-wrap gap-2 border-b border-border pb-2" role="tablist" aria-label="Opções de instalação">
                <button
                    type="button"
                    role="tab"
                    x-on:click="installTab = 'artisan'"
                    x-bind:aria-selected="(installTab === 'artisan').toString()"
                    class="cursor-pointer rounded-xl px-4 py-2 text-xs font-bold transition-all"
                    x-bind:class="installTab === 'artisan' ? 'bg-primary text-white shadow-xs' : 'bg-surface border border-border text-secondary/80 hover:border-primary/40 hover:text-primary'"
                >
                    <i class="bi bi-magic me-1.5"></i> Instalação Automática
                </button>

                <button
                    type="button"
                    role="tab"
                    x-on:click="installTab = 'ejection'"
                    x-bind:aria-selected="(installTab === 'ejection').toString()"
                    class="cursor-pointer rounded-xl px-4 py-2 text-xs font-bold transition-all"
                    x-bind:class="installTab === 'ejection' ? 'bg-primary text-white shadow-xs' : 'bg-surface border border-border text-secondary/80 hover:border-primary/40 hover:text-primary'"
                >
                    <i class="bi bi-box-arrow-in-down me-1.5"></i> CLI de Ejeção (sampaui:add)
                </button>

                <button
                    type="button"
                    role="tab"
                    x-on:click="installTab = 'tailwind'"
                    x-bind:aria-selected="(installTab === 'tailwind').toString()"
                    class="cursor-pointer rounded-xl px-4 py-2 text-xs font-bold transition-all"
                    x-bind:class="installTab === 'tailwind' ? 'bg-primary text-white shadow-xs' : 'bg-surface border border-border text-secondary/80 hover:border-primary/40 hover:text-primary'"
                >
                    <i class="bi bi-wind me-1.5"></i> Tailwind CSS v4
                </button>

                <button
                    type="button"
                    role="tab"
                    x-on:click="installTab = 'manual'"
                    x-bind:aria-selected="(installTab === 'manual').toString()"
                    class="cursor-pointer rounded-xl px-4 py-2 text-xs font-bold transition-all"
                    x-bind:class="installTab === 'manual' ? 'bg-primary text-white shadow-xs' : 'bg-surface border border-border text-secondary/80 hover:border-primary/40 hover:text-primary'"
                >
                    <i class="bi bi-folder2-open me-1.5"></i> Publicação Manual
                </button>

                <button
                    type="button"
                    role="tab"
                    x-on:click="installTab = 'doctor'"
                    x-bind:aria-selected="(installTab === 'doctor').toString()"
                    class="cursor-pointer rounded-xl px-4 py-2 text-xs font-bold transition-all"
                    x-bind:class="installTab === 'doctor' ? 'bg-primary text-white shadow-xs' : 'bg-surface border border-border text-secondary/80 hover:border-primary/40 hover:text-primary'"
                >
                    <i class="bi bi-heart-pulse me-1.5"></i> Diagnóstico & CLI
                </button>
            </div>

            {{-- Painel 1: Instalação Automática --}}
            <div x-show="installTab === 'artisan'" x-cloak class="mt-6 space-y-6">
                <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr] items-start">
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-heading flex items-center gap-2">
                            <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-primary/10 text-primary text-xs font-bold">1</span>
                            Instale via Composer e execute o instalador oficial
                        </h3>
                        <p class="text-sm text-secondary/80 leading-relaxed">
                            O comando <code>sampaui:install</code> publica automaticamente as configurações, os assets compilados (CSS, JS, fontes e ícones) e insere as importações necessárias em seus arquivos de frontend.
                        </p>

                        <div class="grid gap-3 sm:grid-cols-3 pt-2">
                            <div class="rounded-lg border border-border bg-surface-subtle p-3 text-xs">
                                <strong class="block text-heading font-bold mb-1"><i class="bi bi-check2 text-primary me-1"></i> Config</strong>
                                <code>config/sampaui.php</code>
                            </div>
                            <div class="rounded-lg border border-border bg-surface-subtle p-3 text-xs">
                                <strong class="block text-heading font-bold mb-1"><i class="bi bi-check2 text-primary me-1"></i> Assets</strong>
                                <code>public/vendor/sampaui</code>
                            </div>
                            <div class="rounded-lg border border-border bg-surface-subtle p-3 text-xs">
                                <strong class="block text-heading font-bold mb-1"><i class="bi bi-check2 text-primary me-1"></i> Frontend</strong>
                                <code>resources/css & js</code>
                            </div>
                        </div>
                    </div>

                    <x-docs.code-block :code="'# 1. Requisite o pacote'.PHP_EOL.'composer require sampaui/sampaui'.PHP_EOL.PHP_EOL.'# 2. Execute o instalador automático'.PHP_EOL.'php artisan sampaui:install'.PHP_EOL.PHP_EOL.'# 3. Compile os assets do seu app'.PHP_EOL.'npm run build'" label="Terminal" />
                </div>
            </div>

            {{-- Painel 2: CLI de Ejeção Seletiva (shadcn style) --}}
            <div x-show="installTab === 'ejection'" x-cloak class="mt-6 space-y-6">
                <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr] items-start">
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-heading flex items-center gap-2">
                            <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-primary/10 text-primary text-xs font-bold">2</span>
                            Copie componentes diretamente para o seu projeto
                        </h3>
                        <p class="text-sm text-secondary/80 leading-relaxed">
                            Inspirado no <strong>shadcn/ui</strong>, você pode ejetar componentes específicos diretamente para <code>resources/views/components/sampaui</code>. Tenha total liberdade para customizar o markup Blade sem depender de overrides na pasta <code>vendor/</code>.
                        </p>

                        <div class="rounded-xl border border-primary/20 bg-primary/5 p-4 text-xs text-secondary/90 space-y-2">
                            <p class="font-bold text-heading flex items-center gap-1.5 text-primary">
                                <i class="bi bi-info-circle-fill"></i> Vantagem do Modo Ejeção
                            </p>
                            <p>O componente passa a pertencer ao seu repositório Git, permitindo refatorações, adição de novos slots e regras de negócio sob medida.</p>
                        </div>
                    </div>

                    <x-docs.code-block :code="'# Copiar componentes específicos para o projeto'.PHP_EOL.'php artisan sampaui:add button modal table select-search'.PHP_EOL.PHP_EOL.'# Copiar todos os 48 componentes oficiais'.PHP_EOL.'php artisan sampaui:add --all'.PHP_EOL.PHP_EOL.'# Sobrescrever componentes já existentes'.PHP_EOL.'php artisan sampaui:add button --force'" label="Terminal Artisan" />
                </div>
            </div>

            {{-- Painel 3: Tailwind CSS v4 --}}
            <div x-show="installTab === 'tailwind'" x-cloak class="mt-6 space-y-6">
                <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr] items-start">
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-heading flex items-center gap-2">
                            <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-primary/10 text-primary text-xs font-bold">3</span>
                            Importações no Tailwind CSS v4 e Vite
                        </h3>
                        <p class="text-sm text-secondary/80 leading-relaxed">
                            O SampaUI utiliza a arquitetura moderna do Tailwind CSS v4. As importações de CSS e JS integram automaticamente as fontes oficiais (Plus Jakarta Sans e Outfit), ícones e utilitários sem conflitos.
                        </p>

                        <div class="space-y-2 text-xs">
                            <strong class="text-heading block font-bold">Em resources/css/app.css:</strong>
                            <pre class="overflow-x-auto rounded-lg bg-secondary p-3 text-white font-mono"><code>@import "tailwindcss";
@import "../../vendor/sampaui/sampaui/dist/sampaui.css";</code></pre>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="space-y-2 text-xs">
                            <strong class="text-heading block font-bold">Em resources/js/app.js:</strong>
                            <pre class="overflow-x-auto rounded-lg bg-secondary p-3 text-white font-mono"><code>import './bootstrap';
import '../../vendor/sampaui/sampaui/dist/sampaui.js';</code></pre>
                        </div>

                        <div class="rounded-xl border border-border bg-surface p-4 text-xs text-secondary/80 space-y-2">
                            <strong class="text-heading block font-bold text-primary">Helper sampaui_cn() Disponível</strong>
                            <p>Utilize <code>sampaui_cn('p-4 bg-primary', $customClass)</code> para mesclar classes Tailwind resolvendo conflitos automaticamente.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Painel 4: Publicação Manual --}}
            <div x-show="installTab === 'manual'" x-cloak class="mt-6 space-y-6">
                <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr] items-start">
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-heading flex items-center gap-2">
                            <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-primary/10 text-primary text-xs font-bold">4</span>
                            Publicação seletiva por tags do Laravel
                        </h3>
                        <p class="text-sm text-secondary/80 leading-relaxed">
                            Se preferir publicar manualmente os recursos do pacote em vez de usar o instalador automático, utilize as tags de publicação oficiais:
                        </p>

                        <ul class="space-y-2 text-xs text-secondary/80 list-disc list-inside">
                            <li><code>sampaui-config</code>: Arquivo de configuração de temas e prefixo de tags.</li>
                            <li><code>sampaui-assets</code>: Arquivos CSS, JS e fontes em <code>public/vendor/sampaui</code>.</li>
                            <li><code>sampaui-views</code>: Todos os 48 templates Blade em <code>resources/views/vendor/sampaui</code>.</li>
                        </ul>
                    </div>

                    <x-docs.code-block :code="'# Publicar arquivo de configuração'.PHP_EOL.'php artisan vendor:publish --tag=sampaui-config'.PHP_EOL.PHP_EOL.'# Publicar assets (CSS, JS, fontes)'.PHP_EOL.'php artisan vendor:publish --tag=sampaui-assets --force'.PHP_EOL.PHP_EOL.'# Publicar views para customização'.PHP_EOL.'php artisan vendor:publish --tag=sampaui-views'" label="Terminal Artisan" />
                </div>
            </div>

            {{-- Painel 5: Diagnóstico & Comandos --}}
            <div x-show="installTab === 'doctor'" x-cloak class="mt-6 space-y-6">
                <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr] items-start">
                    <div class="space-y-4">
                        <h3 class="text-lg font-bold text-heading flex items-center gap-2">
                            <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-primary/10 text-primary text-xs font-bold">5</span>
                            Diagnóstico e catálogo pelo terminal
                        </h3>
                        <p class="text-sm text-secondary/80 leading-relaxed">
                            O SampaUI inclui ferramentas de diagnóstico para validar a saúde do ambiente, verificar dependências e inspecionar os componentes disponíveis.
                        </p>

                        <div class="grid gap-3 sm:grid-cols-2 pt-2">
                            <div class="rounded-xl border border-border bg-surface p-4 text-xs">
                                <strong class="text-heading block font-bold text-primary mb-1">sampaui:doctor</strong>
                                <p class="text-secondary/70">Testa a presença dos assets compilados, fontes, extensões e versões do Laravel/Livewire.</p>
                            </div>
                            <div class="rounded-xl border border-border bg-surface p-4 text-xs">
                                <strong class="text-heading block font-bold text-primary mb-1">sampaui:list</strong>
                                <p class="text-secondary/70">Lista todos os 48 componentes registrados com suas tags Blade e categorias.</p>
                            </div>
                        </div>
                    </div>

                    <x-docs.code-block :code="'# Diagnosticar saúde da instalação'.PHP_EOL.'php artisan sampaui:doctor'.PHP_EOL.PHP_EOL.'# Listar todos os 48 componentes'.PHP_EOL.'php artisan sampaui:list'.PHP_EOL.PHP_EOL.'# Informações do pacote'.PHP_EOL.'php artisan sampaui:about'" label="Comandos Utilitários" />
                </div>
            </div>
        </div>
    </section>

    {{-- Templates e Blocks em Destaque --}}
    <section class="doc-home-section" aria-labelledby="templates-title">
        <div class="doc-home-section-heading doc-home-section-heading-row">
            <div>
                <span class="doc-kicker">Blocks & Templates</span>
                <h2 id="templates-title">Composições prontas para acelerar seus projetos</h2>
                <p>Dashboards analíticos, fluxos de autenticação, tabelas completas e atendimento prontos para copiar e adaptar.</p>
            </div>
            <a href="{{ route('examples.index') }}" class="doc-card-link text-sm font-bold">
                Ver todos os {{ $templateTotal }} templates <i class="bi bi-arrow-right" aria-hidden="true"></i>
            </a>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($featuredTemplates as $template)
                <a
                    href="{{ route($template['route']) }}"
                    class="group flex flex-col justify-between rounded-xl border border-border bg-surface p-4 shadow-xs transition-all duration-150 hover:-translate-y-0.5 hover:border-primary/60 hover:shadow-md hover:shadow-primary/5"
                >
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-primary/10 text-primary">
                                <i class="bi bi-{{ $template['icon'] }} text-base"></i>
                            </span>
                            <span class="text-[0.6875rem] font-bold uppercase tracking-wider text-secondary/60">{{ $template['category'] }}</span>
                        </div>
                        <h3 class="text-sm font-bold text-heading group-hover:text-primary transition-colors">{{ $template['title'] }}</h3>
                        <p class="mt-1 text-xs text-secondary/70 leading-relaxed">{{ $template['description'] }}</p>
                    </div>

                    <span class="mt-4 inline-flex items-center gap-1.5 text-xs font-semibold text-primary">
                        Explorar template <i class="bi bi-arrow-right transition-transform group-hover:translate-x-0.5" aria-hidden="true"></i>
                    </span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Catálogo Completo de Componentes --}}
    <section
        id="componentes"
        class="doc-home-section"
        aria-labelledby="components-title"
        x-data="{
            activeFilter: 'all',
            searchQuery: '',
            matches(filters, name, slug, summary) {
                const matchesFilter = this.activeFilter === 'all' || filters.includes(this.activeFilter);
                if (!matchesFilter) return false;
                if (!this.searchQuery || this.searchQuery.trim() === '') return true;
                const q = this.searchQuery.toLowerCase().trim();
                return name.toLowerCase().includes(q) || slug.toLowerCase().includes(q) || summary.toLowerCase().includes(q);
            }
        }"
    >
        <div class="doc-home-section-heading doc-home-section-heading-row">
            <div>
                <span class="doc-kicker">Todos os componentes</span>
                <h2 id="components-title">Componentes organizados para acelerar CRMs, ERPs e sistemas internos em Laravel.</h2>
                <p>Props, estados, snippets Blade/Livewire e boas práticas em uma estrutura filtrável e previsível.</p>
            </div>
            <span class="doc-count-pill">{{ $componentTotal }} componentes</span>
        </div>

        {{-- Barra de Busca e Filtros Rápidos --}}
        <div class="doc-catalog-search-wrap">
            <i class="bi bi-search" aria-hidden="true"></i>
            <input
                type="search"
                x-model="searchQuery"
                placeholder="Filtrar componentes por nome, tag ou finalidade... (ex: table, modal, chat, button, select)"
                class="doc-catalog-search-input"
                aria-label="Buscar componentes"
            />
            <button
                type="button"
                class="doc-catalog-search-clear"
                x-show="searchQuery"
                x-on:click="searchQuery = ''"
                aria-label="Limpar busca"
            >
                <i class="bi bi-x-circle-fill"></i>
            </button>
        </div>

        <div class="doc-catalog-filters" role="tablist" aria-label="Filtrar componentes">
            @foreach ($catalogFilters as $filter)
                <button
                    type="button"
                    role="tab"
                    x-on:click="activeFilter = @js($filter['key'])"
                    x-bind:aria-selected="(activeFilter === @js($filter['key'])).toString()"
                    x-bind:class="activeFilter === @js($filter['key']) ? 'doc-catalog-filter-active' : ''"
                >
                    {{ $filter['label'] }}
                </button>
            @endforeach
        </div>

        <div class="doc-catalog-grid">
            @foreach ($components as $component)
                @php
                    $category = \App\Support\DocumentationGuidance::category($component['slug']);
                    $filter = \App\Support\DocumentationGuidance::filter($component['slug']);
                    $status = \App\Support\DocumentationGuidance::status($component);
                    $isPopular = \App\Support\DocumentationGuidance::isPopular($component['slug']);
                    $isNew = \App\Support\DocumentationGuidance::isNew($component['slug']);
                    $isForm = $category === 'Formulários';
                    $filters = collect(['all', $filter])
                        ->when($isPopular, fn ($items) => $items->push('popular'))
                        ->when($isNew, fn ($items) => $items->push('new'))
                        ->unique()
                        ->values()
                        ->all();
                @endphp
                <a
                    href="{{ route('documentation.components.show', $component['slug']) }}"
                    x-show="matches(@js($filters), @js($component['name']), @js($component['slug']), @js($component['summary']))"
                    x-transition.opacity.duration.150ms
                    @class([
                        'doc-catalog-card',
                        'doc-catalog-card-form' => $isForm,
                        'doc-catalog-card-ui' => ! $isForm,
                    ])
                >
                    <div class="doc-catalog-mini-preview" aria-hidden="true">
                        @include('docs.partials.component-preview', ['slug' => $component['slug']])
                    </div>
                    <div class="doc-catalog-meta-row">
                        @if ($status === 'Planejado')
                            <span class="doc-status-label doc-status-label-planned">Planejado</span>
                        @elseif ($isPopular)
                            <span class="doc-status-label doc-status-label-popular">Popular</span>
                        @elseif ($isNew)
                            <span class="doc-status-label doc-status-label-new">Novo</span>
                        @endif
                        <span class="doc-props-count">{{ count($component['props']) }} props</span>
                        <span class="doc-category-pill">{{ $category }}</span>
                    </div>
                    <div class="doc-catalog-card-copy">
                        <h3>{{ $component['name'] }}</h3>
                        <p>{{ $component['summary'] }}</p>
                    </div>
                    <span class="doc-card-link">Abrir documentação <i class="bi bi-arrow-right" aria-hidden="true"></i></span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Roadmap do Pacote --}}
    <section id="roadmap" class="doc-home-section" aria-labelledby="roadmap-title">
        <div class="doc-home-section-heading">
            <span class="doc-kicker">Roadmap</span>
            <h2 id="roadmap-title">O pacote continua evoluindo com o ecossistema.</h2>
            <p>Prioridades públicas para tornar o SampaUI mais útil em produtos reais.</p>
        </div>
        <div class="doc-roadmap-grid">
            @foreach ($roadmap as $item)
                <article>
                    <span><i class="bi bi-{{ $item['icon'] }}" aria-hidden="true"></i></span>
                    <div><small>{{ $item['status'] }}</small><h3>{{ $item['title'] }}</h3><p>{{ $item['copy'] }}</p></div>
                </article>
            @endforeach
        </div>
    </section>
@endsection
