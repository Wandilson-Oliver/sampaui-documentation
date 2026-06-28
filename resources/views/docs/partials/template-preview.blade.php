@props(['type'])

<div class="doc-template-component-preview" aria-hidden="true">
    @switch($type)
        @case('dashboard')
            <x-sampaui::header title="Dashboard" subtitle="Resumo operacional" />
            <div class="grid grid-cols-2 gap-2">
                <x-sampaui::card title="Clientes">
                    <strong class="text-xl text-secondary">248</strong>
                </x-sampaui::card>
                <x-sampaui::card title="Conversão">
                    <x-sampaui::progress value="72" />
                </x-sampaui::card>
            </div>
            @break

        @case('users')
            <x-sampaui::table-search
                title="Usuários"
                compact
                :columns="['name' => 'Nome', 'status' => 'Status']"
                :rows="[
                    ['name' => 'Ana Souza', 'status' => 'Ativo'],
                    ['name' => 'Bruno Lima', 'status' => 'Pendente'],
                ]"
            />
            @break

        @case('authentication')
            <x-sampaui::card title="Acesse sua conta" description="Entre para continuar">
                <div class="space-y-2">
                    <x-sampaui::input name="template_email" label="Email" icon="envelope" />
                    <x-sampaui::button size="sm" full>Entrar</x-sampaui::button>
                </div>
            </x-sampaui::card>
            @break

        @case('admin-form')
            <x-sampaui::card title="Novo cliente">
                <div class="grid gap-2">
                    <x-sampaui::input name="template_name" label="Nome" />
                    <x-sampaui::select
                        name="template_status"
                        label="Status"
                        :options="['active' => 'Ativo', 'pending' => 'Pendente']"
                        value="active"
                    />
                </div>
            </x-sampaui::card>
            @break

        @case('advanced-table')
            <x-sampaui::table-search
                title="Clientes"
                compact
                selectable
                :columns="['name' => 'Cliente', 'value' => 'Valor']"
                :rows="[
                    ['id' => 1, 'name' => 'Ana Souza', 'value' => 'R$ 8.500'],
                    ['id' => 2, 'name' => 'Bruno Lima', 'value' => 'R$ 6.200'],
                ]"
            />
            @break

        @case('profile')
            <x-sampaui::card title="Perfil">
                <div class="flex items-center gap-3">
                    <x-sampaui::avatar name="Ana Souza" size="lg" status="online" />
                    <div>
                        <strong class="block text-sm text-secondary">Ana Souza</strong>
                        <span class="text-xs text-secondary/60">ana@sampa.dev</span>
                    </div>
                </div>
            </x-sampaui::card>
            @break

        @case('settings')
            <x-sampaui::tabs :tabs="['profile' => 'Perfil', 'security' => 'Segurança']" active="profile">
                <x-sampaui::tab-panel name="profile">
                    <x-sampaui::toggle name="template_notifications" label="Notificações" checked />
                </x-sampaui::tab-panel>
                <x-sampaui::tab-panel name="security">Segurança da conta.</x-sampaui::tab-panel>
            </x-sampaui::tabs>
            @break

        @case('chat')
            <div class="space-y-2">
                <x-sampaui::chat-message author="Ana" time="09:40">Pode revisar o cadastro?</x-sampaui::chat-message>
                <x-sampaui::chat-message from="me" time="09:42" status="Lida">Sim, já estou verificando.</x-sampaui::chat-message>
            </div>
            @break
    @endswitch
</div>
