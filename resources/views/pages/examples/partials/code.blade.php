@props([
    'snippet' => '',
    'livewireSnippet' => null,
    'codeTitle' => 'Trecho de uso',
    'description' => 'Copie o código completo para utilizar diretamente na sua aplicação Laravel ou Livewire.',
    'codeLabel' => 'Blade View',
    'components' => [],
])

<div class="space-y-4 pt-2" x-data="{ tab: 'blade' }">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="flex items-center gap-2">
                <span class="inline-flex h-2.5 w-2.5 rounded-full bg-emerald-500 shadow-sm"></span>
                <h2 class="text-xl font-bold tracking-tight text-heading">{{ $codeTitle }}</h2>
                <span class="rounded-md border border-primary/20 bg-primary/10 px-2 py-0.5 text-xs font-semibold text-primary">Trecho de uso</span>
            </div>
            <p class="mt-1 text-sm text-secondary/80">{{ $description }}</p>
        </div>

        @if(filled($livewireSnippet))
            <div class="inline-flex rounded-xl border border-border bg-surface p-1 shadow-xs">
                <button
                    type="button"
                    x-on:click="tab = 'blade'"
                    x-bind:class="tab === 'blade' ? 'bg-primary text-white shadow-xs font-semibold' : 'text-secondary hover:text-heading'"
                    class="flex items-center gap-2 rounded-lg px-3.5 py-1.5 text-xs transition cursor-pointer"
                >
                    <i class="bi bi-code-slash"></i> Blade View
                </button>
                <button
                    type="button"
                    x-on:click="tab = 'livewire'"
                    x-bind:class="tab === 'livewire' ? 'bg-primary text-white shadow-xs font-semibold' : 'text-secondary hover:text-heading'"
                    class="flex items-center gap-2 rounded-lg px-3.5 py-1.5 text-xs transition cursor-pointer"
                >
                    <i class="bi bi-lightning-charge"></i> Livewire Component (PHP)
                </button>
            </div>
        @endif
    </div>

    @if(!empty($components))
        <div class="flex flex-wrap items-center gap-2 pt-1">
            <span class="text-xs font-semibold text-secondary/70">Componentes utilizados:</span>
            @foreach($components as $comp)
                <span class="inline-flex items-center gap-1 rounded-md border border-border bg-surface-subtle px-2 py-0.5 font-mono text-[11px] font-semibold text-primary">
                    <i class="bi bi-box"></i> {{ $comp }}
                </span>
            @endforeach
        </div>
    @endif

    <div x-show="tab === 'blade'">
        <x-docs.code-block :code="$snippet" :label="$codeLabel" />
    </div>

    @if(filled($livewireSnippet))
        <div x-show="tab === 'livewire'" x-cloak>
            <x-docs.code-block :code="$livewireSnippet" label="PHP (Livewire Component)" />
        </div>
    @endif
</div>
