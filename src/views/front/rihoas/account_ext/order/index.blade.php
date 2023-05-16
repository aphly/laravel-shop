@include('laravel-shop-front::common.header')
<section class="container">
    <div class="account_info">
        @include('laravel-common-front::account_ext.left_menu')
        <div class="account-main-section" style="background: transparent;padding: 0;">
            <div class="">
                <div class="top-desc d-flex justify-content-between">
                    <h2>Order</h2>
                </div>
                <ul class="order_list">
                    @foreach($res['list'] as $val)
                        <li class="">
                            <div class="d-flex justify-content-between order_list11">
                                <div>OrderId#{{$val->id}}</div>
                                <div class="order_status">
                                    {{$val->orderStatus->name}}
                                </div>
                            </div>
                            <dl class="order_list12">
                                @foreach($val->orderProduct as $v)
                                <dd class="d-flex">
                                    <div class="order_list121">
                                        <a href="/product/{{$v->product_id}}"><img src="{{$v->image}}" alt=""></a>
                                    </div>
                                    <div class="order_list122">
                                        <a href="/product/{{$v->product_id}}"><div class="order_list12b wenzi">{{$v->name}}</div></a>
                                        <div class="order_list12c">Price: {{$v->price_format}}</div>
                                        <div class="order_list12c">Qty: {{$v->quantity}}</div>
                                    </div>
                                </dd>
                                @endforeach
                            </dl>
                            <div style="" class="order_list13">
                                <div style="color:#999;">{{$val->created_at}}</div>
                                <div>Payment: {{$val->total_format}}</div>
                            </div>
                            <div class="d-flex order_list14">
                                <a href="/account_ext/order/detail?id={{$val->id}}">detail</a>
                                @if($val->orderStatus->id==1)
                                    @if($val->payment_id)
                                        <a href="/account_ext/order/pay?id={{$val->id}}">pay</a>
                                    @endif
                                    <a href="/account_ext/order/close?id={{$val->id}}" data-fn="close_res" class="a_request" data-_token="{{csrf_token()}}">close</a>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div>
                    {{$res['list']->links('laravel-common-front::common.pagination')}}
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .order_list11{margin-bottom: 5px;}
    .order_list{}
    .order_list li{margin-bottom: 10px;background: #fff;padding: 15px;border-radius: 4px;}
    .order_status{color:#ffc107}
    .order_list img{width: 80px;height: 80px;margin-right: 20px;border-radius: 4px;}
    .order_list13{font-weight: 500;padding: 5px 0;display: flex;justify-content: space-between;}
    .order_list14{flex-direction: row-reverse;margin-top: 10px;}
    .order_list12c{font-size: 12px;color:#999;}
    .order_list14 a{display:block;padding:5px 10px;border-radius:4px;border:1px solid #f1f1f1;margin-left:20px}
    .order_list122{width: calc(100% - 100px);}
    .order_list12 dd{margin-bottom: 5px;}
    .order_list12b{font-weight: 500;margin-bottom: 5px;margin-top: 5px;}
</style>

<script>
    function close_res(res,_this) {
        alert_msg(res,true)
    }
    $(function () {

    })
</script>
@include('laravel-shop-front::common.footer')
