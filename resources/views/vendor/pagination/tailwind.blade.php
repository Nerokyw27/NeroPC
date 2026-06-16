@if ($paginator->hasPages())
    <nav class="custom-pagination" role="navigation" aria-label="{{ __('Pagination Navigation') }}">
        <div class="pagination-info">
            <p>
                {!! __('Showing') !!}
                @if ($paginator->firstItem())
                    <span>{{ $paginator->firstItem() }}</span>
                    {!! __('to') !!}
                    <span>{{ $paginator->lastItem() }}</span>
                @else
                    {{ $paginator->count() }}
                @endif
                {!! __('of') !!}
                <span>{{ $paginator->total() }}</span>
                {!! __('results') !!}
            </p>
        </div>

        <div class="pagination-links">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="page-item disabled" aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                    <span aria-hidden="true">&lsaquo;</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="page-item" rel="prev" aria-label="{{ __('pagination.previous') }}">&lsaquo;</a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="page-item disabled" aria-disabled="true">
                        <span>{{ $element }}</span>
                    </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="page-item active" aria-current="page">
                                <span>{{ $page }}</span>
                            </span>
                        @else
                            <a href="{{ $url }}" class="page-item" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="page-item" rel="next" aria-label="{{ __('pagination.next') }}">&rsaquo;</a>
            @else
                <span class="page-item disabled" aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                    <span aria-hidden="true">&rsaquo;</span>
                </span>
            @endif
        </div>
    </nav>
@endif
