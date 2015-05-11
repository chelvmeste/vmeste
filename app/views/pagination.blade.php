@if ($paginator->getLastPage() > 1)

    <div class="pagination">
        <ul>

            @if ($paginator->getCurrentPage() > 1)
                <li>
                    <a href="{{ $paginator->getUrl($paginator->getCurrentPage() - 1) }}"><</a>
                </li>
            @endif
            <li>{{ $paginator->getCurrentPage() }} стр</li>
            @if ($paginator->getCurrentPage() < $paginator->getLastPage())
                <li>
                    <a href="{{ $paginator->getUrl($paginator->getCurrentPage() + 1) }}">></a>
                </li>
            @endif

        </ul>
        <div>всего {{ $paginator->getLastPage() }} стр</div>
    </div>

@endif
