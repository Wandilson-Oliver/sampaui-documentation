<x-sampaui::card title="{{ $codeTitle ?? 'Trecho de uso' }}" description="{{ $description ?? 'Blade copiavel para usar em uma pagina Laravel/Livewire' }}" padding="lg">
    <div class="doc-showcase-code-wrap rounded-[1.35rem] border border-light" x-data="{ copied: false }">
        <button
            type="button"
            class="doc-copy-button"
            x-bind:aria-label="copied ? 'Codigo copiado' : 'Copiar codigo'"
            x-on:click="
                navigator.clipboard?.writeText($refs.code.innerText);
                copied = true;
                setTimeout(() => copied = false, 1200);
            "
        >
            <i class="bi" x-bind:class="copied ? 'bi-check2' : 'bi-copy'"></i>
        </button>

        <pre class="doc-showcase-code"><code x-ref="code">{{ trim($snippet) }}</code></pre>
    </div>
</x-sampaui::card>
