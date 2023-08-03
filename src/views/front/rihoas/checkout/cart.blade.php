@include('laravel-shop-front::common.header')

<style>
    .cart-content{display: flex;flex-wrap: wrap;}
    .myChart{width: 60%;margin-right: 20px;background: #fff;padding:20px 0;margin-bottom: 20px;}
    .cart-pay{width: calc(40% - 20px);}
    .cart-shopping{background:#fff;box-shadow:0 0 15px 0 #e3e3e3;margin-top:0;margin-bottom:10px;padding:50px 30px 30px;position:relative;border-radius: 4px;}
    .close-btn{cursor:pointer;position:absolute;right:10px;top:10px;width:18px}
    .cart-img{width: calc(40% - 20px);margin-right: 20px;}
    .cart-img_r{width: 60%;}
    .cart-product-name{font-size: 18px;font-weight: 700;}
    .shopping-info .cart-product-info{display: flex;justify-content: space-between;padding: 5px 0;}
    .cart-product-info-x{color: #999;}
    .qtyInfo {border-bottom: 1px solid #dadada; padding-bottom: 15px; padding-top: 5px;display: flex;justify-content: space-between;}
    .subtotalInfo{display: flex;justify-content: space-between;margin-top: 25px;font-weight: 600}

    .cart-code{margin-top: 10px;}
    .cart-order-summary{padding:0 10px 30px}
    .btn-apply-code,.cart-code-input{border-radius:5px;height:45px;outline:none}
    .cart-code-input{border:1px solid #ccc;padding-left:10px;width:calc(100% - 120px)}
    .btn-apply-code{background:#f16c00;border:none;color:#fff;font-size:14px;line-height:43px;padding:0;width: 110px;margin-left: 5px;position: relative;top: -1px;}
    .btn-apply-code:hover{color:#fff;}

    .summarytip{border-bottom:1px solid #dadada;padding:10px 0 13px;position:relative}
    .cart-total-summary{padding-top:25px}
    .cart-total-summary dl{display:flex;justify-content:space-between;flex-wrap: wrap;}
    .cart-total-summary dl dd{width: 100%;display: flex;justify-content: space-between;margin-bottom: 5px;}
    .total-summary{margin-bottom:10px;font-weight:600}
    .cart-total-detail{border-top:1px solid #dadada;margin-top:23px;padding-top:25px;font-size:16px;font-weight:700}
    .btn-checkout{background:var(--btn_bg);border-radius:4px;color:var(--btn_color);font-size:16px;height:45px;width:100%; line-height: 38px;font-weight: 600;}
    .btn-checkout:hover{background:var(--btn_bg_hover);color:var(--btn_color_hover)}
    .btn-checkout:disabled{background: #b6b6b6!important;}
    .cart-order-total{display: flex;justify-content: space-between;margin-bottom: 10px;}

    .cart-btn-continue{color:#2a2a2a;margin-top:15px;text-align:center}
    a.color-link-defaut{border-bottom:1px solid #333;color:#333}
    .pc-cart-coupon{align-items:center;display:flex;justify-content:space-between;padding:0 40px}
    .cart-coupon-conent{display:inline-block;padding-left:32px;position:relative}
    .pc-cart-coupon .divider{color:#dadada;display:inline-block}
    .Guarantee{height:26px;left:0;position:absolute;top:50%;transform:translateY(-50%)}

    .cart-label{line-height: 28px;}
    .quantity-wrapper{display: flex;}
    .quantity-wrapper div,.quantity-wrapper input{text-align: center; line-height: 28px;height: 28px;width: 28px;min-width:28px;background-color: #fff;border: 1px solid #f1f1f1;border-radius: 2px;}
    .quantity-wrapper div{color: #aaa;font-size: 22px;cursor: pointer;user-select: none}
    .quantity-wrapper input{margin: 0 10px;}
    input[type='number']::-webkit-outer-spin-button,input[type='number']::-webkit-inner-spin-button {
        -webkit-appearance: none !important;
    }
    .img-product img{width: 100%;}
    .coupon-remove {color: #0da9c4;cursor: pointer}
    .empty-text{margin-top:70px}
    .emptyTitle{font-size:30px;font-weight:700;margin-bottom:15px}
    .btn-empty{margin-top:45px}
    .btn-empty .color-link-white{background:#0da9c4;border:none;border-radius:4px;color:#fff;display:inline-block;font-size:18px;height:50px;line-height:50px;width:40%;}
    .cart-empty img{max-width: 100%;}
    .cart-empty{text-align: center;}
    @media (max-width: 1200px) {
        .myChart{width: 100%;margin-right: 0;}
        .cart-pay{width: 100%;}
        .img-product img{height:100px; }
        .cart-shopping{padding:40px 20px 20px;}
        .btn-empty .color-link-white{font-size: 12px;}
    }
</style>

<div class="container shop_main">
    <div class="cart">
        <div class="cart-title">
            <h2 class="">
                My Cart
            </h2>
        </div>
        <div class="cart-content">
            <div class="myChart">
                @if($res['list'])
                    <div class="cart-shoppings">
                        @foreach($res['list'] as $val)
                            <div class=" cart-shopping">
                                <div class="d-flex">
                                    <div class="cart-img">
                                        <a href="/product/{{$val['product_id']}}" class="img-product">
                                            <img class="" src="{{$val['product']['image_src']}}" alt="">
                                        </a>
                                    </div>
                                    <div class="cart-img_r cart_product_js" data-cart_id="{{$val['id']}}">
                                        <ul class="cart_product">
                                            <li class="cart-product-info">
                                                <span class="cart-product-name">{{$val['product']['name']}}</span>
                                            </li>
                                            @if($val['option_value_str'])
                                                <li class="cart-product-info-x">
                                                    <span class="">{{$val['option_value_str']}}</span>
                                                </li>
                                            @endif
                                            <li class="cart-product-info">
                                                <span class="cart-label">Price:</span>
                                                <span class="item_price_js">{{$val['price_format']}}</span>
                                            </li>
                                        </ul>
                                        <div class="qtyInfo">
                                            <span class="cart-label">Qty:</span>
                                            <div class="quantity-wrapper" data-cart_id="{{$val['id']}}">
                                                <div class="quantity-down">-</div>
                                                <input type="number" name="qty" class="product-qty" value="{{$val['quantity']}}">
                                                <div class="quantity-up">+</div>
                                            </div>
                                        </div>
                                        <div class="subtotalInfo">
                                            <span>Subtotal:</span>
                                            <span class="item-total">{{$val['total_format']}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="close-btn">
                                    <img class="img-fluid" src="{{ URL::asset('static/shop/img/cart/close_mobile.svg') }}">
                                </div>
                                <div class="close-bac d-none close-bac{{$val['id']}}">
                                    <div class="close-content">
                                        <p class="close-title">Remove from Cart?</p>
                                        <div class="btn-remove">
                                            <form action="/cart/remove" method="post" data-fn="cart_remove_res" class="form_request">
                                                @csrf
                                                <input type="hidden" name="cart_id" value="{{$val['id']}}">
                                                <button type="submit" class="btn-close active">Yes</button>
                                            </form>
                                            <button type="button" class="btn-close" onclick="$('.close-bac{{$val['id']}}').addClass('d-none')">No</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="cart-empty">
                        <img class="emptyImg" src="{{ URL::asset('static/shop/img/cart/empty.svg') }}">
                        <div class="empty-text">
                            <p class="emptyTitle">Your Shopping Cart is Empty</p>
                            <p class="emptyDescrip">
                                You can continue shopping or sign in to view a previously saved cart.
                            </p>
                        </div>
                        <div class="btn-empty">
                            <a class="color-link-white" href="/">
                                Continue Shopping
                            </a>
                            @if(!$user)
                            <a class="color-link-white" href="{{route('login')}}">
                                Login / Register
                            </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
            <div class="cart-pay">
                <div class="cart-sidebar " >
                    <div class="cart-order-summary" >
                        <p class="font-weight-bold ">
                            Discount Code:
                        </p>
                        <div class="cart-code">
                            <form class="code-apply form_request" action="/cart/coupon" method="post" data-fn="coupon_res">
                                @csrf
                                <div class="form-group">
                                    <input class="cart-code-input" type="text" placeholder="Promo code" name="coupon_code" value="" autocomplete="off">
                                    <button class="btn btn-apply-code">Apply</button>
                                </div>
                            </form>
                        </div>

                        <div class="summarytip">
                            <div class="coupon-used text-left  hide-item">
                                @if(isset($res['total_data']['totals']['coupon']))
                                <div class="d-flex justify-content-between">
                                    <div>
                                        Applied Coupon:
                                        <strong class="coupon-code cart-list-coupon-code">{{$res['total_data']['totals']['coupon']['ext']}}</strong>
                                    </div>
                                    <div class="coupon-remove" onclick="couponRemove()">Remove</div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="cart-total-summary">
                            <div class="total-summary">Summary</div>
                            <dl>
                                <dd><span>Items:</span> <span class="cart-order-total-items-quantity cart_count_js">{{$res['count']}}</span></dd>
                                <dd><span>Subtotal:</span> <span class=" cart-order-total-items cart_sub_total_js">{{$res['total_data']['totals']['sub_total']['value_format']}}</span></dd>
                                @if(isset($res['total_data']['totals']))
                                    @foreach($res['total_data']['totals'] as $key=>$val)
                                        @if($key=='coupon' || $key=='shipping')
                                        <dd class="{{$key}}_js"><span>{{$val['title']}}:</span><span class="cart-order-total-items">{{$val['value_format']}}</span> </dd>
                                        @endif
                                    @endforeach
                                @endif
                            </dl>
                        </div>

                        <dl class="cart-total-detail">
                            <dd class="cart-order-total">
                                <span>Order Total:</span>
                                <span class="cart-order-grand-total cart_total_js">{{$res['total_data']['total_format']}}</span>
                            </dd>
                        </dl>

                        <div class="cart-proceed-checkout">
                            <button type="button" class="btn btn-checkout proceed-to-checkout" @if(!$res['count']) disabled @endif>
                                Proceed to Checkout
                            </button>
                        </div>

                        <div class="cart-btn-continue">
                            <a class="color-link-defaut" href="/">Continue Shopping</a>
                        </div>

                    </div>
                    <div class="pc-cart-coupon">
                        <div class="cart-coupon-conent">
                            <a href="javascript:;" data-toggle="modal" data-target="#sale-after">
                                <img class="Guarantee" src="{{ URL::asset('static/shop/img/cart/return-icon.svg') }}">
                                <p>30-Day Free Return</p>
                            </a>
                        </div>
                        <div class="cart-coupon-conent">
                            <a href="javascript:;" data-toggle="modal" data-target="#sale-after">
                                <img class="Guarantee" src="{{ URL::asset('static/shop/img/cart/guarantee-icon.svg') }}">
                                <p>365-Day Guarantee</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .close-bac{position: absolute;height: 100%;left: 0;top: 0; width: 100%;z-index: 2;display: flex;align-items: center;justify-content: center; background: #fff;}
    .close-bac .btn-remove{display: flex;}
    .close-bac button{border:none;border-radius:4px;color:#333;height:30px;line-height:30px;margin:25px 15px 0;text-align:center;width:80px}
    .close-bac .close-title{text-align: center}
    .btn-close.active{background: #0da9c4;color: #fff;}
</style>

<script>
    $(function () {
        $('.proceed-to-checkout').click(function () {
            location.href = '/checkout/address?redirect='+urlencode('{{url('/cart')}}')
        })

        $('.quantity-wrapper').on('click','.quantity-down', function () {
            let input = $(this).parent().find('input')
            let q_curr = parseInt(input.val());
            let quantity = q_curr-1;
            quantity = quantity>1?quantity:1;
            input.val(quantity)
            let cart_id = $(this).closest('.quantity-wrapper').data('cart_id');
            let _this = this
            debounce_fn(function () {
                edit_cart(cart_id,quantity,_this)
            },1000,cart_id,quantity,_this)
        })

        $('.quantity-wrapper').on('click','.quantity-up', function () {
            let input = $(this).parent().find('input')
            let q_curr = parseInt(input.val());
            let quantity = q_curr+1;
            input.val(quantity)
            let cart_id = $(this).closest('.quantity-wrapper').data('cart_id');
            let _this = this
            debounce_fn(function () {
                edit_cart(cart_id,quantity,_this)
            },1000,cart_id,quantity,_this)
        })

        $('.quantity-wrapper').on('blur','input',debounce(function () {
            let quantity = $(this).val();
            let cart_id = $(this).closest('.quantity-wrapper').data('cart_id');
            edit_cart(cart_id,quantity,this)
        }))

        $('.close-btn').click(function () {
            $(this).next().removeClass('d-none');
        })

    })

    function edit_cart(cart_id,quantity,_this) {
        if(cart_id && quantity){
            $.ajax({
                url:'/cart/edit',
                type:'post',
                data:{cart_id,quantity,'_token':'{{csrf_token()}}'},
                dataType: "json",
                success:function (res) {
                    if(!res.code){
                        for(let i in res.data.list){
                            let cart_product_js = $('.cart_product_js[data-cart_id="'+i+'"]');
                            cart_product_js.find('.item-total').text(res.data.list[i].total_format)
                            cart_product_js.find('.item_price_js').text(res.data.list[i].price_format)
                        }
                        $('.cart_num').text(res.data.count)
                        $('.cart_count_js').text(res.data.count)
                        $('.cart_sub_total_js').text(res.data.total_data.totals.sub_total.value_format)
                        if(res.data.total_data.totals.coupon){
                            $('.coupon_js .cart-order-total-items').text(res.data.total_data.totals.coupon.value_format)
                        }
                        if(res.data.total_data.totals.shipping){
                            $('.shipping_js .cart-order-total-items').text(res.data.total_data.totals.shipping.value_format)
                        }
                        $('.cart_total_js').text(res.data.total_data.totals.total.value_format)
                    }
                }
            })
        }
    }

    function cart_remove_res(res,_this) {
        location.href = '/cart'
    }

    function couponRemove() {
        $.ajax({
            url:'/cart/coupon_remove',
            success:function () {
                location.href = '/cart'
            }
        })
    }

    function coupon_res(res,_this){
        location.href = '/cart'
    }

</script>
@include('laravel-shop-front::common.footer')
