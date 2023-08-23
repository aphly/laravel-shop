@include('laravel-shop-front::common.header')
<div>
    <div class="home_carousel">
        <div id="carouselCaptionsHome" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselCaptionsHome" data-slide-to="0" class="active"></li>
                <li data-target="#carouselCaptionsHome" data-slide-to="1"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ URL::asset('image/banner1.png') }}" class="d-block w-100">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>First slide label</h5>
                        <p>Some representative placeholder content for the first slide.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ URL::asset('image/banner2.png') }}" class="d-block w-100">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Second slide label</h5>
                        <p>Some representative placeholder content for the second slide.</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-target="#carouselCaptionsHome" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-target="#carouselCaptionsHome" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </button>
        </div>
    </div>
</div>
<style>
    .home_carousel .carousel-item img{ height: 600px;}
    .product-category li .product_image img{height: 100%;width: 100%;}
    @media (max-width: 1199.98px) {
        .home_carousel .carousel-item img{height: 300px; }
    }
</style>
<div>
    <div class="container">
        @foreach($res['data_products'] as $val)
            <div>
                <div class="home_title">{{$val['title']}}</div>
                <ul class=" product-category">
                @foreach($val['product_ids'] as $v)
                    @if(!empty($res['products'][$v]))
                    <li>
                        <div class="product_image">
                            <a href="/product/{{$v}}"><img src="{{$res['products'][$v]->image_src}}" alt="" class="img-responsive"></a>
                        </div>
                        <a href="/product/{{$v}}"><div class="p_name">{{$res['products'][$v]->name}}</div></a>
                        <div class="p_name_x d-flex justify-content-between">
                            <div class="d-flex price">
                                @if($res['products'][$v]->special)
                                    <span class="normal">{{$res['products'][$v]->special}}</span>
                                    <span class="special_price">{{$res['products'][$v]->price}}</span>
                                    <span class="price_sale">Sale</span>
                                @else
                                    @if($res['products'][$v]->discount)
                                        <span class="normal">{{$res['products'][$v]->discount}}</span>
                                        <span class="special_price">{{$res['products'][$v]->price}}</span>
                                        <span class="price_sale">Sale</span>
                                    @else
                                        <span class="normal">{{$res['products'][$v]->price}}</span>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="wt-badge">
                            <span class="wt-badge--small wt-badge--status-03">Bestseller</span>
                        </div>
                    </li>
                    @endif
                @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</div>

@include('laravel-shop-front::common.footer')
