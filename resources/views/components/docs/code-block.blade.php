@props([
    'code',
    'label' => 'Código',
    'tone' => 'dark',
])

<div @class(['doc-code-block', 'doc-code-block-light' => $tone === 'light']) x-data="copyCode()">
    <div class="doc-code-toolbar">
        <span>{{ $label }}</span>
        <button type="button" x-on:click="copy($refs.code.innerText)" x-bind:aria-label="copied ? 'Código copiado' : 'Copiar código'">
            <i class="bi" x-bind:class="copied ? 'bi-check2' : 'bi-copy'" aria-hidden="true"></i>
            <span x-text="copied ? 'Copiado' : 'Copiar'"></span>
        </button>
    </div>
    <pre><code x-ref="code">{{ trim($code) }}</code></pre>
</div>
