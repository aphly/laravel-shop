@Linclude('laravel-front::common.header')
<section class="container">
    <style>
        .title_p{margin-bottom: 5px;}

        .received li{width: 48%;line-height: 34px;color: #333;border-radius: 6px;text-align: center;border: 1px solid #f1f1f1;cursor: pointer;}
        .received li.active{color: var(--btn_bg);border: 1px solid var(--btn_bg);}
        .service_action{align-items: center;background: #fff;padding:15px; border-radius: 8px;}
        .service_action label{margin-bottom: 0;line-height: 44px;cursor: pointer;}
        .service_action input{ height: 44px;margin-right: 10px;}
        .service_action>div{margin-right: 20px;}
        .service_action>h5{margin-bottom: 10px;}
        .service_product{margin-bottom: 20px;}
        .service_product li{margin-bottom: 10px; }
        .serviceOrderOption{color: #999;display: flex;}
        .serviceOrderOption dd{margin-right: 10px;}
        .serviceOrderOptionx{}
        .serviceOrderOptionx dd{margin-right: 10px;}
        .service_product1 input[type="checkbox"]{ width: 20px; height: 20px;cursor: pointer;}
        .orderProductImg{width: 90px;height: 90px;margin-right: 10px;}
        .orderProductImg img{width: 100%;height: 100%;}

        .orderInfo{background: #fff;padding:15px; border-radius: 8px;margin-bottom: 10px;}
        .orderInfo li{display: flex;}
        .orderInfo li>div{margin-right: 20px;}
        .orderInfo li>div:first-child{width: 100px;color:#666;}

        .service_action_ul{display: flex;justify-content: space-between;}
        .service_action_ul li{flex:1;color: #333;border-radius: 6px;text-align: center;border: 1px solid #f1f1f1;cursor: pointer;margin: 0 10px;padding:10px 0;display: flex;justify-content: center;align-items: center;}
        .service_action_ul li.active{color: var(--btn_bg);border: 1px solid var(--btn_bg);}
        .quantity-wrapper div, .quantity-wrapper input{height: 30px;line-height: 30px;width: 30px; min-width: 30px;padding: 0;}
        .service_action_ul_res li{display: none;}
        .service_action_ul_res li.active{display: block;color: var(--btn_bg);}
        .service_action_ul_res{ line-height: 26px;margin-top: 5px;padding: 0 10px;}
        .service_form{margin-bottom: 10px;background: #fff;padding:15px; border-radius: 8px;}
        .service_product2{width:calc(100% - 100px);}

        .refund_total2,.return_total2{font-size: 12px;color: #999;margin-top: 5px;}
        #refund_total,#return_total{margin-bottom: 10px;}
        .refund_total_js,.return_total_js{font-weight: 600;}
        .serviceOrderOptions{font-weight: 600;line-height: 26px;}
        .file_img img{width: 80px;height: 80px;margin-right: 10px;}
    </style>
    <div class="account_info">
        @include('larave-front::account_ext.left_menu')
        <div class="account-main-section" style="background: transparent;">
            <div class="order">
                <div class="top-desc d-flex justify-content-between">
                    <h2>Service</h2>
                </div>

                <div style="" class="orderInfo">
                    <ul>
                        <li><div>Order id</div><div>{{$res['orderInfo']->id}}</div></li>
                        <li><div>Order Total</div><div>{{$res['orderInfo']->total_format}}</div></li>
                        <li><div>Order Status</div><div>{{$res['orderInfo']->orderStatus->name}}</div></li>
                        <li><div>Date Added</div><div>{{$res['orderInfo']->created_at}}</div></li>
                    </ul>
                </div>

                <div class="service_action">
                    <h5 >Please select the after-sales type</h5>
                    <ul class="service_action_ul">
                        <li value="1" class="active">
                            <div>
                                <div>Refund Only</div>
                                <div style="font-size: 12px;">(Unreceived goods)</div>
                            </div>
                        </li>
                        <li value="2" >
                            <div>
                                <div>Return</div>
                                <div style="font-size: 12px;">(Received goods)</div>
                            </div>
                        </li>
                    </ul>
                </div>

                <form action="/account_ext/service/save?order_id={{$res['orderInfo']->id}}" method="post" class="form_request received1 service_form " data-fn="refund_res">
                    @csrf
                    <input type="hidden" name="service_action_id" value="1">
                    <input type="hidden" name="is_received" value="0">
                    <div id="refund_total">
                        <div class="d-flex justify-content-between refund_total1">
                            <div>Refund Amount :</div>
                            <div class="refund_total_js">{{$res['refund_amount_format']}}</div>
                        </div>
                        <div class="refund_total2">{{$shop_config['service_refund_fee']}}% service charge will be deducted from the refund amount</div>
                    </div>
                    <div class="form-group" >
                        <p class="title_p">Reason: <b>*</b></p>
                        <textarea name="reason" required class="form-control" style="height: 75px;">{{$res['info']->reason}}</textarea>
                    </div>
                    <div class="form-group d-flex">
                        <button class="btn-default save-address account_btn" type="submit">Request</button>
                    </div>
                </form>

                <form action="/account_ext/service/save?order_id={{$res['orderInfo']->id}}" method="post" enctype="multipart/form-data" class="form_request_img_file received2 service_form d-none" data-fn="return_res">
                    @csrf
                    <input type="hidden" name="service_action_id" id="return_service_action_id" value="2">
                    <input type="hidden" name="is_received" value="1">

                    <ul class="service_product" data-currency_code="{{$res['orderInfo']->currency_code}}">
                        @foreach($res['orderProduct'] as $val)
                        <li>
                            <div class="d-flex">
                                <input type="hidden" data-qty="{{$val->quantity}}" data-total="{{$val->total}}" class="order_product_id" name="order_product[{{$val->id}}]" id="service_product_{{$val->id}}" checked value="{{$val->quantity}}">
                                <div class="orderProductImg">
                                    <img src="{{$val->image}}" alt="">
                                </div>
                                <div class="service_product2">
                                    <div class="serviceOrderOptions"><a href="/product/{{$val->product_id}}">{{$val->name}}</a></div>
                                    <dl class="serviceOrderOption">
                                        @if($val->orderOption)
                                            @foreach($val->orderOption as $v)
                                                <dd>{{$v->name}} : {{$v->value}}</dd>
                                            @endforeach
                                        @endif
                                    </dl>
                                    <dl class="serviceOrderOptionx">
                                        <dd data-value="{{$val->quantity}}" class="d-flex justify-content-between align-items-center" >
                                            <div class="d-flex">
                                                Qty:
                                            </div>
                                            <div class="quantity-wrapper">
                                                <div class="quantity-down">-</div>
                                                <input type="number" class="form-control quantity_js"  onblur="if(value<0){value=0}else if(value>={{$val->quantity}}){value={{$val->quantity}}}" value="{{$val->quantity}}">
                                                <div class="quantity-up" data-max="{{$val->quantity}}">+</div>
                                            </div>
                                        </dd>
                                        <dd style="display: none;">Payment:{{$val->real_total_format}}</dd>
                                    </dl>

                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>

                    <div class="form-group">
                        <p class="title_p">Is opened: <b>*</b></p>
                        @if(isset($dict['shop_yes_no']))
                        <select name="is_opened" class="form-control">
                            @foreach($dict['shop_yes_no'] as $key=>$val)
                                <option value="{{$key}}" @if(($res['info']->is_opened)==$key) selected @endif>{{$val}}</option>
                            @endforeach
                        </select>
                        @endif
                    </div>

                    <div id="return_total">
                        <div class="d-flex justify-content-between return_total1">
                            <div>Maximum refund amount :</div>
                            <div class="return_total_js"></div>
                        </div>
                        <div class="return_total2">Refund amount does not include freight.
                            After agreeing to the return request,
                            you can send the goods to us. Once we receive the goods, we will evaluate the returned goods and issue a refund.</div>
                    </div>

                    <div class="form-group">
                        <div class="add_photo"><i class="common-iconfont icon-zhaoxiangji"></i>Add Photo</div>
                        <input type="file" style="display: none" accept="image/gif,image/jpeg,image/jpg,image/png" data-img_list="file_img"
                               class="input_file_img add_photo_file" multiple="multiple">
                        <div class="file_img"></div>
                    </div>

                    <div class="form-group" >
                        <p class="title_p">Reason: <b>*</b></p>
                        <textarea name="reason" required class="form-control" style="height: 75px;">{{$res['info']->reason}}</textarea>
                    </div>

                    <div class="form-group d-flex">
                        <button class="btn-default save-address account_btn" type="submit">Request</button>
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
        if(service_type==='2'){
            let return_total = 0;
            $('.service_product .order_product_id').each(function () {
                let that = $(this)
                return_total = return_total + new Decimal(that.data('total')).mul(that.val()).div(that.data('qty')).toNumber();
            })
            return_total = return_total.toFixed(2);
            $('.return_total_js').html(currency.format(return_total,$('.service_product').data('currency_code')))
        }else{
            $('.return_total_js').html('')
        }
    }

$(function () {

    $('.add_photo').click(function () {
        $('.add_photo_file').click();
    })

    $('.service_action_ul').on('click','li',function () {
        $('.service_action_ul li').removeClass('active')
        let service_action_id = $(this).val()
        // $('.service_action_ul_res li').removeClass('active')
        // $('.service_action_ul_res li[value="'+service_action_id+'"]').addClass('active')
        $(this).addClass('active')
        $('#return_service_action_id').val(service_action_id)
        if(service_action_id===1){
            $('.received1').removeClass('d-none')
            $('.received2').addClass('d-none')
        }else{
            $('.received2').removeClass('d-none')
            $('.received1').addClass('d-none')
            if(service_action_id===2){
                $('#return_total').show()
            }else{
                $('#return_total').hide()
            }
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

@include('laravel-front::common.footer')
