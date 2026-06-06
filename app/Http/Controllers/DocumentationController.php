<?php

namespace App\Http\Controllers;

use App\Support\DocumentationComponents;
use App\Support\DocumentationPages;
use Illuminate\Contracts\View\View;

class DocumentationController extends Controller
{
    public function __invoke(): View
    {
        $components = array_values(DocumentationComponents::all());

        return view('docs.index', [
            'components' => $components,
            'featuredComponent' => $components[0],
            'influences' => DocumentationComponents::influences(),
            'navigationComponents' => $components,
            'navigationPages' => array_values(DocumentationPages::all()),
        ]);
    }

    public function show(string $component): View
    {
        $components = DocumentationComponents::all();
        $selectedComponent = $components[$component] ?? abort(404);

        return view('docs.show', [
            'component' => $selectedComponent,
            'components' => array_values($components),
            'influences' => DocumentationComponents::influences(),
            'navigationComponents' => array_values($components),
            'navigationPages' => array_values(DocumentationPages::all()),
        ]);
    }

    public function page(string $page): View
    {
        $pages = DocumentationPages::all();
        $selectedPage = $pages[$page] ?? abort(404);
        $components = DocumentationComponents::all();

        if ($selectedPage['slug'] === 'dashboard-home') {
            return view('docs.page-preview', [
                'page' => $selectedPage,
            ]);
        }

        return view('docs.page', [
            'page' => $selectedPage,
            'components' => array_values($components),
            'navigationComponents' => array_values($components),
            'navigationPages' => array_values($pages),
        ]);
    }

    public function pagePreview(string $page): View
    {
        $pages = DocumentationPages::all();
        $selectedPage = $pages[$page] ?? abort(404);

        return view('docs.page-preview', [
            'page' => $selectedPage,
        ]);
    }
}
