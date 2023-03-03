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

        .orderInfo li{display: flex;}
        .orderInfo li>div{margin-right: 20px;}
        .orderInfo li>div:first-child{width: 100px;}

        .service_action_ul{display: flex;}
        .service_action_ul li{width: 100px;line-height: 40px;color: #333;border-radius: 6px;text-align: center;margin-right: 20px;border: 1px solid #f1f1f1;cursor: pointer;}
        .service_action_ul li.active{background:var(--default-bg);color: #fff;}
    </style>
    <div class="account_info">
        @include('laravel-common-front::account_ext.left_menu')
        <div class="account-main-section">
            <div class="order">
                <div class="top-desc d-flex justify-content-between">
                    <h2>Service</h2>
                </div>

                <div style="margin-bottom: 20px;" class="orderInfo">
                    <h5>Order Info</h5>
                    <ul>
                        <li><div>Order id</div><div>{{$res['orderInfo']->id}}</div></li>
                        <li><div>Order Total</div><div>{{$res['orderInfo']->total_format}}</div></li>
                        <li><div>Order Status</div><div>{{$res['orderInfo']->orderStatus->name}}</div></li>
                        <li><div>Date Added</div><div>{{$res['orderInfo']->created_at}}</div></li>
                    </ul>
                </div>

                <div class="form-group">
                    <p class="title_p">Is received: <b>*</b></p>
                    <ul class="received">
                        <li value="2" class="active">Yes</li>
                        <li value="1" >No</li>
                    </ul>
                </div>

                <form action="/account_ext/service/save?order_id={{$res['orderInfo']->id}}" method="post" class="form_request received2 received_form " data-fn="return_res">
                    @csrf
                    <input type="hidden" name="is_received" value="1">
                    <input type="hidden" name="service_action_id" id="return_service_action_id" value="2">
                    <div class="d-flex service_action">
                        <ul class="service_action_ul">
                            <li value="2" class="active">Return</li>
                            @if($shop_setting['exchange']==1)
                            <li value="3">Exchange</li>
                            @endif
                        </ul>
                    </div>

                    <ul class="service_product" data-currency_code="{{$res['orderInfo']->currency_code}}">
                        @foreach($res['orderProduct'] as $val)
                        <li>
                            <div class="d-flex">
                                <input type="hidden" data-qty="{{$val->quantity}}" data-total="{{$val->total}}" class="order_product_id" name="order_product[{{$val->id}}]" id="service_product_{{$val->id}}" checked value="{{$val->quantity}}">
                                <div class="orderProductImg">
                                    <img src="{{$val->image}}" alt="">
                                </div>
                                <div class="service_product2">
                                    <div><a href="/product/{{$val->product_id}}">{{$val->name}}</a></div>
                                    <dl class="serviceOrderOption">
                                        @if($val->orderOption)
                                            @foreach($val->orderOption as $v)
                                                <dd>{{$v->name}} : {{$v->value}}</dd>
                                            @endforeach
                                        @endif
                                    </dl>
                                    <dl class="serviceOrderOptionx">
                                        <dd>Quantity:{{$val->quantity}} </dd>
                                        <dd>Payment:{{$val->real_total_format}}</dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="service_product1">
                                <div class="quantity-wrapper">
                                    <div class="quantity-down">-</div>
                                    <input type="number" class="form-control quantity_js"  onblur="if(value<0){value=0}else if(value>={{$val->quantity}}){value={{$val->quantity}}}" value="{{$val->quantity}}">
                                    <div class="quantity-up" data-max="{{$val->quantity}}">+</div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>

                    <div id="return_total">
                        <div class="d-flex">
                            <div>Refund Amount :</div>
                            <div class="return_total_js"></div>
                        </div>
                        <div>Refund amount does not include freight, and {{$shop_setting['service_return_fee']}}% service charge is deducted</div>
                    </div>

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

                <form action="/account_ext/service/save?order_id={{$res['orderInfo']->id}}" method="post" class="form_request received1 received_form d-none" data-fn="refund_res">
                    @csrf
                    <input type="hidden" name="is_received" value="2">
                    <input type="hidden" name="service_action_id" value="1">
                    <div id="refund_total">
                        <div class="d-flex">
                            <div>Refund Amount :</div>
                            <div class="refund_total_js">{{$res['refund_amount_format']}}</div>
                        </div>
                        <div>{{$shop_setting['service_return_fee']}}% service charge will be deducted from the refund amount</div>
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
    function return_price() {
        let service_type = $('#return_service_action_id').val();
        if(service_type==2){
            let return_total = 0;
            $('.service_product .order_product_id').each(function () {
                let that = $(this)
                return_total = return_total + new Decimal(that.data('total')).mul(that.val()).div(that.data('qty')).toNumber();
            })
            return_total = new Decimal(return_total).mul((100-{{$shop_setting['service_return_fee']}})/100).toFixed(2);
            $('.return_total_js').html(currency.format(return_total,$('.service_product').data('currency_code')))
        }else{
            $('.return_total_js').html('')
        }
    }

$(function () {
    $('.received').on('click','li',function () {
        $('.received li').removeClass('active')
        $(this).addClass('active')
        $('.received_form').addClass('d-none')
        $('.received'+$(this).val()).removeClass('d-none')
    })

    $('.service_action_ul').on('click','li',function () {
        $('.service_action_ul li').removeClass('active')
        $(this).addClass('active')
        let service_action_id = $(this).val()
        $('#return_service_action_id').val(service_action_id)
        if(service_action_id==2){
            $('#return_total').show()
        }else{
            $('#return_total').hide()
        }
    })

    $('.service_product .quantity_js').on('input',function () {
        $(this).closest('li').find('.order_product_id').val($(this).val())
    })

    $('.quantity-wrapper').on('click','.quantity-down', function (e) {
        let input = $(this).parent().find('input')
        let q_curr = parseInt(input.val());
        let quantity ;
        if(q_curr>0){
            quantity = q_curr-1
        }else{
            quantity = 0
        }
        input.val(quantity)
        $(this).closest('li').find('.order_product_id').val(quantity)
        return_price()
    })

    $('.quantity-wrapper').on('click','.quantity-up', function (e) {
        let max  = $(this).data('max');
        let input = $(this).parent().find('input')
        let q_curr = parseInt(input.val());
        let quantity ;
        if(q_curr<max){
            quantity = q_curr+1
        }else{
            quantity = q_curr
        }
        input.val(quantity)
        $(this).closest('li').find('.order_product_id').val(quantity)
        return_price()
    })
    return_price();
})
</script>

@include('laravel-shop-front::common.footer')
