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
                        @if($res['is_color'] && !empty($res['product_image'][$product_id]))
                            <div class="image">
                                <a href="/product/{{$product_id}}">
                                    @if($res['product_image'])
                                        <dl class="product_image">
                                            @foreach($res['product_image'][$product_id][0] as $k=>$v)
                                                @if(reset($res['product_image'][$product_id][0])==$v)
                                                    <dd class="active" data-image_id="{{$v[0]['id']}}" data-option_value_id="{{$k}}"><img src="{{ URL::asset('static/base/img/none.png') }}" data-original="{{$v[0]['image_src']}}" class="lazy" /></dd>
                                                @else
                                                    <dd data-image_id="{{$v[0]['id']}}" data-option_value_id="{{$k}}"><img src="{{ URL::asset('static/base/img/none.png') }}" data-original="{{$v[0]['image_src']}}" class="lazy" /></dd>
                                                @endif
                                            @endforeach
                                        </dl>
                                    @else
                                        <img src="{{ URL::asset('static/base/img/none.png') }}" data-original="{{ $val->image_src }}"  class="img-responsive lazy" >
                                    @endif
                                </a>
                            </div>

                        @else
                            <div class="image">
                                <a href="/product/{{$product_id}}">
                                    <img src="{{ URL::asset('static/base/img/none.png') }}" data-original="{{ $res['products'][$product_id]->image_src }}"  class="img-responsive lazy" >
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
                        @if($res['is_color'] && !empty($res['product_image'][$product_id]) && isset($res['product_option'][$product_id]['product_option_value']))
                            <div class="product_option">
                                <dl>
                                    @foreach($res['product_option'][$product_id]['product_option_value'] as $v)
                                        @if($v['product_image'] && $v['product_image']['image_src'])
                                            <dd data-image_id="{{$v['product_image']['id']}}" data-option_value_id="{{$v['option_value_id']}}">
                                                <img src="{{ URL::asset('static/base/img/none.png') }}" data-original="{{$v['product_image']['image_src']}}" class="lazy" alt=""></dd>
                                        @elseif($v['option_value'] && $v['option_value']['image_src'])
                                            <dd><img src="{{ URL::asset('static/base/img/none.png') }}" data-original="{{$v['option_value']['image_src']}}" class="lazy" alt=""></dd>
                                        @endif
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
@if($res['is_color'])
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
                let option_value_id = $(this).data('option_value_id');
                if(option_value_id){
                    let product_image = $(this).closest('li').find('.product_image');
                    product_image.find('dd').removeClass('active')
                    let img = product_image.find('dd[data-option_value_id="'+option_value_id+'"]').addClass('active').find('img')
                    img.attr('src',img.data('original'))
                }
            })
            $('.product_option dd:first-child').click();
        })
    </script>
@endif
@include('laravel-shop-front::common.footer')
