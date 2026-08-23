@extends('docs.layout', ['title' => $title ?? 'Central de atendimento · Documentação SampaUI'])

@php
    $snippet = <<<'BLADE'
<x-sampaui::chat-layout height="46rem">
    {{-- Sidebar com Lista de Conversas e Busca --}}
    <x-slot:sidebar>
        <x-sampaui::chat-sidebar
            title="Atendimento"
            subtitle="12 conversas ativas hoje"
            search-placeholder="Buscar contato ou empresa"
        >
            <x-slot:actions>
                <x-sampaui::button icon="plus" rounded size="sm" aria-label="Nova conversa" />
            </x-slot:actions>

            <div class="space-y-1">
                @foreach ($conversations as $item)
                    <button
                        type="button"
                        wire:click="selectConversation('{{ $item['id'] }}')"
                        @class([
                            'flex w-full items-center gap-3 rounded-xl p-3 text-left transition',
                            'bg-primary/10 text-primary font-semibold' => $selectedId === $item['id'],
                            'hover:bg-light text-secondary' => $selectedId !== $item['id'],
                        ])
                    >
                        <div class="relative">
                            <img src="{{ $item['photo'] }}" class="h-10 w-10 rounded-full object-cover" />
                            <span @class([
                                'absolute -bottom-0.5 -right-0.5 h-3 w-3 rounded-full border-2 border-white',
                                'bg-success' => $item['status'] === 'online',
                                'bg-amber-400' => $item['status'] === 'away',
                                'bg-danger' => $item['status'] === 'busy',
                                'bg-muted' => $item['status'] === 'offline',
                            ])></span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center justify-between">
                                <p class="truncate font-semibold text-heading text-sm">{{ $item['name'] }}</p>
                                <span class="text-xs text-secondary/60">{{ $item['time'] }}</span>
                            </div>
                            <p class="truncate text-xs text-secondary/70">{{ $item['preview'] }}</p>
                        </div>
                        @if ($item['unread'] > 0)
                            <x-sampaui::badge variant="primary" size="sm">{{ $item['unread'] }}</x-sampaui::badge>
                        @endif
                    </button>
                @endforeach
            </div>
        </x-sampaui::chat-sidebar>
    </x-slot:sidebar>

    {{-- Janela da Conversa Selecionada --}}
    <x-sampaui::chat-conversation
        name="Ana Souza"
        subtitle="Online agora · Conta Enterprise"
    >
        <x-slot:actions>
            <x-sampaui::button variant="outline" size="sm" icon="telephone" rounded />
            <x-sampaui::button variant="outline" size="sm" icon="info-circle" rounded />
        </x-slot:actions>

        {{-- Histórico de Mensagens --}}
        <div class="space-y-4 p-4">
            <x-sampaui::chat-message time="09:40" user="Ana Souza" avatar="https://i.pravatar.cc/160?img=47">
                Olá! Gostaria de entender mais sobre as condições do plano Enterprise.
            </x-sampaui::chat-message>

            <x-sampaui::chat-message from="me" time="09:41" status="Lida">
                Bom dia, Ana! Com certeza. Temos SLA garantido, suporte prioritário 24/7 e onboarding dedicado.
            </x-sampaui::chat-message>

            <x-sampaui::chat-message time="09:42" user="Ana Souza" avatar="https://i.pravatar.cc/160?img=47">
                Perfeito. Pode me enviar a proposta formalizada em PDF?
            </x-sampaui::chat-message>
        </div>

        {{-- Composer para envio de novas mensagens --}}
        <x-slot:composer>
            <x-sampaui::chat-composer
                wire:submit.prevent="sendMessage"
                wire:model.live="messageText"
                placeholder="Escreva sua mensagem..."
            />
        </x-slot:composer>
    </x-sampaui::chat-conversation>
</x-sampaui::chat-layout>
BLADE;

    $livewireSnippet = <<<'PHP'
namespace App\Livewire;

use Livewire\Component;

class ChatCenter extends Component
{
    public string $selectedId = 'ana';
    public string $messageText = '';
    public array $conversations = [];
    public array $messages = [];

