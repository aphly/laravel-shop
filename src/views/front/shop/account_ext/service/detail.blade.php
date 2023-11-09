@include('laravel-shop-front::common.header')
<section class="container">
    <style>
        .service_detail{}
        .service_detail li{display: flex;justify-content: space-between;line-height: 26px;}
        .service_detail li>div:first-child{color: #999;}
        .detail{background: #fff;border-radius: 8px;padding: 15px;}
        .detail .btn{padding: 0px 10px; border-radius: 4px;border: 1px solid #333; line-height: 34px;}
        .order_detail_title {font-weight: 500; border-top: 1px solid #f1f1f1;padding-top: 15px;}
    </style>
    <div class="account_info">
        @include('laravel-common-front::account_ext.left_menu')
        <div class="account-main-section" style="background: transparent;">
            <div class="service_detail">
                <div class="top-desc d-flex justify-content-between">
                    <h2>Service Information</h2>
                </div>
                <div class="detail">
                    <dl class="my_product">
                        @foreach($res['serviceProduct'] as $val)
                            <dd class="d-flex">
                                <div class="my_product121">
                                    <a href="/product/{{$val->orderProduct->id}}"><img src="{{$val->orderProduct->image}}" alt=""></a>
                                </div>
                                <div class="my_product122">
                                    <div class="my_product12b wenzi"><a href="/product/{{$val->orderProduct->id}}">{{$val->orderProduct->name}}</a></div>
                                    <ul class="my_product122_ul d-flex">
                                        @foreach($val->orderProduct->orderOption as $v)
                                            <li style="margin-right: 10px;">{{$v['name']}} : {{$v['value']}}</li>
                                        @endforeach
                                    </ul>
                                    <div class="my_product12c">Qty: {{$val->quantity}}</div>
                                </div>
                            </dd>
                        @endforeach
                    </dl>
                </div>
                <div class="detail">
                    <ul class="service_detail">
                        <li><div>ID:</div><div>{{$res['info']->id}}</div></li>
                        <li><div>Date Added:</div><div>{{$res['info']->created_at}}</div></li>
                        <li><div>Reason:</div><div>{{$res['info']->reason}}</div></li>
                        @if($res['info']->service_action_id==1)
                            <li><div>Refund Amount ({{$res['info']->refund_fee}}% fee):</div><div>{{$res['info']->refund_amount_format}}</div></li>
                        @elseif($res['info']->service_action_id==2)
                            @if($res['info']->refund_amount)
                                <li><div>Actual refund:</div><div>{{$res['info']->refund_amount_format}}</div></li>
                            @else
                                <li><div>Maximum refund amount:</div><div>{{$res['info']->amount_format}}</div></li>
                            @endif
                        @endif
                        @if($res['info']->service_action_id==2)
                            @if($res['info']->service_status_id>=3)
                                <li><div>Name </div><div>{{$res['info']->service_name}}</div></li>
                                <li><div>Address </div><div>{{$res['info']->service_address}}</div></li>
                                <li><div>Postcode </div><div>{{$res['info']->service_postcode}}</div></li>
                                <li><div>Phone </div><div>{{$res['info']->service_phone}}</div></li>
                            @endif
                            @if($res['info']->service_status_id>=4)
                                <li><div>Express delivery name </div><div>{{$res['info']->c_shipping}}</div></li>
                                <li><div>Tracking number </div><div>{{$res['info']->c_shipping_no}}</div></li>
                            @endif
                        @endif
                    </ul>
                    @if($res['info']->img->count())
                        <ul class="service_upload" style="margin-top: 10px;">
                            @foreach($res['info']->img as $val)
                                <li>
                                    <img src="{{$val->image_src}}" alt="" style="width: 100px;height: 100px;">
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                @if($res['serviceHistory']->count())
                <div class="detail">
                    <div class="order_detail_title">
                        Service History
                    </div>
                    <dl class="my_step">
                        @foreach($res['serviceHistory'] as $val)
                            <dd class="">
                                <div class="my_step1">
                                    <div class="my_step11"></div>
                                    <div class="my_step12">{{$val->created_at}}</div>
                                </div>
                                <div class="my_step2">
                                    <div class="my_step22">
                                        <div class="my_step221 d-flex justify-content-between">
                                            <div>{{$dict['service_action'][$val->service_action_id]}}</div>
                                            <div >{{$dict[$dict['service_action'][$val->service_action_id].'_status'][$val->service_status_id]}}</div>
                                        </div>
                                        <div class="my_step222">{{$val->comment}}</div>
                                    </div>
                                </div>
                            </dd>
                        @endforeach
                    </dl>
                    @if($res['orderRefund']->count())
                    <dl class="my_step">
                        @foreach($res['orderRefund'] as $val)
                            <dd class="">
                                <div class="my_step1">
                                    <div class="my_step11"></div>
                                    <div class="my_step12">{{$val->created_at}}</div>
                                </div>
                                <div class="my_step2">
                                    <div class="my_step22">
                                        <div class="my_step221 d-flex justify-content-between">
                                            <div>{{$val->amount_format}}</div>
                                            <div class="">
                                                @if($val->cred_status)
                                                    {{$val->cred_status}}
                                                @else
                                                    Pending
                                                @endif
                                            </div>
                                        </div>

                                        <div class="my_step222">{{$val->reason}}</div>
                                    </div>
                                </div>
                            </dd>
                        @endforeach
                    </dl>
                    @endif
                </div>
                @endif

                <div >
                    @if($res['info']->service_action_id==1)
                        @if($res['info']->service_status_id==1)
                            <div class="">
                                If the merchant has not operated for more than 48 hours, the system will automatically refund
                            </div>
                        @elseif($res['info']->service_status_id==2)
                            <div class="">
                                <a href="/account_ext/service/del?id={{$res['info']->id}}" class="btn a_request del_style" data-fn="service_del_res" data-_token="{{csrf_token()}}">Delete</a>
                            </div>
                        @endif
                    @elseif($res['info']->service_action_id==2 )
                        @if($res['info']->service_status_id==1)
                        @elseif($res['info']->service_status_id==2)
                            <div class="">
                                <a href="/account_ext/service/del?id={{$res['info']->id}}" class="btn a_request del_style" data-fn="service_del_res" data-_token="{{csrf_token()}}">Delete</a>
                            </div>
                        @elseif($res['info']->service_status_id==3)
                            <div class="">
                                <form class="form_request service_detail_form" method="post" action="/account_ext/service/return_exchange3" data-fn="return_exchange3_res">
                                    @csrf
                                    <div>Express delivery information</div>
                                    <input type="hidden" name="service_id" value="{{$res['info']->id}}">
                                    <input type="hidden" name="service_action_id" value="{{$res['info']->service_action_id}}">
                                    <input type="text" name="c_shipping" class="form-control " placeholder="Express delivery name">
                                    <input type="text" name="c_shipping_no" class="form-control " placeholder="Tracking number">
                                    <button type="submit" class="account_btn">Shipped</button>
                                </form>
                            </div>
                        @elseif($res['info']->service_status_id==4)
                            <div class="">
                                <form class="form_request service_detail_form" method="post" action="/account_ext/service/return_exchange4" data-fn="return_exchange4_res">
                                    @csrf
                                    <div>Express delivery information</div>
                                    <input type="hidden" name="service_id" value="{{$res['info']->id}}">
                                    <input type="text" name="c_shipping" class="form-control " value="{{$res['info']->c_shipping}}">
                                    <input type="text" name="c_shipping_no" class="form-control " value="{{$res['info']->c_shipping_no}}">
                                    <button type="submit" class="account_btn">Shipped</button>
                                </form>
                            </div>
                        @elseif($res['info']->service_status_id==5)
                        @endif
                    @endif
                    @if($res['info']->service_action_id==3)
                    @endif
                </div>

            </div>
        </div>
    </div>
</section>
<style>
    .product img{width: 100px;height: 100px;}
    .service_detail_form{background: #fff;border-radius: 8px;}
    .service_detail_form input{margin: 10px 0}
</style>
<script>
    function service_del_res(res,that) {
        alert_msg(res,true)
    }
    function return_exchange3_res(res,that) {
        alert_msg(res,true)
    }
    function return_exchange4_res(res,that) {
        alert_msg(res,true)
    }
</script>
@include('laravel-shop-front::common.footer')
