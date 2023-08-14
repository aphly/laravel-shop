@include('laravel-shop-front::common.header')
<style>
.checkout_ul_payment li{display: flex;justify-content: space-between;align-items: center;}
.checkout_ul_payment img{height:30px; }
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
                        <span>{{$id}}</span>
                        <span></span>
                    </li>
                    @if($res['hasShipping'])
                    <li>
                        <span>Ship to</span>
                        <span>{{$res['address']['address_1']}}, {{$res['address']['city']}}, {{$res['address']['zone_name']}}, {{$res['address']['country_name']}}</span>
                        <span><a href="/checkout/address">Change</a></span>
                    </li>
                    <li>
                        <span>Method</span>
                        <span>{{$res['shipping']['name']}}</span>
                        <span><a href="/checkout/shipping">Change</a></span>
                    </li>
                    @endif
                </ul>
            </div>
            <form action="/checkout/payment" method="post" class="form_request" data-fn="checkout_pay" id="checkout_pay">
                @csrf
                <input type="hidden" name="payment_method_id" value="{{$res['paymentMethod_default_id']}}">
                <div class="checkout_box">
                    <div class="checkout_title">
                        Payment
                    </div>
                    <ul class="checkout_ul checkout_ul_payment">
                        @foreach($res['paymentMethod'] as $val)
                            <li class="@if($res['paymentMethod_default_id']==$val['id']) active @endif" data-id="{{$val['id']}}">
                                <div>{{$val['name']}}</div>
                                <img src="/static/payment/img/{{$val['name']}}.png">
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="checkout_btn">
                    <div class="checkout_btn_l"><a href="javascript:;" onclick="self.location=document.referrer;"><i class="common-iconfont icon-xiangl"></i>Return to shipping</a></div>
                    <button type="submit">Pay now</button>
                </div>
            </form>
        </div>
        <div class="checkout_r">
            @include('laravel-shop-front::checkout.right')
        </div>
    </div>

</div>
<style>

</style>
<script>
    function checkout_pay(res) {
        if(!res.code){
            location.href = res.data.redirect
        }else{
            if(typeof res.data.redirect !=='undefined'){
                location.href = res.data.redirect
            }else{
                alert_msg(res,true)
            }
        }
    }
    $(function () {
        $('.checkout_ul').on('click','li',function () {
            $('.checkout_ul li').removeClass('active')
            $(this).addClass('active')
            $('input[name="payment_method_id"]').val($(this).data('id'))
        })
    })
</script>
@include('laravel-shop-front::common.footer')
