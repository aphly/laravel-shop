@include('laravel-shop::front.common.header')
<link rel="stylesheet" href="{{ URL::asset('static/shop/css/checkout.css') }}"/>
<style>

</style>
<div class="container">
    <div class="row">
        <div class="col-8">
            <form action="/checkout/address" method="post" class="save_form">
                @csrf
                @foreach($res['address'] as $val)
                    <label class="row checkout-address" data-id="{{$val['id']}}" >
                        <input type="radio" class="checkout-form-radio shipping-address" name="address_id" value="{{$val['id']}}">
                        <div class="col-11 pl-3">
                            <div>{{$val['firstname']}} {{$val['lastname']}},{{$val['address_1']}}
                                , {{$val['address_2']}}, {{$val['city']}}, {{$val['zone_name']}}
                                , {{$val['country_name']}}, {{$val['postcode']}}
                                , {{$val['telephone']}}</div>
                            <a href="javascript:;"
                               class="checkout-address-edit color-link d-inline-block pt-3 pr-3"
                               data-address-id="375308">change</a>
                        </div>
                    </label>
                @endforeach
                <button> next</button>
            </form>
        </div>
        <div class="col-4">
            @include('laravel-shop::front.checkout.right')
        </div>
    </div>

</div>
<style>

</style>
<script>

</script>
@include('laravel-shop::front.common.footer')
