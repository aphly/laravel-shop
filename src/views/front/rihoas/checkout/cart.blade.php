@include('laravel-shop-front::common.header')

<style>
    .cart-content{display: flex;flex-wrap: wrap;}
    .myChart{width: 60%;margin-right: 20px;}
    .cart-pay{width: calc(40% - 20px);}

    .cart-shopping{background:#fff;box-shadow:0 0 15px 0 #e3e3e3;margin-top:0;margin-bottom:10px;padding:50px 30px 30px;position:relative}
    .close-btn{cursor:pointer;position:absolute;right:10px;top:10px;width:18px}

    .cart-img{width: 40%;padding:0 35px;}
    .cart-img_r{width: 60%;}
    .cart-product-name{font-size: 18px;font-weight: 700;}
    .shopping-info .cart-product-info{display: flex;justify-content: space-between;padding: 5px 0;}
    .cart-product-info-x{color: #999;}
    .qtyInfo {border-bottom: 1px solid #dadada; padding-bottom: 15px; padding-top: 5px;}
    .subtotalInfo{display: flex;justify-content: space-between;margin-top: 25px;font-weight: 600}

    .cart-order-summary{padding:0 30px 30px}
    .btn-apply-code,.cart-code-input{border-radius:5px;height:45px;outline:none}
    .cart-code-input{border:1px solid #ccc;padding-left:10px;width:calc(100% - 90px)}
    .btn-apply-code{background:#f16c00;border:none;color:#fff;font-size:14px;line-height:43px;padding:0;width:75px}

    .summarytip{border-bottom:1px solid #dadada;padding:10px 0 13px;position:relative}
    .cart-total-summary{padding-top:25px}
    .cart-total-summary dl{display:flex;justify-content:space-between}
    .total-summary{margin-bottom:10px;font-weight:600}
    .cart-total-detail{border-top:1px solid #dadada;margin-top:23px;padding-top:25px;font-size:16px;font-weight:700}
    .btn-checkout{background:#0da9c4;border-radius:4px;color:#fff;font-size:16px;height:38px;width:100%}
    .btn-checkout:hover{background:#0c92a9;color:#fff}
    .btn-checkout:disabled{background: #b6b6b6!important;}

    .cart-btn-continue{color:#2a2a2a;margin-top:15px;text-align:center}
    a.color-link-defaut{border-bottom:1px solid #333;color:#333}
    .pc-cart-coupon{align-items:center;display:flex;justify-content:space-between;padding:0 40px}
    .cart-coupon-conent{display:inline-block;padding-left:32px;position:relative}
    .pc-cart-coupon .divider{color:#dadada;display:inline-block}
    .Guarantee{height:26px;left:0;position:absolute;top:50%;transform:translateY(-50%)}

    @media (max-width: 1200px) {
        .myChart{width: 100%;margin-right: 0;}
        .cart-pay{width: 100%;}
    }
</style>

<div class="container">
    <div class="cart">
        <div class=" cart-title">
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
                                        <a href="" class="img-product">
                                            <img class="h-100 w-100" src="{{$val['product']['image_src']}}" alt="">
                                        </a>
                                    </div>
                                    <div class="cart-img_r">
                                        <ul class=" shopping-info  ">
                                            <li class="cart-product-info">
                                                <span class="cart-product-name">{{$val['product']['name']}}</span>
                                            </li>
                                            @if($val['option'])
                                                <li class="cart-product-info-x">
                                                    @foreach($val['option'] as $v)
                                                        <span class="">{{$v['product_option_value']['option_value']['name']}}</span>
                                                    @endforeach
                                                </li>
                                            @endif
                                            <li class="cart-product-info">
                                                <span class="cart-label">Price:</span>
                                                <span class="">{{$val['price_format']}}</span>
                                            </li>
                                        </ul>
                                        <div class="qtyInfo">
                                            <span class="cart-label">Qty:</span>
                                            <input type="number" name="qty" class="product-qty" value="{{$val['quantity']}}">
                                        </div>
                                        <div class="subtotalInfo">
                                            <span>Subtotal:</span>
                                            <span class=" item-total">{{$val['total_format']}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="close-btn">
                                    <a href="javascript:;">
                                        <img class="img-fluid" src="{{ URL::asset('static/shop/img/cart/close_mobile.svg') }}">
                                    </a>
                                </div>
                                <div class="close-bac d-none">
                                    <div class="remove-bac"></div>
                                    <div class="close-content">
                                        <span class="close-title">Remove from Cart?</span>
                                        <div class="btn-remove">
                                            <button type="button" class="btn-close btn-y btn-remove-item-y">
                                                Yes
                                            </button>
                                            <button type="button" class="btn-close btn-n btn-remove-item-n">
                                                No
                                            </button>
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
                            <a class="color-link-white" href="route('login')">
                                Sign in / Register
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
                            <form class="code-apply form_request" action="/cart/coupon" method="post" data-fn="coupon">
                                @csrf
                                <div class="form-group">
                                    <input class="cart-code-input" type="text" placeholder="Promo code" name="coupon_code" value="" autocomplete="off">
                                    <button class="btn btn-apply-code">Apply</button>
                                </div>
                            </form>
                        </div>

                        <div class="summarytip">
                            <div class="coupon-used text-left  hide-item">
                                <div class="d-lg-none d-block">
                                    The coupon has been applied for <strong class="coupon-code cart-list-coupon-save">$0.00</strong>
                                </div>
                                <div class="position-relative">
                                    Applied Coupon:
                                    <strong class="coupon-code cart-list-coupon-code"></strong>
                                    <span class="coupon-remove">Remove</span>
                                </div>
                                <div class="alert alert-danger  hide-item">
                                    <ul>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="cart-total-summary">
                            <div class="total-summary">Summary</div>
                            <dl>
                            @if(isset($res['total_data']['totals']))
                                <dd><span>Items:</span> <span class="cart-order-total-items-quantity">{{$res['items']}}</span></dd>
                                @foreach($res['total_data']['totals'] as $val)
                                    <dd><span>{{$val['title']}}:</span><span class=" cart-order-total-items">{{$val['value_format']}}</span> </dd>
                                @endforeach
                            @else
                                <dd><span>Items:</span> <span class="cart-order-total-items-quantity">0</span></dd>
                                <dd><span>Subtotal:</span> <span class=" cart-order-total-items">{{$res['total_data']['total_format']}}</span></dd>
                            @endif
                            </dl>
                        </div>

                        <dl class="cart-total-detail">
                            <dd class="cart-order-total">
                                <span>Order Total:</span>
                                <span class="cart-order-grand-total">{{$res['total_data']['total_format']}}</span>
                            </dd>
                        </dl>

                        <div class="cart-proceed-checkout">
                            <button type="button" class="btn btn-checkout proceed-to-checkout" @if(!$res['items']) disabled @endif>
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
                        <span class="divider">|</span>
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

</style>

<script>
    $(function () {
        $('.proceed-to-checkout').click(function () {
            location.href = '/checkout/address'
        })
    })

    function coupon(res){
        console.log(res)
    }

</script>
@include('laravel-shop-front::common.footer')
