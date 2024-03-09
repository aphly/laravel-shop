@Linclude('laravel-front::common.header')
<section class="container">
    <style>
        .order_product .option{display: flex;align-items: center;flex-wrap: wrap;width: 100%}
        .order_product .option li{width: 100%;margin-bottom: 0}
        .order_product img{width: 70px;height: 70px;margin-right: 10px;}
        .product_total p{width: 100%;}
        .cancel_btn{border:none;background: #ffd539;color:#333;border-radius: 4px;font-weight: 600;}
        .cancel2{margin-bottom: 20px;margin-top: 20px;}
        .order_product21{font-size: 16px;}
        .order_product1{width: 80px;}
        .order_product2{width: calc(100% - 155px);margin-left: 10px;margin-right: 5px}
        .order_product3{width: 60px;color:#999;text-align: right;}
        .order_product22{color:#999;}
        .order_total li{display: flex;justify-content: space-between;margin-bottom: 5px;}
        .order_product dd{margin-bottom: 5px;}

        .orderHistory{padding: 5px 0;}
        .orderHistory li{margin-bottom: 5px;}

        .order_info{border-top: 1px solid #f1f1f1;padding: 15px 0;}
        .order_info li{display: flex;justify-content: space-between;margin-bottom: 5px;}
        .order_info li .info_left{width: 46%;flex-shrink: 0;color: #666;}
        .order_btns{margin: 15px 0;display: flex;}
        .orderHistory1{display: flex;line-height: 30px;color: #999;align-items: center;}
        .orderHistory11{background: #999;border-radius: 50%;width: 10px;height: 10px;margin: 5px;}
        .orderHistory22{padding-left: 10px; margin-left: 10px;border-left: 1px solid #999;margin-bottom: 10px;}
        .order_detail_title{font-weight: 500;border-top: 1px solid #f1f1f1; padding-top: 15px;}
    </style>
    <div class="account_info">
        @Linclude('laravel-front::account.left_menu')
        <div class="account-main-section">
            <div class="order">
                <div class="top-desc d-flex justify-content-between">
                    <h2>Order Information</h2>
                </div>
                <div class="detail">
                    <div></div>
                    <dl class="order_product">
                        @foreach($res['orderProduct'] as $val)
                            <dd class="d-flex">
                                <div class="order_product1">
                                    <a href="/product/{{$val->product_id}}"><img src="{{$val->image}}" alt=""></a>
                                </div>
                                <div class="order_product2">
                                    <a href="/product/{{$val->product_id}}">
                                        <div class="order_product21 wenzi">{{$val->name}}</div>
                                    </a>
                                    @if($val->orderOption)
                                        <ul class="option order_product22">
                                            @foreach($val->orderOption as $v)
                                                <li>{{$v->name}} : {{$v->value}}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                <div class="order_product3">
                                    <div class="order_product23">{{$val->price_format}}</div>
                                    <div class="order_product24">×{{$val->quantity}}</div>
                                </div>
                            </dd>
                        @endforeach
                    </dl>
                    <div>
                        @if($res['info']->orderTotal)
                            <ul class="order_total">
                                @foreach($res['info']->orderTotal as $val)
                                    <li>
                                        <div>{{$val->title}}</div>
                                        <div>{{$val->value_format}}</div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                <div class="detail">
                    <ul class="order_info">
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
                    <div class="order_detail_title">
                        Order History
                    </div>
                    <ul class="orderHistory">
                        @if($res['orderHistory'])
                            @foreach($res['orderHistory'] as $val)
                                <li class=" ">
                                    <div class="orderHistory1">
                                        <div class="orderHistory11"></div>
                                        <div class="orderHistory12">{{$val->created_at}}</div>
                                    </div>
                                    <div class="orderHistory2">
                                        <div class="orderHistory22">
                                            <div class="orderHistory221">{{$val->orderStatus->name}}</div>
                                            <div class="orderHistory222">{{$val->comment}}</div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @endif
                        @if($res['orderRefund'])
                            @foreach($res['orderRefund'] as $val)
                                <li class="">
                                    <div class="orderHistory1">
                                        <div class="orderHistory11"></div>
                                        <div class="orderHistory12">{{$val->created_at}}</div>
                                    </div>
                                    <div class="orderHistory2">
                                        <div class="orderHistory22">
                                            <div class="orderHistory221 d-flex justify-content-between">
                                                <div class="orderRefund1a">
                                                    {{$val->amount_format}}
                                                </div>
                                                <div class="orderRefund1b">
                                                    @if($val->cred_status)
                                                        {{$val->cred_status}}
                                                    @else
                                                        Pending
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="orderHistory222">{{$val->reason}}</div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>

                </div>

                <div class="order_btns">
                    @if($res['info']->order_status_id==1)
                        @if($res['info']->payment_method_name=='stripeCard' && $res['info']->payment_id)

                        @else
                            @if($res['info']->payment_id)
                                <a href="/account_ext/order/pay?id={{$res['info']->id}}" class="account_btn">Pay</a>
                            @endif
                        @endif
                        <a href="/account_ext/order/close?id={{$res['info']->id}}" data-fn="close_res" class="a_request account_btn" data-_token="{{csrf_token()}}">Close</a>
                    @elseif($res['info']->order_status_id==2)
                        <a href="javascript:void(0)" onclick="cancel('{{$res['cancelAmountFormat']}}',{{$res['info']->id}})" class="account_btn">Cancel</a>
                    @elseif($res['info']->order_status_id==3)
                        <a href="/account_ext/service/form?order_id={{$val->order_id}}" class="account_btn">Service</a>
                    @endif
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
                <div class="cancel1">
                    <p>Please note that the cancellation of the order will be charged with management fee,
                        processing fee and transaction fee, {{$shop_config['order_cancel_fee_24']}}% of the transaction fee will be charged within 24 hours,
                        and {{$shop_config['order_cancel_fee']}}% of the transaction fee will be charged over 24 hours</p>
                </div>
                <div class="cancel2">
                    Refund <span class="cancelAmountFormat">0</span>
                </div>
                <form action="/account_ext/order/cancel?id={{$res['info']->id}}" method="post" data-fn="cancel_res" class="form_request cancel3">
                    @csrf
                    <div class="d-flex flex-row-reverse">
                        <button type="submit" class="cancel_btn btn" style="">Cancel</button>
                    </div>
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
        //cancelModal.find('form').attr('action','/account_ext/order/cancel?id='+order_id);
        cancelModal.modal('show')
    }
$(function () {

})
</script>
@Linclude('laravel-front::common.footer')
