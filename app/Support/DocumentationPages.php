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
                'summary' => 'Referência oficial de tokens semânticos, anatomia, dark mode e decisões visuais do SampaUI.',
                'description' => 'Guia de Design System para manter cores, tipografia, spacing, radius, shadows, borders, motion, grid, icons, focus ring e componentes consistentes.',
                'preview' => <<<'BLADE'
<div class="space-y-6">
    <x-sampaui::card padding="lg">
        <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_22rem]">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-primary">Paleta de cores</p>
                <h2 class="mt-3 text-3xl font-semibold tracking-tight text-primary">Paleta personalizada do SampaUI</h2>
                <p class="mt-4 max-w-2xl text-sm leading-6 text-secondary">
                    O pacote usa tokens semanticos definidos em <code>config/sampaui.php</code> e no bloco <code>@theme</code> do CSS. Para trocar a identidade visual, altere os mesmos tokens nos dois lugares, recompile o pacote e publique os assets no app consumidor.
                </p>
            </div>

            <x-sampaui::alert title="Regra do tema" variant="success">
                Mantenha as cores centralizadas nos tokens do SampaUI para preservar consistencia entre componentes e documentacao.
            </x-sampaui::alert>
        </div>
    </x-sampaui::card>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        @foreach ([
            ['name' => 'Primary', 'className' => 'bg-primary', 'hex' => '#5574C9', 'class' => 'bg-primary'],
            ['name' => 'Secondary', 'className' => 'bg-secondary', 'hex' => '#2E314A', 'class' => 'bg-secondary'],
            ['name' => 'Success', 'className' => 'bg-success', 'hex' => '#79C8BC', 'class' => 'bg-success'],
            ['name' => 'Accent', 'className' => 'bg-accent', 'hex' => '#FDB82E', 'class' => 'bg-accent'],
            ['name' => 'Purple', 'className' => 'bg-purple', 'hex' => '#895FC4', 'class' => 'bg-purple'],
            ['name' => 'Danger', 'className' => 'bg-danger', 'hex' => '#E84586', 'class' => 'bg-danger'],
            ['name' => 'Warning', 'className' => 'bg-warning', 'hex' => '#FF7D3D', 'class' => 'bg-warning'],
            ['name' => 'Info', 'className' => 'bg-info', 'hex' => '#43BEE3', 'class' => 'bg-info'],
            ['name' => 'Light', 'className' => 'bg-light', 'hex' => '#F4F6FA', 'class' => 'bg-light'],
            ['name' => 'Muted', 'className' => 'bg-muted', 'hex' => '#B7B8C5', 'class' => 'bg-muted'],
            ['name' => 'Surface', 'className' => 'bg-white', 'hex' => '#FFFFFF', 'class' => 'bg-white'],
            ['name' => 'Border', 'className' => 'border-light', 'hex' => '#F4F6FA', 'class' => 'bg-white'],
        ] as $color)
            <x-sampaui::card padding="lg">
                <div class="flex items-start gap-4">
                    <span class="h-14 w-14 shrink-0 rounded-[1.1rem] border border-light {{ $color['class'] }}"></span>
                    <div class="min-w-0">
                        <p class="font-semibold text-primary">{{ $color['name'] }}</p>
                        <p class="mt-1 text-sm text-secondary">{{ $color['className'] }}</p>
                        <p class="mt-1 font-mono text-xs font-semibold text-secondary">{{ $color['hex'] }}</p>
                        <p class="mt-2 text-xs font-semibold uppercase tracking-[0.18em] text-primary">Token SampaUI</p>
                    </div>
                </div>
            </x-sampaui::card>
        @endforeach
    </div>

    <x-sampaui::card title="Fundamentos do framework" description="Referência rápida para revisar antes de criar ou ajustar componentes" padding="lg">
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach ([
                ['title' => 'Colors', 'copy' => 'Tokens semânticos: primary, secondary, accent, danger, light, success, warning, info, purple e muted.'],
                ['title' => 'Typography', 'copy' => 'Hierarquia objetiva, pesos fortes em títulos, texto operacional legível e labels compactos.'],
                ['title' => 'Spacing', 'copy' => 'Espaçamento generoso, mas funcional: grids densos em dashboards e respiro em páginas institucionais.'],
                ['title' => 'Radius', 'copy' => 'Use rounded-default como base e aumente raio apenas em superfícies editoriais ou hero cards.'],
                ['title' => 'Shadows', 'copy' => 'Sombras discretas para elevação; nunca usar sombra pesada como substituta de hierarquia.'],
                ['title' => 'Borders', 'copy' => 'Campos e triggers usam border-secondary/20; divisores e cards usam border-light.'],
                ['title' => 'Elevation', 'copy' => 'Elevação deve indicar sobreposição, foco ou agrupamento de tarefas.'],
                ['title' => 'Motion', 'copy' => 'Transições curtas, úteis e previsíveis. Evite animações decorativas em fluxos operacionais.'],
                ['title' => 'Grid', 'copy' => 'Priorize layouts responsivos com colunas claras e fallback mobile em uma coluna.'],
                ['title' => 'Icons', 'copy' => 'Bootstrap Icons é a biblioteca oficial. Use sempre classes bi bi-*.'],
                ['title' => 'Focus Ring', 'copy' => 'Foco visível com focus:ring-primary/20 e contraste suficiente em light/dark.'],
                ['title' => 'Dark Mode', 'copy' => 'Superfícies, bordas, textos e estados precisam manter contraste sem criar tema paralelo.'],
            ] as $foundation)
                <div class="rounded-[1rem] border border-light bg-white p-4">
                    <p class="font-semibold text-primary">{{ $foundation['title'] }}</p>
                    <p class="mt-2 text-sm leading-6 text-secondary">{{ $foundation['copy'] }}</p>
                </div>
            @endforeach
        </div>
    </x-sampaui::card>

    <div class="grid gap-5 lg:grid-cols-2">
        <x-sampaui::card title="Component Anatomy" description="Estrutura recomendada para novos componentes" padding="lg">
            <div class="space-y-3 text-sm leading-6 text-secondary">
                <p><strong class="text-primary">Wrapper:</strong> controla layout, surface, radius, border e slots.</p>
                <p><strong class="text-primary">Control real:</strong> recebe name, id, wire:*, x-*, disabled, readonly, required e aria-*.</p>
                <p><strong class="text-primary">Feedback:</strong> hint, error, loading, success e empty state devem ser explícitos.</p>
                <p><strong class="text-primary">Slots:</strong> prefix, suffix, actions, footer e body devem evitar HTML duplicado no consumo.</p>
            </div>
        </x-sampaui::card>

        <x-sampaui::card title="Tokens semânticos" description="Não crie paleta paralela dentro de componentes" padding="lg">
            <div class="flex flex-wrap gap-2">
                @foreach (['primary', 'secondary', 'accent', 'danger', 'light', 'success', 'warning', 'info', 'purple', 'muted'] as $token)
                    <x-sampaui::badge variant="light">{{ $token }}</x-sampaui::badge>
                @endforeach
            </div>
            <x-sampaui::alert class="mt-5" title="Regra" variant="warning">
                Se um ajuste visual precisa de cor, primeiro verifique se já existe token semântico SampaUI.
            </x-sampaui::alert>
        </x-sampaui::card>
    </div>

    <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_24rem]">
        <x-sampaui::card title="Como alterar a paleta" description="Altere config e CSS juntos para manter pacote, docs e app consumidor sincronizados" padding="lg">
            <div class="space-y-4">
                @foreach ([
                    ['title' => '1. Edite sampaui/config/sampaui.php', 'copy' => 'Atualize o array theme com os hexadecimais oficiais da marca. Esses valores documentam a paleta que o pacote expõe.'],
                    ['title' => '2. Edite sampaui/resources/css/sampaui.css', 'copy' => 'Repita os mesmos valores no bloco @theme para o Tailwind gerar bg-primary, text-secondary, border-light e demais utilitarias.'],
                    ['title' => '3. Recompile o pacote', 'copy' => 'Rode npm run build dentro de sampaui para atualizar dist/sampaui.css.'],
                    ['title' => '4. Publique no app consumidor', 'copy' => 'Rode php artisan vendor:publish --tag=sampaui-assets --force e php artisan view:clear no projeto Laravel que usa o pacote.'],
                ] as $step)
                    <div class="rounded-[1.1rem] border border-light bg-white p-4">
                        <p class="font-semibold text-primary">{{ $step['title'] }}</p>
                        <p class="mt-1 text-sm leading-6 text-secondary">{{ $step['copy'] }}</p>
                    </div>
                @endforeach
            </div>
        </x-sampaui::card>

        <x-sampaui::card title="Arquivos que controlam as cores" description="Use os mesmos hexadecimais nos dois arquivos" padding="lg">
            <div class="space-y-4">
                <div>
                    <p class="mb-2 text-xs font-semibold uppercase tracking-[0.18em] text-primary">config/sampaui.php</p>
                    <pre class="overflow-x-auto rounded-[1rem] bg-primary p-4 text-xs leading-6 text-white"><code>'theme' => [
    'primary' => '#5574C9',
    'secondary' => '#2E314A',
    'accent' => '#FDB82E',
    'danger' => '#E84586',
    'light' => '#F4F6FA',
    'success' => '#79C8BC',
    'warning' => '#FF7D3D',
    'info' => '#43BEE3',
    'purple' => '#895FC4',
    'muted' => '#B7B8C5',
],</code></pre>
                </div>

                <div>
                    <p class="mb-2 text-xs font-semibold uppercase tracking-[0.18em] text-primary">resources/css/sampaui.css</p>
                    <pre class="overflow-x-auto rounded-[1rem] bg-secondary p-4 text-xs leading-6 text-white"><code>@theme {
  --color-primary: #5574C9;
  --color-secondary: #2E314A;
  --color-accent: #FDB82E;
  --color-danger: #E84586;
  --color-light: #F4F6FA;
  --color-success: #79C8BC;
  --color-warning: #FF7D3D;
  --color-info: #43BEE3;
  --color-purple: #895FC4;
  --color-muted: #B7B8C5;
}</code></pre>
                </div>
            </div>
        </x-sampaui::card>
    </div>

    <x-sampaui::card title="Comandos depois da alteracao" description="Fluxo minimo para validar e publicar a nova paleta" padding="lg">
        <pre class="overflow-x-auto rounded-[1rem] bg-primary p-4 text-xs leading-6 text-white"><code>cd sampaui
