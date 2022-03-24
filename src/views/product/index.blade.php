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
    .filter-icon{padding: 2px;width: 22px;height: 22px;border-radius: 50%;border: 1px solid #fff;}

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
                            <div class="col-12 mb-lg-3 mb-4 filter_where @if($res['filter'][$key] && in_array($v['value'],$res['filter'][$key])) checked @endif" data-key="{{$key}}[]" data-val="{{$v['value']}}">
                                <label>
                                    <input type="checkbox" @if($res['filter'][$key] && in_array($v['value'],$res['filter'][$key])) checked @endif
                                    class="form-checkbox mt-n1" name="{{$key}}" value="{{$v['value']}}">
                                    @if($key=='color')
                                        <div class="filter-icon" style="background-color: {{$v['img']}}"></div>
{{--                                    @elseif($key=='shape')--}}
{{--                                        <img src="" alt="">--}}
                                    @endif
                                    {{$v['name']}}
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
<style>
    .product-icon-text-style2{background-color: #777620;color: white;font-size: 15px; border-radius: 20px;padding: 1px 8px;margin-bottom: 5px;}
    .product-img img{width: 100%;}
</style>
<div class="container">
    <ul class="row">
        @foreach($res['list']['data'] as $key=>$val)
            <li class="col-lg-4">
                <div class="product-text">
                    <span class="product-icon-text-style2">New</span>
                </div>
                <div class="product-img">
                    <ul>
                        @foreach($res['product'][$val['spu']] as $k=>$v)
                            <li data-id="{{$v['id']}}" @if($k) style="display: none" @endif >
                                <div class="d-flex align-items-center ">
                                    <img class="lazy"
                                         @if(isset($res['product_img'][$v['id']][1]))
                                         data-src="{{Storage::url($res['product_img'][$v['id']][1]['src'])}}"
                                         @endif
                                         @if(isset($res['product_img'][$v['id']][0]))
                                         data-original="{{Storage::url($res['product_img'][$v['id']][0]['src'])}}"
                                         @endif
                                         src="vendor/laravel-shop/img/default.png" alt="">
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="product-img-list">
                    <ul>
                        @foreach($res['product'][$val['spu']] as $k=>$v)
                            <li>
                                <div class="d-flex justify-content-between">

                                </div>
                            </li>
                        @endforeach
                    </ul>
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
    $('.product-img img').on({
        mouseover : function(){
            $(this).attr('src',$(this).data('src'));
        },
        mouseout : function(){
            $(this).attr('src',$(this).data('original'));
        }
    })
})
</script>

@include('laravel-shop::common.footer')
