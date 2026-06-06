<div class="space-y-4">
    <x-sampaui::input
        name="customer_email"
        type="email"
        label="Email do cliente"
        placeholder="voce@empresa.com"
    />

    <x-sampaui::input
        name="customer_phone"
        type="tel"
        label="Telefone"
        value="(11) 99999-0000"
    />

    <x-sampaui::input
        name="document"
        label="Documento"
        error="Nao foi possivel validar o documento informado."
    />
</div>