npm run build
composer test

cd ../sampaui-documentation
npm run build
php artisan test
php artisan view:clear

# no app consumidor
php artisan vendor:publish --tag=sampaui-assets --force
php artisan view:clear</code></pre>
    </x-sampaui::card>
</div>
BLADE,
                'code' => <<<'BLADE'
{{-- Use tokens customizados do SampaUI --}}
<x-sampaui::button class="bg-primary text-white hover:bg-primary/90">
    Salvar
</x-sampaui::button>

{{-- Depois de alterar classes no pacote --}}
{{-- cd sampaui && npm run build --}}

{{-- Depois, no app consumidor --}}
{{-- php artisan vendor:publish --tag=sampaui-assets --force --}}
{{-- php artisan view:clear --}}
BLADE,
            ],
            'real-estate-patterns' => [
                'slug' => 'real-estate-patterns',
                'name' => 'Padrões imobiliários',
                'icon' => 'buildings',
                'tag' => 'Imobiliário',
                'summary' => 'Receitas objetivas para CRM, captação, funil comercial, atendimento e propostas.',
                'description' => 'Guia de composição para manter produtos imobiliários Laravel consistentes com o ecossistema SampaUI.',
                'preview' => <<<'BLADE'
<div class="space-y-6">
    <x-sampaui::card padding="lg">
        <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_22rem]">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-primary">CRM imobiliário</p>
                <h2 class="mt-3 text-3xl font-semibold tracking-tight text-primary">Padrões para captação, atendimento e conversão</h2>
                <p class="mt-4 max-w-2xl text-sm leading-6 text-secondary">
                    Use estes blocos para orientar agentes de IA e times de produto. A regra é compor telas com componentes SampaUI antes de criar marcação solta.
                </p>
            </div>

            <x-sampaui::alert title="Regra prática" variant="info">
                Componentes primeiro, `class=""` para ajuste fino e novo componente apenas quando o padrão se repetir.
            </x-sampaui::alert>
        </div>
    </x-sampaui::card>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        @foreach ([
            ['title' => 'Captar', 'icon' => 'person-plus', 'copy' => 'Formulários de lead, proprietário e imóvel.'],
            ['title' => 'Qualificar', 'icon' => 'funnel', 'copy' => 'Origem, orçamento, região, interesse e prioridade.'],
            ['title' => 'Atender', 'icon' => 'chat-dots', 'copy' => 'Histórico de conversa, anexos e follow-up.'],
            ['title' => 'Converter', 'icon' => 'file-earmark-check', 'copy' => 'Proposta, visita, contrato e assinatura.'],
        ] as $step)
            <x-sampaui::card padding="lg">
                <span class="inline-flex h-12 w-12 items-center justify-center rounded-default bg-light text-xl text-primary">
                    <i class="bi bi-{{ $step['icon'] }}"></i>
                </span>
                <h3 class="mt-5 text-xl font-semibold text-primary">{{ $step['title'] }}</h3>
                <p class="mt-2 text-sm leading-6 text-secondary">{{ $step['copy'] }}</p>
            </x-sampaui::card>
        @endforeach
    </div>

    <div class="grid gap-5 xl:grid-cols-[minmax(0,1fr)_24rem]">
        <x-sampaui::card title="Lead comprador" description="Ficha de qualificação" padding="lg">
            <div class="grid gap-4 md:grid-cols-2">
                <x-sampaui::input name="lead_name" label="Nome" icon="person" placeholder="Ana Souza" />
                <x-sampaui::phone name="lead_phone" label="WhatsApp" value="11988887777" />
                <x-sampaui::currency-br name="lead_budget" label="Orçamento" value="890000" />
                <x-sampaui::select-search
                    name="lead_broker"
                    label="Corretor"
                    :options="['ana' => 'Ana Souza', 'bruno' => 'Bruno Lima', 'carla' => 'Carla Martins']"
                    value="ana"
                />
            </div>
        </x-sampaui::card>

        <x-sampaui::card title="Meta mensal" description="Fechamento projetado" padding="lg">
            <div class="space-y-5">
                <div class="flex items-end justify-between gap-4">
                    <div>
                        <p class="text-3xl font-semibold text-primary">68%</p>
                        <p class="mt-1 text-sm text-secondary">R$ 2,4 mi em propostas</p>
                    </div>
                    <x-sampaui::badge variant="success">No prazo</x-sampaui::badge>
                </div>
                <x-sampaui::progress value="68" label="Receita" />
                <x-sampaui::button full icon="clipboard-check">Revisar propostas</x-sampaui::button>
            </div>
        </x-sampaui::card>
    </div>

    <x-sampaui::card title="Trechos recomendados para IA" description="Copie o bloco certo e adapte dados/rotas ao app consumidor" padding="lg">
        <pre class="overflow-x-auto rounded-[1rem] bg-secondary p-4 text-xs leading-6 text-white"><code>&lt;x-sampaui::card title="Apartamento Vila Mariana" description="Lead quente"&gt;
    &lt;x-sampaui::badge variant="success"&gt;Disponível&lt;/x-sampaui::badge&gt;
    &lt;x-sampaui::badge variant="accent"&gt;R$ 890.000&lt;/x-sampaui::badge&gt;
    &lt;x-sampaui::button icon="calendar2-check"&gt;Agendar visita&lt;/x-sampaui::button&gt;