    public function mount(): void
    {
        $this->conversations = [
            ['id' => 'ana', 'name' => 'Ana Souza', 'role' => 'Conta Enterprise', 'preview' => 'Pode me enviar as opções?', 'time' => '09:42', 'status' => 'online', 'unread' => 2, 'photo' => 'https://i.pravatar.cc/160?img=47'],
            ['id' => 'bruno', 'name' => 'Bruno Lima', 'role' => 'Onboarding', 'preview' => 'Fechamos a visita amanhã.', 'time' => '08:17', 'status' => 'away', 'unread' => 0, 'photo' => 'https://i.pravatar.cc/160?img=12'],
        ];
    }

    public function selectConversation(string $id): void
    {
        $this->selectedId = $id;
    }

    public function sendMessage(): void
    {
        if (trim($this->messageText) === '') return;

        $this->messages[] = [
            'from' => 'me',
            'text' => $this->messageText,
            'time' => now()->format('H:i'),
            'status' => 'Enviada',
        ];

        $this->reset('messageText');
    }

    public function render()
    {
        return view('livewire.chat-center');
    }
}
PHP;

    $conversations = [
        ['id' => 'ana', 'name' => 'Ana Souza', 'role' => 'Conta Enterprise', 'preview' => 'Pode me enviar as opções?', 'time' => '09:42', 'status' => 'online', 'unread' => 2, 'tag' => 'Quente', 'photo' => 'https://i.pravatar.cc/160?img=47'],
        ['id' => 'bruno', 'name' => 'Bruno Lima', 'role' => 'Onboarding agendado', 'preview' => 'Fechamos a visita para amanhã.', 'time' => '08:17', 'status' => 'away', 'unread' => 0, 'tag' => 'Agenda', 'photo' => 'https://i.pravatar.cc/160?img=12'],
        ['id' => 'carla', 'name' => 'Carla Martins', 'role' => 'Implantação', 'preview' => 'Obrigada pelo retorno.', 'time' => 'Ontem', 'status' => 'offline', 'unread' => 0, 'tag' => 'Follow-up', 'photo' => 'https://i.pravatar.cc/160?img=32'],
        ['id' => 'diego', 'name' => 'Diego Ramos', 'role' => 'Proposta enviada', 'preview' => 'Vou revisar com minha sócia.', 'time' => 'Seg', 'status' => 'busy', 'unread' => 1, 'tag' => 'Contrato', 'photo' => 'https://i.pravatar.cc/160?img=68'],
    ];
@endphp

