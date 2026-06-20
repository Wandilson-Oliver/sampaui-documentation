<x-sampaui::card title="{{ $codeTitle ?? 'Trecho de uso' }}" description="{{ $description ?? 'Blade copiavel para usar em uma pagina Laravel/Livewire' }}" padding="lg">
    <x-docs.code-block :code="$snippet" :label="$codeLabel ?? 'Blade'" />
</x-sampaui::card>
