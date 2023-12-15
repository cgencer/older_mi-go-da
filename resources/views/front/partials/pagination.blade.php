<div class="listing_pagination">
    <ul class="clearfix">
        {{-- @if ($paginator->onFirstPage())
            <li class="prev disabled">
                <a class="paginiaton-link"><i class="fa fa-caret-left"></i></a>
            </li>
        @else
            <li class="prev">
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="paginiaton-link"><i class="fa fa-caret-left"></i></a>
            </li>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="current"><a class="paginiaton-link">{{ $page }}</a></li>
                    @else
                        <li><a href="{{ $url }}" class="paginiaton-link">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li class="next">
                <a href="{{ $paginator->nextPageUrl() }}" class="paginiaton-link"><i class="fa fa-caret-right"></i></a>
            </li>
        @else
            <li class="next disabled">
                <a class="paginiaton-link"><i class="fa fa-caret-right"></i></a>
            </li>
        @endif --}}
    </ul>
</div>
