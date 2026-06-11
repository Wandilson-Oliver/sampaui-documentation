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
                'summary' => 'Paleta personalizada, tokens semanticos e orientacao para manter o visual consistente.',
                'description' => 'Guia rapido para ajustar as cores personalizadas do SampaUI usando os tokens do pacote.',
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
        ];

        return $pages;
    }
}
