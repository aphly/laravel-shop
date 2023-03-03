@include('laravel-shop-front::common.header')
<section class="container">
    <style>
        .service_detail ul li{display: flex;margin-bottom: 5px;}
        .service_detail ul li>div{flex: 1;display: flex;align-items: center;}
        .service_detail dl .li_top{display: flex;margin-bottom: 5px;}
        .service_detail dl .li_top>div{flex: 1;display: flex;align-items: center;}
    </style>
    <div class="account_info">
        @include('laravel-common-front::account_ext.left_menu')
        <div class="account-main-section">
            <div class="service_detail">
                <div class="top-desc d-flex justify-content-between">
                    <h2>Service</h2>
                </div>
                <div class="detail">
                    <div class="title">The service details</div>
                    <dl>
                        <dd style="color:#777;">
                            <div class="li_top">
                                <div>Service Action</div>
                                <div>Service Status</div>
                                <div>Date Added</div>
                            </div>
                        </dd>
                        @if($res['serviceHistory'])
                            @foreach($res['serviceHistory'] as $val)
                                <dd>
                                    <div class="li_top">
                                        <div>{{$dict['service_action'][$val->service_action_id]}}</div>
                                        <div>
                                            {{$dict[$dict['service_action'][$val->service_action_id].'_status'][$val->service_status_id]}}
                                        </div>
                                        <div>{{$val->created_at}}</div>
                                    </div>
                                    <div class="">
                                        <div>{{$val->comment}}</div>
                                    </div>
                                </dd>
                            @endforeach
                        @endif
                    </dl>
                </div>

                @if($res['info']->service_action_id==1)
                    @if($res['info']->service_status_id==1)
                    @elseif($res['info']->service_status_id==2)
                    @elseif($res['info']->service_status_id==3)
                        <form class="form_request" method="post" action="/account_ext/service/refund3" data-fn="refund3_res">
                            @csrf
                            <input type="hidden" name="service_id" value="{{$res['info']->id}}">
                            <input type="hidden" name="service_action_id" value="{{$res['info']->service_action_id}}">
                            <input type="hidden" name="service_status_id" value="1">
                            <textarea name="comment"></textarea>
                            <button type="submit">Request</button>
                        </form>
                    @elseif($res['info']->service_status_id==4)
                    @elseif($res['info']->service_status_id==5)
                    @endif
                @elseif($res['info']->service_action_id==2 && $res['info']->service_action_id==3)
                    @if($res['info']->service_status_id==1)
                    @elseif($res['info']->service_status_id==2)
                        <form class="form_request" method="post" action="/account_ext/service/return_exchange2" data-fn="return_exchange2_res">
                            @csrf
                            <input type="hidden" name="service_id" value="{{$res['info']->id}}">
                            <input type="hidden" name="service_action_id" value="{{$res['info']->service_action_id}}">
                            <input type="text" name="c_shipping" value="c_shipping">
                            <input type="text" name="c_shipping_no" value="c_shipping_no">
                            <button type="submit">Shipping</button>
                        </form>
                    @elseif($res['info']->service_status_id==3)
                        <div>Please delete and reapply</div>
                        <a href="/account_ext/service/del?id={{$val->id}}" class="btn a_request" data-fn="return_exchange3_res" data-_token="{{csrf_token()}}">del</a>
                    @elseif($res['info']->service_status_id==4)
                        <form class="form_request" method="post" action="/account_ext/service/return_exchange4" data-fn="return_exchange4_res">
                            @csrf
                            <input type="hidden" name="service_id" value="{{$res['info']->id}}">
                            <input type="text" name="c_shipping" value="{{$res['info']->c_shipping}}">
                            <input type="text" name="c_shipping_no" value="{{$res['info']->c_shipping_no}}">
                            <button type="submit">Shipping</button>
                        </form>
                    @elseif($res['info']->service_status_id==5)
                    @endif
                @endif
                @if($res['info']->service_action_id==3)

                @endif

                <div class="detail">
                    <div class="title">The service details</div>
                    <ul>
                        <li><div>ID:</div><div>{{$res['info']->id}}</div></li>
                        <li><div>Date Added:</div><div>{{$res['info']->created_at}}</div></li>
                        <li><div>Reason:</div><div>{{$res['info']->reason}}</div></li>
                        @if($res['info']->service_action_id==1)
                            <li><div>Refund Amount ({{$shop_setting['service_refund_fee']}}% fee):</div><div>{{$res['info']->refund_amount_format}}</div></li>
                        @elseif($res['info']->service_action_id==2)
                            <li><div>Refund Amount ({{$shop_setting['service_return_fee']}}% fee):</div><div>{{$res['info']->refund_amount_format}}</div></li>
                        @endif
                        @if($res['info']->service_action_id==2 || $res['info']->service_action_id==3)
                            <li><div>name </div><div>{{$shop_setting['service_name']}}</div></li>
                            <li><div>address </div><div>{{$shop_setting['service_address']}}</div></li>
                            <li><div>postcode </div><div>{{$shop_setting['service_postcode']}}</div></li>
                            <li><div>phone </div><div>{{$shop_setting['service_phone']}}</div></li>
                        @endif

                        <li><div>c_shipping </div><div>{{$res['info']->c_shipping}}</div></li>
                        <li><div>c_shipping_no </div><div>{{$res['info']->c_shipping_no}}</div></li>
                    </ul>
                </div>

                <div class="product">
                    <div class="title">The service details</div>
                    @if($res['serviceProduct'])
                        <ul>
                            @foreach($res['serviceProduct'] as $val)
                                <li>
                                    <img src="{{$val->orderProduct->image}}" alt="">
                                    <div><a href="/product/{{$val->orderProduct->product_id}}">{{$val->orderProduct->name}}</a></div>
                                    <div>{{$val->quantity}}</div>
                                    <div>{{$val->total_format}}</div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="detail">
                    <div class="title">Refund</div>
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

            </div>
        </div>
    </div>
</section>
<style>
    .product img{width: 100px;height: 100px;}
</style>
<script>
    function refund3_res(res,that) {
        console.log(res,that)
    }

    function return_exchange2_res(res,that) {
        console.log(res,that)
    }

    function return_exchange3_res(res,that) {
        alert_msg(res,true)
    }

    function return_exchange4_res(res,that) {
        console.log(res,that)
    }

</script>
@include('laravel-shop-front::common.footer')
