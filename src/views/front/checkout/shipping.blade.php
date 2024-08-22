@include(config('base.view_namespace_front_blade').'::common.header')
<style>
    .checkout_ul .desc{color:#36970e}
</style>
<div class="container shop_main">
    <div class="">
        {!! $res['breadcrumb'] !!}
    </div>
    <div class="checkout">
        <div class="checkout_l">
            <div class="checkout_box">
                <div class="checkout_title">
                    Contact information
                </div>
                <ul class="checkout_info">
                    <li>
                        <span>Contact</span>
                        <span>{{$email}}</span>
                        <span></span>
                    </li>
                    <li>
                        <span>Ship to</span>
                        <span>{{$res['address']['address_1']}}, {{$res['address']['city']}}, {{$res['address']['zone_name']}}, {{$res['address']['country_name']}}</span>
                        <span><a href="/checkout/address">Change</a></span>
                    </li>
                </ul>
            </div>
            <form action="/checkout/shipping" method="post" class="form_request" data-fn="checkout_shipping">
                @csrf
                <div class="my_address checkout_box">
                    <div class="checkout_title">
                        Shipping Method
                    </div>
                    <ul class="checkout_ul">
                        @foreach($res['shipping'] as $val)
                            <li class="@if($val['disabled']) disabled @endif" data-id="{{$val['id']}}">
                                <label>
                                    <input type="radio" name="shipping_id" value="{{$val['id']}}" @if($val['disabled']) disabled @endif >
                                    <div class="">
                                        {{$val['name']}}
                                    </div>
                                    <div class="desc" >
                                        {{$val['desc']}}
                                    </div>
                                    <div>
                                        @if($val['free'])
                                            @if($val['cost']>0)
                                            <span class="old_price">{{$val['cost_format']}}</span>
                                            @endif
                                            <span>Free</span>
                                        @else
                                            @if($val['cost']>0)
                                                {{$val['cost_format']}}
                                            @else
                                                Free
                                            @endif
                                        @endif
                                    </div>
                                </label>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="checkout_btn">
                    <div class="checkout_btn_l"><a href="/checkout/address"><i class="common-iconfont icon-xiangl"></i>Return to Address</a></div>
                    <button type="submit">Continue to payment</button>
                </div>
            </form>
        </div>
        <div class="checkout_r">
            @include('laravel-front::checkout.right')
        </div>
    </div>


</div>
<style>
    .checkout_ul li{display: flex;justify-content: space-between;}
    .checkout_ul li div:first-child{margin-right: 10px;}
    .checkout_ul li div:nth-child(3){margin-right: auto;margin-left: 10px;}
    .checkout_ul li.disabled{ background: #f1f1f1;}
</style>
<script>
function checkout_shipping(res) {
    alert_res(res)
}
$(function () {
    $('.checkout_ul').on('click','li',function () {
        if($(this).hasClass('disabled')){
        }else{
            $('.checkout_ul li').removeClass('active')
            $(this).addClass('active')
        }
        //$('input[name="shipping_id"]').val($(this).data('id'))
    })
    $('.checkout_ul li:not(.disabled):first').find('label').click()
})
</script>
@include(config('base.view_namespace_front_blade').'::common.footer')
