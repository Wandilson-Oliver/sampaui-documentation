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
                'title' => 'Dashboard operacional',
                'copy' => 'Dashboard SaaS com navegação, métricas, atividades, prioridades e listagem.',
                'icon' => 'speedometer2',
                'route' => 'examples.dashboard',
                'tag' => 'Dashboard',
            ],
            [
                'title' => 'CRUD de usuários',
                'copy' => 'Fluxo Livewire completo com busca, filtros, tabela, modal e paginação.',
                'icon' => 'people',
                'route' => 'examples.users.index',
                'tag' => 'Livewire',
            ],
            [
                'title' => 'Login completo',
                'copy' => 'Tela de acesso com validação, feedback, recuperação e estado de envio.',
                'icon' => 'shield-lock',
                'route' => 'examples.authentication',
                'tag' => 'Auth',
            ],
            [
                'title' => 'Formulário administrativo',
                'copy' => 'Cadastro responsivo com campos especializados, validação e ações consistentes.',
                'icon' => 'ui-checks-grid',
                'route' => 'examples.admin-form',
                'tag' => 'Forms',
            ],
            [
                'title' => 'Listagem avançada',
                'copy' => 'Pesquisa, filtros, seleção, ações por linha, estados e paginação.',
                'icon' => 'table',
                'route' => 'examples.advanced-table',
                'tag' => 'Data',
            ],
            [
                'title' => 'Perfil e arquivos',
                'copy' => 'Avatar, documentos, dados pessoais e credenciais em uma única tela.',
                'icon' => 'person-badge',
                'route' => 'examples.profile',
                'tag' => 'Upload',
            ],
            [
                'title' => 'Configurações em abas',
                'copy' => 'Perfil, segurança e notificações organizados em uma experiência única.',
                'icon' => 'gear',
                'route' => 'examples.settings',
                'tag' => 'Settings',
            ],
            [
                'title' => 'Central de atendimento',
                'copy' => 'Inbox, conversa, envio de mensagens e contexto do cliente em layout responsivo.',
                'icon' => 'chat-dots',
                'route' => 'examples.chat',
                'tag' => 'Chat',
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
            'title' => 'Perfil e arquivos · Documentação SampaUI',
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
            'title' => 'Listagem avançada · Documentação SampaUI',
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
            'title' => 'Central de atendimento · Documentação SampaUI',
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