&lt;/x-sampaui::card&gt;</code></pre>
    </x-sampaui::card>
</div>
BLADE,
                'code' => <<<'BLADE'
{{-- Card de imóvel --}}
<x-sampaui::card title="Apartamento Vila Mariana" description="Lead quente" padding="lg">
    <div class="flex flex-wrap gap-2">
        <x-sampaui::badge variant="success">Disponível</x-sampaui::badge>
        <x-sampaui::badge variant="accent">R$ 890.000</x-sampaui::badge>
        <x-sampaui::badge variant="light">2 dorms</x-sampaui::badge>
    </div>

    <div class="mt-5 flex flex-wrap gap-3">
        <x-sampaui::button icon="calendar2-check">Agendar visita</x-sampaui::button>
        <x-sampaui::button variant="outline" icon="chat-dots">Conversar</x-sampaui::button>
    </div>
</x-sampaui::card>

{{-- Formulário de lead --}}
<x-sampaui::input name="name" label="Nome" icon="person" wire:model.live="lead.name" />
<x-sampaui::phone name="phone" label="WhatsApp" wire:model.live="lead.phone" />
<x-sampaui::currency-br name="budget" label="Orçamento" wire:model.live="lead.budget" />
BLADE,
            ],
        ];

        return $pages;
    }
}
