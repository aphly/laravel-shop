@include('laravel-shop::common.header')
<style>
dl,dd{margin:0;}
.productPreview{display: flex;align-items: center;}
.productPreview img{width: 100%;max-height: 100%;}
.carousel{min-height: 500px;}
.lens_box .img-box{width: 23%;text-align: center;}

.usage .img-icon{align-items:center;display:flex;justify-content:center;margin:0 auto;min-height:113px;padding:20px 0;width:100px}
.usage .content.data-active,.lencolors .lencolors-desc.data-active{background-color:#c4eeff}
.lensPackag .content,.lentype .content,.usage .content{font-size:14px}
.usage .glass-desc{border-bottom:1px solid #dadada;display:flex;position:relative;vertical-align:middle;width:100%}
.usage .glass-desc div{vertical-align:middle}
.usage .sub-content,.lentype .sub-content,.lencolors .colortips{display: none;}
.usage .sub-content dd,.lentype .sub-content dd{align-items:center;border-bottom:1px solid #dadada;display:flex;height:64px;line-height:64px;padding-left:23%;}
.box-title{align-items:center;color:#000;display:flex;font-size:14px;margin-bottom:10px;margin-top: 25px;}

.lentype-desc,.lencolors-desc,.lensPackage-desc,.lensCoating-desc{cursor:pointer;display:flex;position:relative;vertical-align:middle;width:100%;height: 140px;border-bottom: 1px solid #dadada;}
.lentype .sub-content .lentypeSub>li:first-child,.lentype .sub-content>header:first-child,.lentype-desc{border-bottom:1px solid #dadada}
.lentype .content:not(.data-active):hover,.usage .content:not(.data-active):hover,.lencolors .lencolors-desc:not(.data-active):hover {background-color: #f0fbff;}
.lentype .sub-content dd:hover, .usage .sub-content dd:hover {background-color: #f0fbff;}

.chooseColor .glass-color{background-repeat:no-repeat;border:2px solid #fff;border-radius:100%;box-shadow:0 0 0 1px #d1d1d1;cursor:pointer;display:inline-block;height:30px;margin:2px 6px;position:relative;vertical-align:middle;width:30px}
.chooseColor .glass-color.data-active{box-shadow:0 0 0 1px #06b4d1}
.colortips{border-bottom:1px solid #dadada;font-size:14px;padding:10px 0 21px 23%}

.glass-submit{background-color:#0da9c4;border:1px solid #0000;border-radius:3px;color:#fff;font-size:14px;line-height:38px;margin-top:25px;outline:none;padding:0;text-align:center;width:180px}
.color-opacity{cursor:pointer;font-size:14px;padding:0 0 0 10px}
.strength{align-items:center;display:flex;padding-top:15px}
.color-opacity:before{border:2px solid #dadada;border-radius:56%;content:"";display:inline-block;height:20px;margin-right:10px;position:relative;top:2px;vertical-align:sub;width:20px}
.color-opacity.data-active:before{background:url(/vendor/laravel-shop/img/lens/select1.svg) no-repeat 50%;background-size:20px 20px;border:none}
.lenTitleDescrip .price{font-size:16px;font-weight:700}
.thinner{background:#ffd18a;border-radius:13px;display:inline-block;font-size:14px;margin-left:10px;padding:0 14px;font-weight:700}
.lensCoating-desc{height: 64px;line-height: 64px;}
.lensCoating-desc .box-title{margin: 0;}
</style>
<div class="container">
    <div class="row">
        <div class="col-8 lens_box">
            <div id="carouselLens" class="carousel slide" data-ride="carousel" data-interval="false">
                <ol class="carousel-indicators">

                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item usages ">
                        <ul class="" >
                            @foreach($res['lens']['usage']['child'] as $key=>$val)
                            <li class="usage">
                                <section class="content">
                                    <section class="glass-desc">
                                        <div class="img-box"><img class="img-icon" src="{{ URL::asset('vendor/laravel-shop/img/lens/'.$val['icon']) }}" alt=""></div>
                                        <div class="text-box">
                                            <div class="box-title"><span class="font-weight-bold">{{$val['name']}}</span></div>
                                            <span>{{$val['value']}}</span></div>
                                    </section>
                                </section>
                                @if($val['json'])
                                <div class="sub-content">
                                     <dl>
                                         @foreach($val['json'][0] as $k=>$v)
                                         <dd>
                                             {{$v['name']}}
                                         </dd>
                                         @endforeach
                                     </dl>
                                </div>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="carousel-item">
                    </div>
                    <div class="carousel-item ">
                        <ul class="lentypes clearfix" data-mobile="true">
                            @foreach($res['lens']['type']['child'] as $key=>$val)
                            <li class="lentype">
                                <section class="content">
                                    <section class="lentype-desc">
                                        <div class="img-box"><img class="img-icon" src="{{ URL::asset('vendor/laravel-shop/img/lens/'.$val['icon']) }}" alt=""></div>
                                        <div class="text-box">
                                            <div class="box-title"><span class="font-weight-bold">{{$val['name']}}</span>
                                                <span class="iconfont icon-warning-circle help-tip iconfont icon-warning-circle help-tip"
                                                    aria-describedby="tooltip_t8vl3577rz"></span></div>
                                            <span>{{$val['value']}}</span></div>
                                    </section>
                                </section>
                                @if($val['json'] && !$val['is_leaf'])
                                    <div class="sub-content">
                                        <dl>
                                            @foreach($val['json'][0] as $k=>$v)
                                                <dd>
                                                    {{$v['name']}}
                                                </dd>
                                            @endforeach
                                        </dl>
                                    </div>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="carousel-item sunglasseColor">
                        <ul class="lencolors ">
                            @foreach($res['lens']['sunglasses']['child'] as $key=>$val)
                            <li class="lencolor " >
                                <section class="lencolors-desc sub-boder">
                                    <div class="img-box d-none d-lg-table-cell">
                                        <img class="img-icon" src="{{ URL::asset('vendor/laravel-shop/img/lens/'.$val['icon']) }}" alt="">
                                    </div>
                                    <div class="text-box">
                                        <div class="box-title">
                                            <span>{{$val['name']}}</span>
                                        </div>
                                        <span>{{$val['value']}}</span>
                                    </div>
                                </section>
                                @if($val['json'])
                                <div class="colortips">
                                    @if(isset($val['json'][1]))
                                    <div>
                                        <span>Choose Color:</span>
                                        <div class="mt-3 chooseColor" style="display: inline-block; white-space: nowrap;">
                                            @foreach($val['json'][1] as $k=>$v)
                                            <span class="glass-color" style="background-color: {{$v['img']}};">
                                                <span class="iconfont icon-warning-circle help-tip color-tip"></span>
                                            </span>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                    @if(isset($val['json'][2]))
                                    <div class="strength">
                                        <span>Tint Strength:</span>
                                        @foreach($val['json'][2] as $k=>$v)
                                            <span class="color-opacity">{{$v['value']}}</span>
                                        @endforeach
                                    </div>
                                    @endif
                                    <div>
                                        <button type="button" data-normal="" class="glass-submit">Confirm</button>
                                    </div>
                                </div>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="carousel-item lensPackagSelect">
                        @foreach($res['lens']['thickness'] as $key=>$val)
                        <ul class="lensPackages" data-id="{{$key}}" @if($key!=25) style="display: none;" @endif>
                            @foreach($val as $k=>$v)
                                @if($v['img'])
                                <li class="lensPackage">
                                    <section class="content">
                                        <section class="lensPackage-desc">
                                            <div class="img-box"><img src="/vendor/laravel-shop/img/lens/package2.svg" alt=""></div>
                                            <div class="text-box">
                                                <div class="box-title">
                                                    <span class="font-weight-bold">{{$v['img']}}</span>
                                                    <div class="lenTitleDescrip"><span>&nbsp;-&nbsp;</span>
                                                        <span class="price">${{$v['value']}}</span>
                                                        <span class="thinner">(Up to 15% thinner)</span>
                                                    </div>
                                                </div>
                                                <div class="thinner d-inline-block d-lg-none">
                                                    (Up to 15% thinner)
                                                </div>
                                                <div>
                                                    <span>{{$v['name']}}, </span>
                                                    <span>Gradient Tint, </span>
                                                    <span>Anti-Scratch, </span>
                                                    <span>Anti-Reflective, </span>
                                                    <span>UV Coating</span>
                                                </div>
                                            </div>
                                        </section>
                                    </section>
                                </li>
                                @endif
                            @endforeach
                            <li class="lensPackage">
                                <section class="content">
                                    <section class="lensPackage-desc">
                                        <div class="img-box "><img src="/vendor/laravel-shop/img/lens/package2.svg" alt=""></div>
                                        <div class="text-box">
                                            <div class="box-title">
                                                <span class="font-weight-bold">Customize</span>
                                            </div>
                                            <div><span>Select your preferred lens index and coatings.</span></div>
                                        </div>
                                    </section>
                                </section>
                            </li>
                        </ul>
                        @endforeach
                    </div>
                    <div class="carousel-item active customize">
                        @foreach($res['lens']['thickness'] as $key=>$val)
                            <ul class="lensCoatings" data-id="{{$key}}" @if($key!=25) style="display: none;" @endif>
                                @foreach($val as $k=>$v)
                                    <li class="lensCoating">
                                        <section class="content">
                                            <section class="lensCoating-desc">
                                                <div class="text-box">
                                                    <div class="box-title pb-0">
                                                        <div class="font-weight-bold">
                                                            {{$v['name']}} Blue Blocker Pro
                                                            <span>&nbsp;-&nbsp;</span>
                                                            <span>${{$v['value']}}</span>
                                                        </div>
                                                        <span data-toggle="modal" class="iconfont icon-warning-circle help-tip"></span>
                                                    </div>
                                                </div>
                                            </section>
                                        </section>
                                        <div>
                                            <div class="table">
                                                <ul data-select="true" class="tr" style="cursor: pointer;">
                                                    <li class="td table-raido" style="width: 7%;">
                                                        <div data-select="true" class="checkbox-attr">
                                                            <input type="checkbox" id="selectLens11426"
                                                                name="selectLens11426" value="11426"> <label
                                                                for="selectLens11426"
                                                                class="label_input iconfont icon-gou"></label></div>
                                                    </li>
                                                    <li class="td" style="width: 15%;"> Free </li>
                                                    <li class="td" style="width: 50%;">
                                                        Anti-Scratch Coating
                                                        <span data-toggle="modal" class="iconfont icon-warning-circle help-tip"></span>
                                                    </li>
                                                </ul>

                                                <div>
                                                    <button class="glass-submit mt-3 mb-4">Confirm</button>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endforeach
                    </div>
                </div>
                <div class="product-detail-img_btn">
                    <button class="carousel-control-prev" type="button" data-target="#carouselLens" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-target="#carouselLens" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </button>
                </div>
            </div>
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
var lens = {};
let ss = 37.5*10;
console.log(ss)
$(function () {
    $('.usage').on('click','.content',function () {
        $(this).addClass('data-active')
        $('.usage .content').not($(this)).removeClass('data-active')
        let next = $(this).next();
        next.toggle('normal')
        $(".usage .sub-content").not(next).slideUp()
    })

    $('.lentypes').on('click','.content',function () {
        $(this).addClass('data-active')
        $('.lentypes .content').not($(this)).removeClass('data-active')
        let next = $(this).next();
        next.toggle('normal')
        $(".lentypes .sub-content").not(next).slideUp()
    })

    $('.lencolors').on('click','.lencolors-desc',function () {
        $(this).addClass('data-active')
        $('.lencolors .lencolors-desc').not($(this)).removeClass('data-active')
        let next = $(this).next();
        next.toggle('normal')
        $(".lencolors .colortips").not(next).slideUp()
    })

    $('.chooseColor').on('click','.glass-color',function () {
        $(this).addClass('data-active')
        $('.chooseColor .glass-color').not($(this)).removeClass('data-active')
    })

    $('.strength').on('click','.color-opacity',function () {
        $(this).addClass('data-active')
        $('.strength .color-opacity').not($(this)).removeClass('data-active')
    })
})
</script>
@include('laravel-shop::common.footer')
