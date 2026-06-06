<?php

namespace App\Http\Controllers;

use App\Support\DocumentationComponents;
use App\Support\DocumentationPages;
use Illuminate\Contracts\View\View;

class ExampleController extends Controller
{
    public function index(): View
    {
        return $this->view('pages.examples.index', [
            'title' => 'Exemplos · Documentação SampaUI',
        ]);
    }

    public function authentication(): View
    {
        return $this->view('pages.examples.authentication', [
            'title' => 'Exemplo de autenticação · Documentação SampaUI',
        ]);
    }

    public function dashboard(): View
    {
        $dashboard = DocumentationPages::all()['dashboard-home'];

        return $this->view('pages.examples.dashboard', [
            'title' => 'Exemplo de dashboard · Documentação SampaUI',
            'dashboard' => $dashboard,
        ]);
    }

    public function usersCreate(): View
    {
        return $this->view('pages.examples.users.create', [
            'title' => 'Exemplo de cadastro de usuário · Documentação SampaUI',
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
        ]));
    }
}
