@include('laravel-shop-front::common.header')
<section class="container">
    <style>
        .service_detail ul li{display: flex;margin-bottom: 5px;}
        .service_detail ul li>div{flex: 1;display: flex;align-items: center;}
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
                    <ul>
                        <li style="color:#777;">
                            <div>Service Action</div>
                            <div>Service Status</div>
                            <div>Notes</div>
                            <div>Date Added</div>
                        </li>
                        @if($res['serviceHistory'])
                            @foreach($res['serviceHistory'] as $val)
                                <li>
                                    <div>{{$dict['service_action'][$val->service_action_id]}}</div>
                                    <div>
                                        {{$dict[$dict['service_action'][$val->service_action_id].'_status'][$val->service_status_id]}}
                                    </div>
                                    <div>{{$val->comment}}</div>
                                    <div>{{$val->created_at}}</div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
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
                @elseif($res['info']->service_action_id==2 || $res['info']->service_action_id==3)
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
                        <form class="form_request" method="post" action="/account_ext/service/return_exchange3" data-fn="return_exchange3_res">
                            @csrf
                            <input type="hidden" name="service_id" value="{{$res['info']->id}}">
                            <input type="hidden" name="service_action_id" value="{{$res['info']->service_action_id}}">
                            <input type="hidden" name="service_status_id" value="1">
                            <textarea name="comment"></textarea>
                            <button type="submit">Request</button>
                        </form>
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

                <div class="detail">
                    <div class="title">The service details</div>
                    <ul>
                        <li><div>ID:</div><div>{{$res['info']->id}}</div></li>
                        <li><div>Date Added:</div><div>{{$res['info']->created_at}}</div></li>
                        <li><div>Reason:</div><div>{{$res['info']->reason}}</div></li>
                    </ul>
                </div>

                <div class="product">
                    <div class="title">The service details</div>
                    @if($res['serviceProduct'])
                        <ul>
                            @foreach($res['serviceProduct'] as $val)
                                <li>
                                    <img src="{{$val->orderProduct->image}}" alt="">{{$val->orderProduct->name}}
                                    {{$val->quantity}}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

            </div>
        </div>
    </div>
</section>
<style>
    .product img{width: 100px;height: 100px;}
</style>
<script>
    function refund3_res(res,_this) {
        console.log(res,_this)
    }
    function return_exchange2_res(res,_this) {
        console.log(res,_this)
    }
    function return_exchange3_res(res,_this) {
        console.log(res,_this)
    }
    function return_exchange4_res(res,_this) {
        console.log(res,_this)
    }
$(function () {

})
</script>
@include('laravel-shop-front::common.footer')
