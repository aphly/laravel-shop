@include('laravel-shop::front.common.header')
<link rel="stylesheet" href="{{ URL::asset('static/shop/css/checkout.css') }}"/>
<style>

</style>
<div class="container">
    <div class="row">
        <div class="col-12">
            {{$res['address']['firstname']}} {{$res['address']['lastname']}} {{$res['address']['address_1']}}
        </div>
        <div class="col-8">
            @foreach($res['shipping'] as $val)
                <label class="checkout-shipping" data-id="{{$val['id']}}">
                    <input type="radio" class="checkout-form-radio col-1 shipping-address"
                           name="shipping_address" value="">
                    <div class="col-11 pl-3">
                        <div>{{$val['name']}}</div>
                        <a href="javascript:;"
                           class="checkout-address-edit color-link d-inline-block pt-3 pr-3"
                           data-address-id="375308">Edit</a>
                    </div>
                </label>
            @endforeach

            <a href="/checkout/payment_method"> next</a>
        </div>
        <div class="col-4">
            @include('laravel-shop::front.checkout.right')
        </div>
    </div>

</div>
<style>

</style>
<script>
    $(function () {
        $('body').on('click', '.checkout-shipping', function (e) {
            e.preventDefault();
            e.stopPropagation();
            let id = $(this).data('id')
            $.ajax({
                url: '/checkout/shipping',
                type:'post',
                data: {shipping_id: id, _token: "{!! csrf_token() !!}"},
                success: function (res) {
                    console.log(res)
                }
            })
        })
    })
</script>
@include('laravel-shop::front.common.footer')
