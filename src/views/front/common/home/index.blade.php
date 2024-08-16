@include(config('base.view_namespace_front_blade').'::common.header')
<div>
    @if(!empty($res['banner']['home']))
    <div class="home_carousel">
        <div id="carouselCaptionsHome" class="carousel slide carousel-fade" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach($res['banner']['home'] as $key=>$val)
                <li data-target="#carouselCaptionsHome" data-slide-to="{{$key}}" class="@if(!$key) active @endif" ></li>
                @endforeach
            </ol>
            <div class="carousel-inner">
                @foreach($res['banner']['home'] as $key=>$val)
                <div class="carousel-item @if(!$key) active @endif">
                    <img src="{{ $val['img'] }}" class="w-100 carousel_pc">
                    <img src="{{ $val['img_m'] }}" class="w-100 carousel_m">
                    @if(0)
                    <div class="carousel-caption d-none d-md-block">
                        <h5>{{$val['title']}}</h5>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
            @if(0)
            <button class="carousel-control-prev" type="button" data-target="#carouselCaptionsHome" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-target="#carouselCaptionsHome" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </button>
            @endif
        </div>
    </div>
    @endif
</div>
<style>
    .home_carousel .carousel-item img{ height: 600px;border-radius: 0}
    .product-category li .product_image img{height: 100%;width: 100%;}
    .carousel-indicators li{height: 8px;border-radius: 4px;background-clip:inherit;border-top:none;border-bottom: none;}
    .carousel_pc{display: block}
    .carousel_m{display: none}
    .product-category li{width:calc((100% - 40px) / 5);margin:0px 10px 10px 0px;background:#fff;transition: box-shadow .2s ease-in-out;border-radius: 6px;}
    .product-category > li:nth-child(5n),.product-category li:last-child{margin-right:0}
    @media (max-width: 1499.98px) {
        .product-category li{width:calc((100% - 30px) / 4);margin:0px 10px 10px 0px;background:#fff;transition: box-shadow .2s ease-in-out;border-radius: 6px;}
        .product-category > li:nth-child(5n){margin-right:10px;}
        .product-category > li:nth-child(4n){margin-right:0}
        .home_carousel .carousel-item img{height: 450px; }
    }
    @media (max-width: 1199.98px) {
        .home_carousel .carousel-item img{height: 500px; }
        .product-category li{width:calc((100% - 10px) / 2);margin:0px 10px 10px 0px;background:#fff;transition: box-shadow .2s ease-in-out;border-radius: 6px;}
        .product-category > li:nth-child(5n){margin-right:10px;}
        .product-category > li:nth-child(4n){margin-right:10px}
        .product-category > li:nth-child(2n){margin-right:0}
        .carousel_pc{display: none}
        .carousel_m{display: block}
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
@include(config('base.view_namespace_front_blade').'::common.footer')
