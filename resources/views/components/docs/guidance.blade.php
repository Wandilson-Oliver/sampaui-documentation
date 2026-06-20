@props(['guidance'])

<div class="doc-guidance-grid">
    <article class="doc-guidance-card doc-guidance-positive">
        <span class="doc-severity-icon"><i class="bi bi-check2-circle" aria-hidden="true"></i></span>
        <div>
            <h3>Quando usar</h3>
            <ul>
                @foreach ($guidance['use'] as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>
    </article>

    <article class="doc-guidance-card doc-guidance-neutral">
        <span class="doc-severity-icon"><i class="bi bi-slash-circle" aria-hidden="true"></i></span>
        <div>
            <h3>Quando não usar</h3>
            <ul>
                @foreach ($guidance['avoid'] as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>
    </article>

    <article class="doc-guidance-card doc-guidance-warning">
        <span class="doc-severity-icon"><i class="bi bi-exclamation-triangle" aria-hidden="true"></i></span>
        <div>
            <h3>Erros comuns</h3>
            <ul>
                @foreach ($guidance['errors'] as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>
    </article>
</div>