@section('content')
    <section class="doc-component-intro-grid">
        <article class="doc-hero-card">
            <div class="relative z-[1] flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="doc-kicker">Exemplo</p>
                    <h1 class="mt-3 text-3xl font-semibold tracking-tight text-primary md:text-4xl">Central de atendimento</h1>
                    <p class="mt-4 max-w-3xl text-sm leading-6 text-secondary">
                        Experiência de atendimento comercial com inbox, conversa ativa, anexos e painel de contexto usando componentes SampaUI.
                    </p>
                </div>
                <x-sampaui::badge variant="success" icon="chat-dots">Mensagens</x-sampaui::badge>
            </div>
        </article>
    </section>

    <section class="space-y-7">
        <div class="overflow-x-auto rounded-[1.5rem] border border-border bg-light/70 p-4 shadow-default">
            <x-sampaui::chat-layout
                height="46rem"
                class="!rounded-[1.25rem] !border-white !shadow-2xl !shadow-primary/10 lg:!grid-cols-[20rem_minmax(0,1fr)] xl:min-w-[72rem] 2xl:min-w-[88rem]"
                data-chat-example
            >
                <x-slot:sidebar>
                    <x-sampaui::chat-sidebar title="Inbox" subtitle="12 atendimentos hoje" search-placeholder="Buscar cliente ou conta">
                        <x-slot:actions>
                            <x-sampaui::button icon="plus" rounded>
                                <span class="sr-only">Nova conversa</span>
                            </x-sampaui::button>
                        </x-slot:actions>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between px-2">
                                <span class="text-xs font-semibold uppercase tracking-[0.2em] text-secondary/50">Fixadas</span>
                                <x-sampaui::badge variant="danger" size="sm">2 novas</x-sampaui::badge>
                            </div>

                            <div class="space-y-2">
                                @foreach ($conversations as $conversation)
                                    <button
                                        type="button"
                                        data-chat-target="{{ $conversation['id'] }}"
                                        data-chat-photo="{{ $conversation['photo'] }}"
                                        data-chat-status="{{ $conversation['status'] }}"
                                        class="{{ sampaui_classes([
                                            'group flex w-full cursor-pointer items-start gap-3 rounded-default border px-3 py-3 text-left transition focus:outline-none focus:ring-2 focus:ring-primary/20',
                                            $conversation['id'] === 'ana' ? 'border-primary/20 bg-primary text-white shadow-default' : 'border-transparent bg-white hover:border-primary/20 hover:bg-light/70',
                                        ]) }}"
                                    >
                                        <x-sampaui::avatar :src="$conversation['photo']" :name="$conversation['name']" :status="$conversation['status']" size="lg" />
                                        <span class="min-w-0 flex-1">
                                            <span class="flex items-center justify-between gap-3">
                                                <span class="{{ $conversation['id'] === 'ana' ? 'text-white' : 'text-primary' }} truncate text-sm font-semibold" data-chat-name>{{ $conversation['name'] }}</span>
                                                <span class="{{ $conversation['id'] === 'ana' ? 'text-white/75' : 'text-secondary/60' }} shrink-0 text-xs font-medium" data-chat-time>{{ $conversation['time'] }}</span>
                                            </span>
                                            <span class="{{ $conversation['id'] === 'ana' ? 'text-white/80' : 'text-secondary/70' }} mt-0.5 block truncate text-xs font-medium" data-chat-role>{{ $conversation['role'] }}</span>
                                            <span class="mt-2 flex items-center justify-between gap-3">
                                                <span class="{{ $conversation['id'] === 'ana' ? 'text-white/80' : 'text-secondary' }} truncate text-xs leading-5" data-chat-preview>{{ $conversation['preview'] }}</span>
                                                @if ($conversation['unread'] > 0)
                                                    <span class="{{ $conversation['id'] === 'ana' ? 'bg-white text-primary' : 'bg-primary text-white' }} inline-flex h-5 min-w-5 shrink-0 items-center justify-center rounded-full px-1.5 text-[0.68rem] font-semibold" data-chat-unread>{{ $conversation['unread'] }}</span>
                                                @endif
                                            </span>
                                            <span class="{{ $conversation['id'] === 'ana' ? 'border-white/20 bg-white/10 text-white' : 'border-border bg-light text-secondary' }} mt-3 inline-flex rounded-full border px-2 py-1 text-[0.68rem] font-semibold" data-chat-tag>
                                                {{ $conversation['tag'] }}
                                            </span>
                                        </span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </x-sampaui::chat-sidebar>
                </x-slot:sidebar>

                <div class="doc-chat-context-grid" data-chat-context-grid data-context-open="true">
                    <div class="min-h-0 min-w-0 border-r border-border bg-white">
                        <div class="h-full" data-chat-panel="ana">
                            <x-sampaui::chat-conversation name="Ana Souza" subtitle="Online agora · Conta Enterprise" avatar="https://i.pravatar.cc/160?img=47" status="online" class="!bg-white">
                                <div class="contents" data-chat-messages>
                                    <x-sampaui::chat-message from="system">Atendimento iniciado pelo site institucional.</x-sampaui::chat-message>
                                    <x-sampaui::chat-message time="09:36">Oi, vi os apartamentos no Jardim Paulista. Quero algo com varanda e duas vagas.</x-sampaui::chat-message>
                                    <x-sampaui::chat-message from="me" time="09:38" status="Lida">Bom dia, Ana. Separei três opções dentro do perfil e uma delas tem lazer completo.</x-sampaui::chat-message>
                                    <div class="flex justify-end">
                                        <article class="max-w-[min(34rem,82%)] rounded-default rounded-br-sm bg-primary px-4 py-3 text-white shadow-sm">
                                            <p class="text-sm leading-6">Também anexei uma simulação com entrada reduzida.</p>
                                            <div class="mt-3 flex items-center gap-3 rounded-[0.85rem] bg-white/12 p-3">
                                                <span class="flex h-10 w-10 items-center justify-center rounded-default bg-white text-primary">
                                                    <i class="bi bi-file-earmark-pdf" aria-hidden="true"></i>
                                                </span>
                                                <span class="min-w-0 flex-1">
                                                    <span class="block truncate text-sm font-semibold">proposta-implantacao.pdf</span>
                                                    <span class="text-xs text-white/70">1.8 MB</span>
                                                </span>
                                                <i class="bi bi-download text-white/80" aria-hidden="true"></i>
                                            </div>
                                            <div class="mt-1 flex items-center justify-end gap-1 text-[0.68rem] font-medium text-white/70">
                                                <span>09:39</span>
                                                <i class="bi bi-check2-all" aria-hidden="true"></i>
                                            </div>
                                        </article>
                                    </div>
                                    <x-sampaui::chat-message time="09:42">Perfeito. Pode me mandar o link da opção com lazer completo?</x-sampaui::chat-message>
                                </div>

                                <x-slot:actions>
                                    <x-sampaui::button type="button" variant="ghost" icon="layout-sidebar-inset-reverse" rounded data-chat-context-toggle>
                                        <span class="sr-only">Alternar dados do cliente</span>
                                    </x-sampaui::button>
                                    <x-sampaui::button variant="ghost" icon="telephone" rounded><span class="sr-only">Ligar</span></x-sampaui::button>
                                    <x-sampaui::button variant="ghost" icon="camera-video" rounded><span class="sr-only">Vídeo</span></x-sampaui::button>
                                    <x-sampaui::button variant="ghost" icon="three-dots-vertical" rounded><span class="sr-only">Mais ações</span></x-sampaui::button>
                                </x-slot:actions>

                                <x-slot:composer>
                                    <x-sampaui::chat-composer data-chat-form placeholder="Mensagem para Ana">
                                        <x-slot:before>
                                            <div class="flex items-center gap-1">
                                                <x-sampaui::button type="button" variant="ghost" icon="paperclip" rounded><span class="sr-only">Anexar</span></x-sampaui::button>
                                                <x-sampaui::button type="button" variant="ghost" icon="emoji-smile" rounded><span class="sr-only">Emoji</span></x-sampaui::button>
                                            </div>
                                        </x-slot:before>
                                    </x-sampaui::chat-composer>
                                </x-slot:composer>
                            </x-sampaui::chat-conversation>
                        </div>

                        <div class="hidden h-full" data-chat-panel="bruno">
                            <x-sampaui::chat-conversation name="Bruno Lima" subtitle="Visto por último às 08:17 · Onboarding agendado" avatar="https://i.pravatar.cc/160?img=12" status="away" class="!bg-white">
                                <div class="contents" data-chat-messages>
                                    <x-sampaui::chat-message time="08:10">Consegue confirmar o onboarding amanhã?</x-sampaui::chat-message>
                                    <x-sampaui::chat-message from="me" time="08:12" status="Entregue">Sim, deixei reservado às 10h30 e avisei a portaria.</x-sampaui::chat-message>
                                    <x-sampaui::chat-message time="08:17">Perfeito. Vou levar minha esposa.</x-sampaui::chat-message>
                                </div>

                                <x-slot:actions>
                                    <x-sampaui::button type="button" variant="ghost" icon="layout-sidebar-inset-reverse" rounded data-chat-context-toggle>
                                        <span class="sr-only">Alternar dados do cliente</span>
                                    </x-sampaui::button>
                                    <x-sampaui::button variant="ghost" icon="telephone" rounded><span class="sr-only">Ligar</span></x-sampaui::button>
                                    <x-sampaui::button variant="ghost" icon="camera-video" rounded><span class="sr-only">Vídeo</span></x-sampaui::button>
                                </x-slot:actions>

                                <x-slot:composer>
                                    <x-sampaui::chat-composer data-chat-form placeholder="Mensagem para Bruno">
                                        <x-slot:before>
                                            <x-sampaui::button type="button" variant="ghost" icon="paperclip" rounded><span class="sr-only">Anexar</span></x-sampaui::button>
                                        </x-slot:before>
                                    </x-sampaui::chat-composer>
                                </x-slot:composer>
                            </x-sampaui::chat-conversation>
                        </div>

                        <div class="hidden h-full" data-chat-panel="carla">
                            <x-sampaui::chat-conversation name="Carla Martins" subtitle="Offline · Implantação" avatar="https://i.pravatar.cc/160?img=32" status="offline" class="!bg-white">
                                <div class="contents" data-chat-messages>
                                    <x-sampaui::chat-message from="system">Conversa marcada como oportunidade fria.</x-sampaui::chat-message>
                                    <x-sampaui::chat-message from="me" time="17:22" status="Lida">Enviei a simulação atualizada por aqui.</x-sampaui::chat-message>
                                    <x-sampaui::chat-message time="17:40">Obrigada pelo retorno. Vou analisar com calma.</x-sampaui::chat-message>
                                </div>

                                <x-slot:actions>
                                    <x-sampaui::button type="button" variant="ghost" icon="layout-sidebar-inset-reverse" rounded data-chat-context-toggle>
                                        <span class="sr-only">Alternar dados do cliente</span>
                                    </x-sampaui::button>
                                    <x-sampaui::button variant="ghost" icon="telephone" rounded><span class="sr-only">Ligar</span></x-sampaui::button>
                                    <x-sampaui::button variant="ghost" icon="camera-video" rounded><span class="sr-only">Vídeo</span></x-sampaui::button>
                                </x-slot:actions>

                                <x-slot:composer>
                                    <x-sampaui::chat-composer data-chat-form placeholder="Mensagem para Carla" />
                                </x-slot:composer>
                            </x-sampaui::chat-conversation>
                        </div>

                        <div class="hidden h-full" data-chat-panel="diego">
                            <x-sampaui::chat-conversation name="Diego Ramos" subtitle="Ocupado · Proposta enviada" avatar="https://i.pravatar.cc/160?img=68" status="busy" class="!bg-white">
                                <div class="contents" data-chat-messages>
                                    <x-sampaui::chat-message time="10:12">Vou revisar com minha sócia e retorno ainda hoje.</x-sampaui::chat-message>
                                    <x-sampaui::chat-message from="me" time="10:14" status="Entregue">Combinado. Deixei a validade da proposta até amanhã às 18h.</x-sampaui::chat-message>
                                </div>

                                <x-slot:actions>
                                    <x-sampaui::button type="button" variant="ghost" icon="layout-sidebar-inset-reverse" rounded data-chat-context-toggle>
                                        <span class="sr-only">Alternar dados do cliente</span>
                                    </x-sampaui::button>
                                    <x-sampaui::button variant="ghost" icon="telephone" rounded><span class="sr-only">Ligar</span></x-sampaui::button>
                                    <x-sampaui::button variant="ghost" icon="camera-video" rounded><span class="sr-only">Vídeo</span></x-sampaui::button>
                                </x-slot:actions>

                                <x-slot:composer>
                                    <x-sampaui::chat-composer data-chat-form placeholder="Mensagem para Diego" />
                                </x-slot:composer>
                            </x-sampaui::chat-conversation>
                        </div>
                    </div>

                    <aside class="doc-chat-context-panel" data-chat-context-panel>
                        <div class="border-b border-border p-5 text-center">
                            <div class="mb-4 flex justify-end">
                                <x-sampaui::button type="button" size="sm" variant="ghost" icon="x-lg" rounded data-chat-context-toggle>
                                    <span class="sr-only">Fechar dados do cliente</span>
                                </x-sampaui::button>
                            </div>
                            <div class="mx-auto w-max">
                                <x-sampaui::avatar src="https://i.pravatar.cc/160?img=47" name="Ana Souza" status="online" size="2xl" data-chat-detail-avatar />
                            </div>
                            <h3 class="mt-3 text-base font-semibold text-primary" data-chat-detail-name>Ana Souza</h3>
                            <p class="mt-1 text-xs font-medium text-secondary/70" data-chat-detail-role>Conta Enterprise</p>
                            <div class="mt-4 flex justify-center gap-2">
                                <x-sampaui::button variant="outline" icon="telephone" rounded><span class="sr-only">Ligar</span></x-sampaui::button>
                                <x-sampaui::button variant="outline" icon="camera-video" rounded><span class="sr-only">Vídeo</span></x-sampaui::button>
                                <x-sampaui::button variant="outline" icon="calendar-event" rounded><span class="sr-only">Agendar</span></x-sampaui::button>
                            </div>
                        </div>

                        <div class="min-h-0 flex-1 overflow-y-auto p-5">
                            <div class="space-y-5">
                                <section>
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-sm font-semibold text-primary">Resumo</h4>
                                        <x-sampaui::badge variant="success" size="sm">CRM</x-sampaui::badge>
                                    </div>
                                    <p class="mt-3 text-sm leading-6 text-secondary" data-chat-detail-summary>
                                        Busca apartamento com varanda, duas vagas e lazer completo. Orçamento aprovado para entrada reduzida.
                                    </p>
                                </section>

                                <section>
                                    <h4 class="text-sm font-semibold text-primary">Arquivos recentes</h4>
                                    <div class="mt-3 grid grid-cols-3 gap-2">
                                        @foreach (['PDF', 'IMG', 'DOC', 'KEY', 'XLS', 'URL'] as $asset)
                                            <span class="flex aspect-square items-center justify-center rounded-default border border-border bg-light text-xs font-semibold text-primary">{{ $asset }}</span>
                                        @endforeach
                                    </div>
                                </section>

                                <section>
                                    <h4 class="text-sm font-semibold text-primary">Próximas ações</h4>
                                    <div class="mt-3 space-y-2">
                                        @foreach (['Enviar material comercial', 'Agendar demonstração assistida', 'Atualizar proposta no CRM'] as $task)
                                            <label class="flex items-start gap-3 rounded-default border border-border bg-white p-3 text-sm text-secondary">
                                                <input type="checkbox" class="mt-1 rounded border-secondary/40 text-primary focus:ring-primary/20">
                                                <span>{{ $task }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </section>
                            </div>
                        </div>
                    </aside>
                </div>
            </x-sampaui::chat-layout>
        </div>

        @include('pages.examples.partials.code', [
            'snippet' => $snippet,
            'livewireSnippet' => $livewireSnippet,
            'codeTitle' => 'Código da Central de Atendimento',
            'description' => 'Layout responsivo para conversas com inbox lateral, timeline de mensagens e composer com submit reativo.',
            'components' => ['chat-layout', 'chat-sidebar', 'chat-conversation', 'chat-message', 'chat-composer', 'badge', 'button'],
        ])
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-chat-example]').forEach((chat) => {
                const buttons = [...chat.querySelectorAll('[data-chat-target]')];
                const panels = [...chat.querySelectorAll('[data-chat-panel]')];
                const contextGrid = chat.querySelector('[data-chat-context-grid]');
                const contextPanel = chat.querySelector('[data-chat-context-panel]');
                const contextToggles = [...chat.querySelectorAll('[data-chat-context-toggle]')];
                const activeButtonClasses = ['border-primary/20', 'bg-primary', 'text-white', 'shadow-default'];
                const inactiveButtonClasses = ['border-transparent', 'bg-white', 'hover:border-primary/20', 'hover:bg-light/70'];
                const summaries = {
                    ana: 'Busca plano com onboarding guiado, suporte prioritário e relatórios executivos. Orçamento aprovado.',
                    bruno: 'Demonstração confirmada para amanhã às 10h30. Cliente quer avaliar fluxos de atendimento.',
                    carla: 'Cliente em análise de implantação. Aguardando retorno sobre proposta enviada.',
                    diego: 'Proposta enviada para revisão com sócia. Validade até amanhã às 18h.',
                };

                const setTone = (button, active) => {
                    activeButtonClasses.forEach((className) => button.classList.toggle(className, active));
                    inactiveButtonClasses.forEach((className) => button.classList.toggle(className, ! active));

                    button.querySelectorAll('[data-chat-name]').forEach((node) => {
                        node.classList.toggle('text-white', active);
                        node.classList.toggle('text-primary', ! active);
                    });
                    button.querySelectorAll('[data-chat-time], [data-chat-role], [data-chat-preview]').forEach((node) => {
                        node.classList.remove('text-white/80', 'text-secondary', 'text-secondary/60');
                        node.classList.toggle('text-white/75', active);
                        node.classList.toggle('text-secondary/70', ! active);
                    });
                    button.querySelectorAll('[data-chat-unread]').forEach((node) => {
                        node.classList.toggle('bg-white', active);
                        node.classList.toggle('text-primary', active);
                        node.classList.toggle('bg-primary', ! active);
                        node.classList.toggle('text-white', ! active);
                    });
                    button.querySelectorAll('[data-chat-tag]').forEach((node) => {
                        node.classList.toggle('border-white/20', active);
                        node.classList.toggle('bg-white/10', active);
                        node.classList.toggle('text-white', active);
                        node.classList.toggle('border-border', ! active);
                        node.classList.toggle('bg-light', ! active);
                        node.classList.toggle('text-secondary', ! active);
                    });
                };

                const activate = (target) => {
                    panels.forEach((panel) => panel.classList.toggle('hidden', panel.dataset.chatPanel !== target));
                    buttons.forEach((button) => setTone(button, button.dataset.chatTarget === target));

                    const activeButton = buttons.find((button) => button.dataset.chatTarget === target);
                    const detailName = chat.querySelector('[data-chat-detail-name]');
                    const detailRole = chat.querySelector('[data-chat-detail-role]');
                    const detailSummary = chat.querySelector('[data-chat-detail-summary]');
                    const detailAvatar = chat.querySelector('[data-chat-detail-avatar]');
                    const detailAvatarImage = detailAvatar?.querySelector('img');
                    const detailAvatarStatus = detailAvatar?.querySelector('[aria-label]');

                    if (activeButton && detailName && detailRole && detailSummary) {
                        detailName.textContent = activeButton.querySelector('[data-chat-name]')?.textContent?.trim() ?? '';
                        detailRole.textContent = activeButton.querySelector('[data-chat-role]')?.textContent?.trim() ?? '';
                        detailSummary.textContent = summaries[target] ?? summaries.ana;

                        if (detailAvatarImage) {
                            detailAvatarImage.src = activeButton.dataset.chatPhoto ?? detailAvatarImage.src;
                            detailAvatarImage.alt = detailName.textContent || 'Cliente';
                        }

                        if (detailAvatarStatus) {
                            detailAvatarStatus.setAttribute('aria-label', activeButton.dataset.chatStatus ?? 'online');
                            detailAvatarStatus.classList.remove('bg-success', 'bg-accent', 'bg-danger', 'bg-secondary/40');
                            detailAvatarStatus.classList.add({
                                online: 'bg-success',
                                away: 'bg-accent',
                                busy: 'bg-danger',
                                offline: 'bg-secondary/40',
                            }[activeButton.dataset.chatStatus] ?? 'bg-success');
                        }
                    }
                };

                const setContextOpen = (open) => {
                    if (! contextGrid || ! contextPanel) {
                        return;
                    }

                    contextGrid.dataset.contextOpen = open ? 'true' : 'false';
                    contextPanel.setAttribute('aria-hidden', open ? 'false' : 'true');

                    contextToggles.forEach((toggle) => {
                        toggle.setAttribute('aria-pressed', open ? 'true' : 'false');
                        toggle.setAttribute('aria-label', open ? 'Fechar dados do cliente' : 'Abrir dados do cliente');
                        toggle.querySelector('i')?.classList.toggle('bi-layout-sidebar-inset-reverse', open);
                        toggle.querySelector('i')?.classList.toggle('bi-layout-sidebar-inset', ! open);
                    });
                };

                buttons.forEach((button) => {
                    button.addEventListener('click', () => activate(button.dataset.chatTarget));
                });

                contextToggles.forEach((toggle) => {
                    toggle.addEventListener('click', () => {
                        const isOpen = contextGrid?.dataset.contextOpen !== 'false';
                        setContextOpen(! isOpen);
                    });
                });

                setContextOpen(true);

                chat.querySelectorAll('[data-chat-form]').forEach((form) => {
                    form.addEventListener('submit', (event) => {
                        event.preventDefault();

                        const textarea = form.querySelector('textarea');
                        const text = textarea.value.trim();

                        if (! text) {
                            return;
                        }

                        const panel = form.closest('[data-chat-panel]');
                        const messages = panel.querySelector('[data-chat-messages]');
                        const time = new Date().toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });

                        messages.insertAdjacentHTML('beforeend', `
                            <div class="flex justify-end">
                                <article class="max-w-[min(34rem,82%)] rounded-default rounded-br-sm bg-primary px-4 py-2.5 text-white shadow-sm">
                                    <div class="text-sm leading-6"></div>
                                    <div class="mt-1 flex items-center justify-end gap-1 text-[0.68rem] font-medium text-white/70">
                                        <span>${time}</span>
                                        <i class="bi bi-check2-all" aria-hidden="true"></i>
                                    </div>
                                </article>
                            </div>
                        `);
                        messages.lastElementChild.querySelector('.text-sm').textContent = text;
                        textarea.value = '';
                    });
                });
            });
        });
    </script>
@endsection
