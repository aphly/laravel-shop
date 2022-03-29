@include('laravel-shop::common.header')
<style>
dl,dd{margin:0;}
.productPreview{display: flex;align-items: center;}
.productPreview img{width: 100%;max-height: 100%;}
.carousel{min-height: 500px;}
.lens_box .img-box{width: 23%;text-align: center;}

.usage .img-icon{align-items:center;display:flex;justify-content:center;margin:0 auto;min-height:113px;padding:20px 0;width:100px}
.usage .content.data-active,.lentype .content.data-active,.lencolors .lencolors-desc.data-active,.lensCoating .content.data-active{background-color:#c4eeff}
.lensPackag .content,.lentype .content,.usage .content{font-size:14px}
.usage .glass-desc{border-bottom:1px solid #dadada;display:flex;position:relative;vertical-align:middle;width:100%}
.usage .glass-desc div{vertical-align:middle}
.usage .sub-content,.lentype .sub-content,.lencolors .colortips{display: none;}
.usage .sub-content dd{align-items:center;border-bottom:1px solid #dadada;display:flex;height:64px;line-height:64px;padding-left:23%;}
.box-title{align-items:center;color:#000;display:flex;font-size:14px;margin-bottom:10px;margin-top: 25px;}
.lentype .sub-content dd .sub-content1{align-items:center;border-bottom:1px solid #dadada;display:flex;height:64px;line-height:64px;padding-left:23%;}
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
.lensCoating-desc{height: 64px;line-height: 64px;text-indent: 50px;}
.lensCoating-desc .box-title{margin: 0;}

.glass-table{border-bottom: 1px solid #dadada;padding-left: 50px;display: none;}

.glass-table .table ul{position:relative}
.glass-table .table .td{color:#333;display:inline-block;font-size:14px;padding:18px 10px 18px 0;vertical-align:middle}
.checkbox-attr{color:#fff;display:inline-block;font-size:18px;height:18px;margin-right:3px;position:relative;vertical-align:sub;width:18px;border:1px solid #333;border-radius:4px}
.glass-table ul[data-select="true"] .checkbox-attr{background:none;background-color:#0da9c4;border-color:#0da9c4;color:#fff}
.checkbox-attr.app-check2:before{position:absolute;top:-2px;font-size:15px;left:2px}

.prescription .prescription-table .table .td,.prescription .prescription-table .table .th{box-sizing:border-box;display:inline-block;padding:8px 1.7%;text-align:center;vertical-align:middle;white-space:nowrap;width:17.3%}
.px-img{height:30px;width:30px}
.prescription .prescription-table .table label{display:block;font-size:14px;height:35px;margin-bottom:0;padding:3px 0}
.prescription .prescription-table select{-webkit-appearance:none;background-color:#fff;display:flex;display:inline-block;flex:1;padding:0 12px;position:relative}
.prescription .prescription-table input,.prescription .prescription-table select{appearance:none;border:none;border-bottom:1px solid #d1d1d1;border-radius:0;color:#333;font-weight:400;height:100%;width:100%}
select{background:url(/vendor/laravel-shop/img/lens/select.svg) no-repeat scroll right 7px center;background-size:15px}
.prescription .prescription-table textarea{border:1px solid #dadada;color:#333;display:inline-block;font-weight:400;height:100%;padding:6px 3px;width:100%}
.prescription .prescription-table .table .td.split-space.bottom { border-bottom: 1px solid #dadada; padding: 12px 0 0;width: 100%;}
.prescription .prescription-table {border-bottom: 1px solid #dadada;position: relative;}
.addPrism {padding: 20px 0 0 20px;position: relative;}
.glass-pd {padding: 15px 0;position: relative;}

.ProductPrice .sku a {color: #000;font-size: 24px;font-weight: 600;}
.total-price{font-weight: 600;font-size: 16px;color: #333;}
.ProductPrice .total-price .total-price-style {font-size: 24px;}

.sub-content dd.data-active,.sub-content .sub-content1.data-active {background-color: #d5f2fe!important;border-color: #d5f2fe;}
.lentype .sub-content.sub-content0 dd{ height:auto;line-height: 64px;flex-direction: column;align-items: start;}
.sub-content2{display: none;padding-left: 23%; border-bottom: 1px solid #dadada;}
</style>
<div class="container">
    <div class="row">
        <div class="col-8 lens_box">
            <div id="carouselLens" class="carousel slide" data-ride="carousel" data-interval="false">
                <ol class="">
                    <li data-target="#carouselLens" data-slide-to="0" class="active">usages</li>
                    <li data-target="#carouselLens" data-slide-to="1">prescription</li>
                    <li data-target="#carouselLens" data-slide-to="2">lensTypeSelect</li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active usages 0">
                        <ul class="" >
                            @foreach($res['lens']['usage']['child'] as $key=>$val)
                            <li class="usage">
                                <section class="content @if(!$val['json']) jump @endif " data-id="{{$val['id']}}" data-name="{{$val['name']}}"
                                         @if($val['id']==41) data-to="2" @else data-to="1" @endif >
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
                                         <dd class="jump" data-id="{{$val['id']}}-{{$k}}" data-name="{{$val['name']}} - {{$v['name']}}" data-to="1">
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
                    <div class="carousel-item 1 prescription">
                        <div class="tab-content">
                            <div class="tab-pane fade active show">
                                <div class="prescription-table default">
                                    <div class="table">
                                        <a href="#" data-toggle="modal" data-target="#rxDialog" class="color-link">
                                            <span class="iconfont icon-warning-circle help-tip popper-help"></span>
                                        </a>
                                        <div class="thead tableUl">
                                            <ul class="tr">
                                                <li data-border-right="" class="th tableTitle"><img src="/vendor/laravel-shop/img/lens/RX_icon.svg" alt="" class="px-img"></li>
                                                <li class="th">
                                                    <span class="rx-name-title d-none d-lg-block">
                                                        <span>Sphere</span> <span>SPH</span>
                                                    </span>
                                                    <span class="rx-name-title d-lg-none"><span>SPH</span></span>
                                                </li>
                                                <li class="th">
                                                    <span class="rx-name-title d-none d-lg-block"><span>Cylinder</span> <span>CYL</span></span>
                                                    <span class="rx-name-title d-lg-none"><span>CYL</span></span>
                                                </li>
                                                <li data-disabled="true" class="th mobileLi d-none d-lg-inline-block">
                                                    <span class="rx-name-title">Axis</span>
                                                </li>
                                                <li data-border-left="" data-disabled="true" class="th mobileLi d-none d-lg-inline-block">
                                                    <span class="rx-name-title">ADD</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="tbody tableUl">
                                            <ul class="tr">
                                                <li data-border-right="" class="td tableTitle">
                                                    <span class="add-rx-title">
                                                        OD<br>
                                                        <span>(Right eye)</span>
                                                    </span>
                                                </li>
                                                <li class="td">
                                                    <label class="select">
                                                        <select class="sph_js"></select>
                                                    </label>
                                                </li>
                                                <li class="td">
                                                    <label class="select">
                                                        <select class="cyl_js"></select>
                                                    </label>
                                                </li>
                                                <li data-disabled="true" class="td mobileLi">
                                                    <label><input type="number" pattern="\d*" size="3"></label>
                                                </li>
                                                <li data-border-left="" data-disabled="true" class="td mobileLi">
                                                    <label class="select">
                                                        <select data-disabled="true" class="add_js">
                                                            <option value="">n/a</option>
                                                        </select>
                                                    </label>
                                                </li>
                                            </ul>
                                            <ul class="tr">
                                                <li data-border-right="" class="td tableTitle">
                                                    <span class="add-rx-title">
                                                        OS<br>
                                                        <span>(Left eye)</span>
                                                    </span>
                                                </li>
                                                <li class="td">
                                                    <label class="select">
                                                        <select class="sph_js"></select>
                                                    </label>
                                                </li>
                                                <li class="td">
                                                    <label class="select">
                                                        <select class="cyl_js"></select>
                                                    </label>
                                                </li>
                                                <li data-disabled="true" class="td mobileLi">
                                                    <label><input type="number" pattern="\d*" size="3"></label>
                                                </li>
                                                <li data-disabled="true" data-border-left="" class="td mobileLi">
                                                    <label class="select">
                                                        <select data-disabled="true" class="add_js">
                                                            <option value="">n/a</option>
                                                        </select>
                                                    </label>
                                                </li>
                                            </ul>
                                            <ul class="tr">
                                                <li class="td split-space bottom"></li>
                                            </ul>
                                            <ul class="tr glass-pd">
                                                <li class="td rx-extra-title"><span style="color: red;">*</span> PD
                                                    <a href="#" data-toggle="modal" data-target="#pdDialog" class="color-link">
                                                        <span class="iconfont icon-warning-circle help-tip popper-help pd-icon"></span>
                                                    </a><br>
                                                    <span>(Pupillary Distance)</span>
                                                </li>
                                                <li class="td single">
                                                    <label class="select">
                                                        <select class="pd_js"></select>
                                                    </label>
                                                </li>
                                                <li class="td isTowTd">
                                                    <label style="white-space: nowrap; display: inline-block; transform: translateY(5px); width: auto; font-weight: normal;">
                                                        <div class="checkbox-attr checkPd"></div>
                                                        <span class="checkPd">Two PD numbers</span>
                                                    </label>
                                                </li>
                                            </ul>
                                            <ul class="tr">
                                                <li class="td split-space top"></li>
                                            </ul>
                                            <ul class="tr rx-extra">
                                                <li class="td rx-extra-title">
                                                    Save Prescription As
                                                </li>
                                                <li class="td mobileInput"><input></li>
                                            </ul>
                                            <ul class="tr pt-3 rx-extra">
                                                <li class="td rx-extra-title">
                                                    Any Extra Information
                                                </li>
                                                <li class="td mobileInput mt-3"><textarea rows="2"></textarea></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div style="">
                                    <div class="addPrism">
                                        <label style="transform: translateY(-2px); white-space: nowrap; font-size: 13px; font-weight: inherit; width: auto; display: inline-block;">
                                            <div class="checkbox-attr"></div>
                                            <span class="pr-2 font-14" data-id="{{$res['lens']['prism']['id']}}">Add Prism ${{$res['lens']['prism']['value']}}</span>
                                        </label>
                                        <span class="iconfont icon-warning-circle help-tip popper-help"></span>
                                    </div>
                                </div>
                                <div class="confirmBtn">
                                    <button type="button" class="glass-submit jump" data-to="2">Confirm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item 2 lensTypeSelect">
                        <ul class="lentypes clearfix" data-mobile="true">
                            @foreach($res['lens']['type']['child'] as $key=>$val)
                            <li class="lentype">
                                <section class="content @if($val['json'] && !$val['is_leaf']) @else jump @endif" data-id="{{$val['id']}}" data-name="{{$val['name']}}"
                                         @if($val['id']==32) data-to="3" @else data-to="4" @endif>
                                    <section class="lentype-desc">
                                        <div class="img-box"><img class="img-icon" src="{{ URL::asset('vendor/laravel-shop/img/lens/'.$val['icon']) }}" alt=""></div>
                                        <div class="text-box">
                                            <div class="box-title"><span class="font-weight-bold">{{$val['name']}}</span>
                                                <span class="iconfont icon-warning-circle help-tip iconfont icon-warning-circle help-tip"></span>
                                            </div>
                                            <span>{{$val['value']}}</span>
                                        </div>
                                    </section>
                                </section>
                                @if($val['json'] && !$val['is_leaf'])
                                    <div class="sub-content sub-content0">
                                        <dl>
                                            @foreach($val['json'][0] as $k=>$v)
                                                @if(isset($val['json'][2]))
                                                    <dd>
                                                        <div class="sub-content1">
                                                            {{$v['name']}}
                                                        </div>
                                                        <div class="sub-content2">
                                                            <div>
                                                                <span>Choose Color:</span>
                                                                <div class="mt-3 chooseColor" style="display: inline-block; white-space: nowrap;">
                                                                    @foreach($val['json'][2] as $k1=>$v1)
                                                                        <span class="glass-color" style="background-color: {{$v1['img']}};">
                                                                    <span class="iconfont icon-warning-circle help-tip color-tip"></span>
                                                                </span>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            <div><button type="button" class="glass-submit jump" data-to="4">Confirm</button></div>
                                                        </div>
                                                    </dd>
                                                @else
                                                    <dd>
                                                        <div class="jump sub-content1" data-to="4" data-id="{{$val['id']}}-{{$k}}" data-name="{{$val['name']}} - {{$v['name']}}">
                                                            {{$v['name']}}
                                                        </div>
                                                    </dd>
                                                @endif
                                            @endforeach
                                        </dl>
                                    </div>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="carousel-item 3 sunglasseColor">
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
                    <div class="carousel-item 4 lensPackagSelect">
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
                    <div class="carousel-item 5 customize">
                        @foreach($res['lens']['thickness'] as $key=>$val)
                            <ul class="lensCoatings" data-id="{{$key}}" @if($key!=25) style="display: none;" @endif>
                                @foreach($val as $k=>$v)
                                    <li class="lensCoating">
                                        <section class="content" data-id="{{$key}}-{{$k}}" data-price="{{$v['value']}}">
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
                                        <div class="glass-table"></div>
                                    </li>
                                @endforeach
                            </ul>
                        @endforeach
                    </div>
                </div>
                <div class="product-detail-img_btn d-none">
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
                    <p class="total-price"><span>Total: </span><span class="total-price-style">${{$res['product']['price']}}</span></p>
                    <div class="usage_res d-none justify-content-between" ><span>Usage</span> <span class="res_val"></span></div>
                    <div class="lensType_res d-none justify-content-between" ><span>lensType</span> <span class="res_val"></span></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
let lens = {};

let sph = px_arr(-1600,1000);
let cyl = px_arr(-600,600);
let add = px_arr(100,350);
let pd = px_arr(4000,8000,100,false);
let xx = px_arr(50,500,50,false);

$(function () {
    //0
    $('.usage').on('click','.content',function () {
        $('.usage dd').removeClass('data-active')
        if($(this).hasClass('data-active')){
            $(this).removeClass('data-active')
            $('.usage_res').removeClass('d-flex').addClass('d-none')
            $('.usage_res .res_val').html('').removeAttr('data-usage')
        }else{
            $(this).addClass('data-active')
            $('.usage_res').removeClass('d-none').addClass('d-flex')
            $('.usage_res .res_val').html($(this).attr('data-name')).attr('data-usage',$(this).attr('data-id'))
        }
        $('.usage .content').not($(this)).removeClass('data-active')
        let next = $(this).next();
        next.toggle('normal')
        $(".usage .sub-content").not(next).slideUp('normal')
    })
    $('.usage').on('click','dd',function () {
        $('.usage dd').removeClass('data-active')
        if($(this).hasClass('data-active')){
            $(this).removeClass('data-active')
        }else{
            $(this).addClass('data-active')
        }
        $('.usage_res .res_val').html($(this).attr('data-name')).attr('data-usage',$(this).attr('data-id'))
    })

    //1
    $('.sph_js').html(function () {
        return sph.map(i=>{
            return `<option value="${i}">${i}</option>`
        })
    })
    $('.cyl_js').html(function () {
        return cyl.map(i=>{
            return `<option value="${i}">${i}</option>`
        })
    })
    $('.add_js').append(function () {
        return add.map(i=>{
            return `<option value="${i}">${i}</option>`
        })
    })
    $('.pd_js').html(function () {
        return pd.map(i=>{
            return `<option value="${i}">${i}</option>`
        })
    })

    //2
    $('.lentypes').on('click','.content',function () {
        $('.lentypes .sub-content1').removeClass('data-active')
        if($(this).hasClass('data-active')){
            $(this).removeClass('data-active')
            $('.lensType_res').removeClass('d-flex').addClass('d-none')
            $('.lensType_res .res_val').html('').removeAttr('data-lensType')
        }else{
            $(this).addClass('data-active')
            if($(this).hasClass('jump')) {
                $('.lensType_res').removeClass('d-none').addClass('d-flex')
                $('.lensType_res .res_val').html($(this).attr('data-name')).attr('data-lensType', $(this).attr('data-id'))
            }else{
                $('.lensType_res').removeClass('d-flex').addClass('d-none')
                $('.lensType_res .res_val').html('').removeAttr('data-lensType')
            }
        }
        $('.lentypes .content').not($(this)).removeClass('data-active')
        let next = $(this).next();
        next.toggle('normal')
        $(".lentypes .sub-content").not(next).slideUp()
    })
    $('.lentypes').on('click','.sub-content1',function () {
        if($(this).hasClass('data-active')){
            $(this).removeClass('data-active')
        }else{
            $(this).addClass('data-active')
        }
        $('.lentypes .sub-content1').not($(this)).removeClass('data-active')
        if(!$(this).data('to')){
            let next = $(this).next();
            next.toggle('normal')
            $(".lentypes .sub-content2").not(next).slideUp()
        }else{
            $('.lensType_res').removeClass('d-none').addClass('d-flex')
            $('.lensType_res .res_val').html($(this).attr('data-name')).attr('data-lensType',$(this).attr('data-id'))
        }
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

    $('.lensCoatings').on('click','.content',function () {
        $(this).addClass('data-active')
        $('.lensCoatings .content').not($(this)).removeClass('data-active')
        let html = `<div class="table">
                        @foreach($res['lens']['coating']['json'] as $k=>$v)
                        <ul data-id="{{$k}}" @if($v['img']) data-select="true" @endif data-price="{{$v['value']}}" class="tr" style="cursor: pointer;">
                            <li class="td table-raido" style="width: 7%;">
                                <div class="checkbox-attr uni app-check2"></div>
                            </li>
                            <li class="td" style="width: 15%;">  @if($v['value']) ${{$v['value']}} @else Free @endif</li>
                            <li class="td" style="width: 50%;">
                                {{$v['name']}}
                                <span data-toggle="modal" class="iconfont icon-warning-circle help-tip"></span>
                            </li>
                        </ul>
                        @endforeach
                        <div>
                            <button class="glass-submit mt-3 mb-4">Confirm</button>
                        </div>
                    </div>`
        let next = $(this).next();
        next.html(html).toggle('normal')
        $(".lensCoatings .glass-table").not(next).slideUp('normal',function () {
            $(this).html('')
        })
    })
    $('.lensCoatings .glass-table').on('click','.tr',function () {
        if($(this).attr('data-select')){
            $(this).removeAttr('data-select')
        }else{
            $(this).attr('data-select','true')
        }
    })

    $('#carouselLens').on('click','.jump',function () {
        $('#carouselLens').carousel($(this).data('to'))
    })
})
function px_arr(i,e,step=25,flag=true){
    let arr = []
    while (i<=e){
        arr.push(i)
        i = i+step;
    }
    return arr.map((i)=>{
        if(i>0 && flag){
            return '+'+(i/100).toFixed(2)
        }else{
            return (i/100).toFixed(2)
        }
    })
}
</script>
@include('laravel-shop::common.footer')
