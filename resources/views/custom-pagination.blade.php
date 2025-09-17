@if ($paginator->hasPages())
    <nav aria-label="Pagination Navigation" role="navigation">
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
            <!-- Results Info -->
            <div class="order-2 order-sm-1">
                <p class="text-muted mb-0 text-center text-sm-start">
                    <span class="fw-semibold">{{ $paginator->firstItem() }}</span> to 
                    <span class="fw-semibold">{{ $paginator->lastItem() }}</span> of 
                    <span class="fw-semibold">{{ $paginator->total() }}</span> products
                </p>
            </div>

            <!-- Pagination Links -->
            <div class="order-1 order-sm-2">
                <ul class="pagination mb-0">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link" title="Previous page">
                                <i class="bi bi-chevron-left"></i>
                                <span class="d-none d-md-inline ms-1">Previous</span>
                            </span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" title="Go to previous page">
                                <i class="bi bi-chevron-left"></i>
                                <span class="d-none d-md-inline ms-1">Previous</span>
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link">{{ $element }}</span>
                            </li>
                        @endif

                        {{-- Array Of Links --}}
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

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" title="Go to next page">
                                <span class="d-none d-md-inline me-1">Next</span>
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link" title="Next page">
                                <span class="d-none d-md-inline me-1">Next</span>
                                <i class="bi bi-chevron-right"></i>
                            </span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

    </nav>
@endif
