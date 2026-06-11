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

    public function profile(): View
    {
        return $this->view('pages.examples.profile', [
            'title' => 'Form Profile · Documentação SampaUI',
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
        ]));
    }
}
