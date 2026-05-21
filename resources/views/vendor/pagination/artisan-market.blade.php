@if ($paginator->hasPages())
    <nav class="am-pagination" aria-label="Pagination du catalogue">
        <ul class="pagination am-pagination-list mb-0">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link am-page-nav">
                        <span class="am-page-nav-icon" aria-hidden="true">←</span>
                        <span>Précédent</span>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link am-page-nav" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <span class="am-page-nav-icon" aria-hidden="true">←</span>
                        <span>Précédent</span>
                    </a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link am-page-nav" href="{{ $paginator->nextPageUrl() }}" rel="next">
                        <span>Suivant</span>
                        <span class="am-page-nav-icon" aria-hidden="true">→</span>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link am-page-nav">
                        <span>Suivant</span>
                        <span class="am-page-nav-icon" aria-hidden="true">→</span>
                    </span>
                </li>
            @endif
        </ul>
        <p class="am-pagination-summary">
            {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} sur {{ $paginator->total() }} produits
        </p>
    </nav>
@endif
