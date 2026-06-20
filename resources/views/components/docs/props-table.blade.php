@props(['props' => []])

<div class="doc-props-table-wrap">
    <table class="doc-props-table">
        <thead>
            <tr>
                <th>Prop</th>
                <th>Tipo</th>
                <th>Default</th>
                <th>Descrição</th>
                <th>Exemplo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($props as $prop)
                @php
                    $default = $prop['default'] ?? '-';
                    $example = $prop['example'] ?? match (true) {
                        $default !== '-' && $default !== 'null' => $default,
                        str_contains($prop['type'] ?? '', 'bool') => $prop['name'],
                        default => $prop['name'].'="..."',
                    };
                @endphp
                <tr>
                    <td><code>{{ $prop['name'] }}</code></td>
                    <td>{{ $prop['type'] }}</td>
                    <td><code>{{ $default }}</code></td>
                    <td>{{ $prop['notes'] }}</td>
                    <td><code>{{ $example }}</code></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
