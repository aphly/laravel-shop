<style>
.items-img{position: relative}
.items-lists .title{font-weight: 500;line-height: 25px;height: 25px;}
.items-qty{position:absolute;right:-5px;width:20px;height:20px;background:#999;color:#fff;border-radius:50%;text-align:center;top:-5px;font-size:12px;line-height:20px}
.checkout_cart{display: none;}
.checkout-coupon {
    padding: 0 0 20px;
}
.checkout-totals{padding: 0 5px;}
.checkout_coupon_form{display: flex;justify-content: space-between;}
@media (max-width: 1199.99px) {
    .checkout{flex-direction:column-reverse}
    .items-info-list-all{display: none;}
    .checkout_cart{display: flex;justify-content: space-between;align-items: center;}
    .front_breadcrumb{margin-bottom: 0;}
    .checkout_r{margin: 10px 0;background: #f9f9f9;padding:10px;border-radius: 4px;}
    .items-total-price{font-size: 16px;}
    .checkout_cart span{margin: 0 5px;}
    .checkout_cart i.uni{font-size: 12px;}
}
</style>
<div class="checkout_cart">
    <div>
        <i class="common-iconfont icon-31gouwuche"></i>
        <span>Show order summary</span>
        <i class="uni app-xiangxiajiantou"></i>
    </div>
    <div>
        {{$res['total_data']['total_format']}}
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
                            <li class="option_name_str wenzi">
                                @if($val['option_value_str'])
                                {{$val['option_value_str']}}
                                @endif
                            </li>
                            <li class="price_qty">
                                <span>Price: {{$val['price_format']}}</span>
                            </li>
                        </ul>
                    </a>
                </div>
                <div class="items-subtotal">
                    <span>{{$val['total_format']}}</span>
                    @if($val['discount'] && 0)
                    <span class="discount">-{{$val['discount_format']}}</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    <div class="checkout-coupon">
        <form action="/cart/coupon" class="form_request checkout_coupon_form" method="post" data-fn="checkout_coupon_res" style="width: 100%;">
            @csrf
            <input class="cart-code-input" type="text" placeholder="Discount code" name="coupon_code" value="" autocomplete="off">
            <button class="btn btn-apply-code">Apply</button>
        </form>
        @if(isset($res['total_data']['totals']['coupon']))
        <div class="summarytip" style="border-bottom: none;padding-bottom: 0;">
            <div class="coupon-used text-left  hide-item">
                <div class="d-flex justify-content-between">
                    <div style="padding: 0 5px;color: #666;">
                        Applied Coupon:
                        <strong class="coupon-code cart-list-coupon-code">ccc</strong>
                    </div>
                    <div class="coupon-remove" onclick="couponRemove()">Remove</div>
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class="checkout-totals">
        <div class="items-price">
            @if(isset($res['total_data']['totals']))
                <ul>
                    @foreach($res['total_data']['totals'] as $key=>$val)
                        @if($key!='total')
                        <li class="order-list">
                            <span class="sub-total subtotal-subtotal">{{$val['title']}}</span>
                            <span class="items-right prices price-symbol">{{$val['value_format']}}</span>
                        </li>
                        @endif
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="items-total-price order-list">
            <span>Order Total:</span>
            <span class="items-right js-total-amount">{{$res['total_data']['total_format']}}</span>
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
    function checkout_coupon_res(res) {
        location.reload()
    }
    function couponRemove() {
        $.ajax({
            url:'/cart/coupon_remove',
            success:function () {
                location.reload()
            }
        })
    }
</script>
