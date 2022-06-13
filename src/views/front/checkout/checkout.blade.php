@include('laravel-shop::front.common.header')
<link rel="stylesheet" href="{{ URL::asset('vendor/laravel-shop/css/checkout.css') }}" />
<style>

</style>
<div class="container">
    <div class="checkout row">
        <div class="col-12 d-none d-xl-block pt-4">
            <h2 class="font-30 checkout-header font-weight-bold">
                Checkout
            </h2>
        </div>
        <div class="col-12 col-xl-8">
            <input type="hidden" name="onLoadCurrentStep" id="onLoadCurrentStep" value="payMethod">
            <div class="checkout-content mb-5">
                <div id="shippingAddress" class="checkout-item step-active ">
                    <div class="checkout-item-title disabled">
                        <span class="checkout-item-title-num"> Shipping Address</span>
                        <a href="javascript:void(0);" class="checkout-item-title-edit">Edit</a>
                    </div>
                    <div class="color-desc selected-content">
                    </div>
                    <div class="select-option" style="">
                        <div class="address-lists">
                                @foreach($res['customer_address'] as $val)
                            <label class="row m-0 checkout-address">
                                <input type="radio" class="checkout-form-radio col-1 shipping-address" name="shipping_address" value="375308">
                                <div class="col-11 pl-3">
                                    <div>{{$val['firstname']}} {{$val['lastname']}},{{$val['address_1']}}, {{$val['address_2']}}, {{$val['city']}}, {{$val['zone_name']}}, {{$val['country_name']}}, {{$val['postcode']}}, {{$val['telephone']}}</div>
                                    <a href="javascript:;" class="checkout-address-edit color-link d-inline-block pt-3 pr-3" data-address-id="375308">Edit</a>
                                </div>
                            </label>
                            @endforeach
                            <label class="row m-0 pt-3 add-new-shipping-address" style="">
                                <input class="checkout-form-radio col-1 shipping-address" type="radio" name="shipping_address" value="0">
                                <div class="col-11 pl-3 font-weight-bold">
                                    Add New Address
                                </div>
                            </label>
                        </div>
                        <div id="shipping-address-form" style="display: none;">
                            <form id="shippingAddressForm" name="shippingAddressForm" method="post" action="">
                                <input type="hidden" name="_token" value="kefgNRtnhzToF1VMf0drb7WMQRuemihAa03xrWhJ">        <ul class="address-form">
                                    <li class="form-item pt-3 mt-1">
                                        <input name="firstname" class="p-3 d-inline-block w-100 checkout-form-input address-form-firstname" type="text" placeholder="First Name">
                                    </li>
                                    <li class="form-item pt-3 mt-1">
                                        <input name="lastname" class="p-3 d-inline-block w-100 checkout-form-input address-form-lastname" type="text" placeholder="Last Name">
                                    </li>
                                    <li class="form-item pt-3 mt-1">
                                        <select name="country" class="p-3 d-inline-block w-100 checkout-form-input address-form-country">
                                            <option value="0">Country</option>
                                            <option value="197" data-code="US">United States</option>
                                            <option value="225" data-code="GB">United Kingdom</option>
                                            <option value="38" data-code="CA">Canada</option>
                                        </select>
                                    </li>
                                    <li class="form-item pt-3 mt-1">
                                        <input name="address_1" class="p-3 d-inline-block w-100 checkout-form-input address-form-address-1" type="text" placeholder="Address Line 1">
                                    </li>
                                    <li class="form-item pt-3 mt-1">
                                        <input name="address_2" class="p-3 d-inline-block w-100 checkout-form-input address-form-address-2" type="text" placeholder="Address Line 2 (Optional:Apt, Building, etc.)">
                                    </li>
                                    <li class="form-item pt-3 mt-1 row">
                                        <div class="col-6">
                                            <input name="city" class="p-3 d-inline-block w-100 checkout-form-input address-form-city" type="text" placeholder="City">
                                        </div>
                                        <div class="col-6">
                                            <input name="postcode" class="p-3 d-inline-block w-100 checkout-form-input address-form-postcode" type="text" placeholder="ZIP / Postal Code">
                                        </div>
                                    </li>
                                    <li class="form-item form-state-item pt-3 mt-1"><input type="text" name="state" class="p-3 w-100 checkout-form-input address-form-state" placeholder="State / Province" value=""></li>
                                    <li class="form-item pt-3 mt-1">
                                        <input name="phone" class="p-3 d-inline-block w-100 checkout-form-input address-form-phone" type="text" placeholder="Phone Number">
                                    </li>

                                    <li class="pt-3 mt-3">
                                        <label>
                                            <input name="is_default" class="checkout-form-checkbox ml-3" type="checkbox" checked="">
                                            Set as primary address
                                        </label>
                                    </li>
                                    <li class="pt-3 mt-3">
                                        <button type="button" class="checkout-btn d-block w-100 btn-checkout-continue">Continue</button>
                                    </li>
                                </ul>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="shippingMethod" class="checkout-item disabled">
                    <div class="checkout-item-title disabled" role="button" tabindex="0">
                        <span class="checkout-item-title-num"> Shipping Method</span>
                        <a href="javascript:void(0);" class="checkout-item-title-edit float-right">Edit</a>
                    </div>
                    <div class="color-desc selected-content">
                    </div>
                    <div class="select-option" style="display: none;">
                    </div>
                </div>

                <div id="payMethod" class="checkout-item disabled">
                    <div class="checkout-item-title" role="button" tabindex="0">
                        <span class="checkout-item-title-num"> Payment Method</span>
                        <a href="javascript:void(0);" class="checkout-item-title-edit float-right">Edit</a>
                    </div>
                    <div class="color-desc checkout-item-select selected-content" style="display: none;">

                    </div>
                </div>

                <div id="payment" class="checkout-item disabled">
                    <h3 class="checkout-item-title disabled">Payment</h3>
                    <div class="color-desc selected-content">

                    </div>
                    <div class="select-option" style="display: none">
                    </div>

                    <div class="order-payment-info" style="display:  none">
                        <div class="order-info font-18 pt-3 ml-3 mr-3 d-block d-lg-none">
                            <div class="items-price">
                                <ul>
                                    <li class="order-list">
                                        <p>
                                            <span class="sub-total subtotal-subtotal">Subtotal:</span>
                                            <span class="items-right prices price-symbol">
                    $765.17
                </span>
                                        </p>
                                    </li>
                                    <li class="order-list" style="display: none">
                                        <p>
                <span class="sub-total subtotal-coupon-saving">
                    Coupon:
                </span>
                                            <span class="items-right prices price-symbol coupon-saving">
                                            -$0.00
                                    </span>
                                        </p>
                                    </li>
                                    <li class="order-list" style="display: none">
                                        <p>
                                            <span class="sub-total subtotal-handling">Handling Fee:</span>
                                            <span class="items-right prices price-symbol handling-fee">
                    $4.95
                </span>
                                        </p>
                                    </li>
                                    <li class="order-list" style="display: none">
                                        <p>
                                            <span class="sub-total subtotal-gs-point">Point:</span>
                                            <span class="items-right prices price-symbol gs-point-saving">
                    -$0.00
                </span>
                                        </p>
                                    </li>
                                    <li class="order-list" style="display: none">
                                        <p>
                <span class="sub-total subtotal-gift-card">
                    GiftCard:
                </span>
                                            <span class="items-right prices price-symbol gift-card-saving">
                    -$0.00
                </span>
                                        </p>
                                    </li>
                                    <li class="order-list" style="display: none">
                                        <p>
                                            <span class="sub-total subtotal-shipping">Shipping:</span>
                                            <span class="items-right prices price-symbol shipping-fee">
                    $0.00
                </span>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                            <div class="items-total-price order-list">
                                <span>Order Total:</span>
                                <span class="items-right js-total-amount">
        $765.17
    </span>
                            </div>
                        </div>
                        <ul class="checkout-payment pt-3 pb-3">
                            <li class="pt-3 mt-3 ml-3 mr-3">
                                <form name="paymentForm" id="paymentForm" action="" method="post">
                                    <input type="hidden" id="paymentMethod" name="paymentMethod" value="">
                                    <input type="hidden" id="shippingMethod" name="shippingMethod" value="">
                                    <input type="hidden" id="isLogin" name="isLogin" value="">
                                    <button type="button" class="checkout-btn d-block w-100 btn-checkout-submit" disabled="disabled">
                                        Checkout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

                <div id="paymentForm" style="display: none">
                    <form id="paypalECForm" action="https://www.glassesshop.com/payment/paypal/execute" method="post">
                        <input type="hidden" name="_token" value="kefgNRtnhzToF1VMf0drb7WMQRuemihAa03xrWhJ">
                        <input type="hidden" name="paymentId" value="">
                        <input type="hidden" name="payerID" value="">
                        <input type="hidden" name="token" value="">
                        <input type="hidden" name="orderId" value="">
                    </form>
                </div>
                <div class="paymentForm" style="display: none">
                    <form id="amazonPaymentForm" action="https://www.glassesshop.com/payment/amazon/execute" method="post">
                        <input type="hidden" name="_token" value="kefgNRtnhzToF1VMf0drb7WMQRuemihAa03xrWhJ">
                        <input type="hidden" name="orderId" value="">
                    </form>
                </div>

            </div>
        </div>
        <div class="col-xl-4 d-none d-xl-block">
            <div class="gs-cart-sidebar sticky-top">
                <div class="gs-cart-sidebar-container js-fix-sidebar" style="position: static; top: 0px;">
                    <div class="sidebar-content" role="region" aria-label="Order summary">
                        <div class="checkout-items-title ">
                            <div class="items-title enterClick" role="button" tabindex="0" aria-expanded="true">
                                <span>items: </span><span>{{$res['items']}}</span>
                                <i class="fa fa-angle-down item-title-icon" aria-hidden="true"></i>
                            </div>
                            <div class="checkout-edit">
                                <span><a href="/cart">edit</a></span>
                            </div>
                        </div>
                        <div class="items-info-list">
                            @foreach($res['list'] as $val)
                            <div class="items-info ">
                                <div class="items-img" style="width: 120px;">
                                    <img src="{{$oss_url?$oss_url.$val['product']['image']:Storage::url($val['product']['image'])}}" alt="" aria-hidden="true" style="max-width: 100%;">
                                </div>
                                <div class="items-lists">
                                    <ul>
                                        <li>
                                            <span><strong>{{$val['product']['name']}}</strong></span>
                                        </li>
                                        <li>
                                            <span>price: </span>
                                            <span>{{$val['price_format']}}</span>
                                        </li>
                                        <li>
                                            <span>qty: </span>
                                            <span>{{$val['quantity']}}</span>
                                        </li>
                                        <li>
                                            <span>subtotal: </span>
                                            <span>{{$val['total_format']}}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div id="checkout-total">
                            <div class="items-price">
                                @if(isset($res['total_data']['totals']))
                                <ul>
                                    @foreach($res['total_data']['totals'] as $val)
                                    <li class="order-list">
                                        <p>
                                            <span class="sub-total subtotal-subtotal">{{$val['title']}}:</span>
                                            <span class="items-right prices price-symbol">{{$val['value_format']}}</span>
                                        </p>
                                    </li>
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
                </div>
            </div>
        </div>

    </div>
</div>
<style>

</style>
<script>
$(function () {

})
</script>
@include('laravel-shop::front.common.footer')
