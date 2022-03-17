@include('laravel-shop::common.header')
<style>
    .filter-wrap{height:54px;border:1px solid #d1d1d1;border-right:0;border-left:0}
    .filter-menu{padding:16px 18px;text-transform:uppercase;cursor:pointer;border:1px solid transparent;border-top:0;border-bottom:0}
    .filter-menu .icon-arrow-down{margin-left:8px;display:inline-block;width:12px;height:12px;transform:rotate(180deg);}
    .filter-down{display:none;position:absolute;left:0;top:53px;z-index:30;padding:23px 20px 16px;border:1px solid #d1d1d1;border-top:0;background-color:#fcfcfc}
    .filter-down-gender{width:100%;padding:16px 0}
    .filter-item.active,.filter-item:hover{background-color:#fcfcfc;min-height:53px;margin-bottom:-1px}
    .filter-item.active .filter-menu,.filter-item:hover .filter-menu{border-color:#d1d1d1}
    .filter-wrap label{width: 100%;cursor: pointer;}
    .color-link {color: #3EA0C0;}

    @media (min-width: 1200px) {
        .filter-item:hover .filter-down {
            display: block;
        }
    }

</style>
<div class="container">
    <ul class="filter-wrap row flex-lg-nowrap">
        @foreach($res['arr'] as $key=>$val)
            <li class="position-relative col-12 col-lg-auto p-0 filter-item ">
                <div class="filter-menu">
                    <span>{{$key}}</span>
                    <span><a href="#" class="color-link d-lg-none"></a><i class="uni app-xia"></i></span>
                </div>
                <div class="filter-down ">
                    <div class="row m-0">
                        @foreach($val as $k=>$v)
                            <div class="col-12 mb-lg-3 mb-4 filter_where @if($res['filter'][$key] && in_array($v,$res['filter'][$key])) checked @endif" data-key="{{$key}}[]" data-val="{{$v}}">
                                <label>
                                    <input type="checkbox" @if($res['filter'][$key] && in_array($v,$res['filter'][$key])) checked @endif
                                    class="form-checkbox mt-n1" name="{{$key}}" value="{{$v}}">
                                    {{$k}}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </li>
        @endforeach
            <li class="position-relative col-12 col-lg-auto p-0 filter-item ">
                <div class="filter-menu">
                    <span>sort by
                        <span class="color-link">
                        @if($res['filter']['sort']=='viewed_desc')
                                Popularity
                        @elseif($res['filter']['sort']=='new_desc')
                                New Arrivals
                        @elseif($res['filter']['sort']=='price_desc')
                                Price: High to Low
                        @elseif($res['filter']['sort']=='price_asc')
                                Price: Low to High
                        @elseif($res['filter']['sort']=='sale_desc')
                                Sale
                        @else
                                Default
                        @endif
                        </span>
                    </span>
                    <span><a href="#" class="color-link d-lg-none"></a><i class="uni app-xia"></i></span>
                </div>
                <div class="filter-down ">
                    <div class="row m-0">
                        <div class="col-12 mb-lg-3 mb-4 filter_orderby" data-key="viewed" data-val="desc">
                            <label>
                                Popularity
                            </label>
                        </div>
                        <div class="col-12 mb-lg-3 mb-4 filter_orderby" data-key="new" data-val="desc">
                            <label>
                                New Arrivals
                            </label>
                        </div>
                        <div class="col-12 mb-lg-3 mb-4 filter_orderby" data-key="price" data-val="desc">
                            <label>
                                Price: High to Low
                            </label>
                        </div>
                        <div class="col-12 mb-lg-3 mb-4 filter_orderby" data-key="price" data-val="asc">
                            <label>
                                Price: Low to High
                            </label>
                        </div>
                        <div class="col-12 mb-lg-3 mb-4 filter_orderby" data-key="sale" data-val="desc">
                            <label>
                                Sale
                            </label>
                        </div>
                    </div>
                </div>
            </li>
    </ul>
</div>

<div class="container">
    <ul class="row">
        @foreach($res['list']['data'] as $key=>$val)
            <li class="col-12 col-lg-4 product-list-row text-center product-list-item">
                <div>
                    <span class="im img-tag tag-off-per product-icon-text product-icon-text-style2">New</span>
                </div>
                <div>
                    <img class="lazy w-100 product-img-second" src="" alt="Jocelyn Golden/Green Cat Eye Metal Eyeglasses">
                </div>
                <div class="d-flex justify-content-between">
                    <div>
                    </div>
                    <div>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <div>
                    </div>
                    <div>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>

<div class="container">
    <ul class="row">
        @foreach($res['list']['data'] as $key=>$val)
            <li class="col-12 pb-5 mb-lg-3 col-lg-4 product-list-row text-center product-list-item">
                <div class="p-icon d-none d-lg-block">
                </div>
                <div class="p-icon-favorite">
                    @foreach($res['product'][$val->spu] as $k=>$v)
                    <div class="p-tab p-tab-16104">
                        <a href="javascript:void(0);" class="font-18 text-decoration-none favorite-btn add" data-product="{{$v['id']}}">
                            <i class="fa fa-heart-o color-link" aria-hidden="true"></i>
                        </a>
                    </div>
                    @endforeach
                </div>
                <div class="product-img-outer">
                    @foreach($res['product'][$val->spu] as $k=>$v)
                    <a href="" class="product-img p-tab p-tab-16104" title="Sabrina">
                        <span class="im img-tag tag-off-per product-icon-text">
                            <span class="limited-time">Time-Limited </span>50% OFF
                        </span>
                        <img class="lazy d-block w-100 product-img-default" src="https://glassesshop-res.cloudinary.com/c_fill,f_auto,fl_lossy,q_auto,w_800,h_400,c_pad/products/202202/621d907bec1d2.jpg" data-src="https://glassesshop-res.cloudinary.com/c_fill,f_auto,fl_lossy,q_auto,w_800,h_400,c_pad/products/202202/621d907bec1d2.jpg" alt="Sabrina Purple Cat Eye Plastic Eyeglasses">
                        <img class="lazy w-100 product-img-second" src="https://glassesshop-res.cloudinary.com/c_fill,f_auto,fl_lossy,q_auto,w_800,h_400,c_pad/products/202202/621d907a7cc81.jpg" data-src="https://glassesshop-res.cloudinary.com/c_fill,f_auto,fl_lossy,q_auto,w_800,h_400,c_pad/products/202202/621d907a7cc81.jpg" alt="Sabrina Purple Cat Eye Plastic Eyeglasses">
                    </a>
                    @endforeach
                </div>
                <div class="p-title-block">
                    <div class="row no-gutters d-lg-flex d-block align-items-center">
                        <div class="col-12 col-lg-8">
                            <div class="product-colors d-none d-lg-block product-colors-pc-left">
                                @foreach($res['product'][$val->spu] as $k=>$v)
                                <span class="product-color active" title="Purple" data-target=".p-tab-16104" data-product="16104" data-try-it-on="https://glassesshop-res.cloudinary.com/w_600,h_300/tryon/fp2568.png">
                                    <i class="color item-color" style="background-image: url(https://d2fxn89uubslc7.cloudfront.net/product-colors/202202/621d907a58cef.jpg) !important;"></i>
                                </span>
                                @endforeach
                            </div>
                            <div class="product-colors d-block d-lg-none product-colors-mobile-display">
                                @foreach($res['product'][$val->spu] as $k=>$v)
                                <span class="product-color" title="Purple" data-target=".p-tab-16104" data-product="16104" data-try-it-on="https://glassesshop-res.cloudinary.com/w_600,h_300/tryon/fp2568.png">
                                    <i class="color item-color" style="background-image: url(https://d2fxn89uubslc7.cloudfront.net/product-colors/202202/621d907a58cef.jpg) !important;"></i>
                                </span>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-12 col-lg-4 text-right d-none d-lg-block">
                            @foreach($res['product'][$val->spu] as $k=>$v)
                            <div class="p-tab p-tab-16104">
                                <a href="javascript:void(0);" class="d-inline-flex align-items-center mt-2 font-18 text-decoration-none favorite-btn add" data-product="16104">
                                    <i class="fa fa-heart-o color-link" aria-hidden="true"></i>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="row no-gutters">
                            <div class="col-6 col-lg-6">
                                <div class="p-title">
                                    @foreach($res['product'][$val->spu] as $k=>$v)
                                    <a href="https://www.glassesshop.com/eyeglasses/fp2568" title="Sabrina" class="product-title p-tab p-tab-16104">
                                        {{$v['name']}}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-6 col-lg-6">
                                <div class="p-price">
                                    @foreach($res['product'][$val->spu] as $k=>$v)
                                    <div class="product-title p-tab p-tab-16104">
                                        <span class="color-red">{{$v['price']}}</span>
                                        <span class="pl-3 product-pre-price">{{$v['desc']?$v['desc']['old_price']:''}}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
{{--                        <div class="d-lg-none text-center pt-3 mt-2">--}}
{{--                            <a href="javascript:void(0);" data-product="https://glassesshop-res.cloudinary.com/w_600,h_300/tryon/fp2570.png" data-product-id="16106" class="try-on-btn font-12">Try On</a>--}}
{{--                        </div>--}}
{{--                        <div class="d-none d-lg-block justify-content-between font-12 align-items-center text-center mt-3">--}}
{{--                            <a href="javascript:void(0);" data-product="https://glassesshop-res.cloudinary.com/w_600,h_300/tryon/fp2570.png" data-product-id="16106" class="d-block try-on-btn text-decoration-none lg-hover-el">Try On</a>--}}
{{--                        </div>--}}
                </div>
            </li>
        @endforeach
    </ul>
</div>
<script>
$(function () {
    $('.filter-down').on('click','.filter_where',function () {
        let str = $(this).data('key')+'='+$(this).data('val')
        if($(this).hasClass("checked")){
            urlOption.__del(str,1)
        }else{
            urlOption.__set(str,1)
        }
    })
    $('.filter-down').on('click','.filter_orderby',function () {
        let str = $(this).data('key')+'='+$(this).data('val')
        if($(this).hasClass("checked")){
            urlOption._del('sort',$(this).data('key')+'_'+$(this).data('val'),1)
        }else{
            urlOption._set('sort',$(this).data('key')+'_'+$(this).data('val'),1)
        }
    })
})
</script>

@include('laravel-shop::common.footer')
