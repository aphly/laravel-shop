@include('laravel-shop-front::common.header')
<section class="container">
    <style>
        .title_p{margin-bottom: 5px;}
        .received{display: flex;}
        .received li{width: 100px;line-height: 40px;color: #333;border-radius: 6px;text-align: center;margin-right: 20px;border: 1px solid #f1f1f1;cursor: pointer;}
        .received li.active{background:var(--default-bg);color: #fff;}
        .service_action{align-items: center;margin-bottom: 10px;}
        .service_action label{margin-bottom: 0;line-height: 44px;cursor: pointer;}
        .service_action input{ height: 44px;margin-right: 10px;}
        .service_action>div{margin-right: 20px;}
        .service_product{margin-bottom: 20px;}
        .service_product li{margin-bottom: 10px;display: flex;justify-content: space-between; padding: 0 10px;}
        .serviceOrderOption{color: #999;display: flex;}
        .serviceOrderOption dd{margin-right: 10px;}
        .serviceOrderOptionx{display: flex;}
        .serviceOrderOptionx dd{margin-right: 10px;}
        .service_product1{display: flex;justify-content: space-between;align-items: center;}
        .service_product1 .quantity{}
        .service_product1 input[type="checkbox"]{ width: 20px; height: 20px;cursor: pointer;}
        .orderProductImg{width: 90px;height: 90px;margin-right: 10px;}
        .orderProductImg img{width: 100%;height: 100%;}
    </style>
    <div class="account_info">
        @include('laravel-common-front::account_ext.left_menu')
        <div class="account-main-section">
            <div class="order">
                <div class="top-desc d-flex justify-content-between">
                    <h2>Service</h2>
                </div>

                <div class="form-group">
                    <p class="title_p">Is received: <b>*</b></p>
                    <ul class="received">
                        <li value="1" class="active">Yes</li>
                        <li value="2">No</li>
                    </ul>
                </div>

                <form action="/account_ext/service/save?order_id={{$res['orderInfo']->id}}" method="post" class="form_request received1 received_form" data-fn="refund_res">
                    @csrf
                    <input type="hidden" name="is_received" value="2">
                    <input type="hidden" name="service_action_id" value="1">

                    <div class="form-group" >
                        <p class="title_p">Reason: <b>*</b></p>
                        <textarea name="reason" required class="form-control" style="height: 75px;">{{$res['info']->reason}}</textarea>
                    </div>
                    <div class="form-group d-flex">
                        <button class="btn-default save-address" type="submit">Request</button>
                    </div>
                </form>

                <form action="/account_ext/service/save?order_id={{$res['orderInfo']->id}}" method="post" class="form_request received2 received_form d-none" data-fn="return_res">
                    @csrf
                    <input type="hidden" name="is_received" value="1">
                    <div class="d-flex service_action">
                        <div class="d-flex">
                            <input type="radio" name="service_action_id" id="service_action_id_2" required checked value="2" class="form-control">
                            <label for="service_action_id_2">Return</label>
                        </div>
                        <div class="d-flex">
                            <input type="radio" name="service_action_id" id="service_action_id_3" required value="3" class="form-control">
                            <label for="service_action_id_3">Exchange</label>
                        </div>
                    </div>

                    <ul class="service_product">
                        @foreach($res['orderProduct'] as $val)
                        <li>
                            <div class="d-flex">
                                <div class="orderProductImg">
                                    <img src="{{$val->image}}" alt="">
                                </div>
                                <div class="service_product2">
                                    <div>{{$val->name}}</div>
                                    <dl class="serviceOrderOption">
                                        @if($val->orderOption)
                                            @foreach($val->orderOption as $v)
                                                <dd>{{$v->name}} : {{$v->value}}</dd>
                                            @endforeach
                                        @endif
                                    </dl>
                                    <dl class="serviceOrderOptionx">
                                        <dd>Quantity:{{$val->quantity}} </dd>
                                        <dd>Price:{{$val->price_format}}</dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="service_product1">
                                <div>
                                    <input type="checkbox" class="order_product_id" name="order_product[{{$val->id}}]" id="service_product_{{$val->id}}" checked value="{{$val->quantity}}">
                                </div>
                                <input type="number" class="quantity d-none" onblur="if(value<1){value=1}else if(value>={{$val->quantity}}){value={{$val->quantity}}}" value="{{$val->quantity}}">
                            </div>
                        </li>
                        @endforeach
                    </ul>

                    <div class="form-group">
                        <p class="title_p">Is opened: <b>*</b></p>
                        @if(isset($dict['shop_yes_no']))
                        <select name="is_opened" class="form-control">
                            @foreach($dict['shop_yes_no'] as $key=>$val)
                                <option value="{{$key}}" @if(($res['info']->is_opened??1)==$key) selected @endif>{{$val}}</option>
                            @endforeach
                        </select>
                        @endif
                    </div>

                    <div class="form-group" >
                        <p class="title_p">Reason: <b>*</b></p>
                        <textarea name="reason" required class="form-control" style="height: 75px;">{{$res['info']->reason}}</textarea>
                    </div>

                    <div class="form-group d-flex">
                        <button class="btn-default save-address" type="submit">Request</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</section>

<script>
    function refund_res(res,_this) {
        alert_msg(res,true)
    }

    function return_res(res,_this) {
        alert_msg(res,true)
    }

$(function () {
    $('.received').on('click','li',function () {
        $('.received li').removeClass('active')
        $(this).addClass('active')
        $('.received_form').addClass('d-none')
        $('.received'+$(this).val()).removeClass('d-none')
    })
    $('.service_product .quantity').on('input',function () {
        $(this).parent().find('.order_product_id').val($(this).val())
    })
})
</script>

@include('laravel-shop-front::common.footer')
