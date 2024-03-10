@Linclude('laravel-front::common.header')
<div>
    <div class="home_carousel">
        <div id="carouselCaptionsHome" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselCaptionsHome" data-slide-to="0" class="active"></li>
                <li data-target="#carouselCaptionsHome" data-slide-to="1"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ URL::asset('image/banner1.jpg') }}" class="d-block w-100">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>First slide label</h5>
                        <p>Some representative placeholder content for the first slide.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="{{ URL::asset('image/banner2.jpg') }}" class="d-block w-100">
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
    @media (max-width: 1499.98px) {
        .home_carousel .carousel-item img{height: 450px; }
    }
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
                @foreach($val['product_ids'] as $product_id)
                    @if(!empty($res['products'][$product_id]))
                    <li>
                        @if(!empty($res['product_option_value_image'][$product_id]))
                            <div class="image">
                                <a href="/product/{{$product_id}}">
                                    <dl class="product_image">
                                        @foreach($res['product_option_value_image'][$product_id] as $k=>$v)
                                            @if(reset($res['product_option_value_image'][$product_id]) ===$v)
                                                <dd class="active" data-image_id="{{$k}}" >
                                                    <img src="{{ URL::asset('static/base/admin/img/none.png') }}" data-original="{{$v}}" class="lazy" />
                                                </dd>
                                            @else
                                                <dd data-image_id="{{$k}}" >
                                                    <img src="{{ URL::asset('static/base/admin/img/none.png') }}" data-original="{{$v}}" class="lazy" />
                                                </dd>
                                            @endif
                                        @endforeach
                                    </dl>
                                </a>
                            </div>
                        @else
                            <div class="image">
                                <a href="/product/{{$product_id}}">
                                    <img src="{{ URL::asset('static/base/admin/img/none.png') }}" data-original="{{ $res['products'][$product_id]->image_src }}"  class="img-responsive lazy" >
                                </a>
                            </div>
                        @endif

                        <a href="/product/{{$product_id}}"><div class="p_name">{{$res['products'][$product_id]->name}}</div></a>
                        <div class="p_name_x d-flex justify-content-between ">
                            <div class="d-flex price">
                                @if($res['products'][$product_id]->special)
                                    <span class="normal">{{$res['products'][$product_id]->special}}</span>
                                    <span class="special_price">{{$res['products'][$product_id]->price}}</span>
                                    <span class="price_sale">Sale</span>
                                @else
                                    @if($res['products'][$product_id]->discount)
                                        <span class="normal">{{$res['products'][$product_id]->discount}}</span>
                                        <span class="special_price">{{$res['products'][$product_id]->price}}</span>
                                        <span class="price_sale">Sale</span>
                                    @else
                                        <span class="normal">{{$res['products'][$product_id]->price}}</span>
                                    @endif
                                @endif
                            </div>
                        </div>
                        @if(!empty($res['product_option_value_image'][$product_id]))
                            <div class="product_option">
                                <dl>
                                    @foreach($res['product_option_value_image'][$product_id] as $k=>$v)
                                        <dd data-image_id="{{$k}}" >
                                            <img src="{{ URL::asset('static/base/admin/img/none.png') }}" data-original="{{$v}}" class="lazy" />
                                        </dd>
                                    @endforeach
                                </dl>
                            </div>
                        @endif
                        <div class="wt-badge none" >
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

<style>
    .product_option dl dd.active{border:none;}
    .product_option dl dd img{border-radius: 50%;padding: 3px;cursor: pointer;}
    .product_option dl dd.active img{padding: 1px;border: 2px solid #e59798;}
    .product-category .p_name{margin-top: 0;}
</style>

<script>
    $(function () {
        $('.product_option ').on('click','dd',function () {
            $(this).closest('.product_option').find('dd').removeClass('active')
            $(this).addClass('active')
            let image_id = $(this).data('image_id');
            if(image_id){
                let product_image = $(this).closest('li').find('.product_image');
                product_image.find('dd').removeClass('active')
                let img = product_image.find('dd[data-image_id="'+image_id+'"]').addClass('active').find('img')
                img.attr('src',img.data('original'))
            }
        })
        $('.product_option dd:first-child').click();
    })
</script>
@Linclude('laravel-front::common.footer')
