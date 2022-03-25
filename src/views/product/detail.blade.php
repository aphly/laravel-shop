@include('laravel-shop::common.header')
<style>

</style>
<div class="container">
    <div class="product-main-detail row">
        <div class="col-8 product-detail-img">
            <div id="carouselIndicators" class="carousel slide" data-ride="carousel" data-interval="false">
                <ol class="carousel-indicators">
                    @foreach($res['product_img'] as $k=>$v)
                        <li data-target="#carouselIndicators" data-slide-to="{{$k}}" @if(!$k) class="active" @endif></li>
                    @endforeach
                </ol>
                <div class="carousel-inner">
                    @foreach($res['product_img'] as $k=>$v)
                        <div class="carousel-item @if(!$k) active @endif">
                            <div>
                                <img src="{{Storage::url($v['src'])}}" class="d-block w-100" alt="...">
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="product-detail-img_btn">
                    <button class="carousel-control-prev" type="button" data-target="#carouselIndicators" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-target="#carouselIndicators" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-4 d-flex" style="align-items: center;">
            <div class="product-info">
                <div class="d-lg-block d-none">
                    <h1 class="product-info-title">
                        {{$res['product']['name']}}
                    </h1>
                    <h2 class="product-subtitle">
                        @if(isset($res['filter_arr']['shape'][$res['product']['shape']]))
                        {{$res['filter_arr']['shape'][$res['product']['shape']]['name']}}
                        @endif
                        {{$res['product']['color']}} Eyeglasses
                    </h2>
                </div>
                <ul class="product-colors d-flex">
                    @foreach($res['spu'] as $v)
                        <li class="product-color large @if($v['sku']==$res['product']['sku']) active @endif" title="Champagne" >
                            <a href="/eyeglasses/{{$v['sku']}}">{!! \Aphly\LaravelShop\Models\Product::color($res['filter_arr']['color'],$v['color']) !!}</a>
                        </li>
                    @endforeach
                </ul>
                <div class="product-price ">
                    <div class="d-lg-block d-none">
                        <span class="product-price-original">${{$res['product']['price']}}</span>
                    </div>
                </div>
                <div class="product-size mb-lg-5 d-none d-lg-block">
                    <span class="font-16">Size</span>
                    <span class="product-size-type">{{$res['product']['size']}}</span>
                    <span style="color: #8f8f8f;">{{$res['product']['lens_width']}} - {{$res['product']['bridge_width']}} - {{$res['product']['arm_length']}}</span>
                    <span class="product-size-guide">
                        <a class="color-link" href="#" data-toggle="modal" data-target="#sizeGuideModal" style="border-bottom: 1px solid #0da9c4;">
                            Size guide
                        </a>
                    </span>
                </div>
                <div class="product-promotion d-lg-block d-none mb-5">
                    <p class="font-16 mb-1">Promotion:</p>
                    <p class="product-promotion-free mb-1">
                        <a href="javascript:;" class="product-promotion-title" data-toggle="modal" data-target="#productPromotionModal" data-class="buy-one-get-one-free" data-url="buy-one-get-one-free">
                            <span class="dot"></span>Buy One Get One Free
                        </a>
                    </p>
                    <p class="product-promotion-free mb-1">
                        <a href="javascript:;" class="product-promotion-title" data-toggle="modal" data-target="#productPromotionModal" data-class="30-off-eyeglasses" data-url="/eyeglasses">
                            <span class="dot"></span>30% Off Entire Order
                        </a>
                    </p>
                </div>
                <a href="/eyeglasses/{{$res['product']['sku']}}/lens">
                    <div class="selectLenses">
                        Select Lenses
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<style>
    .selectLenses{background-color: #0da9c4;font-size: 16px;height: 50px;line-height: 50px;text-align: center;color: #fff;border-radius:4px; }
    .product-size-type{font-weight:bold;width:34px;line-height:34px;border-radius:50%;text-align:center;background-color:#faccb4}
    .product-subtitle{font-size:14px;color:#8f8f8f;margin-bottom:8px}
    .product-color.large{display:inline-block;margin:3px;padding:4px;width:36px;height:36px;border-radius:50%;border:1px solid #fff;box-sizing:border-box}
    .product-color.active{border:1px solid #3ea0c0}
    .product-colors .color_img{width: 100%;height: 100%;margin: 0;}
    .product-price-original {font-size: 24px;}
    .product-price{margin-bottom: 30px;}
    .product-info{width: 100%}
</style>
<script>
$(function () {
    $('#carouselIndicators').carousel()
})
</script>
@include('laravel-shop::common.footer')
