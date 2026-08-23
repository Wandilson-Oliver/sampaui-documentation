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
                    <td class="doc-prop-name"><code>{{ $prop['name'] }}</code></td>
                    <td><span class="doc-prop-type-tag">{{ $prop['type'] }}</span></td>
                    <td class="doc-prop-default"><code>{{ $default }}</code></td>
                    <td class="doc-prop-notes">{{ $prop['notes'] }}</td>
                    <td class="doc-prop-example"><code>{{ $example }}</code></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
