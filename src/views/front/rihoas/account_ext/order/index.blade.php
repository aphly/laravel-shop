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
                                @if($val->orderStatus->id==1)
                                    <a href="/account_ext/order/pay?id={{$val->id}}">pay</a>
                                @endif
                                    <a href="/account_ext/order/detail?id={{$val->id}}">view</a>
                                @if($val->orderStatus->id==1)
                                    <form action="/account_ext/order/close?id={{$val->id}}" method="post" data-fn="close_res" class="form_request">
                                        @csrf
                                        <button type="submit">close</button>
                                    </form>
                                @endif
                                @if($val->orderStatus->id==2)
                                    <a href="javascript:void(0)" onclick="$('#cancelModal').modal('show')">cancel</a>
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

<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Order cancel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    Please be informed that a management, processing and transaction fee (20% of your total order value) will be applied for the cancellation.
                </div>
                <form action="/account_ext/order/cancel?id={{$val->id}}" method="post" data-fn="cancel_res" class="form_request">
                    @csrf
                    <button type="submit">cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>


<style>
    .list_index{padding: 0 10px;}
    .list_index li{display: flex;margin-bottom: 0;height: 40px;line-height: 40px;}
    .list_index li span{flex:1;}
    .list_index li span a{display: inline-block;background-color: var(--default-bg);padding:0 10px;color: #fff;border-radius: 4px;height: 30px;line-height: 30px;}
</style>

<script>
    function close_res(res,_this) {
        console.log(res)
        alert_msg(res)
    }

    function cancel_res(res,_this) {
        console.log(res)
        alert_msg(res)
    }
$(function () {

})
</script>
@include('laravel-shop-front::common.footer')
