<?php

namespace App\Support;

final class DocumentationGuidance
{
    /**
     * @param  array<string, mixed>  $component
     * @return array{use: list<string>, avoid: list<string>, errors: list<string>}
     */
    public static function for(array $component): array
    {
        $slug = (string) $component['slug'];
        $summary = rtrim((string) $component['summary'], '.');

        $formComponents = ['input', 'phone', 'currency-br', 'cep', 'pin', 'select', 'select-multiple', 'select-search', 'textarea', 'checkbox', 'radio', 'toggle', 'date-picker', 'file-upload', 'avatar-upload'];
        $overlayComponents = ['modal', 'drawer', 'dropdown', 'tooltip', 'command-palette'];
        $feedbackComponents = ['alert', 'toast', 'badge', 'indicator', 'progress', 'skeleton', 'empty-state'];

        return [
            'use' => [
                $summary.'.',
                in_array($slug, $formComponents, true)
                    ? 'Use em formulários Blade ou Livewire que precisam de label, estado e validação consistentes.'
                    : 'Use quando a interface precisar manter o mesmo padrão visual e comportamental do SampaUI.',
            ],
            'avoid' => [
                in_array($slug, $overlayComponents, true)
                    ? 'Evite para conteúdo essencial que deve permanecer visível durante toda a tarefa.'
                    : 'Evite quando um elemento semântico nativo mais simples resolver a tarefa sem perder consistência.',
                in_array($slug, $feedbackComponents, true)
                    ? 'Não use como única forma de comunicar uma informação crítica ou persistente.'
                    : 'Não duplique o componente com HTML solto apenas para pequenas diferenças de espaçamento.',
            ],
            'errors' => [
                in_array($slug, $formComponents, true)
                    ? 'Omitir name, label ou vínculo de erro e depender apenas do placeholder.'
                    : 'Alterar cores e estados sem respeitar as variantes semânticas do pacote.',
                'Sobrescrever classes estruturais quando class="" seria suficiente para ajustar somente layout e espaçamento.',
            ],
        ];
    }

    public static function category(string $slug): string
    {
        return in_array($slug, ['input', 'phone', 'currency-br', 'cep', 'pin', 'select', 'select-multiple', 'select-search', 'textarea', 'checkbox', 'radio', 'toggle', 'date-picker', 'file-upload', 'avatar-upload'], true)
            ? 'Formulários'
            : 'Design de UI';
    }
}
