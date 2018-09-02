@if ($paginator->hasPages())
    <ul class="pagination align-items-center" role="navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span class="btn btn-disabled" aria-hidden="true">
                    Назад
                </span>
            </li>
        @else
            <li>
                <a class="btn btn-dark" href="{{ $paginator->previousPageUrl() }}" rel="prev"
                   aria-label="@lang('pagination.previous')">Назад</a>
            </li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="mr-3 ml-1">
                <a class="btn btn-dark" href="{{ $paginator->nextPageUrl() }}" rel="next"
                   aria-label="@lang('pagination.next')">Вперед</a>
            </li>
        @else
            <li class="disabled mr-3 ml-1" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span class="btn btn-disabled" aria-hidden="true">Вперед</span>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled" aria-disabled="true"><span class="btn">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active" aria-current="page"><span class="btn btn-dark">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item"><a class="btn" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach
    </ul>
@endif
