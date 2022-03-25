@include('laravel-shop::common.header')
<style>
.productPreview{display: flex;align-items: center;}
.productPreview img{width: 100%;max-height: 100%;}
</style>
<div class="container">
    <div class="row">
        <div class="col-8">

        </div>
        <div class="col-4">
            <div>
                <div class="productPreview">
                    <img src="{{Storage::url($res['product_img']['src'])}}" alt="">
                </div>
                <div class="ProductPrice">
                    <p class="sku"><a href="/eyeglasses/{{$res['product']['sku']}}" title="{{$res['product']['name']}}">{{$res['product']['name']}}</a></p>
                    <p>{{$res['product']['color']}}</p>
                    <p class="total-price"><span>Total:</span><span class="total-price-style">${{$res['product']['price']}}</span></p>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(function () {

})
</script>
@include('laravel-shop::common.footer')
