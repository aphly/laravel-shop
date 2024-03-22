@include(config('base.view_namespace_front_blade').'::common.header')
<section class="container">
    <div class="account_info">
        @include(config('base.view_namespace_front_blade').'::account.left_menu')
        <div class="account-main-section" style="background: transparent;">
            <div class="">
                <div class="top-desc d-flex justify-content-between">
                    <h2>My Orders</h2>
                </div>
                <ul class="order_list">
                    @foreach($res['list'] as $val)
                        <li class="">
                            <a href="/account_ext/order/detail?id={{$val->id}}">
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
                                        <img src="{{$v->image}}" alt="">
                                    </div>
                                    <div class="order_list122">
                                        <div class="order_list12b wenzi">{{$v->name}}</div>
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
                            </a>
                            <div class="d-flex order_list14">
                                @if($val->orderStatus->id==1)
                                    <a href="/account_ext/order/close?id={{$val->id}}" data-fn="close_res" class="a_request del_style" data-_token="{{csrf_token()}}">Close</a>
                                @endif
                                    <a href="/account_ext/order/detail?id={{$val->id}}">Detail</a>
                                @if($val->orderStatus->id==1)
                                    @if($val->payment_id && $val->payment_method_name!='stripeCard')
                                        <a href="/account_ext/order/pay?id={{$val->id}}">Pay</a>
                                    @endif
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div>
                    {{$res['list']->links()}}
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .order_list11{margin-bottom: 5px;}
    .order_list{}
    .order_list li{margin-bottom: 10px;background: #fff;padding: 15px;border-radius: 4px;border-bottom: 1px solid #f1f1f1;}
    .order_status{color:#ffc107}
    .order_list img{width: 70px;height: 70px;margin-right: 20px;border-radius: 4px;}
    .order_list13{font-weight: 500;padding: 5px 0;display: flex;justify-content: space-between;}
    .order_list14{flex-direction: row-reverse;margin-top: 10px;}
    .order_list14 a{display:block;padding:0px 10px;border-radius:4px;border:1px solid #333;margin-left:20px;line-height: 34px;}
    .order_list12c{font-size: 12px;color:#999;}
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
@include(config('base.view_namespace_front_blade').'::common.footer')
