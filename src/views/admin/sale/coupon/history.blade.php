<div class="top-bar">
    <h5 class="nav-title">coupon history </h5>
</div>
<style>

</style>
<div class="imain">
    <div class="table_scroll">
        <div class="table">
            <ul class="table_header">
                <li >订单号</li>
                <li >用户名</li>
                <li >合计</li>
                <li >时间</li>
            </ul>
            @if($res['list']->total())
                @foreach($res['list'] as $v)
                <ul class="table_tbody">
                    <li>{{$v['order_id']}}</li>
                    <li>{{ $v['uuid'] }}</li>
                    <li>
                        {{$v->amount}}
                    </li>
                    <li>
                        {{$v->date_add?date('Y-m-d H:i:s',$v->date_add):''}}
                    </li>
                </ul>
                @endforeach
                <ul class="table_bottom">
                    <li></li>
                    <li >
                        {{$res['list']->links('laravel::admin.pagination')}}
                    </li>
                </ul>
            @endif
        </div>
    </div>
</div>


