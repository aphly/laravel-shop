@include('laravel-shop-front::common.header')
<section class="container">
    <style>
        .order ul li{display: flex;margin-bottom: 5px;}
        .order ul li>div{flex: 1;display: flex;align-items: center;}
        .order .detail{margin-bottom: 20px;}
        .order .detail .title{margin-bottom: 5px;font-size: 16px;font-weight: 600}
        .order .detail .product{}
        .order .detail .product .option{display: flex;align-items: center;flex-wrap: wrap;width: 100%}
        .order .detail .product .option li{width: 100%;margin-bottom: 0}
        .order .detail .product img{width: 80px;height: 80px;margin-right: 10px;}
        .product_title{font-weight: 600;width: 100%;}
        .total_data li:last-child{font-weight: 600}
        .info_left{color:#777;}
        .product_total{flex-wrap: wrap;}
        .product_total p{width: 100%;}
        .total_format{text-decoration: line-through;font-size: 12px;color: #999;margin-left: 5px;}
    </style>
    <div class="account_info">
        @include('laravel-common-front::account_ext.left_menu')
        <div class="account-main-section">
            <div class="order">
                <div class="top-desc d-flex justify-content-between">
                    <h2>ORDER INFORMATION</h2>
                </div>
                <div class="detail">
                    <div class="title">The shipping details</div>
                    <ul>
                        <li style="color:#777;">
                            <div>Date Added</div>
                            <div>Order Status</div>
                            <div>Notes</div>
                        </li>
                        @if($res['orderHistory'])
                            @foreach($res['orderHistory'] as $val)
                                <li>
                                    <div>{{$val->created_at}}</div>
                                    <div>{{$val->orderStatus->name}}</div>
                                    <div>{{$val->comment}}</div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                @if($res['info']->order_status_id==1)
                    @if($res['info']->payment_id)
                        <a href="/account_ext/order/pay?id={{$res['info']->id}}" class="btn btn-primary">Pay</a>
                    @endif
                    <a href="/account_ext/order/close?id={{$res['info']->id}}" data-fn="close_res" class="a_request btn btn-primary" data-_token="{{csrf_token()}}">Close</a>
                @elseif($res['info']->order_status_id==2)
                    <div class="detail">
                        <a href="javascript:void(0)" onclick="cancel('{{$res['cancelAmountFormat']}}',{{$res['info']->id}})" class="btn btn-primary">Cancel</a>
                    </div>
                @elseif($res['info']->order_status_id==3)
                    <div class="detail">
                        <a href="/account_ext/service/form?order_id={{$val->order_id}}" class="btn btn-primary">Service</a>
                    </div>
                @elseif($res['info']->order_status_id==6)
                    <div class="detail">
                        <div class="title">The order refund</div>
                        <ul>
                            <li>
                                <div>Reason</div>
                                <div>Amount</div>
                                <div>Status</div>
                                <div>Date Added</div>
                            </li>
                            @if($res['orderRefund'])
                                @foreach($res['orderRefund'] as $val)
                                    <li>
                                        <div>{{$val->reason}}</div>
                                        <div>{{$val->amount_format}}</div>
                                        <div>
                                            @if($val->cred_status)
                                                {{$val->cred_status}}
                                            @else
                                                Pending
                                            @endif
                                        </div>
                                        <div>{{$val->created_at}}</div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                @endif
                <div class="detail">
                    <div class="title">The order details</div>
                    <ul>
                        <li><div class="info_left">Order ID:</div><div>{{$res['info']->id}}</div></li>
                        <li><div class="info_left">Date Added:</div><div>{{$res['info']->created_at}}</div></li>
                        <li><div class="info_left">Payment Method:</div><div>{{$res['info']->payment_method_name}}</div></li>
                        <li>
                            <div class="info_left">Shipping Address:</div><div>{{$res['info']->address_firstname}} {{$res['info']->address_lastname}},
                                {{$res['info']->address_address_1}} {{$res['info']->address_address_2}},
                                {{$res['info']->address_city}}, {{$res['info']->address_zone}}, {{$res['info']->address_country}},
                                {{$res['info']->address_postcode}}, {{$res['info']->address_telephone}}
                            </div>
                        </li>
                        <li><div class="info_left">Shipping Method:</div><div>{{$res['info']->shipping_name}}</div></li>
                        <li><div class="info_left">Shipping Tracking:</div><div>{{$res['info']->shipping_no??'-'}}</div></li>
                    </ul>
                </div>
                <div class="detail">
                    <div class="title">The order product</div>
                    <ul class="product">
                        <li>
                            <div>Product Name</div>
                            <div>Quantity</div>
                            <div>Price</div>
                            <div>Total</div>
                        </li>
                        @if($res['orderProduct'])
                            @foreach($res['orderProduct'] as $val)
                                <li>
                                    <div>
                                        <a style="display: flex;" href="/product/{{$val->product_id}}">
                                            <img src="{{$val->image}}">
                                            <div style="display: flex;align-items: center;">
                                                <div>
                                                    <div class="product_title wenzi">{{$val->name}}</div>
                                                    @if($val->orderOption)
                                                    <ul class="option">
                                                        @foreach($val->orderOption as $v)
                                                        <li>{{$v->name}} : {{$v->value}}</li>
                                                        @endforeach
                                                    </ul>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div>{{$val->quantity}}</div>
                                    <div>{{$val->price_format}}</div>
                                    <div class="product_total">
                                        @if($val->real_total_format==$val->total_format)
                                            <p >{{$val->real_total_format}} </p>
                                        @else
                                            <p >{{$val->real_total_format}} <span class="total_format"> {{$val->total_format}} </span></p>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                    <div>
                        @if($res['info']->orderTotal)
                        <ul class="total_data">
                            @foreach($res['info']->orderTotal as $val)
                            <li><div></div><div></div><div>{{$val->title}}</div><div>{{$val->value_format}}</div></li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
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
                    with in 24h {{$shop_setting['order_cancel_fee_24']}}% transaction fee <br>
                    Please be informed that a management, processing and transaction fee ({{$shop_setting['order_cancel_fee']}}% of your total order value) will be applied for the cancellation.
                </div>
                <div>
                    Refund <span class="cancelAmountFormat">0</span>
                </div>
                <form action="" method="post" data-fn="cancel_res" class="form_request">
                    @csrf
                    <button type="submit">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function close_res(res,_this) {
        alert_msg(res,true)
    }

    function cancel_res(res,_this) {
        alert_msg(res,true)
    }

    function cancel(cancelAmountFormat,order_id) {
        let  cancelModal = $('#cancelModal');
        cancelModal.find('.cancelAmountFormat').text(cancelAmountFormat);
        cancelModal.find('form').attr('action','/account_ext/order/cancel?id='+order_id);
        cancelModal.modal('show')
    }
$(function () {

})
</script>
@include('laravel-shop-front::common.footer')
