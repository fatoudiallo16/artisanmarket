@if ($paginator->hasPages())
    <nav class="am-pagination" aria-label="Pagination">
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
    </nav>
@endif
