<?php

namespace App\Support;

class DocumentationComponents
{
    /**
     * @return array<string, array<string, mixed>>
     */
    public static function all(): array
    {
        return (new self)->components();
    }

    /**
     * @return array<int, array<string, string>>
     */
    public static function influences(): array
    {
        return [
            [
                'name' => 'shadcn/ui',
                'takeaway' => 'Exemplos copiaveis e composicao por slots, sem esconder o markup do consumidor.',
            ],
            [
                'name' => 'Radix UI',
                'takeaway' => 'Estados acessiveis, foco visivel e semantica correta antes de qualquer efeito visual.',
            ],
            [
                'name' => 'Material UI',
                'takeaway' => 'API consistente por props, variantes e tamanhos previsiveis entre componentes.',
            ],
            [
                'name' => 'Ant Design',
                'takeaway' => 'Organizacao para produtos corporativos: tabelas, formularios e feedback operacional.',
            ],
            [
                'name' => 'Chakra UI',
                'takeaway' => 'Tokens de tema claros e componentes que aceitam customizacao local sem perder padrao.',
            ],
            [
                'name' => 'Mantine',
                'takeaway' => 'Documentacao objetiva com exemplos por estado, uso comum e API completa.',
            ],
            [
                'name' => 'Headless UI',
                'takeaway' => 'Compatibilidade com Tailwind e controle do consumidor sobre o layout final.',
            ],
            [
                'name' => 'daisyUI',
                'takeaway' => 'Classes semanticas e temas simples, traduzidos aqui para a paleta personalizada do SampaUI.',
            ],
            [
                'name' => 'Flowbite',
                'takeaway' => 'Componentes prontos para Tailwind com exemplos diretos de instalacao e uso.',
            ],
            [
                'name' => 'Bootstrap',
                'takeaway' => 'Conjunto amplo, previsivel e familiar; SampaUI reaproveita Bootstrap Icons.',
            ],
        ];
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    private function components(): array
    {
        $components = [
            'button' => [
                'slug' => 'button',
                'name' => 'Button',
                'tag' => '<x-sampaui::button />',
                'summary' => 'Acoes primarias, icones, estados de loading e largura total em um unico componente Blade.',
                'description' => 'Use para CTAs, acoes de formulario, navegacao e controles de fluxo. Quando recebe `href`, o componente renderiza um link com o mesmo visual do botao.',
                'preview_title' => 'Fluxo de aprovacao',
                'preview_caption' => 'Estados primario, outline, loading e icon-only no mesmo padrao visual.',
                'props' => [
                    ['name' => 'variant', 'type' => 'primary|secondary|accent|danger|success|warning|info|purple|muted|light|ghost|outline', 'default' => 'primary', 'notes' => 'Seleciona o conjunto visual do botao. Apenas `outline` usa borda.'],
                    ['name' => 'size', 'type' => 'sm|md|lg|xl|2xl', 'default' => 'md', 'notes' => 'Controla padding, tipografia e dimensao dos botoes icon-only.'],
                    ['name' => 'icon', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Nome do Bootstrap Icon sem o prefixo `bi-`.'],
                    ['name' => 'iconPosition', 'type' => 'left|right', 'default' => 'left', 'notes' => 'Posiciona o icone antes ou depois do slot.'],
                    ['name' => 'rounded', 'type' => 'bool', 'default' => 'false', 'notes' => 'Troca o raio padrao por pill shape.'],
                    ['name' => 'loading', 'type' => 'bool', 'default' => 'false', 'notes' => 'Desabilita o botao e ativa `aria-busy`.'],
                    ['name' => 'disabled', 'type' => 'bool', 'default' => 'false', 'notes' => 'Aplica bloqueio de interacao sem spinner.'],
                    ['name' => 'full', 'type' => 'bool', 'default' => 'false', 'notes' => 'Expande o botao para `w-full`.'],
                    ['name' => 'type', 'type' => 'string', 'default' => 'button', 'notes' => 'Mantem compatibilidade com botoes submit/reset.'],
                    ['name' => 'href', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Quando informado, renderiza `<a>` e preserva atributos como `wire:navigate`.'],
                    ['name' => '$slot', 'type' => 'Blade slot', 'default' => '-', 'notes' => 'Conteudo textual ou rich slot. Vazio + `icon` gera modo icon-only.'],
                ],
                'attributes' => ['class', 'id', 'wire:click', 'wire:navigate', 'wire:target', 'x-on:*', 'data-*', 'aria-*'],
                'accessibility' => [
                    'Use texto visivel ou um `aria-label` quando o botao for apenas icone.',
                    'O estado `loading` ja marca `aria-busy`; combine com `wire:loading.attr="disabled"` em acoes Livewire longas.',
                    'Prefira `type="submit"` apenas dentro de formularios para evitar submits acidentais.',
                ],
                'examples' => [
                    [
                        'title' => 'Basico',
                        'description' => 'CTA padrao com variante primary.',
                        'code' => <<<'BLADE'
<x-sampaui::button>
    Salvar alteracoes
</x-sampaui::button>
BLADE,
                    ],
                    [
                        'title' => 'Variante com icone',
                        'description' => 'Outline com icone alinhado a direita.',
                        'code' => <<<'BLADE'
<x-sampaui::button variant="outline" icon="box-arrow-up-right" icon-position="right">
    Abrir publicacao
</x-sampaui::button>
BLADE,
                    ],
                    [
                        'title' => 'Link com href',
                        'description' => 'Navegacao com aparencia de botao e suporte a `wire:navigate`.',
                        'code' => <<<'BLADE'
<x-sampaui::button href="/clientes" wire:navigate icon="arrow-right">
    Ver clientes
</x-sampaui::button>
BLADE,
                    ],
                    [
                        'title' => 'Livewire',
                        'description' => 'Padrao para submit de formulario com estado de envio.',
                        'code' => <<<'BLADE'
<x-sampaui::button
    type="submit"
    icon="check2-circle"
    wire:loading.attr="disabled"
    wire:target="save"
>
    Salvar lead
</x-sampaui::button>
BLADE,
                    ],
                ],
            ],
            'input' => [
                'slug' => 'input',
                'name' => 'Input',
                'tag' => '<x-sampaui::input />',
                'summary' => 'Campo textual com label opcional, mensagem de erro, estados desabilitados e passthrough total de atributos HTML/Livewire.',
                'description' => 'Indicado para formularios operacionais, autenticacao e filtros. A borda padrao usa `border-secondary/20`, e `wire:model` inicializa o campo sem exigir a prop `value`.',
                'preview_title' => 'Formulario de contato',
                'preview_caption' => 'Exemplos de input simples, erro validado e binding Livewire.',
                'props' => [
                    ['name' => 'type', 'type' => 'string', 'default' => 'text', 'notes' => 'Aceita qualquer tipo suportado por `<input>`.'],
                    ['name' => 'label', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Renderiza `<label>` associado ao campo.'],
                    ['name' => 'name', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Usado para `name`, `id` fallback e leitura do ErrorBag.'],
                    ['name' => 'value', 'type' => 'mixed', 'default' => 'null', 'notes' => 'Valor inicial opcional para uso sem Livewire.'],
                    ['name' => 'placeholder', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Texto auxiliar dentro do campo.'],
                    ['name' => 'error', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Sobrescreve a mensagem automatica do ErrorBag.'],
                    ['name' => 'disabled', 'type' => 'bool', 'default' => 'false', 'notes' => 'Aplica estilo inativo e atributo `disabled`.'],
                    ['name' => 'icon', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Nome Bootstrap Icons sem o prefixo `bi-`, renderizado dentro do campo à esquerda.'],
                    ['name' => 'revealable', 'type' => 'bool', 'default' => 'true', 'notes' => 'Em campos `type="password"`, renderiza o botao de mostrar/ocultar senha quando nao ha slot `suffix`.'],
                    ['name' => '$prefix', 'type' => 'Named slot', 'default' => '-', 'notes' => 'Conteudo customizado dentro do campo, à esquerda.'],
                    ['name' => '$suffix', 'type' => 'Named slot', 'default' => '-', 'notes' => 'Conteudo customizado dentro do campo, à direita.'],
                ],
                'attributes' => ['class', 'id', 'autocomplete', 'required', 'wire:model.live', 'x-model', 'aria-*'],
                'accessibility' => [
                    'Sempre informe `label` ou um `aria-label` quando o campo nao tiver texto visivel.',
                    'Mensagens de erro recebem `aria-describedby` automaticamente quando o erro existe.',
                    'Use `autocomplete` adequado para email, telefone e endereco em fluxos reais.',
                ],
                'examples' => [
                    [
                        'title' => 'Basico',
                        'description' => 'Input textual com placeholder e label.',
                        'code' => <<<'BLADE'
<x-sampaui::input
    name="email"
    type="email"
    label="Email corporativo"
    placeholder="voce@empresa.com"
/>
BLADE,
                    ],
                    [
                        'title' => 'Com icone',
                        'description' => 'Use `icon` para Bootstrap Icons simples dentro do campo.',
                        'code' => <<<'BLADE'
<x-sampaui::input
    name="email"
    type="email"
    label="Email corporativo"
    icon="envelope"
    placeholder="voce@empresa.com"
/>
BLADE,
                    ],
                    [
                        'title' => 'Slots internos',
                        'description' => 'Use `prefix` e `suffix` para icones ou acoes customizadas.',
                        'code' => <<<'BLADE'
<x-sampaui::input
    name="password"
    type="password"
    label="Senha"
    icon="lock"
/>
BLADE,
                    ],
                    [
                        'title' => 'Senha customizada',
                        'description' => 'Se usar `suffix`, o slot fica no mesmo escopo Alpine e pode alternar `showPassword`.',
                        'code' => <<<'BLADE'
<x-sampaui::input name="password" type="password" label="Senha" icon="lock">
    <x-slot:suffix>
        <button
            type="button"
            x-on:click="showPassword = ! showPassword"
            x-bind:aria-label="showPassword ? 'Ocultar senha' : 'Mostrar senha'"
        >
            <i class="bi" x-bind:class="showPassword ? 'bi-eye-slash' : 'bi-eye'"></i>
        </button>
    </x-slot:suffix>
</x-sampaui::input>
BLADE,
                    ],
                    [
                        'title' => 'Erro customizado',
                        'description' => 'Forca a mensagem de erro sem depender do validator.',
                        'code' => <<<'BLADE'
<x-sampaui::input
    name="cpf"
    label="CPF"
    error="Documento invalido para este cadastro."
/>
BLADE,
                    ],
                    [
                        'title' => 'Livewire',
                        'description' => 'Binding direto em busca incremental.',
                        'code' => <<<'BLADE'
<x-sampaui::input
    name="search"
    label="Buscar cliente"
    placeholder="Nome, email ou telefone"
    wire:model.live.debounce.300ms="search"
/>
BLADE,
                    ],
                ],
            ],
            'pin' => [
                'slug' => 'pin',
                'name' => 'Pin',
                'tag' => '<x-sampaui::pin />',
                'summary' => 'Campo de PIN para codigos curtos, 2FA, prefixo, limpeza, mascaras e envio inteligente.',
                'description' => 'Use em confirmacoes por email, SMS, login em duas etapas e codigos de recuperacao. O componente exibe caixas individuais, mas mantem um valor unico em input hidden e sincroniza com Livewire via `x-modelable`.',
                'preview_title' => 'Verificacao em duas etapas',
                'preview_caption' => 'Codigo de acesso com prefixo, limpar, numeros e envio automatico opcional.',
                'props' => [
                    ['name' => 'label', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Texto visivel associado ao grupo de campos.'],
                    ['name' => 'hint', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Texto auxiliar exibido abaixo do label.'],
                    ['name' => 'name', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Usado como `name`, `id` fallback, ErrorBag e payload do formulario.'],
                    ['name' => 'value', 'type' => 'string', 'default' => "''", 'notes' => 'Valor inicial sem Livewire.'],
                    ['name' => 'length', 'type' => 'int|string', 'default' => '4', 'notes' => 'Quantidade de caixas do PIN.'],
                    ['name' => 'prefix', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Prefixo visual antes das caixas, como `G-`.'],
                    ['name' => 'clear', 'type' => 'bool', 'default' => 'false', 'notes' => 'Exibe botao de limpar quando existe valor.'],
                    ['name' => 'numbers', 'type' => 'bool', 'default' => 'false', 'notes' => 'Aceita somente numeros.'],
                    ['name' => 'letters', 'type' => 'bool', 'default' => 'false', 'notes' => 'Aceita somente letras.'],
                    ['name' => 'smart', 'type' => 'bool', 'default' => 'false', 'notes' => 'Envia o formulario pai uma vez quando o PIN fica completo.'],
                    ['name' => 'error', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Mensagem manual ou fallback do ErrorBag.'],
                    ['name' => 'disabled', 'type' => 'bool', 'default' => 'false', 'notes' => 'Bloqueia todas as caixas e reduz contraste.'],
                    ['name' => 'required', 'type' => 'bool', 'default' => 'false', 'notes' => 'Aplica `required` ao input hidden.'],
                ],
                'attributes' => ['class', 'id', 'wire:model.live', 'wire:model', 'x-on:filled', 'x-on:clear', 'aria-*', 'data-*'],
                'accessibility' => [
                    'Use `label` e `hint` para indicar onde o codigo foi enviado e quantos digitos sao esperados.',
                    'Para OTP numerico, use `numbers` para ativar teclado numerico em mobile.',
                    'Valide no servidor como string; nao confie apenas no filtro do navegador.',
                ],
                'examples' => [
                    [
                        'title' => 'Basico',
                        'description' => 'Codigo curto com quantidade definida de caixas.',
                        'code' => <<<'BLADE'
<x-sampaui::pin
    name="code"
    label="Codigo de verificacao"
    length="5"
/>
BLADE,
                    ],
                    [
                        'title' => 'Prefixo e limpar',
                        'description' => 'Use prefixo visual e botao de limpeza em codigos de recuperacao.',
                        'code' => <<<'BLADE'
<x-sampaui::pin
    name="recovery_code"
    label="Insira o codigo"
    hint="Enviamos um codigo de 5 digitos para seu email."
    prefix="G-"
    length="5"
    clear
/>
BLADE,
                    ],
                    [
                        'title' => 'Livewire smart',
                        'description' => 'Envia o formulario pai quando o PIN numerico fica completo.',
                        'code' => <<<'BLADE'
<form wire:submit="verify">
    <x-sampaui::pin
        name="pin"
        label="Digite seu codigo"
        length="6"
        numbers
        smart
        wire:model.live="pin"
    />
</form>
BLADE,
                    ],
                ],
            ],
            'select' => [
                'slug' => 'select',
                'name' => 'Select',
                'tag' => '<x-sampaui::select />',
                'summary' => 'Select com combobox Alpine, dropdown customizado, placeholder, erro e sombra forte na listagem.',
                'description' => 'Bom para formularios administrativos e filtros curtos. O componente aceita `options` ou `option`s no slot, usa `x-modelable` para Livewire e preserva um `<select>` real oculto para formularios.',
                'preview_title' => 'Filtro operacional',
                'preview_caption' => 'Placeholder inicial, opcoes reais e estado com erro.',
                'props' => [
                    ['name' => 'label', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Renderiza `<label>` associado.'],
                    ['name' => 'name', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Usado como `name`, `id` fallback e chave de erro.'],
                    ['name' => 'value', 'type' => 'string|int|null', 'default' => 'null', 'notes' => 'Valor inicial selecionado.'],
                    ['name' => 'options', 'type' => 'array', 'default' => '[]', 'notes' => 'Aceita `valor => label` ou arrays com `value`, `label` e `disabled`.'],
                    ['name' => 'placeholder', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Texto exibido antes de selecionar uma opcao.'],
                    ['name' => 'emptyText', 'type' => 'string', 'default' => 'Nenhuma opcao encontrada.', 'notes' => 'Mensagem quando nao ha opcoes.'],
                    ['name' => 'error', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Mensagem de erro manual ou fallback do ErrorBag.'],
                    ['name' => 'disabled', 'type' => 'bool', 'default' => 'false', 'notes' => 'Desliga interacao e reduz opacidade.'],
                    ['name' => 'required', 'type' => 'bool', 'default' => 'false', 'notes' => 'Aplica `required` ao select real.'],
                    ['name' => '$slot', 'type' => 'Blade slot', 'default' => '-', 'notes' => 'Recebe as `option` e `optgroup` do consumo.'],
                ],
                'attributes' => ['class', 'id', 'wire:model.live', 'wire:model', 'x-on:select:changed.window', 'aria-*', 'data-*'],
                'accessibility' => [
                    'Use `label` claro para contexto do conjunto de opcoes.',
                    'Para selecao multipla, prefira `select-multiple`.',
                    'Evite placeholders ambiguos; prefira instrucoes orientadas a tarefa.',
                ],
                'examples' => [
                    [
                        'title' => 'Basico',
                        'description' => 'Select com placeholder e opcoes de status.',
                        'code' => <<<'BLADE'
<x-sampaui::select
    name="status"
    label="Status do atendimento"
    placeholder="Selecione um status"
    :options="[
        'new' => 'Novo',
        'qualified' => 'Qualificado',
        'won' => 'Fechado',
    ]"
/>
BLADE,
                    ],
                    [
                        'title' => 'Erro',
                        'description' => 'Mensagem manual para casos de validacao contextual.',
                        'code' => <<<'BLADE'
<x-sampaui::select
    name="owner"
    label="Responsavel"
    error="Escolha um membro da equipe para continuar."
    :options="[
        'ana' => 'Ana',
        'joao' => 'Joao',
    ]"
/>
BLADE,
                    ],
                    [
                        'title' => 'Livewire',
                        'description' => 'Binding em filtros de dashboard.',
                        'code' => <<<'BLADE'
<x-sampaui::select
    name="city"
    label="Cidade"
    wire:model.live="city"
    :options="[
        'sp' => 'Sao Paulo',
        'campinas' => 'Campinas',
    ]"
/>
BLADE,
                    ],
                ],
            ],
            'select-search' => [
                'slug' => 'select-search',
                'name' => 'Select com busca',
                'tag' => '<x-sampaui::select-search />',
                'summary' => 'Select pesquisavel com busca local, opcoes via array e sincronizacao por input hidden para formularios e Livewire.',
                'description' => 'Use quando a lista de opcoes e maior que um select simples, mas ainda pequena o suficiente para busca local no navegador. O trigger e a busca interna usam `border-secondary/40`, e `x-modelable` permite que `wire:model` sincronize o valor sem a prop `value`.',
                'preview_title' => 'Busca de responsavel',
                'preview_caption' => 'Campo pesquisavel com placeholder, opcao selecionada, erro e binding Livewire.',
                'props' => [
                    ['name' => 'label', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Renderiza `<label>` associado ao botao do combobox.'],
                    ['name' => 'name', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Usado como `name`, `id` fallback, chave de erro e payload do evento.'],
                    ['name' => 'value', 'type' => 'string|int|null', 'default' => 'null', 'notes' => 'Valor inicial selecionado.'],
                    ['name' => 'options', 'type' => 'array', 'default' => '[]', 'notes' => 'Aceita `valor => label` ou arrays com `value` e `label`.'],
                    ['name' => 'placeholder', 'type' => 'string', 'default' => 'Selecione', 'notes' => 'Texto exibido antes de selecionar uma opcao.'],
                    ['name' => 'searchPlaceholder', 'type' => 'string', 'default' => 'Buscar...', 'notes' => 'Placeholder do campo de busca interno.'],
                    ['name' => 'emptyText', 'type' => 'string', 'default' => 'Nenhum resultado encontrado.', 'notes' => 'Mensagem quando a busca nao encontra opcoes.'],
                    ['name' => 'error', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Mensagem manual ou fallback do ErrorBag.'],
                    ['name' => 'disabled', 'type' => 'bool', 'default' => 'false', 'notes' => 'Bloqueia interacao e reduz contraste.'],
                    ['name' => 'required', 'type' => 'bool', 'default' => 'false', 'notes' => 'Aplica `required` ao input hidden para formularios nativos.'],
                ],
                'attributes' => ['class', 'id', 'wire:model.live', 'wire:model', 'x-on:select-search:changed.window', 'aria-*', 'data-*'],
                'accessibility' => [
                    'Use `label` claro para indicar qual entidade sera selecionada.',
                    'Para listas muito grandes ou remotas, prefira uma versao futura com busca no servidor em vez de enviar milhares de opcoes no HTML.',
                    'O valor real fica em um input hidden; valide no servidor como qualquer campo de formulario.',
                ],
                'examples' => [
                    [
                        'title' => 'Basico',
                        'description' => 'Busca local com opcoes em array associativo.',
                        'code' => <<<'BLADE'
<x-sampaui::select-search
    name="owner"
    label="Responsavel"
    placeholder="Selecione um responsavel"
    :options="[
        'ana' => 'Ana Souza',
        'bruno' => 'Bruno Lima',
        'carla' => 'Carla Martins',
    ]"
/>
BLADE,
                    ],
                    [
                        'title' => 'Valor inicial',
                        'description' => 'Use `value` para iniciar com uma opcao selecionada.',
                        'code' => <<<'BLADE'
<x-sampaui::select-search
    name="city"
    label="Cidade"
    value="campinas"
    :options="[
        ['value' => 'sp', 'label' => 'Sao Paulo'],
        ['value' => 'campinas', 'label' => 'Campinas'],
        ['value' => 'santos', 'label' => 'Santos'],
    ]"
/>
BLADE,
                    ],
                    [
                        'title' => 'Livewire',
                        'description' => '`wire:model` se conecta ao estado Alpine por `x-modelable`; nao informe `value` neste uso.',
                        'code' => <<<'BLADE'
<x-sampaui::select-search
    name="customer_id"
    label="Cliente"
    placeholder="Buscar cliente"
    wire:model.live="customerId"
    :options="$customers"
/>
BLADE,
                    ],
                ],
            ],
            'select-multiple' => [
                'slug' => 'select-multiple',
                'name' => 'Select múltiplo',
                'tag' => '<x-sampaui::select-multiple />',
                'summary' => 'Select multiplo com busca local, tags removiveis, estados visuais e sincronizacao por `x-modelable`.',
                'description' => 'Use quando o usuario precisa escolher varias opcoes de uma lista local. Cada item selecionado aparece como tag com acao de remocao, o dropdown filtra opcoes em tempo real e fecha ao clicar fora ou pressionar `Esc`.',
                'preview_title' => 'Perfis de acesso',
                'preview_caption' => 'Multipla selecao com tags, busca interna, erro, disabled e loading.',
                'props' => [
                    ['name' => 'label', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Renderiza `<label>` associado ao botao do combobox.'],
                    ['name' => 'name', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Usado como `name[]`, `id` fallback, chave de erro e payload do evento.'],
                    ['name' => 'value', 'type' => 'array|string|null', 'default' => '[]', 'notes' => 'Valores iniciais selecionados.'],
                    ['name' => 'options', 'type' => 'array', 'default' => '[]', 'notes' => 'Aceita `valor => label` ou arrays com `value`, `label` e `disabled`.'],
                    ['name' => 'placeholder', 'type' => 'string', 'default' => 'Selecione', 'notes' => 'Texto exibido antes de selecionar opcoes.'],
                    ['name' => 'searchPlaceholder', 'type' => 'string', 'default' => 'Buscar...', 'notes' => 'Placeholder do campo de busca interno.'],
                    ['name' => 'emptyText', 'type' => 'string', 'default' => 'Nenhum resultado encontrado.', 'notes' => 'Mensagem quando a busca nao encontra opcoes.'],
                    ['name' => 'loadingText', 'type' => 'string', 'default' => 'Carregando opcoes...', 'notes' => 'Mensagem do estado loading.'],
                    ['name' => 'error', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Mensagem manual ou fallback do ErrorBag.'],
                    ['name' => 'disabled', 'type' => 'bool', 'default' => 'false', 'notes' => 'Bloqueia interacao e reduz contraste.'],
                    ['name' => 'loading', 'type' => 'bool', 'default' => 'false', 'notes' => 'Exibe spinner e bloqueia interacao enquanto carrega.'],
                    ['name' => 'required', 'type' => 'bool', 'default' => 'false', 'notes' => 'Aplica `required` aos inputs hidden para formularios nativos.'],
                ],
                'attributes' => ['class', 'id', 'wire:model.live', 'wire:model', 'x-on:select-multiple:changed.window', 'aria-*', 'data-*'],
                'accessibility' => [
                    'Use `label` claro para explicar o conjunto de opcoes.',
                    'Mantenha as labels das tags curtas para evitar truncamento excessivo em mobile.',
                    'Valide no servidor como array e use mensagens de erro objetivas para selecao obrigatoria.',
                ],
                'examples' => [
                    [
                        'title' => 'Basico',
                        'description' => 'Selecao multipla com busca local e tags removiveis.',
                        'code' => <<<'BLADE'
<x-sampaui::select-multiple
    name="roles"
    label="Perfis"
    placeholder="Selecione os perfis"
    search-placeholder="Buscar perfil"
    :options="[
        'admin' => 'Administrador',
        'manager' => 'Gerente',
        'support' => 'Suporte',
    ]"
/>
BLADE,
                    ],
                    [
                        'title' => 'Valor inicial',
                        'description' => 'Use `value` com array para iniciar com opcoes marcadas.',
                        'code' => <<<'BLADE'
<x-sampaui::select-multiple
    name="channels"
    label="Canais"
    :value="['email', 'whatsapp']"
    :options="[
        ['value' => 'email', 'label' => 'Email'],
        ['value' => 'whatsapp', 'label' => 'WhatsApp'],
        ['value' => 'sms', 'label' => 'SMS'],
    ]"
/>
BLADE,
                    ],
                    [
                        'title' => 'Livewire',
                        'description' => '`wire:model` sincroniza um array por `x-modelable`; nao informe `value` neste uso.',
                        'code' => <<<'BLADE'
<x-sampaui::select-multiple
    name="permissions"
    label="Permissoes"
    wire:model.live="permissions"
    :options="$permissions"
/>
BLADE,
                    ],
                ],
            ],
            'textarea' => [
                'slug' => 'textarea',
                'name' => 'Textarea',
                'tag' => '<x-sampaui::textarea />',
                'summary' => 'Campo multiline nativo com `rows`, label opcional, slot para conteudo inicial e tratamento padrao de validacao.',
                'description' => 'Indicado para observacoes de atendimento, briefings e descricoes de produto. Mantem a mesma linguagem visual do `input` e repassa atributos HTML, Alpine e Livewire para o textarea.',
                'preview_title' => 'Resumo do atendimento',
                'preview_caption' => 'Textarea nativo para anotacoes, valor inicial, retorno com erro e binding Livewire.',
                'props' => [
                    ['name' => 'label', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Renderiza legenda visivel do campo.'],
                    ['name' => 'name', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Serve para `name`, `id` fallback e ErrorBag.'],
                    ['name' => 'rows', 'type' => 'int|string', 'default' => '4', 'notes' => 'Define a altura inicial do campo.'],
                    ['name' => 'placeholder', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Ajuda textual para formulario vazio.'],
                    ['name' => 'error', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Mensagem de erro manual ou automatica.'],
                    ['name' => 'disabled', 'type' => 'bool', 'default' => 'false', 'notes' => 'Aplica `disabled` e reduz contraste.'],
                    ['name' => '$slot', 'type' => 'Blade slot', 'default' => '-', 'notes' => 'Conteudo inicial do textarea.'],
                ],
                'attributes' => ['class', 'id', 'maxlength', 'wire:model.live', 'x-model', 'aria-*', 'data-*'],
                'accessibility' => [
                    'Considere `maxlength` e contadores auxiliares para textos longos.',
                    'Prefira `rows` compatível com o contexto, evitando campos excessivamente altos em mobile.',
                    'Use `label` visivel ou `aria-label` quando o contexto visual ja identifica claramente o campo.',
                ],
                'examples' => [
                    [
                        'title' => 'Basico',
                        'description' => 'Textarea nativo para observacoes curtas.',
                        'code' => <<<'BLADE'
<x-sampaui::textarea
    name="notes"
    label="Observacoes"
    rows="5"
    placeholder="Descreva o contexto do atendimento"
/>
BLADE,
                    ],
                    [
                        'title' => 'Com valor inicial',
                        'description' => 'Slot para popular o campo em modo de edicao.',
                        'code' => <<<'BLADE'
<x-sampaui::textarea name="briefing" label="Briefing">
Cliente precisa priorizar lancamento mobile no proximo trimestre.
</x-sampaui::textarea>
BLADE,
                    ],
                    [
                        'title' => 'Erro de validacao',
                        'description' => 'Mensagem manual ou vinda do ErrorBag.',
                        'code' => <<<'BLADE'
<x-sampaui::textarea
    name="notes"
    label="Observacoes"
    error="Inclua uma observacao antes de continuar."
/>
BLADE,
                    ],
                    [
                        'title' => 'Livewire',
                        'description' => 'Binding em rascunho de comentario.',
                        'code' => <<<'BLADE'
<x-sampaui::textarea
    name="message"
    label="Mensagem"
    wire:model.live.debounce.500ms="message"
/>
BLADE,
                    ],
                ],
            ],
            'checkbox' => [
                'slug' => 'checkbox',
                'name' => 'Checkbox',
                'tag' => '<x-sampaui::checkbox />',
                'summary' => 'Controle booleano com label opcional, suporte a slot e integracao direta com validacao.',
                'description' => 'Use em consentimentos, flags operacionais e configuracoes binarias. O componente usa `border-secondary/40` e cuida de alinhamento, estados desabilitados e vinculo do label.',
                'preview_title' => 'Preferencias e opt-in',
                'preview_caption' => 'Checkbox com label, slot customizado e estado de erro.',
                'props' => [
                    ['name' => 'label', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Texto visivel ao lado do controle.'],
                    ['name' => 'name', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Usado como `name`, `id` fallback e chave de erro.'],
                    ['name' => 'value', 'type' => 'string', 'default' => '1', 'notes' => 'Valor enviado quando marcado.'],
                    ['name' => 'checked', 'type' => 'bool', 'default' => 'false', 'notes' => 'Marca o controle na renderizacao inicial.'],
                    ['name' => 'color', 'type' => 'primary|secondary|accent|danger|success|warning|info|purple|muted|light', 'default' => 'primary', 'notes' => 'Define a cor do controle marcado usando os tokens oficiais.'],
                    ['name' => 'error', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Mensagem manual ou vinda do ErrorBag.'],
                    ['name' => 'disabled', 'type' => 'bool', 'default' => 'false', 'notes' => 'Desabilita a interacao e reduz contraste.'],
                    ['name' => '$slot', 'type' => 'Blade slot', 'default' => '-', 'notes' => 'Alternativa ao prop `label` para conteudo mais rico.'],
                ],
                'attributes' => ['class', 'id', 'wire:model.live', 'required', 'aria-*'],
                'accessibility' => [
                    'Nao deixe o checkbox sem texto associado; use `label` ou slot.',
                    'Para termos legais, prefira slot com links e mantenha o texto clicavel.',
                    'Quando o campo for obrigatorio, combine validacao servidor + feedback textual claro.',
                ],
                'examples' => [
                    [
                        'title' => 'Basico',
                        'description' => 'Opt-in simples para newsletters ou preferencias.',
                        'code' => <<<'BLADE'
<x-sampaui::checkbox
    name="marketing"
    label="Receber novidades por email"
    color="accent"
/>
BLADE,
                    ],
                    [
                        'title' => 'Slot customizado',
                        'description' => 'Texto rico para consentimento.',
                        'code' => <<<'BLADE'
<x-sampaui::checkbox name="terms">
    Concordo com os <a href="/termos" class="underline">termos de uso</a>.
</x-sampaui::checkbox>
BLADE,
                    ],
                    [
                        'title' => 'Livewire',
                        'description' => 'Toggle de filtro persistido.',
                        'code' => <<<'BLADE'
<x-sampaui::checkbox
    name="only_open"
    label="Mostrar apenas atendimentos em aberto"
    color="secondary"
    wire:model.live="onlyOpen"
/>
BLADE,
                    ],
                ],
            ],
            'radio' => [
                'slug' => 'radio',
                'name' => 'Radio',
                'tag' => '<x-sampaui::radio />',
                'summary' => 'Grupo de opcoes exclusivas com cores oficiais, suporte a array de opcoes, slot e atributos Livewire.',
                'description' => 'Use quando o usuario precisa escolher exatamente uma opcao em um conjunto curto. Cada controle usa `border-secondary/40`, e o componente resolve label, ids, estado selecionado, erro visual e atributos Livewire.',
                'preview_title' => 'Escolha unica',
                'preview_caption' => 'Radio group com cores, inline e estado validado.',
                'props' => [
                    ['name' => 'label', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Renderiza a legenda do fieldset.'],
                    ['name' => 'name', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Usado como `name`, base de `id` e chave de erro.'],
                    ['name' => 'value', 'type' => 'string|int|null', 'default' => 'null', 'notes' => 'Valor selecionado inicialmente.'],
                    ['name' => 'options', 'type' => 'array', 'default' => '[]', 'notes' => 'Aceita `valor => label` ou arrays com `value`, `label` e `disabled`.'],
                    ['name' => 'color', 'type' => 'primary|secondary|accent|danger|success|warning|info|purple|muted|light', 'default' => 'primary', 'notes' => 'Define cor do controle marcado.'],
                    ['name' => 'inline', 'type' => 'bool', 'default' => 'false', 'notes' => 'Alinha as opcoes na horizontal.'],
                    ['name' => 'error', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Mensagem manual ou vinda do ErrorBag.'],
                    ['name' => 'disabled', 'type' => 'bool', 'default' => 'false', 'notes' => 'Desabilita todas as opcoes.'],
                    ['name' => '$slot', 'type' => 'Blade slot', 'default' => '-', 'notes' => 'Alternativa para compor radios manualmente.'],
                ],
                'attributes' => ['class', 'id', 'wire:model.live', 'required', 'aria-*', 'data-*'],
                'accessibility' => [
                    'Use `label` para dar contexto ao grupo, nao apenas aos itens.',
                    'Mantenha opcoes curtas e mutuamente exclusivas.',
                    'Quando houver erro, o fieldset recebe `aria-invalid` e referencia a mensagem.',
                ],
                'examples' => [
                    [
                        'title' => 'Basico',
                        'description' => 'Grupo vertical com valor inicial.',
                        'code' => <<<'BLADE'
<x-sampaui::radio
    name="status"
    label="Status"
    value="active"
    :options="[
        'active' => 'Ativo',
        'paused' => 'Pausado',
        'archived' => 'Arquivado',
    ]"
/>
BLADE,
                    ],
                    [
                        'title' => 'Inline e cor',
                        'description' => 'Opcoes horizontais usando token accent.',
                        'code' => <<<'BLADE'
<x-sampaui::radio
    name="priority"
    label="Prioridade"
    color="accent"
    inline
    value="medium"
    :options="[
        'low' => 'Baixa',
        'medium' => 'Media',
        'high' => 'Alta',
    ]"
/>
BLADE,
                    ],
                    [
                        'title' => 'Livewire',
                        'description' => 'Binding direto em filtros e formularios.',
                        'code' => <<<'BLADE'
<x-sampaui::radio
    name="type"
    label="Tipo de atendimento"
    wire:model.live="type"
    :options="[
        'sales' => 'Comercial',
        'support' => 'Suporte',
    ]"
/>
BLADE,
                    ],
                ],
            ],
            'date-picker' => [
                'slug' => 'date-picker',
                'name' => 'DatePicker',
                'tag' => '<x-sampaui::date-picker />',
                'summary' => 'Calendario de data apenas, sem hora, com label, min/max, erro, limpeza opcional e atributos Livewire.',
                'description' => 'Use para datas simples em formularios administrativos. O trigger usa `border-secondary/40`; Alpine com `x-modelable` salva somente `YYYY-MM-DD` e recebe o estado de `wire:model` sem exigir a prop `value`.',
                'preview_title' => 'Agendamento',
                'preview_caption' => 'Calendario de data com min/max, erro e binding Livewire.',
                'props' => [
                    ['name' => 'label', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Renderiza `<label>` associado ao campo.'],
                    ['name' => 'name', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Usado para `name`, `id` fallback e chave de erro.'],
                    ['name' => 'value', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Valor inicial opcional para uso sem Livewire, no formato `YYYY-MM-DD`.'],
                    ['name' => 'min', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Data minima selecionavel.'],
                    ['name' => 'max', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Data maxima selecionavel.'],
                    ['name' => 'placeholder', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Texto exibido quando nenhuma data foi selecionada.'],
                    ['name' => 'error', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Mensagem manual ou vinda do ErrorBag.'],
                    ['name' => 'disabled', 'type' => 'bool', 'default' => 'false', 'notes' => 'Bloqueia o campo e reduz contraste.'],
                    ['name' => 'required', 'type' => 'bool', 'default' => 'false', 'notes' => 'Marca o input real como obrigatorio para formularios e validacao.'],
                    ['name' => 'clearable', 'type' => 'bool', 'default' => 'false', 'notes' => 'Exibe acao para limpar a data selecionada.'],
                ],
                'attributes' => ['class', 'id', 'wire:model.live', 'x-model', 'aria-*', 'data-*'],
                'accessibility' => [
                    'Informe `label` ou `aria-label` para descrever a data solicitada.',
                    'Use `min` e `max` quando a regra de negocio tiver periodo valido.',
                    'Valide no servidor porque o valor final e enviado como string `YYYY-MM-DD`.',
                ],
                'examples' => [
                    [
                        'title' => 'Basico',
                        'description' => 'Calendario com valor inicial, exibido em formato brasileiro e salvo como `YYYY-MM-DD`.',
                        'code' => <<<'BLADE'
<x-sampaui::date-picker
    name="published_at"
    label="Data de publicacao"
    value="2026-05-25"
/>
BLADE,
                    ],
                    [
                        'title' => 'Periodo permitido',
                        'description' => 'Use `min` e `max` para restringir a janela.',
                        'code' => <<<'BLADE'
<x-sampaui::date-picker
    name="due_at"
    label="Vencimento"
    min="2026-05-01"
    max="2026-12-31"
    required
/>
BLADE,
                    ],
                    [
                        'title' => 'Erro e Livewire',
                        'description' => 'Mensagem de erro e binding por `x-modelable`, sem prop `value`.',
                        'code' => <<<'BLADE'
<x-sampaui::date-picker
    name="scheduled_at"
    label="Agendamento"
    error="Escolha uma data valida."
    wire:model.live="scheduledAt"
/>
BLADE,
                    ],
                ],
            ],
            'alert' => [
                'slug' => 'alert',
                'name' => 'Alert',
                'tag' => '<x-sampaui::alert />',
                'summary' => 'Mensagem contextual com icone, titulo opcional, role acessivel e variantes nos tokens oficiais.',
                'description' => 'Use para feedback persistente em formularios, avisos operacionais e estados de sistema que precisam ficar no fluxo da pagina.',
                'preview_title' => 'Feedback de sistema',
                'preview_caption' => 'Alertas success, warning e error usando a paleta SampaUI.',
                'props' => [
                    ['name' => 'variant', 'type' => 'success|danger|error|warning|info', 'default' => 'info', 'notes' => 'Define cor, icone padrao e role inicial.'],
                    ['name' => 'type', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Alias de compatibilidade para `variant`.'],
                    ['name' => 'title', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Titulo curto acima da mensagem.'],
                    ['name' => 'icon', 'type' => 'string|false|null', 'default' => 'null', 'notes' => 'Nome do Bootstrap Icon sem `bi-`; `false` remove o icone.'],
                    ['name' => 'role', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Sobrescreve `status` ou `alert` quando necessario.'],
                    ['name' => '$slot', 'type' => 'Blade slot', 'default' => '-', 'notes' => 'Conteudo principal do aviso.'],
                ],
                'attributes' => ['class', 'id', 'wire:show', 'x-show', 'aria-*', 'data-*'],
                'accessibility' => [
                    'Use `variant="error"` para mensagens que precisam ser anunciadas imediatamente.',
                    'Mantenha o titulo curto para nao competir com a mensagem principal.',
                    'Nao use apenas cor para comunicar severidade; mantenha texto claro no slot.',
                ],
                'examples' => [
                    [
                        'title' => 'Informativo',
                        'description' => 'Aviso neutro no fluxo da pagina.',
                        'code' => <<<'BLADE'
<x-sampaui::alert title="Publicacao agendada">
    O conteudo sera exibido apos aprovacao interna.
</x-sampaui::alert>
BLADE,
                    ],
                    [
                        'title' => 'Erro',
                        'description' => 'Feedback assertivo para validacao ou falha de acao.',
                        'code' => <<<'BLADE'
<x-sampaui::alert variant="error" title="Nao foi possivel salvar">
    Revise os campos destacados antes de continuar.
</x-sampaui::alert>
BLADE,
                    ],
                    [
                        'title' => 'Livewire',
                        'description' => 'Pode ser exibido condicionalmente por atributos Livewire.',
                        'code' => <<<'BLADE'
<x-sampaui::alert
    variant="success"
    title="Lead atualizado"
    wire:show="saved"
>
    As alteracoes foram sincronizadas.
</x-sampaui::alert>
BLADE,
                    ],
                ],
            ],
            'card' => [
                'slug' => 'card',
                'name' => 'Card',
                'tag' => '<x-sampaui::card />',
                'summary' => 'Container com header, descricao, actions, footer e variantes discretas para superficies de conteudo.',
                'description' => 'Use para agrupar dados operacionais, formularios curtos e blocos de resumo sem recriar sombra e espacamento.',
                'preview_title' => 'Resumo operacional',
                'preview_caption' => 'Card com header, conteudo, actions e footer.',
                'props' => [
                    ['name' => 'title', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Titulo padrao do header.'],
                    ['name' => 'description', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Texto auxiliar abaixo do titulo.'],
                    ['name' => 'variant', 'type' => 'default|muted|primary|secondary|accent|danger|success|warning|info|purple', 'default' => 'default', 'notes' => 'Define a superficie e a cor de borda com tokens oficiais.'],
                    ['name' => 'padding', 'type' => 'sm|md|lg', 'default' => 'md', 'notes' => 'Controla espacamento interno do header, body e footer.'],
                    ['name' => 'divided', 'type' => 'bool', 'default' => 'false', 'notes' => 'Exibe divisor entre header e body quando ativado.'],
                    ['name' => '$slot', 'type' => 'Blade slot', 'default' => '-', 'notes' => 'Conteudo principal.'],
                    ['name' => '$header/$actions/$footer', 'type' => 'Named slots', 'default' => '-', 'notes' => 'Substituem ou complementam as regioes do card.'],
                ],
                'attributes' => ['class', 'id', 'wire:key', 'x-data', 'aria-*', 'data-*'],
                'accessibility' => [
                    'Quando o card for clicavel, prefira envolver o conteudo em um link sem aninhar botoes internos.',
                    'Use hierarquia de headings coerente com a pagina, nao apenas pelo tamanho visual.',
                    'Actions devem ter nomes claros e foco visivel quando forem interativas.',
                ],
                'examples' => [
                    [
                        'title' => 'Basico',
                        'description' => 'Header simples com conteudo no slot.',
                        'code' => <<<'BLADE'
<x-sampaui::card title="Atendimento" description="Resumo do lead">
    Cliente aguardando retorno comercial.
</x-sampaui::card>
BLADE,
                    ],
                    [
                        'title' => 'Com actions',
                        'description' => 'Slot nomeado para comando no header.',
                        'code' => <<<'BLADE'
<x-sampaui::card title="Contrato" variant="primary">
    <x-slot:actions>
        <x-sampaui::button size="sm" variant="outline">Abrir</x-sampaui::button>
    </x-slot:actions>

    Proposta em analise juridica.
</x-sampaui::card>
BLADE,
                    ],
                    [
                        'title' => 'Footer',
                        'description' => 'Regiao inferior para metadados ou acoes secundarias.',
                        'code' => <<<'BLADE'
<x-sampaui::card title="Publicacao" padding="lg">
    Imovel pronto para revisao final.

    <x-slot:footer>
        Atualizado ha 3 minutos.
    </x-slot:footer>
</x-sampaui::card>
BLADE,
                    ],
                ],
            ],
            'modal' => [
                'slug' => 'modal',
                'name' => 'Modal',
                'tag' => '<x-sampaui::modal />',
                'summary' => 'Dialog Livewire com entangle, backdrop, header, actions e fechamento por evento.',
                'description' => 'Use para formularios curtos, confirmacoes e fluxos que precisam interromper a pagina sem sair do contexto. O componente usa Alpine core, Bootstrap Icons e tokens oficiais SampaUI.',
                'preview_title' => 'Dialog operacional',
                'preview_caption' => 'Modal controlado por propriedade Livewire e slots Blade.',
                'props' => [
                    ['name' => 'model', 'type' => 'string', 'default' => '-', 'notes' => 'Nome da propriedade booleana Livewire usada por `@entangle(...).live`.'],
                    ['name' => 'title', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Titulo padrao do header.'],
                    ['name' => 'subtitle', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Texto auxiliar associado por `aria-describedby`.'],
                    ['name' => 'size', 'type' => 'sm|md|lg|xl|2xl|4xl|5xl|6xl|7xl|full', 'default' => 'lg', 'notes' => 'Controla a largura maxima do painel.'],
                    ['name' => 'variant', 'type' => 'default|primary|secondary|accent|danger|success|warning|info|purple|muted', 'default' => 'default', 'notes' => 'Define a cor de borda do painel.'],
                    ['name' => 'persistent', 'type' => 'bool', 'default' => 'false', 'notes' => 'Impede fechamento por ESC ou clique no backdrop.'],
                    ['name' => 'closeButton', 'type' => 'bool', 'default' => 'true', 'notes' => 'Exibe ou remove o botao de fechar no header.'],
                    ['name' => 'closeEvent', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Evento browser que fecha o modal, como `lead-saved`.'],
                    ['name' => 'afterClose', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Metodo Livewire chamado apos a animacao de fechamento.'],
                    ['name' => 'panelClass', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Classes extras aplicadas ao painel interno, uteis para trocar ou remover a borda.'],
                    ['name' => '$header/$actions', 'type' => 'Named slots', 'default' => '-', 'notes' => 'Permitem substituir o header e adicionar acoes no rodape.'],
                ],
                'attributes' => ['class', 'id', 'wire:key', 'x-on:*', 'data-*', 'aria-*'],
                'accessibility' => [
                    'O componente renderiza `role="dialog"` e `aria-modal="true"` automaticamente.',
                    'Informe `title` ou um slot `header` com heading claro para dar contexto ao dialog.',
                    'Use `persistent` somente em fluxos em que fechar sem acao causaria perda de dados.',
                ],
                'examples' => [
                    [
                        'title' => 'Basico',
                        'description' => 'Modal controlado por propriedade booleana Livewire.',
                        'code' => <<<'BLADE'
<x-sampaui::button wire:click="$set('showLeadModal', true)">
    Abrir modal
</x-sampaui::button>

<x-sampaui::modal model="showLeadModal" title="Novo lead" subtitle="Preencha os dados principais">
    Conteudo do formulario.

    <x-slot:actions>
        <x-sampaui::button variant="outline" wire:click="$set('showLeadModal', false)">
            Cancelar
        </x-sampaui::button>
        <x-sampaui::button wire:click="save">
            Salvar
        </x-sampaui::button>
    </x-slot:actions>
</x-sampaui::modal>
BLADE,
                    ],
                    [
                        'title' => 'Evento Livewire',
                        'description' => 'Fechamento por evento e callback depois da animacao.',
                        'code' => <<<'BLADE'
<x-sampaui::modal
    model="showLeadModal"
    title="Editar lead"
    close-event="lead-saved"
    after-close="afterModalClose"
>
    Dados atualizados no Livewire.
</x-sampaui::modal>
BLADE,
                    ],
                ],
            ],
            'header' => [
                'slug' => 'header',
                'name' => 'Header',
                'tag' => '<x-sampaui::header />',
                'summary' => 'Cabecalho de pagina com titulo, subtitulo, status, acoes e botao mobile para navegacao.',
                'description' => 'Use no topo de dashboards e telas internas. O componente organiza contexto da pagina e comandos principais sem depender de layout especifico do app consumidor.',
                'preview_title' => 'Cabecalho operacional',
                'preview_caption' => 'Titulo, status e acoes alinhados em uma unica superficie.',
                'props' => [
                    ['name' => 'title', 'type' => 'string', 'default' => 'Dashboard', 'notes' => 'Titulo principal exibido no header.'],
                    ['name' => 'subtitle', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Texto auxiliar abaixo do titulo.'],
                    ['name' => 'eyebrow', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Label curto acima do titulo.'],
                    ['name' => 'status', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Pill de status exibida na direita.'],
                    ['name' => 'menu', 'type' => 'bool', 'default' => 'false', 'notes' => 'Exibe botao mobile para abrir navegacao.'],
                    ['name' => 'menuEvent', 'type' => 'string', 'default' => 'sampaui:sidebar-open', 'notes' => 'Evento Alpine disparado pelo botao mobile.'],
                    ['name' => '$actions', 'type' => 'Named slot', 'default' => '-', 'notes' => 'Regiao para botoes e comandos do topo.'],
                ],
                'attributes' => ['class', 'id', 'wire:key', 'x-data', 'aria-*', 'data-*'],
                'accessibility' => [
                    'Use apenas um header principal por tela para manter hierarquia clara.',
                    'Quando `menu` estiver ativo, garanta que uma sidebar escute o mesmo `menuEvent`.',
                    'Actions devem ter texto ou `aria-label` quando forem apenas icones.',
                ],
                'examples' => [
                    [
                        'title' => 'Basico',
                        'description' => 'Titulo com subtitulo e status.',
                        'code' => <<<'BLADE'
<x-sampaui::header
    title="Clientes"
    subtitle="Gerencie relacionamentos comerciais"
    eyebrow="CRM"
    status="Atualizado agora"
/>
BLADE,
                    ],
                    [
                        'title' => 'Com acoes',
                        'description' => 'Botoes no slot `actions`.',
                        'code' => <<<'BLADE'
<x-sampaui::header title="Pipeline" subtitle="Atendimentos em aberto">
    <x-slot:actions>
        <x-sampaui::button variant="outline" icon="download">Exportar</x-sampaui::button>
        <x-sampaui::button icon="plus">Novo lead</x-sampaui::button>
    </x-slot:actions>
</x-sampaui::header>
BLADE,
                    ],
                    [
                        'title' => 'Com menu mobile',
                        'description' => 'Dispara evento para abrir a sidebar.',
                        'code' => <<<'BLADE'
<x-sampaui::header
    title="Dashboard"
    subtitle="Resumo operacional"
    menu
    menu-event="sampaui:sidebar-open"
/>
BLADE,
                    ],
                ],
            ],
            'sidebar' => [
                'slug' => 'sidebar',
                'name' => 'Sidebar',
                'tag' => '<x-sampaui::sidebar />',
                'summary' => 'Navegacao lateral responsiva com marca, usuario, secoes, links ativos e suporte a `wire:navigate`.',
                'description' => 'Use em areas autenticadas e dashboards. O componente nao chama rotas nem `auth()` internamente: links, usuario e estado ativo entram por arrays do app consumidor.',
                'preview_title' => 'Navegacao interna',
                'preview_caption' => 'Menu lateral com secoes e item ativo.',
                'props' => [
                    ['name' => 'brand', 'type' => 'string', 'default' => 'SampaUI', 'notes' => 'Nome exibido no topo.'],
                    ['name' => 'brandHref', 'type' => 'string', 'default' => '#', 'notes' => 'Destino do link da marca.'],
                    ['name' => 'brandIcon', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Nome Bootstrap Icon sem `bi-`, exibido sobre a marca abstrata.'],
                    ['name' => 'logo', 'type' => 'string|null', 'default' => 'null', 'notes' => 'URL de uma imagem para substituir a marca abstrata.'],
                    ['name' => 'logoAlt', 'type' => 'string|null', 'default' => 'brand', 'notes' => 'Texto alternativo da imagem informada em `logo`.'],
                    ['name' => '$logo', 'type' => 'Named slot', 'default' => '-', 'notes' => 'Substitui `logo` por qualquer markup customizado, como SVG inline ou `<picture>`.'],
                    ['name' => 'items', 'type' => 'array', 'default' => '[]', 'notes' => 'Links principais do menu.'],
                    ['name' => 'sections', 'type' => 'array', 'default' => '[]', 'notes' => 'Grupos adicionais com `label` e `items`.'],
                    ['name' => 'user', 'type' => 'array|null', 'default' => 'null', 'notes' => 'Dados opcionais: `name`, `email`, `avatar`.'],
                    ['name' => 'avatar', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Atalho para avatar do usuario quando preferir nao passar `user[avatar]`.'],
                    ['name' => 'avatarAlt', 'type' => 'string|null', 'default' => 'user.name', 'notes' => 'Texto alternativo da imagem do avatar.'],
                    ['name' => 'initialState', 'type' => 'open|closed|collapsed|null', 'default' => 'null', 'notes' => 'Define se a sidebar inicia aberta ou recolhida. `closed` e `collapsed` sao equivalentes.'],
                    ['name' => 'collapsed', 'type' => 'bool', 'default' => 'false', 'notes' => 'Alias legado para iniciar recolhida. Em novos usos, prefira `initial-state="closed"`.'],
                    ['name' => 'collapsible', 'type' => 'bool', 'default' => 'true', 'notes' => 'Exibe botao flutuante para recolher ou expandir.'],
                    ['name' => 'openEvent', 'type' => 'string', 'default' => 'sampaui:sidebar-open', 'notes' => 'Evento Alpine para abrir no mobile.'],
                    ['name' => 'closeEvent', 'type' => 'string', 'default' => 'sampaui:sidebar-close', 'notes' => 'Evento Alpine para fechar no mobile.'],
                    ['name' => 'stateEvent', 'type' => 'string', 'default' => 'sampaui:sidebar-state', 'notes' => 'Evento emitido ao iniciar, abrir, fechar ou recolher. Use para ajustar `margin-left` do conteudo.'],
                    ['name' => 'rail', 'type' => 'bool', 'default' => 'true', 'notes' => 'Exibe o trilho lateral decorativo. Desative com `:rail="false"` em layouts full-page.'],
                    ['name' => 'logoutHref', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Exibe link de saida quando informado.'],
                    ['name' => '$footer', 'type' => 'Named slot', 'default' => '-', 'notes' => 'Substitui o rodape padrao.'],
                ],
                'attributes' => ['class', 'id', 'wire:key', 'x-on:*', 'aria-*', 'data-*'],
                'accessibility' => [
                    'O componente usa `aria-label` em aside/nav e `aria-current="page"` no item ativo.',
                    'Quando usar `logo`, informe `logo-alt`. Quando usar o slot `logo`, inclua `alt` em imagens ou `aria-hidden="true"` em marcas puramente decorativas.',
                    'Mantenha labels textuais mesmo quando iniciar com `initial-state="closed"`; o estado recolhido esconde apenas visualmente no desktop.',
                    'Em layouts com sidebar fixa, escute `sampaui:sidebar-state` e aplique a largura emitida no container de conteudo.',
                    'Evite usar `#` em links reais; envie URLs validas do app consumidor.',
                ],
                'examples' => [
                    [
                        'title' => 'Basico',
                        'description' => 'Marca, usuario e links principais.',
                        'code' => <<<'BLADE'
<x-sampaui::sidebar
    brand="LIACOR"
    initial-state="open"
    brand-href="/dashboard"
    logo="/images/logo-liacor.svg"
    logo-alt="LIACOR"
    :user="[
        'name' => 'Administrador Lia',
        'email' => 'admin@liacorretora.com',
        'avatar' => '/images/admin.jpg',
    ]"
    :items="[
        ['label' => 'Dashboard', 'href' => '/dashboard', 'icon' => 'grid', 'active' => true],
        ['label' => 'Clientes', 'href' => '/clients', 'icon' => 'people'],
        ['label' => 'Imóveis', 'href' => '/properties', 'icon' => 'buildings'],
        ['label' => 'Mapa', 'href' => '/map', 'icon' => 'map'],
    ]"
/>
BLADE,
                    ],
                    [
                        'title' => 'Com secoes',
                        'description' => 'Agrupe links por contexto operacional.',
                        'code' => <<<'BLADE'
<x-sampaui::sidebar
    brand="Operacao"
    initial-state="closed"
    :items="[
        ['label' => 'Dashboard', 'href' => '/dashboard', 'icon' => 'grid', 'active' => true],
    ]"
    :sections="[
        ['label' => 'Gestao', 'items' => [
            ['label' => 'Clientes', 'href' => '/clients', 'icon' => 'people'],
            ['label' => 'Contratos', 'href' => '/contracts', 'icon' => 'file-earmark-text'],
        ]],
    ]"
/>
BLADE,
                    ],
                    [
                        'title' => 'Logo e avatar',
                        'description' => 'Use props simples para logo da marca e avatar do usuario.',
                        'code' => <<<'BLADE'
<x-sampaui::sidebar
    brand="LIACOR"
    logo="/images/logo-liacor.svg"
    logo-alt="LIACOR"
    avatar="/images/admin.jpg"
    avatar-alt="Administrador Lia"
    :user="['name' => 'Administrador Lia', 'email' => 'admin@liacorretora.com']"
    :items="[
        ['label' => 'Dashboard', 'href' => '/dashboard', 'icon' => 'grid', 'active' => true],
        ['label' => 'Clientes', 'href' => '/clients', 'icon' => 'people'],
    ]"
/>
BLADE,
                    ],
                    [
                        'title' => 'Logo via slot',
                        'description' => 'Use o slot quando precisar de SVG inline, `<picture>` ou markup da marca.',
                        'code' => <<<'BLADE'
<x-sampaui::sidebar
    brand="LIACOR"
    brand-href="/dashboard"
    initial-state="open"
    :items="[
        ['label' => 'Dashboard', 'href' => '/dashboard', 'icon' => 'grid', 'active' => true],
    ]"
>
    <x-slot:logo>
        <img
            src="/images/logo-liacor.svg"
            alt="LIACOR"
            class="h-11 w-16 shrink-0 object-contain"
        >
    </x-slot:logo>
</x-sampaui::sidebar>
BLADE,
                    ],
                    [
                        'title' => 'Livewire Navigate',
                        'description' => 'Adicione `navigate` no item para renderizar `wire:navigate`.',
                        'code' => <<<'BLADE'
<x-sampaui::sidebar
    initial-state="open"
    :items="[
        ['label' => 'Relatorios', 'href' => '/reports', 'icon' => 'bar-chart', 'navigate' => true],
    ]"
/>
BLADE,
                    ],
                ],
            ],
            'drawer' => [
                'slug' => 'drawer',
                'name' => 'Drawer',
                'tag' => '<x-sampaui::drawer />',
                'summary' => 'Painel lateral ou vertical com Livewire entangle, backdrop, header, actions e transicao suave.',
                'description' => 'Use para filtros, formularios auxiliares, detalhes de registro e fluxos secundarios sem tirar o usuario da tela atual. O componente compartilha o padrao do Modal, mas entra pelas bordas da viewport.',
                'preview_title' => 'Painel de filtros',
                'preview_caption' => 'Drawer controlado por propriedade Livewire, com posicao, tamanho e slots.',
                'props' => [
                    ['name' => 'model', 'type' => 'string', 'default' => '-', 'notes' => 'Nome da propriedade booleana Livewire usada por `@entangle(...).live`.'],
                    ['name' => 'title', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Titulo padrao do header.'],
                    ['name' => 'subtitle', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Texto auxiliar associado por `aria-describedby`.'],
                    ['name' => 'placement', 'type' => 'right|left|top|bottom', 'default' => 'right', 'notes' => 'Define de qual borda o painel entra.'],
                    ['name' => 'size', 'type' => 'sm|md|lg|xl|2xl|full', 'default' => 'md', 'notes' => 'Controla largura em drawers laterais e altura em drawers superior/inferior.'],
                    ['name' => 'variant', 'type' => 'default|primary|secondary|accent|danger|success|warning|info|purple|muted', 'default' => 'default', 'notes' => 'Define a cor de borda do painel.'],
                    ['name' => 'persistent', 'type' => 'bool', 'default' => 'false', 'notes' => 'Impede fechamento por ESC ou clique no backdrop.'],
                    ['name' => 'closeButton', 'type' => 'bool', 'default' => 'true', 'notes' => 'Exibe ou remove o botao de fechar no header.'],
                    ['name' => 'closeEvent', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Evento browser que fecha o drawer, como `filters-applied`.'],
                    ['name' => 'afterClose', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Metodo Livewire chamado apos a animacao de fechamento.'],
                    ['name' => 'panelClass', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Classes extras aplicadas ao painel interno, uteis para trocar ou remover a borda.'],
                    ['name' => '$header/$actions', 'type' => 'Named slots', 'default' => '-', 'notes' => 'Permitem substituir o header e adicionar acoes no rodape.'],
                ],
                'attributes' => ['class', 'id', 'wire:key', 'x-on:*', 'data-*', 'aria-*'],
                'accessibility' => [
                    'O componente renderiza `role="dialog"` e `aria-modal="true"` automaticamente.',
                    'Informe `title` ou um slot `header` com heading claro para orientar leitores de tela.',
                    'Use drawer para tarefas secundarias; fluxos destrutivos ou bloqueantes continuam mais claros como modal.',
                ],
                'examples' => [
                    [
                        'title' => 'Basico',
                        'description' => 'Drawer lateral controlado por propriedade booleana Livewire.',
                        'code' => <<<'BLADE'
<x-sampaui::button wire:click="$set('filtersOpen', true)">
    Abrir filtros
</x-sampaui::button>

<x-sampaui::drawer model="filtersOpen" title="Filtros" subtitle="Refine a listagem">
    Conteudo dos filtros.

    <x-slot:actions>
        <x-sampaui::button variant="outline" wire:click="$set('filtersOpen', false)">
            Cancelar
        </x-sampaui::button>
        <x-sampaui::button wire:click="applyFilters">
            Aplicar
        </x-sampaui::button>
    </x-slot:actions>
</x-sampaui::drawer>
BLADE,
                    ],
                    [
                        'title' => 'Posicao',
                        'description' => 'Use `placement` para escolher a borda de entrada.',
                        'code' => <<<'BLADE'
<x-sampaui::drawer model="rightDrawer" title="Direita" placement="right" />
<x-sampaui::drawer model="leftDrawer" title="Esquerda" placement="left" />
<x-sampaui::drawer model="topDrawer" title="Topo" placement="top" />
<x-sampaui::drawer model="bottomDrawer" title="Rodape" placement="bottom" />
BLADE,
                    ],
                    [
                        'title' => 'Evento Livewire',
                        'description' => 'Fechamento por evento e callback depois da animacao.',
                        'code' => <<<'BLADE'
<x-sampaui::drawer
    model="filtersOpen"
    title="Filtros avancados"
    close-event="filters-applied"
    after-close="afterDrawerClose"
>
    Filtros atualizados no Livewire.
</x-sampaui::drawer>
BLADE,
                    ],
                ],
            ],
            'toast' => [
                'slug' => 'toast',
                'name' => 'Toast',
                'tag' => '<x-sampaui::toast />',
                'summary' => 'Central de notificacoes Alpine acionada por evento `toast`, com fila, auto-dismiss e progresso visual.',
                'description' => 'Use uma vez no layout da aplicacao para exibir feedback temporario vindo de JavaScript, Alpine ou eventos disparados apos acoes Livewire.',
                'preview_title' => 'Notificacoes temporarias',
                'preview_caption' => 'Container fixo e exemplos de disparo via evento do browser.',
                'props' => [
                    ['name' => 'position', 'type' => 'top-right|top-left|bottom-right|bottom-left', 'default' => 'top-right', 'notes' => 'Define onde a fila aparece na viewport.'],
                    ['name' => 'max', 'type' => 'int', 'default' => '5', 'notes' => 'Quantidade maxima de toasts simultaneos.'],
                    ['name' => 'detail.class', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Classe extra enviada no evento para customizar um toast especifico, inclusive borda.'],
                ],
                'attributes' => ['class', 'id', 'wire:ignore', 'aria-*', 'data-*'],
                'accessibility' => [
                    'Mensagens usam `role="status"` e `aria-live="polite"` para evitar interrupcoes agressivas.',
                    'Nao dependa somente do toast para erros criticos; mantenha tambem feedback persistente no formulario.',
                    'Use duracao `0` apenas quando o usuario tiver um controle claro para fechar.',
                ],
                'examples' => [
                    [
                        'title' => 'Instalacao no layout',
                        'description' => 'Inclua uma vez perto do final do body.',
                        'code' => <<<'BLADE'
<x-sampaui::toast />
BLADE,
                    ],
                    [
                        'title' => 'Disparo basico',
                        'description' => 'Evento browser com titulo e mensagem.',
                        'code' => <<<'BLADE'
<button
    type="button"
    onclick="window.dispatchEvent(new CustomEvent('toast', {
        detail: { type: 'success', title: 'Salvo', message: 'Alteracoes publicadas.' }
    }))"
>
    Mostrar toast
</button>
BLADE,
                    ],
                    [
                        'title' => 'Persistente',
                        'description' => 'Use `duration: 0` para manter ate fechamento manual.',
                        'code' => <<<'BLADE'
window.dispatchEvent(new CustomEvent('toast', {
    detail: {
        type: 'warning',
        title: 'Revisao pendente',
        message: 'Confira os dados antes de aprovar.',
        duration: 0
    }
}))
BLADE,
                    ],
                ],
            ],
            'table' => [
                'slug' => 'table',
                'name' => 'Table',
                'tag' => '<x-sampaui::table />',
                'summary' => 'Tabela responsiva para dados operacionais com colunas via array, linhas via array, slots e estado vazio.',
                'description' => 'Use para listagens simples, tabelas administrativas e blocos de resumo. O componente aceita renderizacao automatica por arrays ou slots `head` e `body` para markup customizado.',
                'preview_title' => 'Listagem operacional',
                'preview_caption' => 'Colunas, linhas, alinhamento e estado vazio.',
                'props' => [
                    ['name' => 'columns', 'type' => 'array', 'default' => '[]', 'notes' => 'Mapa `chave => label` ou arrays com `label`, `key` e `align`.'],
                    ['name' => 'rows', 'type' => 'array', 'default' => '[]', 'notes' => 'Linhas em array ou objeto lidas por `data_get`.'],
                    ['name' => 'empty', 'type' => 'string', 'default' => 'Nenhum registro encontrado.', 'notes' => 'Mensagem exibida quando nao ha linhas.'],
                    ['name' => 'striped', 'type' => 'bool', 'default' => 'false', 'notes' => 'Alterna fundo discreto em linhas pares.'],
                    ['name' => 'hover', 'type' => 'bool', 'default' => 'true', 'notes' => 'Ativa destaque ao passar o mouse nas linhas.'],
                    ['name' => 'bordered', 'type' => 'bool', 'default' => 'true', 'notes' => 'Controla borda externa da tabela.'],
                    ['name' => 'compact', 'type' => 'bool', 'default' => 'false', 'notes' => 'Reduz padding das celulas.'],
                    ['name' => 'sortBy', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Chave da coluna ordenada quando a coluna tem `sortable => true`.'],
                    ['name' => 'sortDirection', 'type' => 'asc|desc', 'default' => 'asc', 'notes' => 'Direcao ativa da ordenacao.'],
                    ['name' => 'sortMethod', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Metodo Livewire chamado nos botoes de ordenacao.'],
                    ['name' => '$head/$body', 'type' => 'Named slots', 'default' => '-', 'notes' => 'Substituem renderizacao automatica quando precisar de markup completo.'],
                ],
                'attributes' => ['class', 'id', 'wire:key', 'x-data', 'aria-*', 'data-*'],
                'accessibility' => [
                    'Use cabecalhos claros e curtos para cada coluna.',
                    'Quando a tabela representar dados importantes, mantenha `<th scope="col">` nos headers.',
                    'Em acoes dentro das linhas, use labels claros em botoes apenas com icone.',
                ],
                'examples' => [
                    [
                        'title' => 'Basico',
                        'description' => 'Tabela a partir de arrays simples.',
                        'code' => <<<'BLADE'
<x-sampaui::table
    :columns="[
        'name' => 'Cliente',
        'status' => 'Status',
        'amount' => ['label' => 'Valor', 'key' => 'amount', 'align' => 'right'],
    ]"
    :rows="[
        ['name' => 'Ana Souza', 'status' => 'Ativo', 'amount' => 'R$ 1.200,00'],
        ['name' => 'Bruno Lima', 'status' => 'Em analise', 'amount' => 'R$ 850,00'],
    ]"
/>
BLADE,
                    ],
                    [
                        'title' => 'Ordenacao',
                        'description' => 'Somente colunas marcadas como `sortable` exibem o controle de ordenacao.',
                        'code' => <<<'BLADE'
<x-sampaui::table
    sort-by="name"
    sort-direction="asc"
    sort-method="sortBy"
    :columns="[
        'name' => ['label' => 'Cliente', 'sortable' => true],
        'status' => 'Status',
        'amount' => ['label' => 'Valor', 'key' => 'amount', 'align' => 'right', 'sortable' => true],
    ]"
    :rows="[
        ['name' => 'Ana Souza', 'status' => 'Ativo', 'amount' => 'R$ 1.200,00'],
        ['name' => 'Bruno Lima', 'status' => 'Em analise', 'amount' => 'R$ 850,00'],
    ]"
/>
BLADE,
                    ],
                    [
                        'title' => 'Compacta e striped',
                        'description' => 'Mais densa para dashboards e relatorios.',
                        'code' => <<<'BLADE'
<x-sampaui::table
    compact
    striped
    :columns="['code' => 'Codigo', 'owner' => 'Responsavel']"
    :rows="[
        ['code' => '#1024', 'owner' => 'Comercial'],
        ['code' => '#1025', 'owner' => 'Suporte'],
    ]"
/>
BLADE,
                    ],
                    [
                        'title' => 'Estado vazio',
                        'description' => 'Mensagem customizada sem linhas.',
                        'code' => <<<'BLADE'
<x-sampaui::table
    empty="Nenhum cliente encontrado."
    :columns="['name' => 'Cliente', 'status' => 'Status']"
    :rows="[]"
/>
BLADE,
                    ],
                ],
            ],
            'pagination' => [
                'slug' => 'pagination',
                'name' => 'Pagination',
                'tag' => '<x-sampaui::pagination />',
                'summary' => 'Paginacao para Laravel paginator ou controle manual, com modo simples e suporte a Livewire.',
                'description' => 'Use abaixo de tabelas e listagens. O componente aceita um paginator Laravel completo ou valores manuais para casos em Livewire e APIs customizadas.',
                'preview_title' => 'Navegacao de paginas',
                'preview_caption' => 'Links numericos, resumo de registros e modo Livewire.',
                'props' => [
                    ['name' => 'paginator', 'type' => 'Paginator|null', 'default' => 'null', 'notes' => 'Quando informado, popula pagina atual, ultima pagina, total, perPage e URLs.'],
                    ['name' => 'currentPage', 'type' => 'int', 'default' => '1', 'notes' => 'Pagina atual em modo manual.'],
                    ['name' => 'lastPage', 'type' => 'int', 'default' => '1', 'notes' => 'Ultima pagina em modo manual.'],
                    ['name' => 'total', 'type' => 'int|null', 'default' => 'null', 'notes' => 'Exibe resumo de registros quando informado.'],
                    ['name' => 'perPage', 'type' => 'int|null', 'default' => 'null', 'notes' => 'Complementa o resumo com itens por pagina.'],
                    ['name' => 'previousUrl', 'type' => 'string|null', 'default' => 'null', 'notes' => 'URL da pagina anterior em modo manual.'],
                    ['name' => 'nextUrl', 'type' => 'string|null', 'default' => 'null', 'notes' => 'URL da proxima pagina em modo manual.'],
                    ['name' => 'window', 'type' => 'int', 'default' => '1', 'notes' => 'Quantidade de paginas exibidas ao redor da atual.'],
                    ['name' => 'wireMethod', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Renderiza botoes com `wire:click`, como `gotoPage(2)`.'],
                    ['name' => 'simple', 'type' => 'bool', 'default' => 'false', 'notes' => 'Exibe apenas anterior/proxima.'],
                ],
                'attributes' => ['class', 'id', 'wire:key', 'aria-*', 'data-*'],
                'accessibility' => [
                    'O componente usa `nav` com `aria-label` para orientar leitores de tela.',
                    'A pagina atual recebe `aria-current="page"` no modo numerico.',
                    'Botoes inativos recebem `disabled` no modo Livewire e `aria-disabled` no modo link.',
                ],
                'examples' => [
                    [
                        'title' => 'Manual',
                        'description' => 'Controle explicito para listagens simples.',
                        'code' => <<<'BLADE'
<x-sampaui::pagination
    :current-page="2"
    :last-page="8"
    :total="80"
    :per-page="10"
    previous-url="/clientes?page=1"
    next-url="/clientes?page=3"
/>
BLADE,
                    ],
                    [
                        'title' => 'Livewire',
                        'description' => 'Botoes chamam metodo no componente Livewire.',
                        'code' => <<<'BLADE'
<x-sampaui::pagination
    :current-page="$page"
    :last-page="$lastPage"
    :total="$total"
    :per-page="10"
    wire-method="gotoPage"
/>
BLADE,
                    ],
                    [
                        'title' => 'Simples',
                        'description' => 'Apenas anterior/proxima para fluxos compactos.',
                        'code' => <<<'BLADE'
<x-sampaui::pagination
    simple
    :current-page="1"
    :last-page="5"
    next-url="/clientes?page=2"
/>
BLADE,
                    ],
                ],
            ],
        ];

        return $this->withShowcases($this->withGuidance($components));
    }

    /**
     * @param  array<string, array<string, mixed>>  $components
     * @return array<string, array<string, mixed>>
     */
    private function withGuidance(array $components): array
    {
        $guidance = [
            'button' => [
                'Use `variant` para semantica visual e deixe `class` para ajustes pontuais de largura, margem ou alinhamento.',
                'Prefira `type="button"` fora de formularios e `type="submit"` somente quando a acao realmente envia dados.',
                'Use `href` com `wire:navigate` para navegacao e combine `loading` com `wire:loading.attr="disabled"` em acoes.',
            ],
            'input' => [
                'Use para texto curto, filtros e dados de formulario que cabem em uma linha.',
                'Informe `name` para integrar ErrorBag, request payload e fallback automatico de `id`.',
                'Passe `wire:model.live` ou `x-model` direto no componente; o atributo chega ao input nativo.',
            ],
            'pin' => [
                'Use para codigos curtos de verificacao, 2FA, recuperacao e convites.',
                'Combine `numbers` com `length` em OTPs numericos para melhorar teclado mobile e validacao visual.',
                'Com Livewire, use propriedade string e `wire:model`; `smart` pode submeter o formulario ao preencher tudo.',
            ],
            'select' => [
                'Use quando a lista e curta e o usuario nao precisa pesquisar antes de escolher.',
                'Mantenha as opcoes no slot para preservar flexibilidade com `option` e `optgroup`.',
                'Para listas maiores, prefira `select-search` e mantenha `select` para filtros simples.',
            ],
            'select-search' => [
                'Use para listas medias que podem ser carregadas no HTML sem consulta remota.',
                'Com Livewire, use somente `wire:model`; `x-modelable` sincroniza o estado sem prop `value`.',
                'Evite usar para milhares de registros; nesse caso, crie uma busca remota no componente Livewire.',
            ],
            'select-multiple' => [
                'Use para listas locais em que o usuario precisa selecionar varios itens e revisar a selecao antes de salvar.',
                'Com Livewire, modele a propriedade como array e use somente `wire:model`; `x-modelable` sincroniza as tags selecionadas.',
                'Para listas muito grandes, prefira busca remota para evitar renderizar todas as opcoes no HTML.',
            ],
            'textarea' => [
                'Use para observacoes, descricoes, briefings e textos longos sem editor rico.',
                'Controle altura com `rows` e mantenha validacao por `name` ou `error` manual.',
                'O slot serve como conteudo inicial quando voce nao quiser usar a prop `value`.',
            ],
            'checkbox' => [
                'Use para decisoes booleanas independentes, como ativo, aceite ou permissao.',
                'A prop `color` troca o token visual sem criar classes customizadas no app consumidor.',
                'Para grupos exclusivos, use `radio`; checkbox deve permitir multiplas marcacoes quando agrupado.',
            ],
            'radio' => [
                'Use para escolha unica em listas curtas, com opcoes claras e comparaveis.',
                'Passe `options` para renderizacao rapida ou use slot quando precisar de markup customizado.',
                'Use `inline` apenas quando houver espaco horizontal suficiente e poucas opcoes.',
            ],
            'date-picker' => [
                'Use para data pura em formato `YYYY-MM-DD`, sem hora e sem timezone.',
                'Configure `min` e `max` para limitar escolhas e reduzir validacoes frustrantes.',
                'Com Livewire, use somente `wire:model`; `x-modelable` sincroniza o estado sem prop `value`.',
            ],
            'alert' => [
                'Use para feedback persistente dentro da pagina, nao para notificacoes temporarias.',
                'Escolha `variant` pela gravidade da mensagem: info, success, warning ou error.',
                'Use `role="alert"` em mensagens que precisam ser anunciadas imediatamente.',
            ],
            'card' => [
                'Use para agrupar conteudo relacionado, formularios curtos ou resumos operacionais.',
                'Use slots `header`, `actions` e `footer` para compor estrutura sem recriar bordas.',
                'Evite aninhar muitos cards; prefira secoes quando o conteudo for uma pagina inteira.',
            ],
            'modal' => [
                'Use para interrupcoes curtas: confirmar, editar pequeno formulario ou exibir detalhe.',
                'Controle abertura por propriedade booleana Livewire via `model`.',
                'Use `persistent` apenas quando fechar por backdrop puder causar perda de dados.',
            ],
            'header' => [
                'Use no topo de paginas internas para titulo, subtitulo, status e acoes principais.',
                'Mantenha uma acao primaria clara no slot `actions` quando a tela tiver fluxo de criacao.',
                'Use `menuEvent` para integrar com sidebar ou drawer em layouts responsivos.',
            ],
            'sidebar' => [
                'Use para navegacao principal persistente em dashboards e sistemas internos.',
                'Use o slot `logo` quando a aplicacao tiver marca propria em SVG ou imagem.',
                'Passe `sections` quando houver muitos links; use `items` para menus simples.',
                'Use `initial-state` para iniciar aberto ou fechado sem depender de JavaScript externo.',
            ],
            'drawer' => [
                'Use para filtros, formularios laterais e detalhes que preservam o contexto da lista.',
                'Escolha `placement` conforme a tarefa: direita para detalhe, esquerda para navegacao, baixo para mobile.',
                'Assim como modal, o estado principal deve vir de uma propriedade Livewire booleana.',
            ],
            'toast' => [
                'Use uma vez no layout e dispare eventos `toast` a partir de Alpine, JavaScript ou Livewire.',
                'Mensagens devem ser curtas e acionaveis; detalhes longos pertencem a Alert ou Modal.',
                'Use `duration: 0` apenas para notificacoes que o usuario precisa fechar manualmente.',
            ],
            'table' => [
                'Use para dados tabulares reais, com colunas previsiveis e alinhamento por tipo de dado.',
                'Use arrays para listagens simples e slots para celulas com botoes, badges ou links.',
                'Combine com Pagination quando a lista puder crescer ou vier de consulta paginada.',
            ],
            'pagination' => [
                'Use abaixo de tabelas, grids ou resultados de busca com multiplas paginas.',
                'Passe um paginator Laravel quando houver, ou valores manuais em componentes Livewire.',
                'Use `simple` quando o usuario so precisa avancar ou voltar sem escolher pagina exata.',
            ],
        ];

        foreach ($components as $slug => $component) {
            $components[$slug]['guidance'] = $guidance[$slug] ?? [
                'Use props para comportamento esperado e `class` para customizacao visual local.',
                'Preserve labels e atributos de acessibilidade no contexto final da tela.',
                'Teste o componente com estado normal, erro, disabled e Livewire quando aplicavel.',
            ];
        }

        return $components;
    }

    /**
     * @param  array<string, array<string, mixed>>  $components
     * @return array<string, array<string, mixed>>
     */
    private function withShowcases(array $components): array
    {
        $components['button']['showcases'] = [
            [
                'title' => 'Variantes',
                'description' => 'Todas as variantes visuais disponiveis para acoes.',
                'code' => <<<'BLADE'
<x-sampaui::button>Primary</x-sampaui::button>
<x-sampaui::button variant="secondary">Secondary</x-sampaui::button>
<x-sampaui::button variant="accent">Accent</x-sampaui::button>
<x-sampaui::button variant="danger">Danger</x-sampaui::button>
<x-sampaui::button variant="light">Light</x-sampaui::button>
<x-sampaui::button variant="ghost">Ghost</x-sampaui::button>
<x-sampaui::button variant="outline">Outline</x-sampaui::button>
BLADE,
            ],
            [
                'title' => 'Tamanhos',
                'description' => 'Escala de densidade para formularios e barras de acao.',
                'code' => <<<'BLADE'
<x-sampaui::button size="sm">Small</x-sampaui::button>
<x-sampaui::button size="md">Medium</x-sampaui::button>
<x-sampaui::button size="lg">Large</x-sampaui::button>
<x-sampaui::button size="xl">Extra large</x-sampaui::button>
<x-sampaui::button size="2xl">Display</x-sampaui::button>
BLADE,
            ],
            [
                'title' => 'Icones e estados',
                'description' => 'Icone, icon-only, loading, pill e largura total.',
                'code' => <<<'BLADE'
<x-sampaui::button icon="plus-circle">Novo atendimento</x-sampaui::button>
<x-sampaui::button variant="outline" icon="box-arrow-up-right" icon-position="right">Abrir portal</x-sampaui::button>
<x-sampaui::button icon="heart-fill" aria-label="Favoritar" />
<x-sampaui::button loading>Sincronizando</x-sampaui::button>
<x-sampaui::button rounded>Botao arredondado</x-sampaui::button>
<x-sampaui::button full>Ocupar linha</x-sampaui::button>
BLADE,
            ],
            [
                'title' => 'Com borda e sem borda',
                'description' => 'O padrao do botao usa borda somente nas variantes outline ou customizadas; use `outline` ou `class` quando a acao pedir contorno.',
                'code' => <<<'BLADE'
<x-sampaui::button>Sem borda</x-sampaui::button>
<x-sampaui::button variant="outline">Com borda outline</x-sampaui::button>
<x-sampaui::button class="border border-primary/25">Com borda customizada</x-sampaui::button>
BLADE,
            ],
        ];

        $components['input']['showcases'] = [
            [
                'title' => 'Com icones',
                'description' => 'Use `icon` para icones Bootstrap simples ou slots internos quando precisar controlar o markup.',
                'code' => <<<'BLADE'
<x-sampaui::input
    name="email"
    type="email"
    label="Email"
    icon="envelope"
    placeholder="voce@empresa.com"
/>

<x-sampaui::input
    name="password"
    type="password"
    label="Senha"
    icon="lock"
/>
BLADE,
            ],
            [
                'title' => 'Tipos comuns',
                'description' => 'Texto, email, telefone e busca preservam os atributos nativos.',
                'code' => <<<'BLADE'
<x-sampaui::input name="name" label="Nome" placeholder="Nome completo" />
<x-sampaui::input name="email" type="email" label="Email" placeholder="voce@empresa.com" />
<x-sampaui::input name="phone" type="tel" label="Telefone" value="(11) 99999-0000" />
<x-sampaui::input name="search" type="search" label="Busca" placeholder="Nome, email ou telefone" />
BLADE,
            ],
            [
                'title' => 'Estados',
                'description' => 'Erro manual, desabilitado, valor inicial e binding Livewire.',
                'code' => <<<'BLADE'
<x-sampaui::input name="document" label="Documento" error="Documento invalido." />
<x-sampaui::input name="company" label="Empresa" value="SampaUI" />
<x-sampaui::input name="disabled_email" label="Email bloqueado" value="admin@sampaui.dev" disabled />
<x-sampaui::input name="filter" label="Filtro Livewire" wire:model.live.debounce.300ms="filter" />
BLADE,
            ],
            [
                'title' => 'Com borda e sem borda',
                'description' => 'Campos usam borda por padrao; remova com `class="border-0"` apenas em usos pontuais.',
                'code' => <<<'BLADE'
<x-sampaui::input name="company" label="Empresa" placeholder="SampaUI" />

<x-sampaui::input
    name="company_clean"
    label="Empresa sem borda"
    placeholder="SampaUI"
    class="border-0"
/>
BLADE,
            ],
        ];

        $components['pin']['showcases'] = [
            [
                'title' => 'Codigo de verificacao',
                'description' => 'PIN numerico com ajuda textual e botao de limpar.',
                'code' => <<<'BLADE'
<x-sampaui::pin
    name="otp"
    label="Codigo de acesso"
    hint="Digite o codigo de 6 digitos enviado para seu email."
    length="6"
    numbers
    clear
/>
BLADE,
            ],
            [
                'title' => 'Prefixo e letras',
                'description' => 'Codigos de convite podem usar prefixo visual e aceitar somente letras.',
                'code' => <<<'BLADE'
<x-sampaui::pin
    name="invite"
    label="Codigo do convite"
    prefix="G-"
    length="4"
    letters
    value="ABCD"
    clear
/>
BLADE,
            ],
            [
                'title' => 'Estados e Livewire',
                'description' => 'Erro, disabled, eventos Alpine e envio smart com Livewire.',
                'code' => <<<'BLADE'
<x-sampaui::pin
    name="recovery"
    label="Recuperacao"
    length="5"
    error="Codigo invalido."
/>

<x-sampaui::pin
    name="blocked_code"
    label="Codigo bloqueado"
    length="5"
    value="12345"
    disabled
/>

<form wire:submit="verify">
    <x-sampaui::pin
        name="pin"
        label="Digite seu codigo"
        length="6"
        numbers
        smart
        wire:model.live="pin"
        x-on:filled="console.log($event.detail.model)"
    />
</form>
BLADE,
            ],
        ];

        $components['select']['showcases'] = [
            [
                'title' => 'Selecoes',
                'description' => 'Placeholder, valor comum, disabled e estado de erro.',
                'code' => <<<'BLADE'
<x-sampaui::select name="status" label="Status" placeholder="Selecione">
    <option value="lead">Lead</option>
    <option value="won">Fechado</option>
</x-sampaui::select>

<x-sampaui::select
    name="owner"
    label="Responsavel"
    value="ana"
    :options="[
        'ana' => 'Ana',
        'bruno' => 'Bruno',
    ]"
/>

<x-sampaui::select
    name="team"
    label="Equipe"
    disabled
    :options="['commercial' => 'Comercial']"
/>

<x-sampaui::select
    name="city"
    label="Cidade"
    error="Escolha uma cidade."
    :options="['sp' => 'Sao Paulo']"
/>
BLADE,
            ],
            [
                'title' => 'Livewire',
                'description' => 'Atributos dinamicos sincronizam o estado pelo `x-modelable`.',
                'code' => <<<'BLADE'
<x-sampaui::select
    name="pipeline"
    label="Pipeline"
    wire:model.live="pipeline"
    :options="[
        'new' => 'Novo',
        'qualified' => 'Qualificado',
        'proposal' => 'Proposta',
        'won' => 'Fechado',
    ]"
/>
BLADE,
            ],
            [
                'title' => 'Com borda e sem borda',
                'description' => 'O select segue o input: superficie limpa por padrao e borda sob demanda via `class`.',
                'code' => <<<'BLADE'
<x-sampaui::select name="status_clean" label="Status">
    <option value="active">Ativo</option>
    <option value="paused">Pausado</option>
</x-sampaui::select>

<x-sampaui::select
    name="status_borderless"
    label="Status sem borda"
    class="border-0"
    :options="[
        'active' => 'Ativo',
        'paused' => 'Pausado',
    ]"
/>
BLADE,
            ],
        ];

        $components['select-search']['showcases'] = [
            [
                'title' => 'Busca local',
                'description' => 'Lista pesquisavel para opcoes operacionais carregadas no HTML.',
                'code' => <<<'BLADE'
<x-sampaui::select-search
    name="owner"
    label="Responsavel"
    placeholder="Selecione um responsavel"
    search-placeholder="Buscar por nome"
    :options="[
        'ana' => 'Ana Souza',
        'bruno' => 'Bruno Lima',
        'carla' => 'Carla Martins',
        'diego' => 'Diego Almeida',
    ]"
/>
BLADE,
            ],
            [
                'title' => 'Valor inicial e array estruturado',
                'description' => 'Use `value` com opcoes no formato `value` e `label`.',
                'code' => <<<'BLADE'
<x-sampaui::select-search
    name="city"
    label="Cidade"
    value="campinas"
    :options="[
        ['value' => 'sp', 'label' => 'Sao Paulo'],
        ['value' => 'campinas', 'label' => 'Campinas'],
        ['value' => 'santos', 'label' => 'Santos'],
    ]"
/>
BLADE,
            ],
            [
                'title' => 'Estados',
                'description' => 'Erro, required, disabled e mensagem vazia customizada.',
                'code' => <<<'BLADE'
<x-sampaui::select-search
    name="pipeline"
    label="Pipeline"
    error="Escolha um pipeline."
    required
    :options="['sales' => 'Vendas', 'support' => 'Suporte']"
/>

<x-sampaui::select-search
    name="team"
    label="Equipe bloqueada"
    value="commercial"
    disabled
    :options="['commercial' => 'Comercial']"
/>

<x-sampaui::select-search
    name="segment"
    label="Segmento"
    empty-text="Nenhum segmento encontrado."
    :options="[]"
/>
BLADE,
            ],
            [
                'title' => 'Livewire e evento',
                'description' => '`wire:model` sincroniza o estado por `x-modelable`; o componente tambem dispara `select-search:changed`.',
                'code' => <<<'BLADE'
<x-sampaui::select-search
    name="customer_id"
    label="Cliente"
    placeholder="Buscar cliente"
    wire:model.live="customerId"
    x-on:select-search:changed.window="$dispatch('customer-selected', $event.detail)"
    :options="[
        1001 => 'ACME Ltda',
        1002 => 'Sampa Consultoria',
        1003 => 'Northwind Brasil',
    ]"
/>
BLADE,
            ],
            [
                'title' => 'Com borda e sem borda',
                'description' => 'O controle usa borda por padrao; remova com `class=\"border-0\"` quando o layout pedir.',
                'code' => <<<'BLADE'
<x-sampaui::select-search
    name="status_with_border"
    label="Com borda"
    :options="['active' => 'Ativo', 'paused' => 'Pausado']"
/>

<x-sampaui::select-search
    name="status_no_border"
    label="Sem borda"
    class="border-0"
    :options="['active' => 'Ativo', 'paused' => 'Pausado']"
/>
BLADE,
            ],
        ];

        $components['select-multiple']['showcases'] = [
            [
                'title' => 'Tags com busca',
                'description' => 'Selecao multipla com valores iniciais, busca local e remocao individual.',
                'code' => <<<'BLADE'
<x-sampaui::select-multiple
    name="roles"
    label="Perfis de acesso"
    placeholder="Selecione os perfis"
    search-placeholder="Buscar perfil"
    :value="['admin', 'support']"
    :options="[
        'admin' => 'Administrador',
        'manager' => 'Gerente',
        'support' => 'Suporte',
        'billing' => 'Financeiro',
    ]"
/>
BLADE,
            ],
            [
                'title' => 'Estados',
                'description' => 'Erro, disabled, loading e opcao individual desabilitada.',
                'code' => <<<'BLADE'
<x-sampaui::select-multiple
    name="channels"
    label="Canais"
    error="Selecione ao menos um canal."
    :options="[
        'email' => 'Email',
        'whatsapp' => 'WhatsApp',
        ['value' => 'sms', 'label' => 'SMS bloqueado', 'disabled' => true],
    ]"
/>

<x-sampaui::select-multiple
    name="teams"
    label="Times"
    disabled
    :value="['sales']"
    :options="['sales' => 'Comercial']"
/>

<x-sampaui::select-multiple
    name="tags"
    label="Tags"
    loading
    :options="[]"
/>
BLADE,
            ],
            [
                'title' => 'Livewire',
                'description' => 'O valor sincronizado e um array e o componente dispara `select-multiple:changed`.',
                'code' => <<<'BLADE'
<x-sampaui::select-multiple
    name="permissions"
    label="Permissoes"
    wire:model.live="permissions"
    x-on:select-multiple:changed.window="$dispatch('permissions-updated', $event.detail)"
    :options="[
        'users.create' => 'Criar usuarios',
        'users.update' => 'Editar usuarios',
        'users.delete' => 'Excluir usuarios',
    ]"
/>
BLADE,
            ],
        ];

        $components['textarea']['showcases'] = [
            [
                'title' => 'Usos principais',
                'description' => 'Rows, placeholder, conteudo inicial e texto longo.',
                'code' => <<<'BLADE'
<x-sampaui::textarea name="summary" label="Resumo" rows="3" placeholder="Registre o contexto" />

<x-sampaui::textarea name="briefing" label="Briefing interno" rows="5">
Cliente quer centralizar atendimento e comercial em um fluxo unico.
</x-sampaui::textarea>
BLADE,
            ],
            [
                'title' => 'Estados',
                'description' => 'Erro, disabled e binding Livewire.',
                'code' => <<<'BLADE'
<x-sampaui::textarea name="notes" label="Observacoes" error="Inclua uma observacao." />
<x-sampaui::textarea name="archived_notes" label="Historico" disabled>Conteudo bloqueado.</x-sampaui::textarea>
<x-sampaui::textarea name="message" label="Mensagem" wire:model.live.debounce.500ms="message" />
BLADE,
            ],
            [
                'title' => 'Com borda e sem borda',
                'description' => 'Use o textarea com borda por padrao e remova apenas quando o layout pedir uma superficie mais limpa.',
                'code' => <<<'BLADE'
<x-sampaui::textarea name="notes_clean" label="Observacoes" rows="3" />

<x-sampaui::textarea
    name="notes_clean"
    label="Observacoes sem borda"
    rows="3"
    class="border-0"
/>
BLADE,
            ],
        ];

        $components['checkbox']['showcases'] = [
            [
                'title' => 'Cores',
                'description' => 'Todas as cores usam tokens oficiais do pacote.',
                'code' => <<<'BLADE'
<x-sampaui::checkbox name="primary" label="Primary" color="primary" checked />
<x-sampaui::checkbox name="secondary" label="Secondary" color="secondary" checked />
<x-sampaui::checkbox name="accent" label="Accent" color="accent" checked />
<x-sampaui::checkbox name="danger" label="Danger" color="danger" checked />
<x-sampaui::checkbox name="light" label="Light" color="light" checked />
BLADE,
            ],
            [
                'title' => 'Conteudo e estados',
                'description' => 'Slot rico, erro, disabled e Livewire.',
                'code' => <<<'BLADE'
<x-sampaui::checkbox name="terms">
    Concordo com os <a href="#" class="font-medium text-primary underline">termos de uso</a>.
</x-sampaui::checkbox>

<x-sampaui::checkbox name="privacy" label="Aceito a politica" error="Aceite obrigatorio." />
<x-sampaui::checkbox name="locked" label="Opcao bloqueada" disabled />
<x-sampaui::checkbox name="only_open" label="Apenas abertos" wire:model.live="onlyOpen" />
BLADE,
            ],
            [
                'title' => 'Com borda e sem borda',
                'description' => 'O controle usa borda por padrao; remova com `class="border-0"` quando o layout exigir.',
                'code' => <<<'BLADE'
<x-sampaui::checkbox name="notify_border" label="Com borda" checked />
<x-sampaui::checkbox name="notify_clean" label="Sem borda" class="border-0" checked />
BLADE,
            ],
        ];

        $components['radio']['showcases'] = [
            [
                'title' => 'Vertical e inline',
                'description' => 'Grupo padrao vertical e alternativa compacta na horizontal.',
                'code' => <<<'BLADE'
<x-sampaui::radio
    name="status"
    label="Status"
    value="active"
    :options="['active' => 'Ativo', 'paused' => 'Pausado', 'archived' => 'Arquivado']"
/>

<x-sampaui::radio
    name="priority"
    label="Prioridade"
    value="medium"
    inline
    :options="['low' => 'Baixa', 'medium' => 'Media', 'high' => 'Alta']"
/>
BLADE,
            ],
            [
                'title' => 'Cores e estados',
                'description' => 'Tokens oficiais, erro, disabled e opcao individual desabilitada.',
                'code' => <<<'BLADE'
<x-sampaui::radio
    name="channel"
    label="Canal"
    color="accent"
    value="email"
    :options="['email' => 'Email', 'phone' => 'Telefone']"
/>

<x-sampaui::radio
    name="approval"
    label="Aprovacao"
    color="danger"
    error="Escolha uma opcao para continuar."
    :options="[
        ['value' => 'yes', 'label' => 'Aprovar'],
        ['value' => 'no', 'label' => 'Reprovar', 'disabled' => true],
    ]"
/>
BLADE,
            ],
            [
                'title' => 'Livewire',
                'description' => 'Atributos Livewire sao aplicados aos inputs reais.',
                'code' => <<<'BLADE'
<x-sampaui::radio
    name="type"
    label="Tipo"
    wire:model.live="type"
    :options="['sales' => 'Comercial', 'support' => 'Suporte']"
/>
BLADE,
            ],
        ];

        $components['date-picker']['showcases'] = [
            [
                'title' => 'Datas',
                'description' => 'Valor inicial, required e limites de selecao.',
                'code' => <<<'BLADE'
<x-sampaui::date-picker
    name="published_at"
    label="Data de publicacao"
    value="2026-05-25"
/>

<x-sampaui::date-picker
    name="due_at"
    label="Vencimento"
    min="2026-05-01"
    max="2026-12-31"
    required
/>
BLADE,
            ],
            [
                'title' => 'Estados',
                'description' => 'Erro, disabled e customizacao por class.',
                'code' => <<<'BLADE'
<x-sampaui::date-picker
    name="scheduled_at"
    label="Agendamento"
    error="Escolha uma data valida."
/>

<x-sampaui::date-picker
    name="locked_at"
    label="Data bloqueada"
    value="2026-05-25"
    disabled
/>
BLADE,
            ],
            [
                'title' => 'Livewire',
                'description' => 'Binding via `x-modelable`, sem necessidade da prop `value`.',
                'code' => <<<'BLADE'
<x-sampaui::date-picker
    name="visit_date"
    label="Data da visita"
    wire:model.live="visitDate"
/>
BLADE,
            ],
        ];

        $components['alert']['showcases'] = [
            [
                'title' => 'Variantes',
                'description' => 'Info, success, warning e error com role adequado.',
                'code' => <<<'BLADE'
<x-sampaui::alert title="Informacao">O conteudo sera revisado.</x-sampaui::alert>
<x-sampaui::alert variant="success" title="Salvo">Alteracoes sincronizadas.</x-sampaui::alert>
<x-sampaui::alert variant="warning" title="Atencao">Revise antes de publicar.</x-sampaui::alert>
<x-sampaui::alert variant="error" title="Erro">Nao foi possivel salvar.</x-sampaui::alert>
BLADE,
            ],
            [
                'title' => 'Icones e controle',
                'description' => 'Icone customizado, sem icone, role e atributos dinamicos.',
                'code' => <<<'BLADE'
<x-sampaui::alert variant="success" icon="check2-square" title="Aprovado">Fluxo liberado.</x-sampaui::alert>
<x-sampaui::alert variant="warning" :icon="false" title="Sem icone">Mensagem compacta.</x-sampaui::alert>
<x-sampaui::alert variant="error" role="alert" wire:show="hasError">Erro vindo do Livewire.</x-sampaui::alert>
BLADE,
            ],
            [
                'title' => 'Com borda e sem borda',
                'description' => 'Alertas usam borda por padrao; remova com `class="border-0"` quando precisar de uma superficie limpa.',
                'code' => <<<'BLADE'
<x-sampaui::alert title="Com borda">
    Mensagem no padrao visual do pacote.
</x-sampaui::alert>

<x-sampaui::alert title="Sem borda" class="border-0">
    Mensagem com contorno removido pelo consumidor.
</x-sampaui::alert>
BLADE,
            ],
        ];

        $components['card']['showcases'] = [
            [
                'title' => 'Variantes',
                'description' => 'Superficies discretas para diferentes contextos.',
                'code' => <<<'BLADE'
<x-sampaui::card title="Default">Conteudo padrao.</x-sampaui::card>
<x-sampaui::card title="Muted" variant="muted">Conteudo destacado com fundo leve.</x-sampaui::card>
<x-sampaui::card title="Primary" variant="primary">Contexto principal.</x-sampaui::card>
<x-sampaui::card title="Secondary" variant="secondary">Contexto secundario.</x-sampaui::card>
<x-sampaui::card title="Accent" variant="accent">Contexto de destaque.</x-sampaui::card>
<x-sampaui::card title="Danger" variant="danger">Contexto sensivel.</x-sampaui::card>
BLADE,
            ],
            [
                'title' => 'Regioes',
                'description' => 'Header, actions, footer, padding e divisor opcional.',
                'code' => <<<'BLADE'
<x-sampaui::card title="Contrato" description="Em analise" padding="lg">
    <x-slot:actions>
        <x-sampaui::button size="sm" variant="outline">Abrir</x-sampaui::button>
    </x-slot:actions>

    Proposta aguardando revisao juridica.

    <x-slot:footer>
        Atualizado ha 3 minutos.
    </x-slot:footer>
</x-sampaui::card>

<x-sampaui::card title="Com divisor" :divided="true">
    Conteudo separado do header quando a tela pedir mais contraste.
</x-sampaui::card>
BLADE,
            ],
            [
                'title' => 'Com borda e sem borda',
                'description' => 'Cards usam borda por padrao; remova com `class="border-0"` apenas quando necessario.',
                'code' => <<<'BLADE'
<x-sampaui::card title="Com borda">
    Superficie padrao do SampaUI.
</x-sampaui::card>

<x-sampaui::card title="Sem borda" class="border-0">
    Contorno removido apenas neste uso.
</x-sampaui::card>
BLADE,
            ],
        ];

        $components['modal']['showcases'] = [
            [
                'title' => 'Estrutura basica',
                'description' => 'Botao abre o modal pela propriedade Livewire e o componente sincroniza por `@entangle`.',
                'preview' => <<<'BLADE'
<div class="rounded-default border border-light bg-white p-5">
    <div class="flex items-start justify-between gap-4 pb-4">
        <div>
            <h3 class="text-lg font-semibold text-primary">Novo lead</h3>
            <p class="mt-1 text-sm text-secondary">Preencha os dados principais</p>
        </div>
        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-secondary">
            <i class="bi bi-x-lg"></i>
        </span>
    </div>
    <div class="py-5 text-secondary">Conteudo do formulario.</div>
    <div class="flex justify-end gap-3 pt-4">
        <x-sampaui::button variant="outline" size="sm">Cancelar</x-sampaui::button>
        <x-sampaui::button size="sm">Salvar</x-sampaui::button>
    </div>
</div>
BLADE,
                'code' => <<<'BLADE'
<x-sampaui::button wire:click="$set('showLeadModal', true)">
    Abrir modal
</x-sampaui::button>

<x-sampaui::modal model="showLeadModal" title="Novo lead" subtitle="Preencha os dados principais">
    Conteudo do formulario.

    <x-slot:actions>
        <x-sampaui::button variant="outline" wire:click="$set('showLeadModal', false)">
            Cancelar
        </x-sampaui::button>
        <x-sampaui::button wire:click="save">
            Salvar
        </x-sampaui::button>
    </x-slot:actions>
</x-sampaui::modal>
BLADE,
            ],
            [
                'title' => 'Tamanhos e variantes',
                'description' => 'Use os botoes para testar visualmente a largura do modal na documentacao.',
                'preview' => <<<'BLADE'
<div
    class="w-full"
    x-data="{
        open: false,
        activeSize: 'lg',
        sizes: {
            sm: 'max-w-sm',
            md: 'max-w-md',
            lg: 'max-w-lg',
            xl: 'max-w-xl',
            '2xl': 'max-w-2xl',
            '4xl': 'max-w-4xl',
            full: 'max-w-[calc(100vw-2rem)]',
        },
        labels: {
            sm: 'Compacto',
            md: 'Confirmacao',
            lg: 'Padrao',
            xl: 'Formulario',
            '2xl': 'Fluxo completo',
            '4xl': 'Conteudo amplo',
            full: 'Tela quase cheia',
        },
        show(size) {
            this.activeSize = size;
            this.open = true;
        },
    }"
>
    <div class="flex flex-wrap gap-3">
        <x-sampaui::button size="sm" variant="outline" x-on:click="show('sm')">Abrir sm</x-sampaui::button>
        <x-sampaui::button size="sm" variant="outline" x-on:click="show('md')">Abrir md</x-sampaui::button>
        <x-sampaui::button size="sm" x-on:click="show('lg')">Abrir lg</x-sampaui::button>
        <x-sampaui::button size="sm" variant="secondary" x-on:click="show('xl')">Abrir xl</x-sampaui::button>
        <x-sampaui::button size="sm" variant="accent" x-on:click="show('2xl')">Abrir 2xl</x-sampaui::button>
        <x-sampaui::button size="sm" variant="outline" x-on:click="show('4xl')">Abrir 4xl</x-sampaui::button>
        <x-sampaui::button size="sm" variant="danger" x-on:click="show('full')">Abrir full</x-sampaui::button>
    </div>

    <div
        x-show="open"
        x-transition.opacity.duration.200ms
        x-cloak
        class="fixed inset-0 z-[13000] flex items-center justify-center p-5"
        role="dialog"
        aria-modal="true"
        x-on:keydown.escape.window="open = false"
    >
        <div
            class="absolute inset-0 bg-primary/40 transition-[backdrop-filter,opacity] duration-300 ease-out"
            x-bind:class="open ? 'backdrop-blur-[2px]' : 'backdrop-blur-none'"
            x-show="open"
            x-transition:enter="transition-opacity duration-300 ease-out"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-200 ease-in"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-on:click="open = false"
        ></div>

        <section
            class="relative flex max-h-[calc(100vh-2rem)] w-full origin-top-right flex-col overflow-hidden rounded-default border border-light bg-white"
            x-bind:class="sizes[activeSize]"
            x-show="open"
            x-transition:enter="transition duration-300 ease-[cubic-bezier(0.16,1,0.3,1)]"
            x-transition:enter-start="translate-x-6 -translate-y-6 scale-75 opacity-0"
            x-transition:enter-end="translate-y-0 scale-100 opacity-100"
            x-transition:leave="transition duration-200 ease-in"
            x-transition:leave-start="translate-y-0 scale-100 opacity-100"
            x-transition:leave-end="translate-x-6 -translate-y-6 scale-75 opacity-0"
        >
            <header class="flex items-start justify-between gap-4 px-5 py-5">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-primary">Preview de tamanho</p>
                    <h3 class="mt-2 text-lg font-semibold text-primary" x-text="`Modal ${activeSize}`"></h3>
                    <p class="mt-1 text-sm text-secondary" x-text="labels[activeSize]"></p>
                </div>
                <button
                    type="button"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-secondary hover:text-primary"
                    aria-label="Fechar preview"
                    x-on:click="open = false"
                >
                    <i class="bi bi-x-lg"></i>
                </button>
            </header>

            <div class="space-y-4 overflow-y-auto px-5 py-5 text-secondary">
                <p>Este preview usa a mesma escala de largura aceita pelo prop <code>size</code>.</p>
                <div class="rounded-default bg-light/30 p-4">
                    <p class="text-sm font-semibold text-primary">Uso no pacote</p>
                    <p class="mt-1 text-sm">Defina <code x-text="`size=&quot;${activeSize}&quot;`"></code> no componente Blade.</p>
                </div>
            </div>

            <footer class="flex justify-end gap-3 px-5 py-4">
                <x-sampaui::button variant="outline" size="sm" x-on:click="open = false">Fechar</x-sampaui::button>
                <x-sampaui::button size="sm">Confirmar</x-sampaui::button>
            </footer>
        </section>
    </div>
</div>
BLADE,
                'code' => <<<'BLADE'
<x-sampaui::modal model="smallModal" title="Compacto" size="sm" />
<x-sampaui::modal model="formModal" title="Formulario" size="2xl" variant="accent" />
<x-sampaui::modal model="dangerModal" title="Confirmar exclusao" size="md" variant="danger" persistent />
<x-sampaui::modal model="fullModal" title="Visualizacao ampla" size="full" />
BLADE,
            ],
            [
                'title' => 'Eventos e controller Livewire',
                'description' => 'Feche por evento de browser e execute um metodo apos a animacao.',
                'preview' => <<<'BLADE'
<x-sampaui::alert title="Fluxo Livewire">
    Depois de salvar, dispare <code>lead-saved</code> e o modal fecha automaticamente.
</x-sampaui::alert>
BLADE,
                'code' => <<<'PHP'
<x-sampaui::modal
    model="showLeadModal"
    title="Editar lead"
    close-event="lead-saved"
    after-close="afterModalClose"
>
    Dados atualizados no Livewire.
</x-sampaui::modal>

<?php

public bool $showLeadModal = false;

public function save(): void
{
    // Salve e valide os dados.

    $this->dispatch('lead-saved');
}

public function afterModalClose(): void
{
    $this->resetValidation();
}
PHP,
            ],
            [
                'title' => 'Com borda e sem borda',
                'description' => 'O painel do modal usa borda por padrao; `panel-class` permite trocar ou remover o contorno.',
                'preview' => <<<'BLADE'
<div class="grid gap-4 md:grid-cols-2">
    <div class="rounded-default border border-light bg-white p-5">
        <p class="font-semibold text-primary">Modal com borda</p>
        <p class="mt-2 text-sm text-secondary">Superficie padrao do pacote.</p>
    </div>

    <div class="rounded-default bg-white p-5">
        <p class="font-semibold text-primary">Modal sem borda</p>
        <p class="mt-2 text-sm text-secondary">Mesmo painel com contorno removido.</p>
    </div>
</div>
BLADE,
                'code' => <<<'BLADE'
<x-sampaui::modal model="defaultModal" title="Com borda">
    Conteudo padrao.
</x-sampaui::modal>

<x-sampaui::modal
    model="cleanModal"
    title="Sem borda"
    panel-class="border-0"
>
    Conteudo com contorno removido.
</x-sampaui::modal>
BLADE,
            ],
        ];

        $components['header']['showcases'] = [
            [
                'title' => 'Titulo e status',
                'description' => 'Contexto da tela com eyebrow, subtitulo e indicador de estado.',
                'code' => <<<'BLADE'
<x-sampaui::header
    title="Clientes"
    subtitle="Gerencie relacionamentos comerciais"
    eyebrow="CRM"
    status="Atualizado agora"
/>
BLADE,
            ],
            [
                'title' => 'Com acoes',
                'description' => 'Slot `actions` para comandos principais.',
                'code' => <<<'BLADE'
<x-sampaui::header title="Pipeline" subtitle="Atendimentos em aberto">
    <x-slot:actions>
        <x-sampaui::button variant="outline" icon="download">Exportar</x-sampaui::button>
        <x-sampaui::button icon="plus">Novo lead</x-sampaui::button>
    </x-slot:actions>
</x-sampaui::header>
BLADE,
            ],
            [
                'title' => 'Menu mobile',
                'description' => 'Botao que dispara o evento usado pela sidebar.',
                'code' => <<<'BLADE'
<x-sampaui::header
    title="Dashboard"
    subtitle="Resumo operacional"
    menu
    menu-event="sampaui:sidebar-open"
/>
BLADE,
            ],
        ];

        $components['sidebar']['showcases'] = [
            [
                'title' => 'Sem secoes',
                'description' => 'Marca, usuario e links diretos em uma lista unica.',
                'preview' => <<<'BLADE'
<div
    class="doc-sidebar-preview relative flex h-[49rem] flex-col border-r border-light bg-white py-8 transition-[width] duration-300"
    x-data="{ collapsed: false }"
    x-bind:style="collapsed ? 'width: 6rem;' : 'width: 18rem;'"
    style="width: 18rem;"
>
    <span class="absolute inset-y-0 -right-7 w-7 bg-light/50"></span>
    <button type="button" class="absolute -right-5 top-8 z-10 inline-flex h-11 w-11 cursor-pointer items-center justify-center rounded-[1.1rem] border border-light bg-white text-secondary transition hover:border-primary hover:bg-white hover:text-primary" x-on:click.prevent.stop="collapsed = ! collapsed">
        <i class="bi bi-chevron-left text-lg" x-show="! collapsed"></i>
        <i class="bi bi-chevron-right text-lg" x-show="collapsed" x-cloak></i>
    </button>
    <div class="flex shrink-0 items-center gap-4 px-8" x-bind:class="collapsed ? 'justify-center px-0' : 'px-8'">
        <x-sampaui::brand-mark />
        <span class="truncate text-2xl font-black leading-none tracking-tight text-primary" x-bind:class="collapsed ? 'hidden' : ''">LIACOR</span>
    </div>
    <div class="mt-14 flex shrink-0 items-center gap-5 px-8" x-bind:class="collapsed ? 'justify-center px-0' : 'px-8'">
        <span class="inline-flex aspect-square h-14 min-h-14 w-14 min-w-14 items-center justify-center overflow-hidden rounded-full bg-light text-lg font-semibold text-primary">
            <img src="https://i.pravatar.cc/128?img=12" alt="Administrador Lia" class="block aspect-square h-14 min-h-14 w-14 min-w-14 rounded-full object-cover grayscale">
        </span>
        <div class="min-w-0" x-bind:class="collapsed ? 'hidden' : ''">
            <p class="truncate text-base font-semibold leading-tight text-primary">Administrador Lia</p>
            <p class="truncate text-sm leading-tight text-secondary/65">admin@liacorretora...</p>
        </div>
    </div>
    <nav class="sampaui-sidebar-scroll mt-10 min-h-0 flex-1 overflow-y-auto overscroll-contain px-8" x-bind:class="collapsed ? 'px-0' : 'px-8'">
        <div class="flex flex-col gap-2">
        <span class="group flex cursor-pointer items-center gap-5 rounded-[1.35rem] px-3 py-2 text-base font-medium text-secondary transition hover:text-primary" x-bind:class="collapsed ? 'justify-center px-0' : 'px-3'">
            <span class="inline-flex aspect-square h-12 min-h-12 w-12 min-w-12 items-center justify-center rounded-full text-secondary/70 transition group-hover:bg-light/50 group-hover:text-primary"><i class="bi bi-grid text-[1.35rem]"></i></span>
            <span x-bind:class="collapsed ? 'hidden' : ''">Dashboard</span>
        </span>
        <span class="group flex cursor-pointer items-center gap-5 rounded-[1.35rem] px-3 py-2 text-base font-medium text-secondary transition hover:text-primary" x-bind:class="collapsed ? 'justify-center px-0' : 'px-3'">
            <span class="inline-flex aspect-square h-12 min-h-12 w-12 min-w-12 items-center justify-center rounded-full text-secondary/70 transition group-hover:bg-light/50 group-hover:text-primary"><i class="bi bi-people text-[1.35rem]"></i></span>
            <span x-bind:class="collapsed ? 'hidden' : ''">Clientes</span>
        </span>
        <span class="group flex cursor-pointer items-center gap-5 rounded-[1.35rem] px-3 py-2 text-base font-medium text-secondary transition hover:text-primary" x-bind:class="collapsed ? 'justify-center px-0' : 'px-3'">
            <span class="inline-flex aspect-square h-12 min-h-12 w-12 min-w-12 items-center justify-center rounded-full text-secondary/70 transition group-hover:bg-light/50 group-hover:text-primary"><i class="bi bi-buildings text-[1.35rem]"></i></span>
            <span x-bind:class="collapsed ? 'hidden' : ''">Imóveis</span>
        </span>
        <span class="group flex cursor-pointer items-center gap-5 rounded-[1.35rem] px-3 py-2 text-base font-medium text-secondary transition hover:text-primary" x-bind:class="collapsed ? 'justify-center px-0' : 'px-3'">
            <span class="inline-flex aspect-square h-12 min-h-12 w-12 min-w-12 items-center justify-center rounded-full text-secondary/70 transition group-hover:bg-light/50 group-hover:text-primary"><i class="bi bi-map text-[1.35rem]"></i></span>
            <span x-bind:class="collapsed ? 'hidden' : ''">Mapa</span>
        </span>
        <p class="px-3 pt-3 text-sm font-medium text-secondary/35" x-bind:class="collapsed ? 'hidden' : ''">Gestão</p>
        <span class="group flex cursor-pointer items-center gap-5 rounded-[1.35rem] px-3 py-2 text-base font-medium text-secondary transition hover:text-primary" x-bind:class="collapsed ? 'justify-center px-0' : 'px-3'">
            <span class="inline-flex aspect-square h-12 min-h-12 w-12 min-w-12 items-center justify-center rounded-full text-secondary/70 transition group-hover:bg-light/50 group-hover:text-primary"><i class="bi bi-file-earmark-text text-[1.35rem]"></i></span>
            <span x-bind:class="collapsed ? 'hidden' : ''">Contratos</span>
        </span>
        <p class="px-3 pt-3 text-sm font-medium text-secondary/35" x-bind:class="collapsed ? 'hidden' : ''">Marketing</p>
        <span class="group flex cursor-pointer items-center gap-5 rounded-[1.35rem] px-3 py-2 text-base font-medium text-secondary transition hover:text-primary" x-bind:class="collapsed ? 'justify-center px-0' : 'px-3'">
            <span class="inline-flex aspect-square h-12 min-h-12 w-12 min-w-12 items-center justify-center rounded-full text-secondary/70 transition group-hover:bg-light/50 group-hover:text-primary"><i class="bi bi-camera-video text-[1.35rem]"></i></span>
            <span x-bind:class="collapsed ? 'hidden' : ''">Roteiro de Vídeo</span>
        </span>
        <span class="flex cursor-pointer items-center gap-5 rounded-[1.35rem] px-3 py-2 text-base font-semibold text-primary" x-bind:class="collapsed ? 'justify-center px-0' : 'px-3'">
            <span class="inline-flex aspect-square h-12 min-h-12 w-12 min-w-12 items-center justify-center rounded-full bg-primary text-white">
                <i class="bi bi-kanban text-[1.35rem]"></i>
            </span>
            <span x-bind:class="collapsed ? 'hidden' : ''">Tarefa</span>
        </span>
        </div>
    </nav>
    <div class="mt-6 flex shrink-0 cursor-pointer items-center gap-5 px-11 text-base font-medium text-danger" x-bind:class="collapsed ? 'justify-center px-0' : 'px-11'">
        <span class="inline-flex h-12 w-12 items-center justify-center"><i class="bi bi-box-arrow-right text-[1.35rem]"></i></span>
        <span x-bind:class="collapsed ? 'hidden' : ''">Sair do sistema</span>
    </div>
</div>
BLADE,
                'code' => <<<'BLADE'
<x-sampaui::sidebar
    brand="LIACOR"
    initial-state="open"
    brand-href="/dashboard"
    :user="['name' => 'Administrador Lia', 'email' => 'admin@liacorretora.com']"
    :items="[
        ['label' => 'Dashboard', 'href' => '/dashboard', 'icon' => 'grid'],
        ['label' => 'Clientes', 'href' => '/clients', 'icon' => 'people'],
        ['label' => 'Imóveis', 'href' => '/properties', 'icon' => 'buildings'],
        ['label' => 'Mapa', 'href' => '/map', 'icon' => 'map'],
        ['label' => 'Tarefa', 'href' => '/tasks', 'icon' => 'kanban', 'active' => true],
    ]"
    logout-href="/logout"
/>
BLADE,
            ],
            [
                'title' => 'Recolhida',
                'description' => 'Estado compacto preserva marca, avatar, icones e acao de saida.',
                'preview' => <<<'BLADE'
<div class="doc-sidebar-preview relative flex h-[49rem] w-[6.25rem] flex-col border-r border-light bg-white px-0 py-8">
    <span class="absolute inset-y-0 -right-8 w-8 bg-light/50"></span>
    <span class="absolute -right-5 top-8 z-10 inline-flex h-12 cursor-pointer w-12 items-center justify-center rounded-[1.15rem] border border-light bg-white text-secondary">
        <i class="bi bi-chevron-right text-lg"></i>
    </span>
    <div class="flex shrink-0 justify-center">
        <x-sampaui::brand-mark />
    </div>
    <div class="mt-16 flex shrink-0 justify-center">
        <span class="inline-flex h-12 w-12 items-center justify-center overflow-hidden rounded-full bg-light text-lg font-semibold text-primary">
            <img src="https://i.pravatar.cc/128?img=12" alt="Administrador Lia" class="block aspect-square h-12 min-h-12 w-12 min-w-12 rounded-full object-cover grayscale">
        </span>
    </div>
    <nav class="sampaui-sidebar-scroll mt-16 min-h-0 flex-1 overflow-y-auto overscroll-contain">
        <div class="space-y-10">
        <span class="flex cursor-pointer justify-center text-secondary/70"><i class="bi bi-grid text-[1.45rem]"></i></span>
        <span class="flex cursor-pointer justify-center text-secondary/70"><i class="bi bi-people text-[1.45rem]"></i></span>
        <span class="flex cursor-pointer justify-center text-secondary/70"><i class="bi bi-buildings text-[1.45rem]"></i></span>
        <span class="flex cursor-pointer justify-center text-secondary/70"><i class="bi bi-map text-[1.45rem]"></i></span>
        <span class="flex cursor-pointer justify-center text-secondary/70"><i class="bi bi-file-earmark-text text-[1.45rem]"></i></span>
        <span class="flex cursor-pointer justify-center text-secondary/70"><i class="bi bi-camera-video text-[1.45rem]"></i></span>
        <span class="flex cursor-pointer justify-center">
            <span class="inline-flex aspect-square h-12 min-h-12 w-12 min-w-12 items-center justify-center rounded-full bg-primary text-white">
                <i class="bi bi-kanban text-[1.45rem]"></i>
            </span>
        </span>
        <span class="flex cursor-pointer justify-center text-danger"><i class="bi bi-box-arrow-right text-[1.45rem]"></i></span>
        </div>
    </nav>
</div>
BLADE,
                'code' => <<<'BLADE'
<x-sampaui::sidebar
    brand="LIACOR"
    initial-state="closed"
    :user="[
        'name' => 'Administrador Lia',
        'email' => 'admin@liacorretora.com',
        'avatar' => '/images/admin.jpg',
    ]"
    :items="[
        ['label' => 'Dashboard', 'href' => '/dashboard', 'icon' => 'grid'],
        ['label' => 'Clientes', 'href' => '/clients', 'icon' => 'people'],
        ['label' => 'Imóveis', 'href' => '/properties', 'icon' => 'buildings'],
        ['label' => 'Mapa', 'href' => '/map', 'icon' => 'map'],
    ]"
    :sections="[
        ['label' => 'Gestão', 'items' => [
            ['label' => 'Contratos', 'href' => '/contracts', 'icon' => 'file-earmark-text'],
        ]],
        ['label' => 'Marketing', 'items' => [
            ['label' => 'Roteiro de Vídeo', 'href' => '/scripts', 'icon' => 'camera-video'],
            ['label' => 'Tarefa', 'href' => '/tasks', 'icon' => 'kanban', 'active' => true],
        ]],
    ]"
    logout-href="/logout"
/>
BLADE,
            ],
            [
                'title' => 'Com secoes',
                'description' => 'Agrupamento por areas da aplicacao usando `items` principais e `sections`.',
                'preview' => <<<'BLADE'
<div class="doc-sidebar-preview w-[18rem] border-r border-light bg-white px-8 py-8">
    <div class="space-y-8">
        <span class="flex items-center gap-6 text-lg font-medium text-secondary">
            <i class="bi bi-grid text-[1.45rem] text-secondary/70"></i> Dashboard
        </span>
    </div>
    <p class="pb-5 pt-12 text-lg font-medium text-secondary/35">Gestao</p>
    <div class="space-y-8">
        <span class="flex items-center gap-6 text-lg font-medium text-secondary">
            <i class="bi bi-people text-[1.45rem] text-secondary/70"></i> Clientes
        </span>
        <span class="flex items-center gap-6 text-lg font-medium text-secondary">
            <i class="bi bi-file-earmark-text text-[1.45rem] text-secondary/70"></i> Contratos
        </span>
    </div>
</div>
BLADE,
                'code' => <<<'BLADE'
<x-sampaui::sidebar
    brand="Operacao"
    initial-state="open"
    :items="[
        ['label' => 'Dashboard', 'href' => '/dashboard', 'icon' => 'grid', 'active' => true],
    ]"
    :sections="[
        ['label' => 'Gestao', 'items' => [
            ['label' => 'Clientes', 'href' => '/clients', 'icon' => 'people'],
            ['label' => 'Contratos', 'href' => '/contracts', 'icon' => 'file-earmark-text'],
        ]],
    ]"
/>
BLADE,
            ],
            [
                'title' => 'Livewire Navigate',
                'description' => 'Use `navigate` no item para adicionar `wire:navigate`.',
                'preview' => <<<'BLADE'
<x-sampaui::alert title="Navegacao">
    O item renderiza `wire:navigate` quando `navigate => true`.
</x-sampaui::alert>
BLADE,
                'code' => <<<'BLADE'
<x-sampaui::sidebar
    :items="[
        ['label' => 'Relatorios', 'href' => '/reports', 'icon' => 'bar-chart', 'navigate' => true],
    ]"
/>
BLADE,
            ],
            [
                'title' => 'Logo customizado',
                'description' => 'Use o slot `logo` para inserir imagem, SVG inline ou marca do produto.',
                'preview' => <<<'BLADE'
<div class="doc-sidebar-preview w-[18rem] border-r border-light bg-white px-8 py-8">
    <div class="flex items-center gap-4">
        <span class="inline-flex h-11 w-11 items-center justify-center rounded-default bg-primary text-white">
            <i class="bi bi-buildings"></i>
        </span>
        <span class="text-2xl font-black leading-none tracking-tight text-primary">LIACOR</span>
    </div>
    <div class="mt-10 space-y-5">
        <span class="flex items-center gap-5 text-base font-semibold text-primary">
            <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-primary text-white">
                <i class="bi bi-grid"></i>
            </span>
            Dashboard
        </span>
    </div>
</div>
BLADE,
                'code' => <<<'BLADE'
<x-sampaui::sidebar
    brand="LIACOR"
    brand-href="/dashboard"
    :items="[
        ['label' => 'Dashboard', 'href' => '/dashboard', 'icon' => 'grid', 'active' => true],
    ]"
>
    <x-slot:logo>
        <img
            src="/images/logo-liacor.svg"
            alt="LIACOR"
            class="h-11 w-16 shrink-0 object-contain"
        >
    </x-slot:logo>
</x-sampaui::sidebar>
BLADE,
            ],
        ];

        $components['drawer']['showcases'] = [
            [
                'title' => 'Estrutura basica',
                'description' => 'Botao abre o drawer pela propriedade Livewire e o painel entra pela direita por padrao.',
                'preview' => <<<'BLADE'
<div class="rounded-default border border-light bg-white p-5">
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.22em] text-primary">Preview</p>
            <h3 class="mt-2 text-lg font-semibold text-primary">Filtros</h3>
            <p class="mt-1 text-sm text-secondary">Refine a listagem sem sair da pagina.</p>
        </div>
        <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white text-secondary">
            <i class="bi bi-x-lg"></i>
        </span>
    </div>

    <div class="mt-5 grid gap-3">
        <x-sampaui::input name="drawer_search_preview" label="Busca" placeholder="Nome ou email" />
        <x-sampaui::select name="drawer_status_preview" label="Status">
            <option>Todos</option>
            <option>Ativos</option>
        </x-sampaui::select>
    </div>

    <div class="mt-5 flex justify-end gap-3">
        <x-sampaui::button variant="outline" size="sm">Limpar</x-sampaui::button>
        <x-sampaui::button size="sm">Aplicar</x-sampaui::button>
    </div>
</div>
BLADE,
                'code' => <<<'BLADE'
<x-sampaui::button wire:click="$set('filtersOpen', true)">
    Abrir filtros
</x-sampaui::button>

<x-sampaui::drawer model="filtersOpen" title="Filtros" subtitle="Refine a listagem">
    <x-sampaui::input name="search" label="Busca" wire:model.live.debounce.300ms="search" />

    <x-sampaui::select name="status" label="Status" wire:model.live="status">
        <option value="">Todos</option>
        <option value="active">Ativos</option>
        <option value="paused">Pausados</option>
    </x-sampaui::select>

    <x-slot:actions>
        <x-sampaui::button variant="outline" wire:click="resetFilters">Limpar</x-sampaui::button>
        <x-sampaui::button wire:click="applyFilters">Aplicar</x-sampaui::button>
    </x-slot:actions>
</x-sampaui::drawer>
BLADE,
            ],
            [
                'title' => 'Posicoes e tamanhos',
                'description' => 'Teste as quatro bordas da viewport e ajuste largura ou altura com `size`.',
                'preview' => <<<'BLADE'
<div
    class="w-full"
    x-data="{
        open: false,
        active: false,
        closeTimer: null,
        activePlacement: 'right',
        activeSize: 'md',
        labels: {
            right: 'Direita',
            left: 'Esquerda',
            top: 'Topo',
            bottom: 'Rodape',
        },
        show(placement, size = 'md') {
            clearTimeout(this.closeTimer);
            this.activePlacement = placement;
            this.activeSize = size;
            this.open = true;
            this.active = false;
            this.$nextTick(() => this.active = true);
        },
        close() {
            this.active = false;
            clearTimeout(this.closeTimer);
            this.closeTimer = setTimeout(() => this.open = false, 260);
        },
        hiddenClass() {
            return {
                right: 'translate-x-full opacity-0',
                left: '-translate-x-full opacity-0',
                top: '-translate-y-full opacity-0',
                bottom: 'translate-y-full opacity-0',
            }[this.activePlacement];
        },
    }"
>
    <div class="flex flex-wrap gap-3">
        <x-sampaui::button size="sm" x-on:click="show('right', 'md')">Direita</x-sampaui::button>
        <x-sampaui::button size="sm" variant="secondary" x-on:click="show('left', 'lg')">Esquerda</x-sampaui::button>
        <x-sampaui::button size="sm" variant="accent" x-on:click="show('top', 'sm')">Topo</x-sampaui::button>
        <x-sampaui::button size="sm" variant="danger" x-on:click="show('bottom', 'sm')">Rodape</x-sampaui::button>
    </div>

    <div
        x-show="open"
        x-cloak
        class="fixed inset-0 z-[13000] flex"
        x-bind:class="{
            'items-stretch justify-end': activePlacement === 'right',
            'items-stretch justify-start': activePlacement === 'left',
            'items-start justify-stretch': activePlacement === 'top',
            'items-end justify-stretch': activePlacement === 'bottom',
        }"
        role="dialog"
        aria-modal="true"
        x-on:keydown.escape.window="close()"
    >
        <div
            class="absolute inset-0 bg-primary/40 transition-[backdrop-filter,opacity] duration-300 ease-out"
            x-bind:class="active ? 'opacity-100 backdrop-blur-[2px]' : 'opacity-0 backdrop-blur-none'"
            x-on:click="close()"
        ></div>

        <section
            class="relative flex flex-col overflow-hidden border border-light bg-white outline-none transition duration-300 ease-[cubic-bezier(0.16,1,0.3,1)]"
            style="will-change: transform, translate, opacity;"
            x-bind:class="{
                'h-full w-full max-w-md rounded-l-default': activePlacement === 'right',
                'h-full w-full max-w-lg rounded-r-default': activePlacement === 'left',
                'w-full max-h-[18rem] rounded-b-default': activePlacement === 'top',
                'w-full max-h-[18rem] rounded-t-default': activePlacement === 'bottom',
                'translate-x-0 translate-y-0 opacity-100': active,
                [hiddenClass()]: ! active,
            }"
        >
            <header class="flex items-start justify-between gap-4 px-5 py-5">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-primary">Drawer</p>
                    <h3 class="mt-2 text-lg font-semibold text-primary" x-text="labels[activePlacement]"></h3>
                    <p class="mt-1 text-sm text-secondary" x-text="`size=${activeSize}`"></p>
                </div>
                <button type="button" class="inline-flex h-10 w-10 cursor-pointer items-center justify-center rounded-full bg-white text-secondary hover:text-primary" x-on:click="close()" aria-label="Fechar preview">
                    <i class="bi bi-x-lg"></i>
                </button>
            </header>
            <div class="min-h-0 flex-1 overflow-y-auto px-5 py-5 text-secondary">
                Preview visual das posicoes aceitas pelo componente.
            </div>
        </section>
    </div>
</div>
BLADE,
                'code' => <<<'BLADE'
<x-sampaui::drawer model="rightDrawer" title="Direita" placement="right" size="md" />
<x-sampaui::drawer model="leftDrawer" title="Esquerda" placement="left" size="lg" />
<x-sampaui::drawer model="topDrawer" title="Topo" placement="top" size="sm" />
<x-sampaui::drawer model="bottomDrawer" title="Rodape" placement="bottom" size="sm" />
BLADE,
            ],
            [
                'title' => 'Com borda e sem borda',
                'description' => 'O painel usa borda por padrao; `panel-class` permite trocar ou remover o contorno.',
                'preview' => <<<'BLADE'
<div class="grid gap-4 md:grid-cols-2">
    <div class="rounded-default border border-light bg-white p-5">
        <p class="font-semibold text-primary">Drawer com borda</p>
        <p class="mt-2 text-sm text-secondary">Superficie padrao do pacote.</p>
    </div>

    <div class="rounded-default bg-white p-5">
        <p class="font-semibold text-primary">Drawer sem borda</p>
        <p class="mt-2 text-sm text-secondary">Contorno removido por `panel-class`.</p>
    </div>
</div>
BLADE,
                'code' => <<<'BLADE'
<x-sampaui::drawer model="defaultDrawer" title="Com borda">
    Conteudo padrao.
</x-sampaui::drawer>

<x-sampaui::drawer
    model="cleanDrawer"
    title="Sem borda"
    panel-class="border-0"
>
    Conteudo com contorno removido.
</x-sampaui::drawer>
BLADE,
            ],
            [
                'title' => 'Eventos e controller Livewire',
                'description' => 'Feche por evento de browser e execute um metodo apos a animacao.',
                'preview' => <<<'BLADE'
<x-sampaui::alert title="Fluxo Livewire">
    Depois de aplicar filtros, dispare <code>filters-applied</code> e o drawer fecha automaticamente.
</x-sampaui::alert>
BLADE,
                'code' => <<<'PHP'
<x-sampaui::drawer
    model="filtersOpen"
    title="Filtros"
    close-event="filters-applied"
    after-close="afterDrawerClose"
>
    Campos de filtro.
</x-sampaui::drawer>

<?php

public bool $filtersOpen = false;

public function applyFilters(): void
{
    // Atualize a query, paginacao ou estado da tela.

    $this->dispatch('filters-applied');
}

public function afterDrawerClose(): void
{
    $this->resetValidation();
}
PHP,
            ],
        ];

        $components['toast']['showcases'] = [
            [
                'title' => 'Disparos',
                'description' => 'Botoes que abrem cada tipo de toast pelo evento browser.',
                'code' => <<<'BLADE'
<x-sampaui::toast position="bottom-right" max="3" />

<x-sampaui::button icon="check2-circle" onclick="window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'success', title: 'Salvo', message: 'Alteracoes publicadas.' } }))">Abrir toast</x-sampaui::button>
<x-sampaui::button variant="secondary" icon="info-circle" onclick="window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'info', title: 'Aviso', message: 'Nova notificacao.' } }))">Info</x-sampaui::button>
<x-sampaui::button variant="accent" icon="exclamation-triangle" onclick="window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'warning', title: 'Atencao', message: 'Revise antes de continuar.' } }))">Warning</x-sampaui::button>
<x-sampaui::button variant="danger" icon="exclamation-octagon" onclick="window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', title: 'Erro', message: 'Falha ao salvar.' } }))">Error</x-sampaui::button>
BLADE,
            ],
            [
                'title' => 'Controller Livewire',
                'description' => 'Dispare o evento `toast` direto do metodo PHP do componente Livewire.',
                'preview' => <<<'BLADE'
<x-sampaui::alert variant="success" title="Evento Livewire">
    O container <code>&lt;x-sampaui::toast /&gt;</code> escuta o evento <code>toast</code> disparado pelo componente.
</x-sampaui::alert>
BLADE,
                'code' => <<<'PHP'
<?php

namespace App\Livewire;

use Livewire\Component;

class SaveLead extends Component
{
    public function save(): void
    {
        // Salve ou valide os dados antes do feedback.

        $this->dispatch(
            'toast',
            type: 'success',
            title: 'Lead salvo',
            message: 'As alteracoes foram sincronizadas.'
        );
    }
}
PHP,
            ],
            [
                'title' => 'Posicao e duracao',
                'description' => 'Configure o container e controle a permanencia por evento.',
                'preview' => <<<'BLADE'
<x-sampaui::alert title="Configuracao">
    Use `position`, `max` e `duration` para controlar comportamento e fila.
</x-sampaui::alert>
BLADE,
                'code' => <<<'BLADE'
<x-sampaui::toast position="top-right" max="5" />

window.dispatchEvent(new CustomEvent('toast', {
    detail: {
        type: 'warning',
        title: 'Revisao pendente',
        message: 'Confira os dados antes de aprovar.',
        duration: 0
    }
}))
BLADE,
            ],
            [
                'title' => 'Com borda e sem borda',
                'description' => 'Toasts usam borda por padrao. Envie `class` no detalhe do evento para trocar ou remover o contorno.',
                'preview' => <<<'BLADE'
<div class="grid gap-4 md:grid-cols-2">
    <div class="overflow-hidden rounded-default border border-primary bg-white">
        <div class="px-4 py-4">
            <p class="font-medium text-primary">Toast com borda</p>
            <p class="mt-1 text-sm text-secondary">Visual padrao.</p>
        </div>
        <div class="h-1 bg-primary"></div>
    </div>

    <div class="overflow-hidden rounded-default bg-white">
        <div class="px-4 py-4">
            <p class="font-medium text-primary">Toast sem borda</p>
            <p class="mt-1 text-sm text-secondary">Classe enviada no evento.</p>
        </div>
        <div class="h-1 bg-primary"></div>
    </div>
</div>
BLADE,
                'code' => <<<'BLADE'
window.dispatchEvent(new CustomEvent('toast', {
    detail: {
        type: 'success',
        title: 'Com borda',
        message: 'Visual padrao do pacote.'
    }
}))

window.dispatchEvent(new CustomEvent('toast', {
    detail: {
        type: 'success',
        title: 'Sem borda',
        message: 'Contorno removido somente neste toast.',
        class: 'border-0'
    }
}))
BLADE,
            ],
        ];

        $components['table']['showcases'] = [
            [
                'title' => 'Colunas e linhas',
                'description' => 'Renderizacao automatica por arrays, com alinhamento por coluna.',
                'code' => <<<'BLADE'
<x-sampaui::table
    :columns="[
        'name' => 'Cliente',
        'status' => 'Status',
        'amount' => ['label' => 'Valor', 'key' => 'amount', 'align' => 'right'],
    ]"
    :rows="[
        ['name' => 'Ana Souza', 'status' => 'Ativo', 'amount' => 'R$ 1.200,00'],
        ['name' => 'Bruno Lima', 'status' => 'Em analise', 'amount' => 'R$ 850,00'],
    ]"
/>
BLADE,
            ],
            [
                'title' => 'Ordenacao opt-in',
                'description' => 'Colunas marcadas com `sortable` exibem icone e podem chamar metodo Livewire.',
                'code' => <<<'BLADE'
<x-sampaui::table
    sort-by="name"
    sort-direction="asc"
    sort-method="sortBy"
    :columns="[
        'name' => ['label' => 'Cliente', 'sortable' => true],
        'status' => 'Status',
        'amount' => ['label' => 'Valor', 'key' => 'amount', 'align' => 'right', 'sortable' => true],
    ]"
    :rows="[
        ['name' => 'Ana Souza', 'status' => 'Ativo', 'amount' => 'R$ 1.200,00'],
        ['name' => 'Bruno Lima', 'status' => 'Em analise', 'amount' => 'R$ 850,00'],
    ]"
/>
BLADE,
            ],
            [
                'title' => 'Compacta, striped e sem borda',
                'description' => 'Controle de densidade e superficie externa.',
                'code' => <<<'BLADE'
<x-sampaui::table
    compact
    striped
    :columns="['code' => 'Codigo', 'owner' => 'Responsavel']"
    :rows="[
        ['code' => '#1024', 'owner' => 'Comercial'],
        ['code' => '#1025', 'owner' => 'Suporte'],
    ]"
/>

<x-sampaui::table
    :bordered="false"
    :columns="['name' => 'Nome']"
    :rows="[['name' => 'Superficie sem borda']]"
/>
BLADE,
            ],
            [
                'title' => 'Slots customizados',
                'description' => 'Use `head` e `body` quando precisar de markup rico nas celulas.',
                'code' => <<<'BLADE'
<x-sampaui::table>
    <x-slot:head>
        <thead>
            <tr>
                <th class="px-4 py-3 text-left">Cliente</th>
                <th class="px-4 py-3 text-right">Acao</th>
            </tr>
        </thead>
    </x-slot:head>

    <x-slot:body>
        <tbody>
            <tr>
                <td class="px-4 py-3">Ana Souza</td>
                <td class="px-4 py-3 text-right">
                    <x-sampaui::button size="sm" variant="outline">Abrir</x-sampaui::button>
                </td>
            </tr>
        </tbody>
    </x-slot:body>
</x-sampaui::table>
BLADE,
            ],
        ];

        $components['pagination']['showcases'] = [
            [
                'title' => 'Numerica',
                'description' => 'Resumo de registros, links anterior/proxima e janela de paginas.',
                'code' => <<<'BLADE'
<x-sampaui::pagination
    :current-page="2"
    :last-page="8"
    :total="80"
    :per-page="10"
    previous-url="/clientes?page=1"
    next-url="/clientes?page=3"
/>
BLADE,
            ],
            [
                'title' => 'Simples',
                'description' => 'Modo compacto com apenas anterior/proxima.',
                'code' => <<<'BLADE'
<x-sampaui::pagination
    simple
    :current-page="1"
    :last-page="5"
    next-url="/clientes?page=2"
/>
BLADE,
            ],
            [
                'title' => 'Livewire',
                'description' => 'Use `wire-method` para acionar um metodo do componente Livewire.',
                'preview' => <<<'BLADE'
<x-sampaui::pagination
    :current-page="3"
    :last-page="9"
    :total="90"
    :per-page="10"
    wire-method="gotoPage"
/>
BLADE,
                'code' => <<<'PHP'
<x-sampaui::pagination
    :current-page="$page"
    :last-page="$lastPage"
    :total="$total"
    :per-page="10"
    wire-method="gotoPage"
/>

<?php

public int $page = 1;

public function gotoPage(int $page): void
{
    $this->page = max(1, $page);
}
PHP,
            ],
        ];

        $extraComponents = [
            'badge' => ['Badge', '<x-sampaui::badge />', 'Marcadores compactos para status, tags e classificacoes.', 'Status operacional', '<x-sampaui::badge variant="accent" icon="star">Novo</x-sampaui::badge>'],
            'avatar' => ['Avatar', '<x-sampaui::avatar />', 'Imagem ou iniciais de usuario com tamanho, status e fallback.', 'Identidade de usuario', '<x-sampaui::avatar src="/images/admin.jpg" name="Ana Silva" status="online" />'],
            'avatar-upload' => ['Avatar Upload', '<x-sampaui::avatar-upload />', 'Upload circular de avatar com preview, botao de editar e flag de remocao enviada no submit.', 'Foto do perfil', '<x-sampaui::avatar-upload name="avatar" src="https://i.pravatar.cc/160?img=12" wire:model="avatar" />'],
            'phone' => ['Phone', '<x-sampaui::phone />', 'Campo de telefone com mascara, icone Bootstrap e suporte direto a Livewire.', 'Telefone com mascara', '<x-sampaui::phone name="phone" label="Telefone" wire:model.live="phone" />'],
            'currency-br' => ['Currency BR', '<x-sampaui::currency-br />', 'Campo monetario em reais com formatacao brasileira e prefixo customizavel.', 'Valor em reais', '<x-sampaui::currency-br name="price" label="Valor" wire:model.live="price" />'],
            'cep' => ['CEP', '<x-sampaui::cep />', 'Campo de CEP com mascara `99999-999`, autocomplete postal e suporte direto a Livewire.', 'Endereco postal', '<x-sampaui::cep name="postal_code" label="CEP" wire:model.live="postal_code" />'],
            'dropdown' => ['Dropdown', '<x-sampaui::dropdown />', 'Menu de acoes com trigger customizavel, alinhamento e itens clicaveis.', 'Acoes contextuais', <<<'BLADE'
<x-sampaui::dropdown label="Acoes" align="right">
    <x-sampaui::dropdown-item href="/editar" icon="pencil">Editar</x-sampaui::dropdown-item>
    <x-sampaui::dropdown-item icon="trash" danger>Remover</x-sampaui::dropdown-item>
</x-sampaui::dropdown>
BLADE],
            'tabs' => ['Tabs', '<x-sampaui::tabs />', 'Navegacao local entre secoes do mesmo contexto.', 'Secoes internas', <<<'BLADE'
<x-sampaui::tabs :tabs="['overview' => 'Resumo', 'billing' => 'Cobranca']" active="overview">
    <x-sampaui::tab-panel name="overview">Resumo do cliente.</x-sampaui::tab-panel>
    <x-sampaui::tab-panel name="billing">Dados financeiros.</x-sampaui::tab-panel>
</x-sampaui::tabs>
BLADE],
            'toggle' => ['Toggle', '<x-sampaui::toggle />', 'Controle booleano colorido para preferencias e configuracoes.', 'Configuracao ativa', '<x-sampaui::toggle name="active" label="Cliente ativo" checked wire:model.live="active" />'],
            'tooltip' => ['Tooltip', '<x-sampaui::tooltip />', 'Ajuda contextual para botoes, icones e acoes compactas.', 'Ajuda contextual', '<x-sampaui::tooltip text="Copiar"><x-sampaui::button icon="copy" aria-label="Copiar" /></x-sampaui::tooltip>'],
            'breadcrumb' => ['Breadcrumb', '<x-sampaui::breadcrumb />', 'Trilha de navegacao para paginas internas.', 'Hierarquia da pagina', <<<'BLADE'
<x-sampaui::breadcrumb :items="[
    ['label' => 'Dashboard', 'href' => '/dashboard'],
    ['label' => 'Clientes', 'href' => '/clientes'],
    ['label' => 'Ana Souza'],
]" />
BLADE],
            'brand-mark' => ['Brand Mark', '<x-sampaui::brand-mark />', 'Marca compacta do SampaUI para sidebars, headers e estados de marca.', 'Identidade visual', '<x-sampaui::brand-mark />'],
            'dropdown-item' => ['Dropdown Item', '<x-sampaui::dropdown-item />', 'Subcomponente de item acionavel para menus Dropdown.', 'Item de menu', <<<'BLADE'
<x-sampaui::dropdown label="Acoes">
    <x-sampaui::dropdown-item icon="pencil" wire:click="edit">Editar</x-sampaui::dropdown-item>
</x-sampaui::dropdown>
BLADE],
            'tab-panel' => ['Tab Panel', '<x-sampaui::tab-panel />', 'Subcomponente de painel para conteudo renderizado dentro de Tabs.', 'Painel de aba', <<<'BLADE'
<x-sampaui::tabs :tabs="['details' => 'Detalhes']" active="details">
    <x-sampaui::tab-panel name="details">Conteudo da aba.</x-sampaui::tab-panel>
</x-sampaui::tabs>
BLADE],
            'indicator' => ['Indicator', '<x-sampaui::indicator />', 'Ponto visual para estado, presenca, conexao ou alerta.', 'Conexao', '<x-sampaui::indicator variant="primary" pulse label="Online" />'],
            'skeleton' => ['Skeleton', '<x-sampaui::skeleton />', 'Placeholder de carregamento para listas, cards e textos.', 'Carregando dados', '<x-sampaui::skeleton :lines="3" />'],
            'empty-state' => ['Estado vazio', '<x-sampaui::empty-state />', 'Estado vazio com icone, descricao e slot de acoes.', 'Lista vazia', <<<'BLADE'
<x-sampaui::empty-state title="Nenhum cliente encontrado" description="Ajuste os filtros ou cadastre um novo cliente.">
    <x-slot:actions>
        <x-sampaui::button icon="plus">Novo cliente</x-sampaui::button>
    </x-slot:actions>
</x-sampaui::empty-state>
BLADE],
            'file-upload' => ['Upload de arquivo', '<x-sampaui::file-upload />', 'Area de selecao com borda tracejada `border-secondary/40`, label, erro, accept e suporte a multiplos arquivos.', 'Envio de arquivo', '<x-sampaui::file-upload name="contract" label="Contrato" accept=".pdf" />'],
            'progress' => ['Progress', '<x-sampaui::progress />', 'Barra de progresso com label, percentual e variantes.', 'Progresso de envio', '<x-sampaui::progress :value="72" label="Importacao" show-value />'],
            'stepper' => ['Stepper', '<x-sampaui::stepper />', 'Sequencia de etapas para onboarding, checkout e fluxos guiados.', 'Fluxo em etapas', <<<'BLADE'
<x-sampaui::stepper
    :current="2"
    :steps="[
        ['label' => 'Dados', 'description' => 'Informacoes principais'],
        ['label' => 'Contato', 'description' => 'Canais de atendimento'],
        ['label' => 'Revisao', 'description' => 'Confirmacao final'],
    ]"
/>
BLADE],
            'accordion' => ['Accordion', '<x-sampaui::accordion />', 'Lista expansivel para perguntas, detalhes e configuracoes.', 'Conteudo recolhivel', <<<'BLADE'
<x-sampaui::accordion :items="[
    ['title' => 'Como instalar?', 'content' => 'Use composer require sampaui/sampaui.', 'open' => true],
    ['title' => 'Funciona com Livewire?', 'content' => 'Sim, atributos wire:* passam intactos.'],
]" />
BLADE],
            'command-palette' => ['Command Palette', '<x-sampaui::command-palette />', 'Busca global acionada por evento Alpine para comandos e atalhos.', 'Busca de comandos', <<<'BLADE'
<x-sampaui::button x-on:click="$dispatch('sampaui:command-open')" icon="search">
    Abrir busca
</x-sampaui::button>

<x-sampaui::command-palette :items="[
    ['label' => 'Novo lead', 'href' => '/leads/create', 'icon' => 'plus'],
    ['label' => 'Clientes', 'href' => '/clients', 'icon' => 'people'],
]" />
BLADE],
        ];

        foreach ($extraComponents as $slug => [$name, $tag, $summary, $previewTitle, $code]) {
            $components[$slug] = [
                'slug' => $slug,
                'name' => $name,
                'tag' => $tag,
                'summary' => $summary,
                'description' => $summary.' O componente preserva atributos HTML, Alpine e Livewire passados pelo consumidor.',
                'preview_title' => $previewTitle,
                'preview_caption' => 'Exemplo base com API simples.',
                'props' => [
                    ['name' => 'class', 'type' => 'HTML attribute', 'default' => '-', 'notes' => 'Mesclado no elemento raiz.'],
                    ['name' => '$slot', 'type' => 'Blade slot', 'default' => '-', 'notes' => 'Conteudo principal quando aplicavel.'],
                ],
                'attributes' => ['class', 'id', 'wire:*', 'x-*', 'aria-*', 'data-*'],
                'accessibility' => [
                    'Mantenha texto visivel ou atributos `aria-*` em controles icon-only.',
                    'Preserve foco de teclado quando o componente acionar menus, paineis ou acoes.',
                ],
                'examples' => [
                    [
                        'title' => 'Uso base',
                        'description' => 'Exemplo direto para copiar e adaptar.',
                        'code' => $code,
                    ],
                    [
                        'title' => 'Livewire',
                        'description' => 'Atributos `wire:*` passam para o elemento raiz ou controle nativo.',
                        'code' => str_replace(' />', ' wire:key="'.$slug.'-example" />', is_string($code) && str_starts_with(trim($code), '<x-sampaui::'.$slug) ? trim($code) : '<x-sampaui::'.$slug.' wire:key="'.$slug.'-example" />'),
                    ],
                ],
                'showcases' => [
                    [
                        'title' => 'Padrao',
                        'description' => $summary,
                        'code' => $code,
                    ],
                ],
            ];
        }

        $components['stepper']['examples'][] = [
            'title' => 'Formulario com validacao',
            'description' => 'Combine o Stepper com componentes de formulario para exibir erros por etapa e avancar somente quando os campos obrigatorios estiverem validos.',
            'code' => <<<'BLADE'
@php
    $currentStep = 2;
    $steps = [
        ['label' => 'Dados', 'description' => 'Identificacao do cliente'],
        ['label' => 'Contato', 'description' => 'Canais obrigatorios'],
        ['label' => 'Revisao', 'description' => 'Confirmacao final'],
    ];
@endphp

<form wire:submit.prevent="save" class="grid gap-6">
    <x-sampaui::stepper :current="$currentStep" :steps="$steps" />

    <div class="grid gap-4 md:grid-cols-2">
        <x-sampaui::input
            name="name"
            label="Nome"
            placeholder="Ana Souza"
            wire:model.live="name"
            error="Informe o nome completo."
        />

        <x-sampaui::input
            name="email"
            type="email"
            label="Email"
            placeholder="ana@empresa.com"
            wire:model.live="email"
            error="Use um email valido."
        />
    </div>

    <x-sampaui::textarea
        name="notes"
        label="Observacoes"
        placeholder="Contexto do atendimento"
        wire:model.live="notes"
    />

    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-between">
        <x-sampaui::button type="button" variant="light" icon="arrow-left">
            Voltar
        </x-sampaui::button>

        <x-sampaui::button type="submit" icon="check2-circle" wire:loading.attr="disabled">
            Validar e salvar
        </x-sampaui::button>
    </div>
</form>
BLADE,
        ];

        $components['toggle']['props'] = [
            ['name' => 'label', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Texto exibido ao lado do controle.'],
            ['name' => 'name', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Nome e id fallback do input checkbox.'],
            ['name' => 'checked', 'type' => 'bool', 'default' => 'false', 'notes' => 'Estado inicial ligado.'],
            ['name' => 'color', 'type' => 'primary|secondary|accent|danger|success|warning|info|purple|muted|light', 'default' => 'primary', 'notes' => 'Cor do controle quando marcado.'],
            ['name' => 'disabled', 'type' => 'bool', 'default' => 'false', 'notes' => 'Desabilita a interacao.'],
            ['name' => 'value', 'type' => 'string', 'default' => '1', 'notes' => 'Valor enviado quando marcado.'],
        ];
        $components['toggle']['showcases'] = [
            [
                'title' => 'Padrao',
                'description' => 'Controle booleano com knob centralizado e label.',
                'code' => '<x-sampaui::toggle name="active" label="Cliente ativo" checked />',
            ],
            [
                'title' => 'Variacoes de cor',
                'description' => 'Quando desligado, borda e botao interno seguem o token. Quando ligado, o trilho recebe o fundo da mesma cor.',
                'code' => <<<'BLADE'
<div class="flex flex-wrap gap-6">
    <x-sampaui::toggle name="primary" label="Primary" color="primary" checked />
    <x-sampaui::toggle name="secondary" label="Secondary" color="secondary" checked />
    <x-sampaui::toggle name="accent" label="Accent" color="accent" checked />
    <x-sampaui::toggle name="danger" label="Danger" color="danger" />
</div>
BLADE,
            ],
            [
                'title' => 'Livewire',
                'description' => 'Binding direto em configuracoes booleanas.',
                'code' => '<x-sampaui::toggle name="notifications" label="Receber notificacoes" wire:model.live="notifications" />',
            ],
        ];

        foreach (['phone', 'currency-br', 'cep'] as $maskedComponent) {
            $components[$maskedComponent]['props'] = [
                ['name' => 'label', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Texto exibido acima do campo.'],
                ['name' => 'name', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Nome do campo, id fallback e chave do ErrorBag.'],
                ['name' => 'placeholder', 'type' => 'string|null', 'default' => 'mascara do componente', 'notes' => 'Texto auxiliar exibido dentro do input.'],
                ['name' => 'icon', 'type' => 'string|null', 'default' => 'icone do componente', 'notes' => 'Nome Bootstrap Icons sem o prefixo `bi-`.'],
                ['name' => '$prefix', 'type' => 'Named slot', 'default' => '-', 'notes' => 'Conteudo customizado dentro do campo, à esquerda.'],
                ['name' => '$suffix', 'type' => 'Named slot', 'default' => '-', 'notes' => 'Conteudo customizado dentro do campo, à direita.'],
            ];
            $components[$maskedComponent]['attributes'] = ['class', 'id', 'wire:model.live', 'x-model', 'autocomplete', 'required', 'aria-*', 'data-*'];
        }

        $components['phone']['showcases'] = [
            [
                'title' => 'Telefone',
                'description' => 'Mascara para telefone brasileiro com nono digito.',
                'code' => '<x-sampaui::phone name="phone" label="Telefone" wire:model.live="phone" />',
            ],
            [
                'title' => 'Prefixo customizado',
                'description' => 'Substitua o icone padrao usando slot.',
                'code' => <<<'BLADE'
<x-sampaui::phone name="phone" label="WhatsApp">
    <x-slot:prefix>
        <i class="bi bi-whatsapp"></i>
    </x-slot:prefix>
</x-sampaui::phone>
BLADE,
            ],
        ];

        $components['currency-br']['showcases'] = [
            [
                'title' => 'Valor',
                'description' => 'Formatacao monetaria no padrao brasileiro.',
                'code' => '<x-sampaui::currency-br name="price" label="Valor" wire:model.live="price" />',
            ],
            [
                'title' => 'Simbolo customizado',
                'description' => 'Use a prop `symbol` para trocar o prefixo textual.',
                'code' => '<x-sampaui::currency-br name="fee" label="Taxa" symbol="BRL" />',
            ],
        ];

        $components['cep']['showcases'] = [
            [
                'title' => 'CEP',
                'description' => 'Mascara postal com autocomplete nativo.',
                'code' => '<x-sampaui::cep name="postal_code" label="CEP" wire:model.live="postal_code" />',
            ],
            [
                'title' => 'Endereco',
                'description' => 'Uso comum em formulario de endereco.',
                'code' => <<<'BLADE'
<div class="grid gap-4 md:grid-cols-[12rem_minmax(0,1fr)]">
    <x-sampaui::cep name="postal_code" label="CEP" wire:model.live="postal_code" />
    <x-sampaui::input name="address" label="Endereco" wire:model.live="address" />
</div>
BLADE,
            ],
        ];

        $components['file-upload']['props'] = [
            ['name' => 'label', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Label associado ao input.'],
            ['name' => 'name', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Nome do campo e chave de erro.'],
            ['name' => 'accept', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Tipos aceitos pelo input nativo.'],
            ['name' => 'multiple', 'type' => 'bool', 'default' => 'false', 'notes' => 'Permite selecionar multiplos arquivos.'],
            ['name' => 'preview', 'type' => 'bool', 'default' => 'false', 'notes' => 'Exibe preview local de imagens selecionadas e permite remover itens antes de salvar.'],
            ['name' => 'error', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Mensagem manual ou ErrorBag.'],
            ['name' => 'disabled', 'type' => 'bool', 'default' => 'false', 'notes' => 'Desabilita a selecao.'],
        ];
        $components['file-upload']['showcases'] = [
            [
                'title' => 'Arquivo unico',
                'description' => 'Area de selecao com label, erro, accept e suporte a arquivos comuns.',
                'code' => '<x-sampaui::file-upload name="contract" label="Contrato" accept=".pdf" />',
            ],
            [
                'title' => 'Multiplas imagens com preview',
                'description' => 'Preview local via Alpine para galerias, anexos e documentos escaneados, com remocao individual antes de salvar.',
                'code' => <<<'BLADE'
<x-sampaui::file-upload
    name="photos[]"
    label="Imagens do atendimento"
    accept="image/*"
    multiple
    preview
>
    Selecione uma ou mais imagens
</x-sampaui::file-upload>
BLADE,
            ],
            [
                'title' => 'Upload com Livewire',
                'description' => 'Use `wire:model` normalmente no input nativo.',
                'code' => <<<'BLADE'
<x-sampaui::file-upload
    name="attachments"
    label="Anexos"
    multiple
    wire:model="attachments"
/>
BLADE,
            ],
        ];

        $components['avatar']['props'] = [
            ['name' => 'src', 'type' => 'string|null', 'default' => 'null', 'notes' => 'URL da imagem. Quando ausente, usa iniciais.'],
            ['name' => 'name', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Nome usado para alt e iniciais.'],
            ['name' => 'alt', 'type' => 'string|null', 'default' => 'name', 'notes' => 'Texto alternativo da imagem.'],
            ['name' => 'size', 'type' => 'xs|sm|md|lg|xl|2xl', 'default' => 'md', 'notes' => 'Tamanho do avatar e do status.'],
            ['name' => 'rounded', 'type' => 'bool', 'default' => 'true', 'notes' => 'Usa circulo quando true ou raio padrao quando false.'],
            ['name' => 'status', 'type' => 'online|busy|away|offline|null', 'default' => 'null', 'notes' => 'Indicador visual no canto inferior.'],
        ];
        $components['avatar']['showcases'] = [
            [
                'title' => 'Imagem e fallback',
                'description' => 'Renderiza imagem quando `src` existe ou iniciais quando nao existe.',
                'code' => <<<'BLADE'
<div class="flex items-center gap-4">
    <x-sampaui::avatar src="/images/admin.jpg" name="Ana Silva" status="online" />
    <x-sampaui::avatar name="Bruno Lima" status="away" />
</div>
BLADE,
            ],
            [
                'title' => 'Tamanhos',
                'description' => 'Use tamanhos de `xs` a `2xl` para listas, headers e perfis.',
                'code' => <<<'BLADE'
<div class="flex items-end gap-4">
    <x-sampaui::avatar name="Ana Silva" size="xs" />
    <x-sampaui::avatar name="Ana Silva" size="sm" />
    <x-sampaui::avatar name="Ana Silva" size="md" />
    <x-sampaui::avatar name="Ana Silva" size="lg" />
    <x-sampaui::avatar name="Ana Silva" size="xl" />
    <x-sampaui::avatar name="Ana Silva" size="2xl" />
</div>
BLADE,
            ],
        ];

        $components['avatar-upload']['props'] = [
            ['name' => 'label', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Label associado ao input de arquivo.'],
            ['name' => 'name', 'type' => 'string|null', 'default' => 'avatar', 'notes' => 'Nome do arquivo e chave de erro.'],
            ['name' => 'src', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Imagem atual exibida antes da troca.'],
            ['name' => 'alt', 'type' => 'string|null', 'default' => 'label', 'notes' => 'Texto alternativo da imagem.'],
            ['name' => 'size', 'type' => 'sm|md|lg|xl|2xl', 'default' => 'xl', 'notes' => 'Tamanho do preview circular.'],
            ['name' => 'accept', 'type' => 'string|null', 'default' => 'image/*', 'notes' => 'Tipos aceitos pelo input nativo.'],
            ['name' => 'placeholder', 'type' => 'string', 'default' => 'No Image', 'notes' => 'Texto quando nao ha imagem.'],
            ['name' => 'help', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Texto auxiliar opcional abaixo do avatar.'],
            ['name' => 'removeName', 'type' => 'string|null', 'default' => 'name_remove', 'notes' => 'Nome do hidden enviado como `1` quando a imagem for removida. Gerado automaticamente pelo `name`.'],
            ['name' => 'removeModel', 'type' => 'string|null', 'default' => 'wireModelRemove', 'notes' => 'Propriedade Livewire sincronizada com a flag de remocao. Gerada automaticamente a partir de `wire:model` quando existir.'],
            ['name' => 'removeLabel', 'type' => 'string', 'default' => 'Remover imagem', 'notes' => 'Label acessivel do botao de remover.'],
            ['name' => 'uploadLabel', 'type' => 'string', 'default' => 'Selecionar imagem', 'notes' => 'Label acessivel do botao de upload.'],
            ['name' => 'error', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Mensagem manual ou ErrorBag.'],
            ['name' => 'disabled', 'type' => 'bool', 'default' => 'false', 'notes' => 'Desabilita a selecao e remocao.'],
        ];
        $components['avatar-upload']['showcases'] = [
            [
                'title' => 'Sem imagem',
                'description' => 'Estado inicial com placeholder e botao de lapis.',
                'code' => <<<'BLADE'
<x-sampaui::avatar-upload
    name="avatar"
/>
BLADE,
            ],
            [
                'title' => 'Com imagem e remocao',
                'description' => 'Mostra a lixeira ao lado do lapis quando existe imagem atual ou preview selecionado.',
                'code' => <<<'BLADE'
<x-sampaui::avatar-upload
    name="avatar"
    src="https://i.pravatar.cc/160?img=12"
/>
BLADE,
            ],
            [
                'title' => 'Livewire',
                'description' => 'Use `wire:model` no input real. No componente PHP, use `WithFileUploads` e trate `avatar_remove` no metodo de salvar.',
                'code' => <<<'BLADE'
<x-sampaui::avatar-upload
    name="avatar"
    src="https://i.pravatar.cc/160?img=12"
    wire:model="avatar"
/>
BLADE,
            ],
        ];

        $components['tooltip']['props'] = [
            ['name' => 'text', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Conteudo textual do tooltip.'],
            ['name' => 'position', 'type' => 'top|right|bottom|left', 'default' => 'top', 'notes' => 'Posicao em relacao ao elemento alvo.'],
        ];
        $components['tooltip']['showcases'] = [
            [
                'title' => 'Posicionamento',
                'description' => 'Controle a direcao do tooltip por prop.',
                'code' => <<<'BLADE'
<div class="flex flex-wrap gap-4">
    <x-sampaui::tooltip text="Acima" position="top"><x-sampaui::button variant="outline">Top</x-sampaui::button></x-sampaui::tooltip>
    <x-sampaui::tooltip text="Direita" position="right"><x-sampaui::button variant="outline">Right</x-sampaui::button></x-sampaui::tooltip>
    <x-sampaui::tooltip text="Abaixo" position="bottom"><x-sampaui::button variant="outline">Bottom</x-sampaui::button></x-sampaui::tooltip>
    <x-sampaui::tooltip text="Esquerda" position="left"><x-sampaui::button variant="outline">Left</x-sampaui::button></x-sampaui::tooltip>
</div>
BLADE,
            ],
        ];

        $components['progress']['props'] = [
            ['name' => 'value', 'type' => 'int|float', 'default' => '0', 'notes' => 'Valor atual.'],
            ['name' => 'max', 'type' => 'int|float', 'default' => '100', 'notes' => 'Valor maximo usado para calcular percentual.'],
            ['name' => 'label', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Texto acima da barra.'],
            ['name' => 'showValue', 'type' => 'bool', 'default' => 'false', 'notes' => 'Exibe percentual calculado.'],
            ['name' => 'variant', 'type' => 'primary|secondary|accent|danger|success|warning|info|purple|muted|light', 'default' => 'primary', 'notes' => 'Cor da barra.'],
        ];
        $components['progress']['showcases'] = [
            [
                'title' => 'Padrao',
                'description' => 'Barra com label e percentual calculado.',
                'code' => '<x-sampaui::progress :value="72" label="Importacao" show-value />',
            ],
            [
                'title' => 'Variacoes de cor',
                'description' => 'Use variantes para progresso, alerta e falha.',
                'code' => <<<'BLADE'
<div class="grid gap-4">
    <x-sampaui::progress :value="35" label="Primary" variant="primary" show-value />
    <x-sampaui::progress :value="52" label="Secondary" variant="secondary" show-value />
    <x-sampaui::progress :value="68" label="Accent" variant="accent" show-value />
    <x-sampaui::progress :value="84" label="Danger" variant="danger" show-value />
</div>
BLADE,
            ],
        ];

        $components['badge']['props'] = [
            ['name' => 'variant', 'type' => 'primary|secondary|accent|danger|success|warning|info|purple|muted|light', 'default' => 'primary', 'notes' => 'Define cor semantica. Variantes invalidas retornam para `primary`.'],
            ['name' => 'size', 'type' => 'xs|sm|md|lg', 'default' => 'md', 'notes' => 'Controla padding, gap, tipografia e altura de linha.'],
            ['name' => 'icon', 'type' => 'string|null', 'default' => 'null', 'notes' => 'Nome Bootstrap Icons sem o prefixo `bi-`.'],
            ['name' => 'rounded', 'type' => 'bool', 'default' => 'true', 'notes' => 'Usa `rounded-full`; quando false usa `rounded-default`.'],
            ['name' => '$slot', 'type' => 'Blade slot', 'default' => '-', 'notes' => 'Texto curto do marcador.'],
        ];
        $components['badge']['showcases'] = [
            [
                'title' => 'Status de publicacao',
                'description' => 'Use badges para estados curtos que precisam ser lidos rapidamente em cards e tabelas.',
                'code' => <<<'BLADE'
<div class="flex flex-wrap gap-3">
    <x-sampaui::badge variant="success" icon="check2-circle">Publicado</x-sampaui::badge>
    <x-sampaui::badge variant="warning" icon="clock">Pendente</x-sampaui::badge>
    <x-sampaui::badge variant="danger" icon="exclamation-triangle">Revisar</x-sampaui::badge>
    <x-sampaui::badge variant="muted" icon="archive">Arquivado</x-sampaui::badge>
</div>
BLADE,
            ],
            [
                'title' => 'Prioridade e contadores',
                'description' => 'Combine variantes, tamanhos e icones para filas operacionais.',
                'code' => <<<'BLADE'
<div class="flex flex-wrap gap-3">
    <x-sampaui::badge variant="success" size="xs">Novo</x-sampaui::badge>
    <x-sampaui::badge variant="secondary" size="sm">Baixa</x-sampaui::badge>
    <x-sampaui::badge variant="accent">Media</x-sampaui::badge>
    <x-sampaui::badge variant="danger" size="lg">Alta</x-sampaui::badge>
    <x-sampaui::badge variant="info" icon="image">12 sem foto</x-sampaui::badge>
</div>
BLADE,
            ],
        ];
        $components['badge']['examples'] = array_merge($components['badge']['examples'], [
            [
                'title' => 'Em tabela',
                'description' => 'Renderize o status de cada linha a partir de um mapa simples.',
                'code' => <<<'BLADE'
@php
    $variant = [
        'published' => 'success',
        'pending' => 'warning',
        'review' => 'danger',
    ][$status] ?? 'muted';
@endphp

<x-sampaui::badge :variant="$variant">
    {{ $label }}
</x-sampaui::badge>
BLADE,
            ],
            [
                'title' => 'Com Livewire',
                'description' => 'No componente Livewire, deixe a regra de cor centralizada em um metodo.',
                'code' => <<<'PHP'
// Blade
<x-sampaui::badge :variant="$this->statusVariant($property->status)">
    {{ $property->status_label }}
</x-sampaui::badge>

// Classe Livewire
public function statusVariant(string $status): string
{
    return [
        'published' => 'success',
        'pending' => 'warning',
        'review' => 'danger',
    ][$status] ?? 'muted';
}
PHP,
            ],
        ]);

        $components['skeleton']['description'] = 'Use Skeleton quando o layout final ja e conhecido e a espera e curta. Ele evita salto visual enquanto Livewire, filtros ou requisicoes assíncronas atualizam a tela.';
        $components['skeleton']['props'] = [
            ['name' => 'lines', 'type' => 'int', 'default' => '1', 'notes' => 'Quantidade de linhas horizontais. A ultima linha fica menor para simular texto real.'],
            ['name' => 'circle', 'type' => 'bool', 'default' => 'false', 'notes' => 'Renderiza bloco circular para avatar, icone ou thumbnail.'],
            ['name' => 'class', 'type' => 'HTML attribute', 'default' => '-', 'notes' => 'Use para ajustar largura, altura e espacamento do placeholder.'],
        ];
        $components['skeleton']['showcases'] = [
            [
                'title' => 'Card carregando',
                'description' => 'Combine circulo, linhas e larguras para representar o card antes dos dados chegarem.',
                'code' => <<<'BLADE'
<div class="w-full max-w-md rounded-default border border-light bg-white p-5">
    <div class="flex items-center gap-4">
        <x-sampaui::skeleton circle class="h-14 w-14" />
        <div class="flex-1">
            <x-sampaui::skeleton class="h-4 w-2/3" />
            <x-sampaui::skeleton class="mt-3 h-3 w-1/2" />
        </div>
    </div>

    <div class="mt-6">
        <x-sampaui::skeleton :lines="3" />
    </div>
</div>
BLADE,
            ],
            [
                'title' => 'Lista ou tabela',
                'description' => 'Repita o skeleton para linhas de listagens enquanto filtros e paginacao carregam.',
                'code' => <<<'BLADE'
<div class="grid w-full gap-3">
    @foreach (range(1, 4) as $row)
        <div class="flex items-center gap-4 rounded-default border border-light bg-white p-4">
            <x-sampaui::skeleton circle class="h-10 w-10" />
            <x-sampaui::skeleton class="h-4 flex-1" />
            <x-sampaui::skeleton class="h-4 w-24" />
        </div>
    @endforeach
</div>
BLADE,
            ],
        ];
        $components['skeleton']['examples'] = array_merge($components['skeleton']['examples'], [
            [
                'title' => 'Com wire:loading',
                'description' => 'Mostre o skeleton somente enquanto uma acao Livewire estiver em andamento.',
                'code' => <<<'BLADE'
<div wire:loading wire:target="filter">
    <x-sampaui::skeleton :lines="4" />
</div>

<div wire:loading.remove wire:target="filter">
    {{-- conteudo real da lista --}}
</div>
BLADE,
            ],
            [
                'title' => 'Classe Livewire',
                'description' => 'O `wire:loading` e controlado pelo Livewire; o metodo apenas atualiza o estado usado pela tela.',
                'code' => <<<'PHP'
public string $search = '';

public function filter(): void
{
    $this->resetPage();
}

// Blade
<x-sampaui::input
    name="search"
    label="Buscar"
    icon="search"
    wire:model.live.debounce.300ms="search"
/>

<div wire:loading>
    <x-sampaui::skeleton :lines="3" />
</div>
PHP,
            ],
        ]);

        $components['command-palette']['description'] = 'Use Command Palette para busca global, atalhos e navegacao rapida em dashboards. O componente recebe uma lista de comandos e abre por evento Alpine ou JavaScript.';
        $components['command-palette']['props'] = [
            ['name' => 'items', 'type' => 'array', 'default' => '[]', 'notes' => 'Lista de comandos com `label`, `href` e `icon` opcional.'],
            ['name' => 'placeholder', 'type' => 'string', 'default' => 'Buscar comando...', 'notes' => 'Texto exibido no campo de busca interno.'],
            ['name' => 'openEvent', 'type' => 'string', 'default' => 'sampaui:command-open', 'notes' => 'Nome do evento escutado em `window` para abrir a paleta.'],
            ['name' => '$slot', 'type' => 'Blade slot', 'default' => '-', 'notes' => 'Conteudo adicional dentro da lista, quando a lista via `items` nao for suficiente.'],
        ];
        $components['command-palette']['showcases'] = [
            [
                'title' => 'Busca global',
                'description' => 'Dispare o evento `sampaui:command-open` a partir de um botao, atalho ou busca no header.',
                'code' => <<<'BLADE'
<x-sampaui::button
    variant="outline"
    icon="search"
    x-on:click="$dispatch('sampaui:command-open')"
>
    Buscar comando
</x-sampaui::button>

<x-sampaui::command-palette
    placeholder="Buscar imoveis, paginas e acoes"
    :items="[
        ['label' => 'Novo imovel', 'href' => '/imoveis/create', 'icon' => 'plus'],
        ['label' => 'Imoveis para revisar', 'href' => '/imoveis/revisao', 'icon' => 'house-check'],
        ['label' => 'Categorias', 'href' => '/categorias', 'icon' => 'tags'],
        ['label' => 'Dicas em video', 'href' => '/videos', 'icon' => 'play-btn'],
    ]"
/>
BLADE,
            ],
        ];
        $components['command-palette']['examples'] = array_merge($components['command-palette']['examples'], [
            [
                'title' => 'Atalho de teclado',
                'description' => 'Use Alpine no layout para abrir a paleta com Cmd/Ctrl + K.',
                'code' => <<<'BLADE'
<div
    x-data
    x-on:keydown.window.prevent.meta.k="$dispatch('sampaui:command-open')"
    x-on:keydown.window.prevent.ctrl.k="$dispatch('sampaui:command-open')"
>
    <x-sampaui::command-palette :items="$commands" />
</div>
BLADE,
            ],
            [
                'title' => 'Classe Livewire',
                'description' => 'Monte os comandos no componente Livewire e envie a lista para a view.',
                'code' => <<<'PHP'
public array $commands = [];

public function mount(): void
{
    $this->commands = [
        ['label' => 'Novo imovel', 'href' => route('properties.create'), 'icon' => 'plus'],
        ['label' => 'Revisar imoveis', 'href' => route('properties.review'), 'icon' => 'house-check'],
        ['label' => 'Categorias', 'href' => route('categories.index'), 'icon' => 'tags'],
    ];
}

// Blade
<x-sampaui::command-palette :items="$commands" />
PHP,
            ],
            [
                'title' => 'Evento customizado',
                'description' => 'Quando a tela ja usa outro evento global, altere `open-event`.',
                'code' => <<<'BLADE'
<x-sampaui::button x-on:click="$dispatch('open-dashboard-search')">
    Abrir atalhos
</x-sampaui::button>

<x-sampaui::command-palette
    open-event="open-dashboard-search"
    :items="$commands"
/>
BLADE,
            ],
        ]);

        $components['dropdown']['showcases'] = [
            [
                'title' => 'Padrao',
                'description' => 'Menu alinhado ao trigger, sem ocupar a largura total do preview.',
                'code' => <<<'BLADE'
<x-sampaui::dropdown label="Acoes">
    <x-sampaui::dropdown-item href="/editar" icon="pencil">Editar</x-sampaui::dropdown-item>
    <x-sampaui::dropdown-item icon="trash" danger>Remover</x-sampaui::dropdown-item>
</x-sampaui::dropdown>
BLADE,
            ],
            [
                'title' => 'Alinhado a direita',
                'description' => 'Use `align="right"` quando o trigger estiver no canto direito da interface.',
                'code' => <<<'BLADE'
<x-sampaui::dropdown label="Mais" align="right" width="12rem">
    <x-sampaui::dropdown-item icon="eye">Visualizar</x-sampaui::dropdown-item>
    <x-sampaui::dropdown-item icon="archive">Arquivar</x-sampaui::dropdown-item>
</x-sampaui::dropdown>
BLADE,
            ],
        ];

        return $components;
    }
}
