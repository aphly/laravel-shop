@Linclude('laravel-front::common.header')
<script src="https://js.stripe.com/v3/"></script>
<style>
.checkout_ul_payment li{display: flex;justify-content: space-between;align-items: center;padding: 0;}
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
                <div class="checkout_box">
                    <div class="checkout_title">
                        Payment Method
                    </div>
                    <ul class="checkout_ul checkout_ul_payment">
                        @foreach($res['paymentMethod'] as $val)
                            @if($val['id']==3)
                                @php
                                    $card_status = true;
                                @endphp
                                <li style="margin-bottom: 10px;justify-content: left;flex-wrap: wrap;">
                                    <label style="width: 100%">
                                        <input type="radio" name="payment_method_id" value="{{$val['id']}}" >
                                        <div style="margin-right: auto">Other</div>
                                    </label>
                                    <div style="width: 100%;">
                                        <div id="payment-element" style="width: 100%;">
                                            <!--Stripe.js injects the Payment Element-->
                                        </div>
                                        <div id="payment-message" class="hidden"></div>
                                    </div>
                                </li>
                            @else
                            <li data-id="{{$val['id']}}">
                                <label>
                                    <input type="radio" name="payment_method_id" value="{{$val['id']}}">
                                    <div style="margin-right: auto">{{$val['name']}}</div>
                                    <img src="/static/payment/img/{{$val['name']}}.png">
                                </label>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="checkout_btn">
                    <div class="checkout_btn_l"><a href="javascript:;" onclick="self.location=document.referrer;"><i class="common-iconfont icon-xiangl"></i>Return to shipping</a></div>
                    <button type="submit" id="submit">Pay now</button>
                </div>
            </form>
        </div>
        <div class="checkout_r">
            @include('laravel-front::checkout.right')
        </div>
    </div>

</div>
<style>

</style>
<script>
    function checkout_pay(res) {
        if(!res.code){
            if(res.data.card){
                handleSubmit(res.data.payment_id);
            }else{
                location.href = res.data.redirect
            }
        }else{
            if(typeof res.data.redirect !=='undefined'){
                location.href = res.data.redirect
            }else{
                alert_msg(res,true)
            }
        }
    }
    $(function () {
        $('.checkout_ul').on('click','label',function () {
            $('.checkout_ul li').removeClass('active')
            $(this).closest('li').addClass('active')
        })
        $('.checkout_ul li:first label').click()
    })
</script>

@if($card_status)
<script>
    const stripe = Stripe("{{$res['stripe']->pk}}");
    let elements;
    const items = { amount: {{$res['total_data']['total']}},currency:'{{$res['currency']['code']}}',_token:'{{csrf_token()}}' };
    let emailAddress = '{{$id}}';

    async function initialize() {
        const res = await fetch("/card/create", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(items),
        }).then((r) => r.json());
        const appearance = {
            rules: {
                '.AccordionItem':{
                    'border':'1px solid #fff',
                    'boxShadow':'none'
                }
            }
        };
        if(!res.code){
            let clientSecret = res.data.clientSecret;
            elements = stripe.elements({ clientSecret,appearance });
            const paymentElementOptions = {
                layout: "accordion"
            };
            const paymentElement = elements.create("payment", paymentElementOptions);
            paymentElement.mount("#payment-element");
        }
    }
    async function handleSubmit(payment_id) {
        setLoading(true);
        const { error } = await stripe.confirmPayment({
            elements,
            confirmParams: {
                return_url: "{{url('/payment/stripeCard/return')}}",
                receipt_email: emailAddress,
            },
        });
        location.href = '{{url('/payment/stripeCard/return')}}';
        // if (error.type === "card_error" || error.type === "validation_error") {
        //     showMessage(error.message);
        // } else {
        //     showMessage("An unexpected error occurred.");
        // }
        setLoading(false);
    }
    async function checkStatus() {
        const clientSecret = new URLSearchParams(window.location.search).get(
            "payment_intent_client_secret"
        );
        if (!clientSecret) {
            return;
        }
        const { paymentIntent } = await stripe.retrievePaymentIntent(clientSecret);
        switch (paymentIntent.status) {
            case "succeeded":
                showMessage("Payment succeeded!");
                break;
            case "processing":
                showMessage("Your payment is processing.");
                break;
            case "requires_payment_method":
                showMessage("Your payment was not successful, please try again.");
                break;
            default:
                showMessage("Something went wrong.");
                break;
        }
    }

    function showMessage(messageText) {
        const messageContainer = document.querySelector("#payment-message");
        messageContainer.classList.remove("hidden");
        messageContainer.textContent = messageText;
        setTimeout(function () {
            messageContainer.classList.add("hidden");
            messageContainer.textContent = "";
        }, 4000);
    }
    function setLoading(isLoading) {
        if (isLoading) {
            document.querySelector("#submit").disabled = true;
        } else {
            document.querySelector("#submit").disabled = false;
        }
    }
    $(function () {
        initialize();
    })
</script>
<style>
    #payment-message{padding: 5px 20px;font-weight: 600;}
</style>
@endif

@include('laravel-front::common.footer')
