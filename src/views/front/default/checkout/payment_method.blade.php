@include('laravel-shop-front::common.header')
<link rel="stylesheet" href="{{ URL::asset('static/shop/css/checkout.css') }}"/>
<style>

</style>
<div class="container">
    <div class="row">
        <div class="col-12">
            {{$res['address']['firstname']}} {{$res['address']['lastname']}} {{$res['address']['address_1']}}
        </div>
        <div class="col-12">
            {{$res['shipping']['name']}}
        </div>
        <div class="col-8">
            <form action="/checkout/pay" method="post" class="save_form">
                @csrf
                @foreach($res['paymentMethod'] as $val)
                    <label class="checkout-payment" data-id="{{$val['id']}}">
                        <input type="radio" class="checkout-form-radio col-1 shipping-address" name="payment_method_id" value="{{$val['id']}}">
                        <div class="col-11 pl-3">
                            <div>{{$val['name']}}</div>
                            <a href="javascript:;"
                               class="checkout-address-edit color-link d-inline-block pt-3 pr-3"
                               data-address-id="375308">Edit</a>
                        </div>
                    </label>
                @endforeach
                <button> pay</button>
            </form>
        </div>
        <div class="col-4">
            @include('laravel-shop-front::checkout.right')
        </div>
    </div>

</div>
<style>

</style>
<script>

</script>
@include('laravel-shop-front::common.footer')
