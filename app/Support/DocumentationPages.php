<?php

namespace App\Support;

class DocumentationPages
{
    /**
     * @return array<string, array<string, mixed>>
     */
    public static function all(): array
    {
        $pages = [
            'design-system' => [
                'slug' => 'design-system',
                'name' => 'Design system',
                'icon' => 'palette2',
                'tag' => 'Foundations',
                'summary' => 'Referência oficial de tokens semânticos, paleta de cores, tipografia, anatomia de componentes e guia para customização visual do SampaUI.',
                'description' => 'Aprenda como o ecossistema SampaUI organiza tokens de design em Laravel, Livewire e Tailwind CSS v4 para manter uma interface moderna, consistente, acessível e pronta para dark mode.',
                'preview' => <<<'BLADE'
<div class="space-y-10">
    <!-- Intro Card -->
    <div class="rounded-2xl border border-border bg-surface p-6 md:p-8 shadow-sm">
        <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_22rem] items-center">
            <div>
                <div class="inline-flex items-center gap-2 rounded-full border border-primary/20 bg-primary/10 px-3 py-1 text-xs font-semibold text-primary mb-3">
                    <i class="bi bi-stars"></i> Tokens & Diretrizes Visuais
                </div>
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-heading">Arquitetura de Design System</h2>
                <p class="mt-3 text-sm md:text-base leading-relaxed text-secondary/80">
                    O SampaUI utiliza uma arquitetura baseada em <strong>tokens semânticos centralizados</strong>. As cores e propriedades visuais são declaradas no arquivo <code>config/sampaui.php</code> e mapeadas no bloco <code>@theme</code> do Tailwind CSS, garantindo total harmonia entre os componentes Blade, os scripts Alpine.js e as regras CSS.
                </p>
            </div>

            <x-sampaui::alert title="Princípio de Ouro" variant="success">
                Nunca utilize cores hexadecimais soltas no código. Utilize sempre as classes semânticas oficiais (<code>bg-primary</code>, <code>text-secondary</code>, <code>border-border</code>).
            </x-sampaui::alert>
        </div>
    </div>

    <!-- 1. Paleta de Cores Semânticas -->
    <div class="space-y-4">
        <div>
            <h3 class="text-xl font-bold tracking-tight text-heading flex items-center gap-2">
                <i class="bi bi-palette text-primary"></i> 1. Paleta de Cores & Tokens Semânticos
            </h3>
            <p class="mt-1 text-sm text-secondary/70">Clique nas classes para entender o propósito de cada token no ecossistema.</p>
        </div>

        <!-- Grupo: Marca e Ações -->
        <div>
            <p class="text-xs font-bold uppercase tracking-wider text-secondary/60 mb-3">Cores de Identidade & Ação</p>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    ['name' => 'Primary (Teal)', 'bg' => 'bg-primary', 'hex' => '#2FAFD3', 'usage' => 'Botões de ação principal, links ativos, foco e destaques.'],
                    ['name' => 'Secondary (Navy)', 'bg' => 'bg-secondary', 'hex' => '#102A43', 'usage' => 'Títulos fortes, ícones de cabeçalho e superfícies escuras.'],
                    ['name' => 'Accent (Amber)', 'bg' => 'bg-accent', 'hex' => '#F7931E', 'usage' => 'Badges populares, notificações e detalhes de destaque.'],
                    ['name' => 'Purple (Royal)', 'bg' => 'bg-purple', 'hex' => '#7C5CFC', 'usage' => 'Tags especiais, métricas analíticas e recursos pro.'],
                ] as $color)
                    <div class="rounded-xl border border-border bg-surface p-4 shadow-sm transition hover:border-primary/40">
                        <div class="flex items-center gap-3">
                            <span class="h-12 w-12 shrink-0 rounded-xl shadow-inner {{ $color['bg'] }}"></span>
                            <div class="min-w-0 flex-1">
                                <p class="font-bold text-heading text-sm">{{ $color['name'] }}</p>
                                <p class="font-mono text-xs text-secondary/60 font-semibold">{{ $color['hex'] }}</p>
                            </div>
                        </div>
                        <p class="mt-3 text-xs leading-5 text-secondary/80 border-t border-border/60 pt-2.5">{{ $color['usage'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Grupo: Feedback e Status -->
        <div class="pt-2">
            <p class="text-xs font-bold uppercase tracking-wider text-secondary/60 mb-3">Feedback, Alertas & Validação</p>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    ['name' => 'Success', 'bg' => 'bg-success', 'hex' => '#2CB36C', 'usage' => 'Sucesso, conclusões, badges positivos e confirmações.'],
                    ['name' => 'Danger', 'bg' => 'bg-danger', 'hex' => '#D93045', 'usage' => 'Erros de validação, alertas críticos e ações de exclusão.'],
                    ['name' => 'Warning', 'bg' => 'bg-warning', 'hex' => '#FBBF24', 'usage' => 'Avisos preventivos, pendências e atenção.'],
                    ['name' => 'Info', 'bg' => 'bg-info', 'hex' => '#4FC3E8', 'usage' => 'Dicas contextuais, guias e informações operacionais.'],
                ] as $color)
                    <div class="rounded-xl border border-border bg-surface p-4 shadow-sm transition hover:border-primary/40">
                        <div class="flex items-center gap-3">
                            <span class="h-12 w-12 shrink-0 rounded-xl shadow-inner {{ $color['bg'] }}"></span>
                            <div class="min-w-0 flex-1">
                                <p class="font-bold text-heading text-sm">{{ $color['name'] }}</p>
                                <p class="font-mono text-xs text-secondary/60 font-semibold">{{ $color['hex'] }}</p>
                            </div>
                        </div>
                        <p class="mt-3 text-xs leading-5 text-secondary/80 border-t border-border/60 pt-2.5">{{ $color['usage'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Grupo: Superfícies e Estrutura -->
        <div class="pt-2">
            <p class="text-xs font-bold uppercase tracking-wider text-secondary/60 mb-3">Superfícies, Bordas & Contraste</p>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    ['name' => 'Surface', 'bg' => 'bg-surface border border-border', 'hex' => '#FFFFFF', 'usage' => 'Fundo de cards, painéis modais, menus e dropdowns.'],
                    ['name' => 'Light', 'bg' => 'bg-light border border-border', 'hex' => '#F8FAFC', 'usage' => 'Fundo de páginas, áreas sutis e estados desabilitados.'],
                    ['name' => 'Border', 'bg' => 'bg-border', 'hex' => '#E2E8F0', 'usage' => 'Linhas divisórias, contorno de cards e separadores.'],
                    ['name' => 'Muted', 'bg' => 'bg-muted', 'hex' => '#CBD5E1', 'usage' => 'Textos secundários, placeholders e bordas suaves.'],
                ] as $color)
                    <div class="rounded-xl border border-border bg-surface p-4 shadow-sm transition hover:border-primary/40">
                        <div class="flex items-center gap-3">
                            <span class="h-12 w-12 shrink-0 rounded-xl shadow-inner {{ $color['bg'] }}"></span>
                            <div class="min-w-0 flex-1">
                                <p class="font-bold text-heading text-sm">{{ $color['name'] }}</p>
                                <p class="font-mono text-xs text-secondary/60 font-semibold">{{ $color['hex'] }}</p>
                            </div>
                        </div>
                        <p class="mt-3 text-xs leading-5 text-secondary/80 border-t border-border/60 pt-2.5">{{ $color['usage'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- 2. Fundamentos Visuais (Tipografia, Radius, Sombras, Foco) -->
    <div class="space-y-4 pt-4">
        <div>
            <h3 class="text-xl font-bold tracking-tight text-heading flex items-center gap-2">
                <i class="bi bi-grid-1x2 text-primary"></i> 2. Fundamentos Visuais
            </h3>
            <p class="mt-1 text-sm text-secondary/70">Padrões estruturais aplicados rigorosamente em todos os componentes do pacote.</p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ([
                ['title' => 'Tipografia', 'icon' => 'fonts', 'copy' => 'Utiliza a fonte Instrument Sans com forte contraste hierárquico: títulos em semibold/bold e corpo legível e fluido.'],
                ['title' => 'Raios de Borda (Radius)', 'icon' => 'square', 'copy' => 'rounded-default (12px) para inputs, cards e botões. rounded-full para badges e avatares circulares.'],
                ['title' => 'Sombras & Elevação', 'icon' => 'shadows', 'copy' => 'Sombras suaves (shadow-sm, shadow-xl) reservadas para dropdowns e modais flutuantes.'],
                ['title' => 'Anéis de Foco (A11y)', 'icon' => 'bullseye', 'copy' => 'Foco acessível em todos os controles navegáveis por teclado via focus:ring-2 focus:ring-primary/20.'],
                ['title' => 'Ícones Padronizados', 'icon' => 'bootstrap', 'copy' => 'Bootstrap Icons (bi bi-*) integrado nativamente como biblioteca oficial com suporte a props dedicadas.'],
                ['title' => 'Dark Mode Nativo', 'icon' => 'moon-stars', 'copy' => 'Transições suaves para modo escuro via variáveis CSS e classes utilitárias dark: sem quebrar contrastes.'],
            ] as $foundation)
                <div class="rounded-xl border border-border bg-surface p-5 shadow-sm">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-surface-subtle text-primary border border-border">
                            <i class="bi bi-{{ $foundation['icon'] }} text-lg"></i>
                        </span>
                        <h4 class="font-bold text-heading text-base">{{ $foundation['title'] }}</h4>
                    </div>
                    <p class="mt-3 text-sm leading-relaxed text-secondary/80">{{ $foundation['copy'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- 3. Anatomia de Componentes -->
    <div class="space-y-4 pt-4">
        <div>
            <h3 class="text-xl font-bold tracking-tight text-heading flex items-center gap-2">
                <i class="bi bi-layers text-primary"></i> 3. Anatomia de um Componente SampaUI
            </h3>
            <p class="mt-1 text-sm text-secondary/70">Todo componente segue uma estrutura consistente de 4 camadas para máxima previsibilidade:</p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-xl border border-border bg-surface p-5">
                <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-primary/10 text-primary font-bold text-xs mb-3">1</span>
                <h4 class="font-bold text-heading text-sm">Wrapper / Field</h4>
                <p class="mt-2 text-xs leading-relaxed text-secondary/80">Controla labels acessíveis, asterisco de obrigatório, layout e espaçamento vertical.</p>
            </div>

            <div class="rounded-xl border border-border bg-surface p-5">
                <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-primary/10 text-primary font-bold text-xs mb-3">2</span>
                <h4 class="font-bold text-heading text-sm">Controle Nativo</h4>
                <p class="mt-2 text-xs leading-relaxed text-secondary/80">Preserva atributos HTML (name, id, required, disabled) e bindings reativos Livewire/Alpine.</p>
            </div>

            <div class="rounded-xl border border-border bg-surface p-5">
                <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-primary/10 text-primary font-bold text-xs mb-3">3</span>
                <h4 class="font-bold text-heading text-sm">Feedback Visual</h4>
                <p class="mt-2 text-xs leading-relaxed text-secondary/80">Mensagens de erro de validação (ErrorBag), hint de apoio e estados de carregamento (loading).</p>
            </div>

            <div class="rounded-xl border border-border bg-surface p-5">
                <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-primary/10 text-primary font-bold text-xs mb-3">4</span>
                <h4 class="font-bold text-heading text-sm">Slots Flexíveis</h4>
                <p class="mt-2 text-xs leading-relaxed text-secondary/80">Prefixos, sufixos, botões de ação e rodapés customizáveis sem duplicação de marcação.</p>
            </div>
        </div>
    </div>

    <!-- 4. Guia Passo a Passo de Customização -->
    <div class="space-y-4 pt-4">
        <div>
            <h3 class="text-xl font-bold tracking-tight text-heading flex items-center gap-2">
                <i class="bi bi-sliders text-primary"></i> 4. Como Customizar a Paleta de Cores
            </h3>
            <p class="mt-1 text-sm text-secondary/70">Passo a passo definitivo para alterar os tokens e publicar em sua aplicação:</p>
        </div>

        <div class="grid gap-5 lg:grid-cols-2">
            <!-- Passo 1 e 2 -->
            <div class="rounded-xl border border-border bg-surface p-6 space-y-4">
                <div class="flex items-start gap-3">
                    <span class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-primary text-white font-bold text-xs">1</span>
                    <div>
                        <h4 class="font-bold text-heading text-sm">Atualize config/sampaui.php</h4>
                        <p class="mt-1 text-xs text-secondary/70">Defina os valores hexadecimais da sua marca no array de tema.</p>
                    </div>
                </div>
                <pre class="overflow-x-auto rounded-lg bg-secondary p-3.5 text-xs text-white"><code>'theme' => [
    'primary'   => '#2FAFD3',
    'secondary' => '#102A43',
    'accent'    => '#F7931E',
    'success'   => '#2CB36C',
    'danger'    => '#D93045',
],</code></pre>

                <div class="flex items-start gap-3 pt-2 border-t border-border/60">
                    <span class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-primary text-white font-bold text-xs">2</span>
                    <div>
                        <h4 class="font-bold text-heading text-sm">Atualize resources/css/sampaui.css</h4>
                        <p class="mt-1 text-xs text-secondary/70">Mapeie as mesmas variáveis no bloco @theme do Tailwind v4.</p>
                    </div>
                </div>
                <pre class="overflow-x-auto rounded-lg bg-secondary p-3.5 text-xs text-white"><code>@theme {
  --color-primary: #2FAFD3;
  --color-secondary: #102A43;
  --color-accent: #F7931E;
}</code></pre>
            </div>

            <!-- Passo 3 e 4 -->
            <div class="rounded-xl border border-border bg-surface p-6 space-y-4">
                <div class="flex items-start gap-3">
                    <span class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-primary text-white font-bold text-xs">3</span>
                    <div>
                        <h4 class="font-bold text-heading text-sm">Recompile o pacote SampaUI</h4>
                        <p class="mt-1 text-xs text-secondary/70">Gere a distribuição compilada do Tailwind CSS no pacote.</p>
                    </div>
                </div>
                <pre class="overflow-x-auto rounded-lg bg-secondary p-3.5 text-xs text-white"><code>cd sampaui
npm run build</code></pre>

                <div class="flex items-start gap-3 pt-2 border-t border-border/60">
                    <span class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-primary text-white font-bold text-xs">4</span>
                    <div>
                        <h4 class="font-bold text-heading text-sm">Publique e limpe o cache na aplicação</h4>
                        <p class="mt-1 text-xs text-secondary/70">Atualize os arquivos publicados no seu projeto Laravel.</p>
                    </div>
                </div>
                <pre class="overflow-x-auto rounded-lg bg-secondary p-3.5 text-xs text-white"><code>php artisan vendor:publish --tag=sampaui-assets --force
php artisan view:clear</code></pre>
            </div>
        </div>
    </div>
</div>
BLADE,
                'code' => <<<'BLADE'
{{-- 1. Exemplo de botão usando token oficial Primary --}}
<x-sampaui::button variant="primary">
    Salvar alterações
</x-sampaui::button>

{{-- 2. Exemplo de Card estruturado com Surface e Border --}}
<x-sampaui::card padding="md">
    <h3 class="text-lg font-bold text-heading">Card Semântico</h3>
    <p class="text-sm text-secondary/80 mt-1">Utiliza superfícies e bordas oficiais.</p>
</x-sampaui::card>

{{-- 3. Exemplo de Badge de Status com token Success --}}
<x-sampaui::badge variant="success">
    Aprovado
</x-sampaui::badge>
BLADE,
            ],
        ];

        return $pages;
    }
}
