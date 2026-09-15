@if ($paginator->hasPages())
    <ul class="pagination_last">
        @php
            $current = $paginator->currentPage();
            $last = $paginator->lastPage();
            $onEachSide = 1;
            $start = max(1, $current - $onEachSide);
            $end = min($last, $current + $onEachSide);
        @endphp

        @if($start > 1)
            <li class="page_item">
                <a class="page_link" href="{{ $paginator->url(1) }}" >1</a>
            </li>
            @if($start >2)
                <li class="page_dot">...</li>
            @endif
        @endif

        @for($i = $start; $i <= $end; $i++)
            @if($i == $current)
                <li class="page_item active">
                    <span class="page_link ">{{$i}}</span>
                </li>
            @else
                <li class="page_item">
                    <a class="page_link" href="{{ $paginator->url($i) }}">{{$i}}</a>
                </li>
            @endif
        @endfor

        @if($end < $last)
            @if($end < $last -1)
                <li class="page_dot">...</li>
            @endif
                <li class="page_item">
                    <a class="page_link" href="{{ $paginator->url($last) }}">{{$last}}</a>
                </li>
        @endif
    </ul>
@endif
<style>
    .pagination_last{margin-top:10px;display:flex;justify-content:center;padding-left:0;border-radius:8px;flex-wrap:wrap;width:100%;list-style:none}
    .pagination_last .page_item{margin:0 4px;width:40px;height:40px}
    .pagination_last .page_link{color:#333;border-radius:4px;display:block;width:100%;height:100%;line-height:40px;text-align:center;background-color:#fff;border:1px solid #dee2e6}
    .pagination_last .page_item.active .page_link{border-color:var(--btn_bg);background-color:var(--btn_bg);color:#fff}
    .page_dot{width:40px;height:40px;text-align: center; line-height: 40px;}
</style>
