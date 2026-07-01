@extends('docs.layout', ['title' => $title ?? 'Exemplos · Documentação SampaUI'])

@section('content')
    @php
        $previewTypes = [
            'examples.dashboard' => 'dashboard',
            'examples.users.index' => 'users',
            'examples.authentication' => 'authentication',
            'examples.admin-form' => 'admin-form',
            'examples.advanced-table' => 'advanced-table',
            'examples.profile' => 'profile',
            'examples.settings' => 'settings',
            'examples.chat' => 'chat',
        ];
    @endphp

    <section class="doc-page-hero">
        <x-docs.breadcrumbs :items="[
            ['label' => 'Documentação', 'href' => route('documentation')],
            ['label' => 'Blocks/Templates'],
        ]" />

        <div class="doc-page-hero-copy">
            <span class="doc-component-tag">Composições SampaUI</span>
            <h1>Blocks / Templates</h1>
            <p>Fluxos essenciais para dashboards, autenticação, dados, formulários e atendimento.</p>
            <p>A seleção foi reduzida aos exemplos que demonstram composição real, responsividade e integração com Blade ou Livewire.</p>
        </div>
    </section>

    <section class="doc-block-grid" aria-label="Blocks e templates">
        @foreach ($examples as $example)
            <a href="{{ route($example['route']) }}" class="doc-block-card">
                <div class="doc-block-preview">
                    @include('docs.partials.template-preview', ['type' => $previewTypes[$example['route']]])
                </div>

                <div class="doc-block-copy">
                    <div>
                        <x-sampaui::badge variant="light" size="sm">{{ $example['tag'] }}</x-sampaui::badge>
                        <h2>{{ $example['title'] }}</h2>
                        <p>{{ $example['copy'] }}</p>
                    </div>
                    <span>Explorar template <i class="bi bi-arrow-right" aria-hidden="true"></i></span>
                </div>
            </a>
        @endforeach
    </section>
@endsection
