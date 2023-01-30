@include('laravel-shop-front::common.header')
<section class="container">
    <div class="account_info">
        @include('laravel-common-front::account_ext.left_menu')
        <div class="account-main-section">
            <div class="">
                <div class="top-desc d-flex justify-content-between">
                    <h2>Order</h2>
                </div>
                <ul class="list_index">
                    <li>
                        <span>Order ID</span>
                        <span>No. of Products</span>
                        <span>Total</span>
                        <span>Order Status</span>
                        <span>Date Added</span>
                        <span>Option</span>
                    </li>
                    @foreach($res['list'] as $val)
                        <li class="">
                            <span>{{$val->id}}</span>
                            <span>{{$val->items}}</span>
                            <span>{{$val->total_format}}</span>
                            <span>{{$val->orderStatus->name}}</span>
                            <span>{{$val->created_at}}</span>
                            <span>
                                    <a href="/account_ext/order/detail?id={{$val->id}}">view</a>
                                @if($val->orderStatus->id==1)
                                    @if($val->payment_id)
                                    <a href="/account_ext/order/pay?id={{$val->id}}">pay</a>
                                    @endif
                                    <a href="/account_ext/order/close?id={{$val->id}}" data-fn="close_res" class="a_request" data-_token="{{csrf_token()}}">close</a>
                                @endif
                            </span>
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
    .list_index{padding: 0 10px;}
    .list_index li{display: flex;margin-bottom: 10px;height: 40px;line-height: 40px;}
    .list_index li span{flex:1;}
    .list_index li span a{display: inline-block;background-color: var(--default-bg);padding:0 10px;color: #fff;border-radius: 4px;height: 30px;line-height: 30px;}
</style>

<script>
    function close_res(res,_this) {
        alert_msg(res,true)
    }


$(function () {

})
</script>
@include('laravel-shop-front::common.footer')
