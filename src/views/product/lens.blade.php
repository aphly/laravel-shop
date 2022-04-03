@include('laravel-shop::common.header')
<style>
dl,dd{margin:0;}
.lens_box1{width: 62%;}
.lens_box2{width: 36%;}

.productPreview{display: flex;align-items: center;}
.productPreview img{width: 100%;max-height: 100%;}
.carousel{min-height: 500px;}
.lens_box .img-box{width: 23%;text-align: center;flex-shrink: 0;}

.usage .img-icon{align-items:center;display:flex;justify-content:center;margin:0 auto;min-height:113px;padding:20px 0;width:100px}
.usage .content.data-active,.lentype .content.data-active,.lencolors .lencolors-desc.data-active,.lensCoating .content.data-active,.lensCoatings .content.data-active,.lensPackages .content.data-active{background-color:#c4eeff}
.lensPackag .content,.lentype .content,.usage .content{font-size:14px}
.usage .glass-desc{border-bottom:1px solid #dadada;display:flex;position:relative;vertical-align:middle;width:100%}
.usage .glass-desc div{vertical-align:middle}
.usage .sub-content,.lentype .sub-content,.lencolors .colortips{display: none;}
.usage .sub-content dd{align-items:center;border-bottom:1px solid #dadada;display:flex;height:64px;line-height:64px;padding-left:23%;}
.box-title{align-items:center;color:#000;display:flex;font-size:14px;margin-bottom:10px;margin-top: 25px;}
.lentype .sub-content dd .sub-content1{align-items:center;border-bottom:1px solid #dadada;display:flex;height:64px;line-height:64px;padding-left:23%;}
.lentype-desc,.lencolors-desc,.lensPackage-desc,.lensCoating-desc{cursor:pointer;display:flex;position:relative;vertical-align:middle;width:100%;height: 140px;border-bottom: 1px solid #dadada;}
.lentype .sub-content .lentypeSub>li:first-child,.lentype .sub-content>header:first-child,.lentype-desc{border-bottom:1px solid #dadada}
.lentype .content:not(.data-active):hover,.usage .content:not(.data-active):hover,.lencolors .lencolors-desc:not(.data-active):hover,.lensCoatings .content:not(.data-active):hover,.lensPackages .content:not(.data-active):hover {background-color: #f0fbff;}
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
.lensPackages36 li.lensPackage[data-sort]{display: none}
.customizeLens {color: #7f7f7f; padding-left: 10px;}
.recommended-icon{background:url(/vendor/laravel-shop/img/lens/recommend2.svg) no-repeat 50%;background-size:24px 24px;display:inline-block;height:24px;margin-left:10px;vertical-align:text-bottom;width:24px}
.toCart{background-color:#0da9c4;border:1px solid #0000;border-radius:3px;color:#fff;font-size:14px;line-height:42px;outline:none;padding:0;text-align:center;width:200px}
.rowText{vertical-align:middle!important}
.colspanTitle{font-weight:700}
.carousel_prev{display: none;}
.mobileInput {width: 340px!important;}
.checkbox-attr.data-active{background: none;background-color: #0da9c4; border-color: #0da9c4;color: #fff;}
.prescription .prescription-table input:focus, .prescription .prescription-table select:focus, .prescription .prescription-table textarea:focus {speak: none;border-color: #0da9c4;outline: none;}
.glass-pd{display: flex;align-items: end;}
.pd_l_r{width: 35% !important;}
.pd_l_r label{width: 46%;margin: 0 4px;}
.pd_all{margin-left: 4px !important;}
.rx-extra-title {width: 30%!important;}
.prism_table{display: none;}
</style>
<script>
    function carousel_prev() {
        let id = $('#carouselLens .carousel-inner .carousel-item.active').data('id')
        if(id){
            if(id===2 && lens.usages.name==="Non-prescription") {
                $('#carouselLens').carousel(0)
            }else if(id===4 && lens.lensType.name!=="Sunglasses"){
                $('#carouselLens').carousel(2)
            }else{
                $('#carouselLens').carousel('prev')
            }
        }
    }
</script>
<div class="container">
    <div class="d-flex justify-content-between">
        <div class="lens_box1 lens_box">
            <div id="carouselLens" class="carousel slide" data-ride="carousel" data-interval="false">
                <div class="d-flex justify-content-between">
                    <div class="carousel_prev" onclick="carousel_prev()"><</div>
                    <ol class="d-flex">
                        <li data-target="#carouselLens" data-slide-to="0" class="active">usages</li>
                        <li data-target="#carouselLens" data-slide-to="1">prescription</li>
                        <li data-target="#carouselLens" data-slide-to="2">lensTypeSelect</li>
                    </ol>
                </div>
                <div class="carousel-inner">
                    <div data-id="0" class="carousel-item active usages">
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
                                         <dd class="jump" data-id="{{$k}}" data-name="{{$v['name']}}" data-to="1">
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
                    <div data-id="1" class="carousel-item prescription" >
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
                                                        <select class="sph_js prescription_select" data-name="od_sph"></select>
                                                    </label>
                                                </li>
                                                <li class="td">
                                                    <label class="select">
                                                        <select class="cyl_js prescription_select" data-name="od_cyl"></select>
                                                    </label>
                                                </li>
                                                <li data-disabled="true" class="td mobileLi">
                                                    <label><input type="number" pattern="\d*" size="3" class="prescription_select" data-name="od_axis"></label>
                                                </li>
                                                <li data-border-left="" data-disabled="true" class="td mobileLi">
                                                    <label class="select">
                                                        <select data-disabled="true" class="add_js prescription_select" data-name="od_add">
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
                                                        <select class="sph_js prescription_select" data-name="os_sph"></select>
                                                    </label>
                                                </li>
                                                <li class="td">
                                                    <label class="select">
                                                        <select class="cyl_js prescription_select" data-name="os_cyl"></select>
                                                    </label>
                                                </li>
                                                <li data-disabled="true" class="td mobileLi">
                                                    <label><input type="number" pattern="\d*" size="3" class="prescription_select" data-name="os_axis"></label>
                                                </li>
                                                <li data-disabled="true" data-border-left="" class="td mobileLi">
                                                    <label class="select">
                                                        <select data-disabled="true" class="add_js prescription_select" data-name="os_add">
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
                                                <li class="td single pd_all">
                                                    <label class="select">
                                                        <select class="pd_js prescription_select" data-name="pd_all">
                                                        </select>
                                                    </label>
                                                </li>
                                                <li class="td single pd_l_r d-none">
                                                    <label class="select">
                                                        <select class="pd_js prescription_select" data-name="l_pd"></select>
                                                    </label>
                                                    <label class="select ">
                                                        <select class="pd_js prescription_select" data-name="r_pd"></select>
                                                    </label>
                                                </li>
                                                <li class="td isTowTd">
                                                    <label style="white-space: nowrap; display: inline-block; transform: translateY(5px); width: auto; font-weight: normal;">
                                                        <div class="checkbox-attr uni app-check2 "></div>
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
                                                <li class="td mobileInput"><input id="save"></li>
                                            </ul>
                                            <ul class="tr pt-3 rx-extra">
                                                <li class="td rx-extra-title">
                                                    Any Extra Information
                                                </li>
                                                <li class="td mobileInput mt-3"><textarea id="ext" rows="2"></textarea></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div style="">
                                    <div class="addPrism">
                                        <label style="transform: translateY(-2px); white-space: nowrap; font-size: 13px; font-weight: inherit; width: auto; display: inline-block;">
                                            <div class="checkbox-attr uni app-check2"></div>
                                            <span class="pr-2 font-14" data-id="{{$res['lens']['prism']['id']}}">Add Prism ${{$res['lens']['prism']['value']}}</span>
                                        </label>
                                        <span class="iconfont icon-warning-circle help-tip popper-help"></span>
                                    </div>
                                    <div class="prescription-table prism_table">
                                        <div class="table">
                                            <div class="thead">
                                                <ul class="tr">
                                                    <li class="th tableTitle"></li>
                                                    <li class="th"><span class="rx-name-title">Vertical (Δ)</span></li>
                                                    <li class="th"><span class="rx-name-title">Base Direction</span>
                                                    </li>
                                                    <li class="th d-none d-lg-inline-block"><span class="rx-name-title">Horizontal (Δ)</span>
                                                    </li>
                                                    <li class="th d-none d-lg-inline-block"><span class="rx-name-title">Base Direction</span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="tbody">
                                                <ul class="tr">
                                                    <li class="td tableTitle"><span class="add-rx-title">
                                                                OS<br> <span>(Left eye)</span></span></li>
                                                    <li class="td"><label class="select"><select class="prescription_select" data-name="os_v"></select></label></li>
                                                    <li class="td"><label class="select"><select class="prescription_select" data-name="os_vb"></select></label></li>
                                                    <li class="td d-none d-lg-inline-block"><label
                                                            class="select"><select class="prescription_select" data-name="os_h"></select></label></li>
                                                    <li class="td d-none d-lg-inline-block"><label
                                                            class="select"><select class="prescription_select" data-name="os_hb"></select></label></li>
                                                </ul>
                                                <ul class="tr">
                                                    <li class="td tableTitle">
                                                        <span class="add-rx-title">OD<br> <span>(Right eye)</span></span>
                                                    </li>
                                                    <li class="td"><label class="select"><select class="prescription_select" data-name="od_v"></select></label></li>
                                                    <li class="td"><label class="select"><select class="prescription_select" data-name="od_vb"></select></label></li>
                                                    <li class="td d-none d-lg-inline-block"><label class="select"><select class="prescription_select" data-name="od_h"></select></label></li>
                                                    <li class="td d-none d-lg-inline-block"><label
                                                            class="select"><select class="prescription_select" data-name="od_hb"></select></label></li>
                                                </ul>
                                                <ul class="d-lg-none">
                                                    <li class="td tableTitle"></li>
                                                    <li class="th"><span class="rx-name-title">Horizontal (Δ)</span>
                                                    </li>
                                                    <li class="th"><span class="rx-name-title">Base Direction</span>
                                                    </li>
                                                </ul>
                                                <ul class="d-lg-none">
                                                    <li data-border-right="" class="td tableTitle"><span
                                                            class="add-rx-title">
                                                                OD<br> <span>(Right eye)</span></span></li>
                                                    <li class="td"><label class="select"><select>
                                                                <option value="">n/a</option>
                                                            </select></label></li>
                                                    <li class="td"><label class="select"><select>
                                                                <option value="">n/a</option>
                                                                <option value="in">In</option>
                                                                <option value="out">Out</option>
                                                            </select></label></li>
                                                </ul>
                                                <ul class="d-lg-none">
                                                    <li data-border-right="" class="td tableTitle"><span
                                                            class="add-rx-title">
                                                                OS<br> <span>(Left eye)</span></span></li>
                                                    <li class="td"><label class="select"><select>
                                                                <option value="">n/a</option>
                                                            </select></label></li>
                                                    <li class="td"><label class="select"><select>
                                                                <option value="">n/a</option>
                                                                <option value="in">In</option>
                                                                <option value="out">Out</option>
                                                            </select></label></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="confirmBtn">
                                    <button type="button" class="glass-submit jump" data-to="2">Confirm</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div data-id="2" class="carousel-item lensTypeSelect" >
                        <ul class="lentypes clearfix" data-mobile="true">
                            @foreach($res['lens']['type']['child'] as $key=>$val)
                            <li class="lentype">
                                <section class="content @if($val['json'] && !$val['is_leaf']) @else jump @endif" data-id="{{$val['id']}}" data-name="{{$val['name']}}"
                                         @if($val['id']==32) data-to="3" @else data-to="4" data-thickness_id="{{$val['id']}}" @endif>
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
                                                        <div class="sub-content1" data-id="{{$k}}" data-name="{{$v['name']}}">
                                                            {{$v['name']}}
                                                        </div>
                                                        <div class="sub-content2">
                                                            <div>
                                                                <span>Choose Color:</span>
                                                                <div class="mt-3 chooseColor" style="display: inline-block; white-space: nowrap;">
                                                                    @foreach($val['json'][2] as $k1=>$v1)
                                                                        <span class="glass-color" style="background-color: {{$v1['img']}};" data-name="{{$v1['img']}}" data-id="{{$k1}}">
                                                                            <span class="iconfont icon-warning-circle help-tip color-tip"></span>
                                                                        </span>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            <div class="glass-submit0"><button type="button" class="glass-submit jump" data-to="4" data-thickness_id="{{$v['value']}}">Confirm</button></div>
                                                        </div>
                                                    </dd>
                                                @else
                                                    <dd>
                                                        <div class="jump sub-content1" data-to="4" data-thickness_id="{{$v['value']}}" data-id="{{$k}}" data-name="{{$v['name']}}">
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
                    <div data-id="3" class="carousel-item sunglasseColor">
                        <ul class="lencolors ">
                            @foreach($res['lens']['sunglasses']['child'] as $key=>$val)
                            <li class="lencolor " >
                                <section class="lencolors-desc sub-boder" data-id="{{$val['id']}}" data-name="{{$val['name']}}">
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
                                    <div class="chooseColor0">
                                        <span>Choose Color:</span>
                                        <div class="mt-3 chooseColor" style="display: inline-block; white-space: nowrap;">
                                            @foreach($val['json'][1] as $k=>$v)
                                            <span class="glass-color" data-color="{{$v['img']}}" data-color_id="{{$k}}" data-color_value="{{$v['value']}}" style="background-color: {{$v['img']}};">
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
                                            <span class="color-opacity" data-opacity_id="{{$k}}" data-opacity="{{$v['value']}}">{{$v['value']}}</span>
                                        @endforeach
                                    </div>
                                    @endif
                                    <div class="glass-submit0">
                                        <button type="button" class="glass-submit jump" data-to="4" data-thickness_id="{{$val['id']}}">Confirm</button>
                                    </div>
                                </div>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div data-id="4" class="carousel-item lensPackagSelect">
                        @foreach($res['lens']['thickness'] as $key=>$val)
                        <ul class="lensPackages lensPackages{{$key}}" data-id="{{$key}}" style="display: none;">
                            @foreach($val as $k=>$v)
                                @if($v['ext1'])
                                    <?php $price = floatval($v['price'])+(floatval($res['lens']['coating']['json']['usyxbeqe']['price'])+floatval($res['lens']['coating']['json']['rivvvcmn']['price'])+floatval($res['lens']['coating']['json']['qoyogomx']['price'])); ?>
                                <li class="lensPackage" data-sort="{{$v['sort']}}">
                                    <section class="content" data-id="{{$k}}" data-name="{{$v['name']}}" data-price="{{floatval($v['price'])}}" data-sum="{{$price}}">
                                        <section class="lensPackage-desc">
                                            <div class="img-box"><img src="/vendor/laravel-shop/img/lens/package2.svg" alt=""></div>
                                            <div class="text-box">
                                                <div class="box-title">
                                                    <span class="font-weight-bold">{{$v['ext1']}}</span>
                                                    <div class="lenTitleDescrip"><span>&nbsp;-&nbsp;</span>
                                                        <span class="price">${{$price}}</span>
                                                        <?php $thickness = substr($v['name'],0,4); ?>
                                                        @if($thickness=='1.50')
                                                        @elseif($thickness=='1.57')
                                                            <span class="thinner">(Up to 15% thinner)</span>
                                                        @elseif($thickness=='1.59')
                                                            <span class="thinner">(Up to 20% thinner)</span>
                                                        @elseif($thickness=='1.61')
                                                            <span class="thinner">(Up to 25% thinner)</span>
                                                        @elseif($thickness=='1.67')
                                                            <span class="thinner">(Up to 30% thinner)</span>
                                                        @elseif($thickness=='1.74')
                                                            <span class="thinner">(Up to 35% thinner)</span>
                                                        @endif
                                                        @if($v['ext2'])
                                                        <i class="recommended-icon"></i>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="thinner d-inline-block d-lg-none">
                                                    (Up to 15% thinner)
                                                </div>
                                                <div class="lensPackage_coating">
                                                    <span>{{ $v['name'] }}</span>
                                                    <span data-id="usyxbeqe" data-name="{{$res['lens']['coating']['json']['usyxbeqe']['name']}}" data-price="{{$res['lens']['coating']['json']['usyxbeqe']['price']}}">, Anti-Scratch</span>
                                                    <span data-id="rivvvcmn" data-name="{{$res['lens']['coating']['json']['rivvvcmn']['name']}}" data-price="{{$res['lens']['coating']['json']['rivvvcmn']['price']}}">, Anti-Reflective</span>
                                                    <span data-id="qoyogomx" data-name="{{$res['lens']['coating']['json']['qoyogomx']['name']}}" data-price="{{$res['lens']['coating']['json']['qoyogomx']['price']}}">, UV Coating</span>
                                                    @if($key==27)
                                                        <span data-id="rriveqdk" data-name="{{$res['lens']['coating']['json']['rriveqdk']['name']}}" data-price="{{$res['lens']['coating']['json']['rriveqdk']['price']}}">, Water Resistant Coating</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </section>
                                    </section>
                                </li>
                                @endif
                            @endforeach
                            <li class="lensPackage jump" data-to="5" data-thickness_id="{{$key}}">
                                <section class="content" data-res="1">
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
                    <div data-id="5" class="carousel-item customize">
                        @foreach($res['lens']['thickness'] as $key=>$val)
                            <ul class="lensCoatings lensCoatings{{$key}}" data-id="{{$key}}" style="display: none;">
                                @foreach($val as $k=>$v)
                                    <li class="lensCoating">
                                        <section class="content" data-id="{{$k}}" data-price="{{$v['price']}}" data-name="{{$v['name']}}">
                                            <section class="lensCoating-desc">
                                                <div class="text-box">
                                                    <div class="box-title pb-0">
                                                        <div class="font-weight-bold">
                                                            {{$v['name']}}
                                                            <span>&nbsp;-&nbsp;</span>
                                                            @if($v['price'])
                                                                <span>${{$v['price']}}</span>
                                                            @else
                                                                <span>Free</span>
                                                            @endif
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

            </div>
        </div>
        <div class="lens_box2">
            <div>
                <div class="productPreview">
                    @if($res['product_img'])
                        <img src="{{Storage::url($res['product_img']['src'])}}" alt="">
                    @endif
                </div>
                <div class="ProductPrice">
                    <p class="sku"><a href="/eyeglasses/{{$res['product']['sku']}}" title="{{$res['product']['name']}}">{{$res['product']['name']}}</a></p>
                    <p>{{$res['product']['color']}}</p>
                    <p class="total-price"><span>Total: </span><span class="total-price-style frame_price">${{$res['product']['price']}}</span></p>
                    <div class="lens_cart"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
let lens = {
    'usages':{},
    'prescription':{
        status: false,
        os_add: "+1.50",
        os_axis: "1",
        os_cyl: "-5.25",
        os_sph: "-15.25",
        od_add: "+1.25",
        od_axis: "1",
        od_cyl: "-4.75",
        od_sph: "-5.25",
        l_pd:'40.00',
        r_pd:'40.00',
        pd_all:'63.00',
        pd_status:false,
        prism:false,
        os_v: "1.00",
        os_vb: "up",
        os_h: "4.00",
        os_hb: "in",
        od_v: "0",
        od_vb: "up",
        od_h: "4.00",
        od_hb: "in",
        save:'',
        ext:''
    },
    'lensType':{},
    'sunglasses': {},
    'lensPackagSelect':{arr:[]},
    'customize':{arr:[]}
};

let frame_price = {{$res['product']['price']}};
let sph = px_arr(-1600,1000);
let cyl = px_arr(-600,600);
let add = px_arr(100,350);
let pd = px_arr(2200,4000,100,false);
let pd_all = px_arr(4000,8000,100,false);
let prism = px_arr(50,500,50,false);
let vb = ['up','down'];
let hb = ['in','out'];

$(function () {
    //0
    $('.usage').on('click','.content',function () {
        lens['usages']['id'] = $(this).attr('data-id')
        lens['usages']['name'] = $(this).attr('data-name')
        delete lens['usages']['child_id']
        delete lens['usages']['child_name']
        lensCart()
        $('.usage dd').removeClass('data-active')
        if($(this).hasClass('data-active')){
            //$(this).removeClass('data-active')
        }else{
            $(this).addClass('data-active')
        }
        $('.usage .content').not($(this)).removeClass('data-active')
        let next = $(this).next();
        next.toggle('normal')
        $(".usage .sub-content").not(next).slideUp('normal')
    })

    $('.usage').on('click','dd',function () {
        $('.usage dd').removeClass('data-active')
        if($(this).hasClass('data-active')){
            //$(this).removeClass('data-active')
        }else{
            $(this).addClass('data-active')
        }
        lens['usages']['child_id'] = $(this).attr('data-id')
        lens['usages']['child_name'] = $(this).attr('data-name')
        lensCart()
    })

    //1
    $('.prescription_select[data-name="od_sph"]').html(function () {
        return sph.map(i=>{
            if(i==lens.prescription.od_sph){
                return `<option value="${i}" selected="selected">${i}</option>`
            }else{
                return `<option value="${i}">${i}</option>`
            }
        })
    })
    $('.prescription_select[data-name="od_cyl"]').html(function () {
        return cyl.map(i=>{
            if(i==lens.prescription.od_cyl){
                return `<option value="${i}" selected="selected">${i}</option>`
            }else{
                return `<option value="${i}">${i}</option>`
            }
        })
    })
    $('.prescription_select[data-name="od_cyl"]').html(function () {
        return cyl.map(i=>{
            if(i==lens.prescription.od_cyl){
                return `<option value="${i}" selected="selected">${i}</option>`
            }else{
                return `<option value="${i}">${i}</option>`
            }
        })
    })
    $('.prescription_select[data-name="od_add"]').html(function () {
        return add.map(i=>{
            if(i==lens.prescription.od_add){
                return `<option value="${i}" selected="selected">${i}</option>`
            }else{
                return `<option value="${i}">${i}</option>`
            }
        })
    })
    $('.prescription_select[data-name="l_pd"]').html(function () {
        let l_pd =`<option value="0">Left</option>`
        l_pd += pd.map(i=>{
            if(i==lens.prescription.l_pd){
                return `<option value="${i}" selected="selected">${i}</option>`
            }else{
                return `<option value="${i}">${i}</option>`
            }
        })
        return l_pd;
    })
    $('.prescription_select[data-name="r_pd"]').html(function () {
        let r_pd =`<option value="0">Right</option>`
        r_pd += pd.map(i=>{
            if(i==lens.prescription.r_pd){
                return `<option value="${i}" selected="selected">${i}</option>`
            }else{
                return `<option value="${i}">${i}</option>`
            }
        })
        return r_pd;
    })
    $('.prescription_select[data-name="pd_all"]').html(function () {
        return pd_all.map(i=>{
            if(i==lens.prescription.pd_all){
                return `<option value="${i}" selected="selected">${i}</option>`
            }else{
                return `<option value="${i}">${i}</option>`
            }
        })
    })

    $('.prescription_select[data-name="os_sph"]').html(function () {
        return sph.map(i=>{
            if(i==lens.prescription.os_sph){
                return `<option value="${i}" selected="selected">${i}</option>`
            }else{
                return `<option value="${i}">${i}</option>`
            }
        })
    })
    $('.prescription_select[data-name="os_cyl"]').html(function () {
        return cyl.map(i=>{
            if(i==lens.prescription.os_cyl){
                return `<option value="${i}" selected="selected">${i}</option>`
            }else{
                return `<option value="${i}">${i}</option>`
            }
        })
    })
    $('.prescription_select[data-name="os_add"]').html(function () {
        return add.map(i=>{
            if(i==lens.prescription.os_add){
                return `<option value="${i}" selected="selected">${i}</option>`
            }else{
                return `<option value="${i}">${i}</option>`
            }
        })
    })
    $('.prescription_select[data-name="od_v"]').html(function () {
        let top =`<option value="0">n/a</option>`
        top += prism.map(i=>{
            if(i==lens.prescription.od_v){
                return `<option value="${i}" selected="selected">${i}</option>`
            }else{
                return `<option value="${i}">${i}</option>`
            }
        })
        return top
    })
    $('.prescription_select[data-name="od_vb"]').html(function () {
        let top =`<option value="0">n/a</option>`
        top += vb.map(i=>{
            if(i==lens.prescription.od_vb){
                return `<option value="${i}" selected="selected">${i}</option>`
            }else{
                return `<option value="${i}">${i}</option>`
            }
        })
        return top
    })
    $('.prescription_select[data-name="od_h"]').html(function () {
        let top =`<option value="0">n/a</option>`
        top += prism.map(i=>{
            if(i==lens.prescription.od_h){
                return `<option value="${i}" selected="selected">${i}</option>`
            }else{
                return `<option value="${i}">${i}</option>`
            }
        })
        return top
    })
    $('.prescription_select[data-name="od_hb"]').html(function () {
        let top =`<option value="0">n/a</option>`
        top += hb.map(i=>{
            if(i==lens.prescription.od_hb){
                return `<option value="${i}" selected="selected">${i}</option>`
            }else{
                return `<option value="${i}">${i}</option>`
            }
        })
        return top
    })
    $('.prescription_select[data-name="os_v"]').html(function () {
        let top =`<option value="0">n/a</option>`
        top += prism.map(i=>{
            if(i==lens.prescription.os_v){
                return `<option value="${i}" selected="selected">${i}</option>`
            }else{
                return `<option value="${i}">${i}</option>`
            }
        })
        return top
    })
    $('.prescription_select[data-name="os_vb"]').html(function () {
        let top =`<option value="0">n/a</option>`
        top += vb.map(i=>{
            if(i==lens.prescription.os_vb){
                return `<option value="${i}" selected="selected">${i}</option>`
            }else{
                return `<option value="${i}">${i}</option>`
            }
        })
        return top
    })
    $('.prescription_select[data-name="os_h"]').html(function () {
        let top =`<option value="0">n/a</option>`
        top += prism.map(i=>{
            if(i==lens.prescription.os_h){
                return `<option value="${i}" selected="selected">${i}</option>`
            }else{
                return `<option value="${i}">${i}</option>`
            }
        })
        return top
    })
    $('.prescription_select[data-name="os_hb"]').html(function () {
        let top =`<option value="0">n/a</option>`
        top += hb.map(i=>{
            if(i==lens.prescription.os_hb){
                return `<option value="${i}" selected="selected">${i}</option>`
            }else{
                return `<option value="${i}">${i}</option>`
            }
        })
        return top
    })

    $('.isTowTd').on('click','.checkbox-attr',function () {
        if($(this).hasClass('data-active')){
            lens.prescription.pd_status=false;
            $(this).removeClass('data-active')
            $('.pd_all').show()
            $('.pd_l_r').addClass('d-none').removeClass('d-flex')
        }else{
            lens.prescription.pd_status=true;
            $(this).addClass('data-active')
            $('.pd_all').hide()
            $('.pd_l_r').addClass('d-flex').removeClass('d-none')
        }
    })
    $('.prescription_select').change(function () {
        let name = $(this).data('name')
        lens.prescription[name] = $(this).val()
    })

    $('.addPrism').on('click','.checkbox-attr',function () {
        if($(this).hasClass('data-active')){
            lens.prescription.prism=false;
            $(this).removeClass('data-active')
            $('.prism_table').hide()
        }else{
            lens.prescription.prism=true;
            $(this).addClass('data-active')
            $('.prism_table').show()
        }
    })

    $('.prescription').on('click','.jump',function () {
        lens.prescription.status = true;
        lens.prescription.save = $('#save').val()
        lens.prescription.ext = $('#ext').val()
        lensCart()
    })

    //2
    $('.lentypes').on('click','.content',function () {
        lensReset(3)
        lens['lensType']['id'] = $(this).attr('data-id')
        lens['lensType']['name'] = $(this).attr('data-name')
        delete lens['lensType']['child1_id']
        delete lens['lensType']['child1_name']
        delete lens['lensType']['child2_id']
        delete lens['lensType']['child2_name']
        lensCart()
        $('.lentypes .sub-content1').removeClass('data-active')
        $('.lentypes .sub-content2').css('display','none')
        if($(this).hasClass('data-active')){
            //$(this).removeClass('data-active')
        }else{
            $(this).addClass('data-active')
        }
        $('.lentypes .content').not($(this)).removeClass('data-active')
        let next = $(this).next();
        next.toggle('normal')
        $(".lentypes .sub-content").not(next).slideUp()
    })

    $('.lentypes').on('click','.sub-content1',function () {
        lens['lensType']['child1_id'] = $(this).attr('data-id')
        lens['lensType']['child1_name'] = $(this).attr('data-name')
        delete lens['lensType']['child2_id']
        delete lens['lensType']['child2_name']
        if($(this).hasClass('jump')){
            lensCart()
        }
        if($(this).hasClass('data-active')){
            //$(this).removeClass('data-active')
        }else{
            $(this).addClass('data-active')
        }
        $('.lentypes .sub-content1').not($(this)).removeClass('data-active')
        if(!$(this).data('to')){
            let next = $(this).next();
            next.toggle('normal')
            $(".lentypes .sub-content2").not(next).slideUp()
        }
    })

    $('.lentypes .chooseColor').on('click','.glass-color',function () {
        lens['lensType']['child2_id'] = $(this).attr('data-id')
        lens['lensType']['child2_name'] = $(this).attr('data-name')
        lensCart()
        $(this).addClass('data-active')
        $('.lentypes .chooseColor .glass-color').not($(this)).removeClass('data-active')
    })

    //3
    $('.sunglasseColor .lencolors').on('click','.lencolors-desc',function () {
        $(this).addClass('data-active')
        $('.lencolors .lencolors-desc').not($(this)).removeClass('data-active')
        let next = $(this).next();
        next.toggle('normal')
        $(".lencolors .colortips").not(next).slideUp()
        lens['sunglasses']['id'] = $(this).data('id')
        lens['sunglasses']['name'] = $(this).data('name')
        delete lens['sunglasses']['color_id']
        delete lens['sunglasses']['color']
        delete lens['sunglasses']['color_value']
        delete lens['sunglasses']['opacity_id']
        delete lens['sunglasses']['opacity']
    })

    $('.sunglasseColor .chooseColor').on('click','.glass-color',function () {
        $(this).addClass('data-active')
        $(this).closest('.chooseColor').children().not($(this)).removeClass('data-active')
        lens['sunglasses']['color_id'] = $(this).data('color_id')
        lens['sunglasses']['color'] = $(this).data('color')
        lens['sunglasses']['color_value'] = $(this).data('color_value')
        lensCart()
    })

    $('.sunglasseColor .strength').on('click','.color-opacity',function () {
        $(this).addClass('data-active')
        $('.sunglasseColor .strength .color-opacity').not($(this)).removeClass('data-active')
        lens['sunglasses']['opacity_id'] = $(this).data('opacity_id')
        lens['sunglasses']['opacity'] = $(this).data('opacity')
        lensCart()
    })

    //4
    $('.lensPackagSelect .lensPackage').on('click','.content',function () {
        lens.lensPackagSelect = {arr:[]}
        $(this).addClass('data-active')
        $('.lensPackagSelect .lensPackage .content').not($(this)).removeClass('data-active')
        if($(this).data('res')) {
            lens.customize['title'] = 'customize Lenses'
        }else{
            lens.lensPackagSelect['id']=$(this).data('id')
            lens.lensPackagSelect['name']=$(this).data('name')
            lens.lensPackagSelect['price']=$(this).data('price')
            lens.lensPackagSelect['sum']=$(this).data('sum')
            let select = $(this).children('.lensPackage-desc').children('.text-box').children('.lensPackage_coating').children('span[data-id]')
            select.map(i=>{
                lens.lensPackagSelect.arr.push({'id':$(select[i]).data('id'),'name':$(select[i]).data('name'),'price':$(select[i]).data('price')})
            })
            lens.customize={arr:[]}
        }
        lensCart()
    })

    //5
    $('.customize .lensCoatings').on('click','.content',function () {
        lens.customize['id'] = $(this).data('id')
        lens.customize['name'] = $(this).data('name')
        lens.customize['price'] = $(this).data('price')
        $(this).addClass('data-active')
        $('.customize .lensCoatings .content').not($(this)).removeClass('data-active')
        let html = `<div class="table">
                        @foreach($res['lens']['coating']['json'] as $k=>$v)
                        <ul data-id="{{$k}}" @if($v['ext1']) data-select="true" @endif data-price="{{$v['price']}}" data-name="{{$v['name']}}" class="tr" style="cursor: pointer;">
                            <li class="td table-raido" style="width: 7%;">
                                <div class="checkbox-attr uni app-check2"></div>
                            </li>
                            <li class="td" style="width: 15%;">  @if($v['price']) ${{$v['price']}} @else Free @endif</li>
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
        $(".customize .lensCoatings .glass-table").not(next).slideUp('normal',function () {
            $(this).html('')
        })
    })
    $('.customize .lensCoatings .glass-table').on('click','.tr',function () {
        if($(this).attr('data-select')){
            $(this).removeAttr('data-select')
        }else{
            lens.customize.arr = []
            $(this).attr('data-select','true')
        }
    })
    $('.customize .lensCoatings .glass-table').on('click','.glass-submit',function () {
        let select = $(this).closest('.table').children('ul[data-select="true"]')
        let sum = 0;
        select.map(i=>{
            let price = $(select[i]).data('price')
            sum += Number(price)*100
            lens.customize.arr.push({'id':$(select[i]).data('id'),'name':$(select[i]).data('name'),price})
        })
        lens.customize.sum = (sum+ lens.customize.price*100)/100;
        lensCart()
    })

    $('#carouselLens').on('click','.jump',function () {
        let to = $(this).data('to')
        let thickness_id = $(this).attr('data-thickness_id')
        if(to===4 && thickness_id){
            $('.lensPackages'+thickness_id).css('display','block')
            if(thickness_id===(36+'')){
                $('.lensPackages'+thickness_id+' li.lensPackage[data-sort]').hide()
                let sorts = lens.sunglasses.color_value
                if(sorts){
                    let arr = sorts.split(',')
                    arr.forEach(i=>{
                        $('.lensPackages'+thickness_id+' li.lensPackage[data-sort="'+i+'"]').show()
                    })
                }
            }
        }else if(to===5 && thickness_id){
            lens.lensPackagSelect = {arr:[]}
            $('.lensCoatings'+thickness_id).show()
        }
        if(to){
           $('.carousel_prev').show()
           $('#carouselLens').carousel(to)
        }
    })

    $('#carouselLens').on('slide.bs.carousel', function (event) {
        // let hoder = $('#carouselLens').find('.carousel-item'),
        //     items = $(event.relatedTarget);
        // let getIndex= hoder.index(items);
        // console.log(getIndex)
        // console.log(event.direction)
        // console.log(event.from)
        // console.log(event.to)
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

function lensReset(step) {
    if(step===3){
        lens['sunglasses']={}
        $('.sunglasseColor .glass-color').removeClass('data-active');
        $('.sunglasseColor .color-opacity').removeClass('data-active');
        $('.sunglasseColor .lencolors-desc').removeClass('data-active');
        $('.sunglasseColor .colortips').hide();

        lens.lensPackagSelect={arr:[]}
        $('.lensPackagSelect .content').removeClass('data-active');

        $('.lensPackages').hide()
        $('.lensCoatings').hide()
    }
}

function lensCart() {
    let html = '';
    for(let i in lens){
        let obj = lens[i]
        if(!$.isEmptyObject(obj)){
            html += `<div class="${i}_res cart_res ">`
            if(i==='usages'){
                if("child_id" in obj){
                    html += `<div class="d-flex justify-content-between"><span>${i}</span><span class="res_val">${obj.name} - ${obj.child_name}</span></div>`
                }else{
                    html += `<div class="d-flex justify-content-between"><span>${i}</span><span class="res_val">${obj.name}</span></div>`
                }
            }else if(i==='prescription'){
                if(obj.status){
                    html += `<div class="d-flex justify-content-between"><span>Your Prescription</span><span class="res_val"></span></div>`
                    if(obj.pd_status){
                        html += `<table class="table table-bordered text-center table-content">
                            <thead><tr><th>RX</th><th>SPH</th><th>CYL</th><th>Axis</th><th>ADD</th><th>PD</th></tr></thead>
                            <tbody>
                                <tr><td class="colspanTitle">OS</td> <td>${obj.os_sph}</td> <td>${obj.os_cyl}</td> <td>${obj.os_axis}</td><td>${obj.os_add}</td><td class="rowText">${obj.l_pd}</td></tr>
                                <tr><td class="colspanTitle">OD</td> <td>${obj.od_sph}</td> <td>${obj.od_cyl}</td> <td>${obj.od_axis}</td><td>${obj.od_add}</td><td class="rowText">${obj.r_pd}</td></tr>
                            </tbody>
                        </table>`
                    }else{
                        html += `<table class="table table-bordered text-center table-content">
                            <thead><tr><th>RX</th><th>SPH</th><th>CYL</th><th>Axis</th><th>ADD</th><th>PD</th></tr></thead>
                            <tbody>
                                <tr><td class="colspanTitle">OS</td> <td>${obj.os_sph}</td> <td>${obj.os_cyl}</td> <td>${obj.os_axis}</td><td>${obj.os_add}</td><td rowspan="2" class="rowText">${obj.pd_all}</td></tr>
                                <tr><td class="colspanTitle">OD</td> <td>${obj.od_sph}</td> <td>${obj.od_cyl}</td> <td>${obj.od_axis}</td><td>${obj.od_add}</td></tr>
                            </tbody>
                        </table>`
                    }
                    if(obj.prism){
                        html += `<table class="table table-bordered text-center table-content">
                            <thead><tr><th></th> <th>Vertical (Δ)</th> <th>Base Direction</th> <th>Horizontal (Δ)</th> <th>Base Direction</th></tr></thead>
                            <tbody><tr><td class="colspanTitle">OS</td> <td>${obj.os_v}</td> <td>${obj.os_vb}</td> <td>${obj.os_h}</td> <td>${obj.os_hb}</td></tr><tr>
                                <td class="colspanTitle">OD</td> <td>${obj.od_v}</td> <td>${obj.od_vb}</td> <td>${obj.od_h}</td> <td>${obj.od_hb}</td></tr>
                                </tbody></table>`
                    }

                }
            }else if(i==='lensType'){
                if("child2_id" in obj){
                    html += `<div class="d-flex justify-content-between"><span>${i}</span><span class="res_val">${obj.name}</span></div>`
                    html += `<div class="d-flex justify-content-between"><span>${obj.child1_name}</span><span class="res_val">${obj.child2_name}</span></div>`
                }else{
                    if("child1_id" in obj){
                        html += `<div class="d-flex justify-content-between"><span>${i}</span><span class="res_val">${obj.name} - ${obj.child1_name}</span></div>`
                    }else{
                        html += `<div class="d-flex justify-content-between"><span>${i}</span><span class="res_val">${obj.name}</span></div>`
                    }
                }
            }else if(i==='sunglasses'){
                if("opacity_id" in obj){
                    html += `<div class="d-flex justify-content-between"><span>${obj.name}</span><span class="res_val">${obj.color} - ${obj.opacity}</span></div>`
                }else{
                    html += `<div class="d-flex justify-content-between"><span>${obj.name}</span><span class="res_val">${obj.color}</span></div>`
                }
            }else if(i==='lensPackagSelect'){
                if('sum' in obj){
                    html += `<div class="d-flex justify-content-between"><span>Lenses</span><span class="res_val">$${obj.sum}</span></div>`
                    html += `<div class="d-flex justify-content-between"><span class="customizeLens">--${obj.name}</span><span class="res_val">$${obj.price}</span></div>`
                }
                if(obj.arr.length>0){
                    obj.arr.forEach(i=>{
                        html += `<div class="d-flex justify-content-between"><span class="customizeLens">--${i.name}</span><span class="res_val">${i.price?'$'+i.price:'Free'}</span></div>`
                    })
                }
            }else if(i==='customize'){
                if('title' in obj){
                    html += `<div class="d-flex justify-content-between"><span>${obj.title}</span><span class="res_val">${('sum' in obj)?'$'+obj.sum:''}</span></div>`
                }
                if('name' in obj){
                    html += `<div class="d-flex justify-content-between"><span class="customizeLens">--${obj.name}</span><span class="res_val">${obj.price?'$'+obj.price:'Free'}</span></div>`
                }
                if(obj.arr.length>0) {
                    obj.arr.forEach(i => {
                        html += `<div class="d-flex justify-content-between"><span class="customizeLens">--${i.name}</span><span class="res_val">${i.price ? '$' + i.price : 'Free'}</span></div>`
                    })
                }
            }
            html += `</div>`
        }
    }
    if(('sum' in lens.lensPackagSelect) || ('sum' in lens.customize)){
        let total = Number(frame_price)*100
        if('sum' in lens.lensPackagSelect){
            total = (total+lens.lensPackagSelect.sum*100)/100
        }
        if('sum' in lens.customize){
            total = (total+lens.customize.sum*100)/100
        }
        html +=`<div class="d-flex justify-content-between Subtotal"><span class="">Subtotal</span><span class="res_val">$${total}</span></div>`
        html +=`<div class="d-flex justify-content-between "><button type="button" class="toCart add-to-cart">Add To Cart</button></div>`
    }
    $('.lens_cart').html(html)
    console.log(lens);
}
</script>
@include('laravel-shop::common.footer')
