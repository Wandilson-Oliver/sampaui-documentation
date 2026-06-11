<?php

namespace App\Http\Controllers;

use App\Support\DocumentationComponents;
use App\Support\DocumentationPages;
use Illuminate\Contracts\View\View;

class ExampleController extends Controller
{
    /**
     * @return array<int, array<string, string>>
     */
    public static function examples(): array
    {
        return [
            [
                'title' => 'Login completo',
                'copy' => 'Tela de acesso com alerta, campos, lembrar-me e estado de loading.',
                'icon' => 'shield-lock',
                'route' => 'examples.authentication',
                'tag' => 'Auth',
            ],
            [
                'title' => 'Dashboard operacional',
                'copy' => 'Sidebar, topbar, metricas, atividades e tabela no padrao SaaS.',
                'icon' => 'speedometer2',
                'route' => 'examples.dashboard',
                'tag' => 'Dashboard',
            ],
            [
                'title' => 'CRUD de usuários',
                'copy' => 'Livewire real com filtros, tabela, modal, acoes e paginacao.',
                'icon' => 'people',
                'route' => 'examples.users.index',
                'tag' => 'Livewire',
            ],
            [
                'title' => 'Formulário administrativo',
                'copy' => 'Cadastro grande com dados, contato, endereco, valores e preferencias.',
                'icon' => 'ui-checks-grid',
                'route' => 'examples.admin-form',
                'tag' => 'Forms',
            ],
            [
                'title' => 'Modal destrutivo',
                'copy' => 'Confirmacao de exclusao com alerta, persistencia e acao final.',
                'icon' => 'trash3',
                'route' => 'examples.destructive-modal',
                'tag' => 'Overlay',
            ],
            [
                'title' => 'Drawer de filtros',
                'copy' => 'Painel lateral para segmentar listagens sem perder contexto.',
                'icon' => 'sliders2',
                'route' => 'examples.filter-drawer',
                'tag' => 'Overlay',
            ],
            [
                'title' => 'Tabela avançada',
                'copy' => 'Tabela com avatar, badges, dropdown, skeleton, vazio e paginacao.',
                'icon' => 'table',
                'route' => 'examples.advanced-table',
                'tag' => 'Data',
            ],
            [
                'title' => 'Upload e perfil',
                'copy' => 'Avatar, galeria, documentos e informacoes de contato em uma tela.',
                'icon' => 'person-badge',
                'route' => 'examples.profile',
                'tag' => 'Upload',
            ],
            [
                'title' => 'Verificação 2FA',
                'copy' => 'Fluxo com PIN, alerta, progresso e reenvio de codigo.',
                'icon' => 'key',
                'route' => 'examples.verification',
                'tag' => 'Auth',
            ],
            [
                'title' => 'Command palette',
                'copy' => 'Busca global acionada por evento, comandos e atalhos do painel.',
                'icon' => 'command',
                'route' => 'examples.command-palette',
                'tag' => 'Busca',
            ],
            [
                'title' => 'Configurações em abas',
                'copy' => 'Perfil, seguranca e notificacoes organizados com tabs.',
                'icon' => 'gear',
                'route' => 'examples.settings',
                'tag' => 'Settings',
            ],
            [
                'title' => 'Estados de feedback',
                'copy' => 'Toast, alertas, progresso, skeleton e estado vazio juntos.',
                'icon' => 'chat-square-heart',
                'route' => 'examples.feedback',
                'tag' => 'Feedback',
            ],
            [
                'title' => 'Chat atendimento',
                'copy' => 'Interface de mensagens estilo WhatsApp Web com conversas, bolhas e envio local.',
                'icon' => 'chat-dots',
                'route' => 'examples.chat',
                'tag' => 'Chat',
            ],
            [
                'title' => 'Bootstrap Icons',
                'copy' => 'Busca rápida dos principais ícones Bootstrap Icons com classes copiáveis.',
                'icon' => 'bootstrap',
                'route' => 'examples.icons',
                'tag' => 'Icons',
            ],
        ];
    }

    /**
     * @return array<int, array<string, string>>
     */
    public static function navigationExamples(): array
    {
        return collect(self::examples())
            ->map(fn (array $example): array => [
                'name' => $example['title'],
                'slug' => str($example['route'])->after('examples.')->replace('.', '-')->toString(),
                'tag' => $example['tag'],
                'summary' => $example['copy'],
                'route' => $example['route'],
                'icon' => $example['icon'],
            ])
            ->all();
    }

    public function index(): View
    {
        return $this->view('pages.examples.index', [
            'title' => 'Exemplos · Documentação SampaUI',
            'examples' => self::examples(),
        ]);
    }

    public function authentication(): View
    {
        return $this->view('pages.examples.authentication', [
            'title' => 'Exemplo de autenticação · Documentação SampaUI',
        ]);
    }

    public function profile(): View
    {
        return $this->view('pages.examples.profile', [
            'title' => 'Upload e perfil · Documentação SampaUI',
        ]);
    }

    public function dashboard(): View
    {
        return $this->view('pages.examples.dashboard', [
            'title' => 'Dashboard operacional · Documentação SampaUI',
        ]);
    }

    public function adminForm(): View
    {
        return $this->view('pages.examples.admin-form', [
            'title' => 'Formulário administrativo · Documentação SampaUI',
        ]);
    }

    public function destructiveModal(): View
    {
        return $this->view('pages.examples.destructive-modal', [
            'title' => 'Modal destrutivo · Documentação SampaUI',
        ]);
    }

    public function filterDrawer(): View
    {
        return $this->view('pages.examples.filter-drawer', [
            'title' => 'Drawer de filtros · Documentação SampaUI',
        ]);
    }

    public function advancedTable(): View
    {
        return $this->view('pages.examples.advanced-table', [
            'title' => 'Tabela avançada · Documentação SampaUI',
        ]);
    }

    public function verification(): View
    {
        return $this->view('pages.examples.verification', [
            'title' => 'Verificação 2FA · Documentação SampaUI',
        ]);
    }

    public function commandPalette(): View
    {
        return $this->view('pages.examples.command-palette', [
            'title' => 'Command palette · Documentação SampaUI',
        ]);
    }

    public function settings(): View
    {
        return $this->view('pages.examples.settings', [
            'title' => 'Configurações em abas · Documentação SampaUI',
        ]);
    }

    public function feedback(): View
    {
        return $this->view('pages.examples.feedback', [
            'title' => 'Estados de feedback · Documentação SampaUI',
        ]);
    }

    public function chat(): View
    {
        return $this->view('pages.examples.chat', [
            'title' => 'Chat atendimento · Documentação SampaUI',
        ]);
    }

    public function icons(): View
    {
        return $this->view('pages.examples.icons', [
            'title' => 'Bootstrap Icons · Documentação SampaUI',
        ]);
    }

    public function usersIndex(): View
    {
        return $this->view('pages.examples.users.index', [
            'title' => 'Exemplo de listagem de usuários · Documentação SampaUI',
        ]);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function view(string $view, array $data = []): View
    {
        return view($view, array_merge($data, [
            'navigationComponents' => array_values(DocumentationComponents::all()),
            'navigationPages' => array_values(DocumentationPages::all()),
            'navigationExamples' => self::navigationExamples(),
        ]));
    }
}
