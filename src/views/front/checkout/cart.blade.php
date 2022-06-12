@include('laravel-shop::front.common.header')
<link rel="stylesheet" href="{{ URL::asset('vendor/laravel-shop/css/cart.css') }}" />
<style>

</style>
<div class="container">
    <div class="cart row">
        <div class="col-12 col-xl-8 cart-title">
            <h2 class="m-0">
                My Cart
            </h2>
        </div>
        <div class="col-12 col-xl-8 car-content">
            <div class="myChart">
                @if($res['list'])
                    <div class="cart-shoppings">
                        @foreach($res['list'] as $val)
                        <div class="col-12 js-shopping cart-shopping">
                            <div class="row m-0 align-items-start">
                                <div class="col-12 col-xl-5 text-center pt-3 pb-3 d-none d-xl-block cart-img">
                                    <span class="im img-tag tag-off-per product-icon-text">50% OFF</span>
                                    <a href="" class="img-product">
                                        <img class="d-block w-100" src="{{$oss_url?$oss_url.$val['product']['image']:Storage::url($val['product']['image'])}}" alt="Rita">
                                    </a>
                                </div>
                                <div class="col-12 col-xl-7 p-0">
                                    <ul class="row shopping-info p-0 m-0">
                                        <li class="d-none d-xl-block">
                                            <span class="font-18 font-weight-bold">{{$val['product']['name']}}</span>
                                        </li>
                                        <li class="col-12 pb-3 pt-3 d-none d-xl-block js-cart-product-info">
                                            <span class="car-label">Price:</span>
                                            <span class="float-right">{{$val['price_format']}}</span>
                                        </li>
                                    </ul>
                                    <div class="qtyInfo">
                                        <span class="car-label">Qty:</span>
                                        <input type="number" name="qty" class="product-qty" value="{{$val['quantity']}}">
                                        <div class="stock-tip" style="display: none"></div>
                                        <div class="subtotalInfo d-xl-none">
                                            <span>Subtotal:</span>
                                            <span class="float-xl-right item-total">{{$val['total_format']}}</span>
                                        </div>
                                    </div>
                                    <div class="subtotalInfo d-none d-xl-block">
                                        <span>Subtotal:</span>
                                        <span class="float-xl-right item-total">{{$val['total_format']}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="close-btn">
                                <a href="javascript:;">
                                    <img class="img-fluid" src="{{ URL::asset('vendor/laravel-shop/img/cart/close_mobile.svg') }}">
                                </a>
                            </div>
                            <div class="close-bac">
                                <div class="remove-bac"></div>
                                <div class="close-content">
                                    <span class="close-title">Remove from Cart?</span>
                                    <div class="btn-remove">
                                        <button type="button" class="btn-close btn-y btn-remove-item-y" data-key="740730931fe75fa8b00bb2ae20328b10">Yes</button>
                                        <button type="button" class="btn-close btn-n btn-remove-item-n" data-key="740730931fe75fa8b00bb2ae20328b10">No</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="car-empty">
                        <img class="emptyImg" src="{{ URL::asset('vendor/laravel-shop/img/cart/empty.svg') }}">
                        <div class="empty-text">
                            <p class="emptyTitle">Your Shopping Cart is Empty</p>
                            <p class="emptyDescrip">
                                You can continue shopping or sign in to view a previously saved cart.
                            </p>
                        </div>
                        <div class="btn-empty">
                            <a class="color-link-white font-18 cartBtn mr-xl-5" href="/eyeglasses">
                                Continue Shopping
                            </a>
                            <a class="color-link-white font-18 cartBtn ml-xl-5" href="/login?redirect=/cart">
                                Sign in / Register
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-xl-4 d-none d-xl-block car-pay">
            <div class="gs-cart-sidebar sticky-top">
                <div class="gs-cart-sidebar-container js-fix-sidebar default-content" style="position: static; top: 0px; display: block">
                    <div class="gs-cart-order-summary" role="region" aria-label="Order Summary">
                        <div class="car-title tips-free-shipping hide-item">
                            Great! You now qualify for Free Shipping .
                        </div>
                        <p class="font-weight-bold font-16 pt-5">
                            Discount Code:
                        </p>
                        <div class="car-code">
                            <form class="code-apply" action="/coupon/add" method="post">
                                <input type="hidden" name="_token" value="Swo5KKcDoZS3kGkqo53Iiqd5V4U8utOQbbJJHWGP">
                                <div class="form-group mb-0">
                                    <input class="car-code-input" type="text" placeholder="Promo code" name="coupon_code" value="" autocomplete="off">
                                    <button class="btn btn-apply-code" type="button">Apply</button>
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
                                <div class="alert alert-danger mt-2 hide-item">
                                    <ul>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <dl class="gs-cart-total-summary">
                            <div class="total-summary">Summary</div>
                            @if(isset($res['total_data']['totals']))
                                <dd>Items: <span class="float-right cart-order-total-items-quantity">{{$res['items']}}</span></dd>
                                @foreach($res['total_data']['totals'] as $val)
                                    <dd>{{$val['title']}}:
                                        <span class="float-right cart-order-total-items">{{$val['value_format']}}</span>
                                    </dd>
                                @endforeach
                            @else
                                <dd>Items: <span class="float-right cart-order-total-items-quantity">0</span></dd>
                                <dd>Subtotal:
                                    <span class="float-right cart-order-total-items">$0.00</span>
                                </dd>
                            @endif
                        </dl>
                        <dl class="gs-cart-total-detail">
                            <dt class="gs-cart-order-total js-order-total">Order Total:
                                <span class="price-symbol float-right cart-order-grand-total">{{$res['total_data']['total_format']}}</span>
                            </dt>
                        </dl>
                        <div class="gs-cart-proceed-checkout">
                            <div class="gs-cart-free-shipping-add mb-4 d-none d-lg-block hide-item">
                                <a href="#" data-toggle="modal" data-target="#addItemsModal"><span>Add</span></a>
                                <span class="free-shipping-add-money">$0.00</span>
                                more to enjoy Free Shipping (US).
                            </div>
                            <button type="button" class="btn btn-checkout btn-lg mb-2 p-3 proceed-to-checkout @if(!$res['items']) btn-emptyCheck @endif" >
                                Proceed to Checkout
                            </button>
                        </div>
                        <div class="gs-cart-btn-continue">
                            <a class="color-link-defaut" href="/eyeglasses">Continue Shopping</a>
                        </div>
                    </div>
                    <div class="pc-gs-cart-coupon">
                        <div class="gs-cart-coupon-conent js-coupon-block">
                            <a href="javascript:;" data-toggle="modal" data-target="#sale-after">
                                <img class="Guarantee" src="{{ URL::asset('vendor/laravel-shop/img/cart/return-icon.svg') }}">
                                <h4>30-Day Free Return</h4>
                            </a>
                        </div>
                        <span class="divider">|</span>
                        <div class="gs-cart-coupon-conent js-coupon-block">
                            <a href="javascript:;" data-toggle="modal" data-target="#sale-after">
                                <img class="Guarantee" src="{{ URL::asset('vendor/laravel-shop/img/cart/guarantee-icon.svg') }}">
                                <h4>365-Day Guarantee</h4>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
@media (min-width:1200px) {
    .cart-title h2{height:35px;line-height:35px}
}
</style>
<script>
$(function () {
    $('.proceed-to-checkout').click(function () {
        // $.ajax({
        //
        // })
        location.href='checkout'
    })
})
</script>
@include('laravel-shop::front.common.footer')
