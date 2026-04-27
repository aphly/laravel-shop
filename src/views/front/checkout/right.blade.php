<style>
.items-img{position: relative}
.items-lists .title{font-weight: 500;line-height: 25px;height: 25px;}
.items-qty{position:absolute;right:-5px;width:20px;height:20px;background:#999;color:#fff;border-radius:50%;text-align:center;top:-5px;font-size:12px;line-height:20px}
.checkout_cart{display: none;}
.checkout-coupon {
    padding: 0 0 20px;
}
.order-list{ margin-bottom: 0; line-height: 40px;}
.checkout-totals{padding: 0 5px;}
.checkout_coupon_form{display: flex;justify-content: space-between;}
.price_new{display: flex;font-size: 12px;}
.items-info-list-all{padding: 0 0 10px;}
@media (max-width: 1199.99px) {
    .checkout{flex-direction:column-reverse}
    .items-info-list-all{display: none;}
    .checkout_cart{display: flex;justify-content: space-between;align-items: center;}
    .front_breadcrumb{margin-bottom: 0;}
    .checkout_r{margin: 10px 0;background: #f9f9f9;padding:0 10px;border-radius: 8px;line-height: 50px;}
    .items-total-price{font-size: 16px;}
    .checkout_cart span{font-weight: 600;}
    .checkout_cart i.uni{font-size: 12px;}
}
</style>
<div class="checkout_cart">
    <div>
        <i class="common-iconfont icon-31gouwuche"></i>
        <span>Show order summary</span>
        <i class="uni app-xiangxiajiantou"></i>
    </div>
    <div class="js-total_all">
        @if($res['total_data']['totals']['total']['value_old']!=$res['total_data']['totals']['total']['value'])
            <span class="items-right js-total-amount  price_format">{{$res['total_data']['totals']['total']['value_format']}}</span>
            <span class="price_old_format js-total-amount_old">{{$res['total_data']['totals']['total']['value_old_format']}}</span>
        @else
            <span class="items-right js-total-amount">{{$res['total_data']['totals']['total']['value_format']}}</span>
        @endif
    </div>
</div>
<div class="items-info-list-all">
    <div class="items-info-list">
        @foreach($res['list'] as $val)
            <div class="items-info ">
                <div class="items-img">
                    <a href="/product/{{$val['product']['id']}}"><img src="{{$val['product']['image_src']}}" ></a>
                    <div class="items-qty">{{$val['quantity']}}</div>
                </div>
                <div class="items-lists">
                    <a href="/product/{{$val['product']['id']}}">
                        <ul>
                            <li class="title wenzi">
                                {{$val['product']['name']}}
                            </li>
                            <li class="option_name_str ">
                                @if($val['option_value_arr'])
                                    <dl class="option_value_arr">
                                        @foreach($val['option_value_arr'] as $v)
                                            <dd>{{$v}}</dd>
                                        @endforeach
                                    </dl>
                                @endif
                            </li>
                            <li class="price_new">
                                <span style="margin-right: 5px;">Price: </span>
                                <div>
                                @if($val['price_old']!=$val['price'])
                                    <span class="price_format">{{$val['price_format']}}</span>
                                    <span class="price_old_format">{{$val['price_old_format']}}</span>
                                @else
                                    <span class="">{{$val['price_format']}}</span>
                                @endif
                                </div>
                            </li>
                        </ul>
                    </a>
                </div>
                <div class="items-subtotal">
                    @if($val['total_old']!=$val['total'])
                        <span class=" price_format">{{$val['total_format']}}</span>
                        <span class="discount price_old_format">{{$val['total_old_format']}}</span>
                    @else
                        <span>{{$val['total_format']}}</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    <div class="checkout-coupon">
        <div class="form_request checkout_coupon_form"  style="width: 100%;">
            <input class="cart-code-input coupon-code-input" type="text" placeholder="Discount code" name="coupon_code" value="" autocomplete="off">
            <button class="btn btn-apply-code" onclick="coupon_apply()">Apply</button>
        </div>
        <div class="summarytip" style="border-bottom: none;padding-bottom: 0;
            @if(isset($res['total_data']['totals']['coupon'])) display:block; @else display:none; @endif">
            <div class="coupon-used text-left  hide-item">
                <div class="d-flex justify-content-between">
                    <div style="padding: 0 5px;color: #666;">
                        Applied Coupon:
                        @if(isset($res['total_data']['totals']['coupon']))
                            <strong class="coupon-code cart-list-coupon-code">{{$res['total_data']['totals']['coupon']['ext']}}</strong>
                        @else
                            <strong class="coupon-code cart-list-coupon-code"></strong>
                        @endif
                    </div>
                    <div class="coupon-remove" onclick="couponRemove()">Remove</div>
                </div>
            </div>
        </div>
    </div>
    <div class="checkout-totals">
        <div class="items-price">
            @if(isset($res['total_data']['totals']))
                <ul>
                    <li class="order-list">
                        <span class="sub-total subtotal-subtotal">SubTotal</span>
                        <div>
                        @if($res['total_data']['totals']['sub_total']['value_old']!=$res['total_data']['totals']['sub_total']['value'])
                            <span class="items-right price_format">{{$res['total_data']['totals']['sub_total']['value_format']}}</span>
                            <span class="items-right price_old_format">{{$res['total_data']['totals']['sub_total']['value_old_format']}}</span>
                        @else
                            <span class="items-right prices price-symbol">{{$res['total_data']['totals']['sub_total']['value_format']}}</span>
                        @endif
                        </div>
                    </li>
                    <li class="order-list totals_coupon">
                        @if(!empty($res['total_data']['totals']['coupon']))
                        <span class="items-left">{{$res['total_data']['totals']['coupon']['title']}}</span>
                        <span class="items-right prices price-symbol">{{$res['total_data']['totals']['coupon']['value_format']}}</span>
                        @endif
                    </li>
                    <li class="order-list totals_shipping">
                        @if(!empty($res['total_data']['totals']['shipping']))
                        <span class="items-left">{{$res['total_data']['totals']['shipping']['title']}}</span>
                        <span class="items-right prices price-symbol">{{$res['total_data']['totals']['shipping']['value_format']}}</span>
                        @endif
                    </li>
                </ul>
            @endif
        </div>
        <div class="items-total-price order-list">
            <span>Order Total:</span>
            <div class="js-total_all">
            @if($res['total_data']['totals']['total']['value_old']!=$res['total_data']['totals']['total']['value'])
                <span class="items-right js-total-amount price_format">{{$res['total_data']['totals']['total']['value_format']}}</span>
                <span class="price_old_format js-total-amount_old">{{$res['total_data']['totals']['total']['value_old_format']}}</span>
            @else
                <span class="items-right js-total-amount">{{$res['total_data']['totals']['total']['value_format']}}</span>
            @endif
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $('.checkout_cart').click(function () {
            $('.items-info-list-all').toggle();
            if($('.checkout_cart i.uni').hasClass('app-xiangxiajiantou')){
                $('.checkout_cart i.uni').removeClass('app-xiangxiajiantou').addClass('app-xiangshangjiantou')
            }else{
                $('.checkout_cart i.uni').addClass('app-xiangxiajiantou').removeClass('app-xiangshangjiantou')
            }
        })
    })
    function coupon_apply() {
        let coupon_code = $('.coupon-code-input').val()
        if(!coupon_code){
            return
        }
        $.ajax({
            url:'/checkout/coupon',
            type:'post',
            data:{coupon_code},
            success:function (res) {
                console.log(res)
                if(!res.code){
                    $('.summarytip').show()
                    if(res.data.total_data.totals.total.value==res.data.total_data.totals.total.value_old){
                        $('.js-total_all').html(`<span class="items-right js-total-amount">${res.data.total_data.totals.total.value_format}</span>`)
                    }else{
                        $('.js-total_all').html(`<span class="items-right js-total-amount price_format">${res.data.total_data.totals.total.value_format}</span>
                        <span class="price_old_format js-total-amount_old">${res.data.total_data.totals.total.value_old_format}</span>`)
                    }
                    $('.totals_coupon').html(`<span class="items-left">Coupon</span>
                        <span class="items-right prices price-symbol">${res.data.total_data.totals.coupon.value_format}</span>`)
                }
            }
        })
    }
    function couponRemove() {
        $.ajax({
            url:'/checkout/coupon_remove',
            type:'post',
            success:function (res) {
                console.log(res)
                if(!res.code){
                    $('.summarytip').hide()
                    if(res.data.total_data.totals.total.value==res.data.total_data.totals.total.value_old){
                        $('.js-total_all').html(`<span class="items-right js-total-amount">${res.data.total_data.totals.total.value_format}</span>`)
                    }else{
                        $('.js-total_all').html(`<span class="items-right js-total-amount price_format">${res.data.total_data.totals.total.value_format}</span>
                        <span class="price_old_format js-total-amount_old">${res.data.total_data.totals.total.value_old_format}</span>`)
                    }
                    $('.totals_coupon').html('')
                }

            }
        })
    }
</script>
