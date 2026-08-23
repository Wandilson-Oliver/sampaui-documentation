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
        $category = self::category($slug);

        return [
            'use' => [
                $summary.'.',
                match ($category) {
                    'Formulários' => 'Use em formulários Blade ou Livewire que precisam de label, estado e validação consistentes.',
                    'Data' => 'Use para leitura, comparação, seleção e operação sobre dados de negócio.',
                    'Overlay' => 'Use para fluxos temporários que precisam de foco, contexto e retorno claro.',
                    'Comunicação' => 'Use para conversas, inbox, atendimento e composição de mensagens com consistência visual.',
                    default => 'Use quando a interface precisar manter o mesmo padrão visual e comportamental do SampaUI.',
                },
            ],
            'avoid' => [
                in_array($category, ['Overlay'], true)
                    ? 'Evite para conteúdo essencial que deve permanecer visível durante toda a tarefa.'
                    : 'Evite quando um elemento semântico nativo mais simples resolver a tarefa sem perder consistência.',
                in_array($category, ['Feedback'], true)
                    ? 'Não use como única forma de comunicar uma informação crítica ou persistente.'
                    : 'Não duplique o componente com HTML solto apenas para pequenas diferenças de espaçamento.',
            ],
            'errors' => [
                $category === 'Formulários'
                    ? 'Omitir name, label ou vínculo de erro e depender apenas do placeholder.'
                    : 'Alterar cores e estados sem respeitar as variantes semânticas do pacote.',
                'Sobrescrever classes estruturais quando class="" seria suficiente para ajustar somente layout e espaçamento.',
            ],
        ];
    }

    public static function category(string $slug): string
    {
        return match (true) {
            in_array($slug, ['input', 'phone', 'currency-br', 'cep', 'pin', 'select', 'select-multiple', 'select-search', 'textarea', 'checkbox', 'radio', 'toggle', 'date-picker', 'file-upload', 'avatar-upload'], true) => 'Formulários',
            in_array($slug, ['table', 'pagination'], true) => 'Data',
            in_array($slug, ['modal', 'drawer', 'dropdown', 'tooltip', 'command-palette'], true) => 'Overlay',
            in_array($slug, ['breadcrumb', 'sidebar', 'header', 'tabs', 'tab-panel', 'accordion', 'stepper'], true) => 'Navigation',
            in_array($slug, ['alert', 'toast', 'badge', 'indicator', 'progress', 'skeleton', 'empty-state'], true) => 'Feedback',
            in_array($slug, ['card', 'avatar', 'brand-mark', 'field'], true) => 'Layout',
            in_array($slug, ['chat-layout', 'chat-sidebar', 'chat-conversation', 'chat-message', 'chat-composer'], true) => 'Comunicação',
            default => 'Design de UI',
        };
    }

    public static function filter(string $slug): string
    {
        return match (self::category($slug)) {
            'Formulários' => 'forms',
            'Data' => 'data',
            'Overlay' => 'overlay',
            'Navigation' => 'navigation',
            'Feedback' => 'feedback',
            'Layout' => 'layout',
            'Comunicação' => 'communication',
            default => 'ui',
        };
    }

    public static function icon(string $slug): string
    {
        return match ($slug) {
            'button' => 'cursor',
            'input' => 'input-cursor-text',
            'pin' => 'key',
            'select', 'select-multiple', 'select-search' => 'menu-button-wide',
            'textarea' => 'textarea-t',
            'checkbox' => 'check2-square',
            'radio' => 'ui-radios',
            'date-picker' => 'calendar3',
            'avatar', 'avatar-upload' => 'person-circle',
            'modal' => 'window-stack',
            'drawer' => 'layout-sidebar-inset-reverse',
            'dropdown' => 'menu-button',
            'table' => 'table',
            'card' => 'window',
            'field' => 'input-cursor',
            'chat-layout', 'chat-sidebar', 'chat-conversation', 'chat-message', 'chat-composer' => 'chat-dots',
            'progress' => 'bar-chart-steps',
            'command-palette' => 'command',
            default => self::category($slug) === 'Formulários' ? 'ui-checks' : 'grid-1x2',
        };
    }

    public static function status(array $component): string
    {
        return (string) ($component['status'] ?? (in_array($component['slug'] ?? '', self::newSlugs(), true) ? 'Novo' : 'Pronto'));
    }

    public static function isPopular(string $slug): bool
    {
        return in_array($slug, ['button', 'input', 'select', 'badge', 'table', 'modal'], true);
    }

    public static function isNew(string $slug): bool
    {
        return in_array($slug, self::newSlugs(), true);
    }

    /**
     * @return list<string>
     */
    private static function newSlugs(): array
    {
        return ['brand-mark', 'command-palette'];
    }
}
