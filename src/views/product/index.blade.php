@include('laravel-shop::common.header')
<style>

</style>
<div class="container">
    <ul class="filter-wrap row flex-lg-nowrap">
        @foreach($res['filter_arr'] as $key=>$val)
            <li class="position-relative col-12 col-lg-auto p-0 filter-item ">
                <div class="filter-menu">
                    <span>{{$key}}</span>
                    <span><a href="#" class="color-link d-lg-none"></a><i class="uni app-xia"></i></span>
                </div>
                <div class="filter-down filter-down-{{$key}}">
                    <div class="row m-0">
                        @foreach($val as $k=>$v)
                            <div class="filter_where @if($res['filter'][$key] && in_array($v['value'],$res['filter'][$key])) checked @endif" data-key="{{$key}}[]" data-val="{{$v['value']}}">
                                <label>
                                    <input type="checkbox" @if($res['filter'][$key] && in_array($v['value'],$res['filter'][$key])) checked @endif
                                    class="form-checkbox" name="{{$key}}" value="{{$v['value']}}">
                                    @if($key=='color')
                                        <div class="filter-icon" style="background-color: {{$v['img']}}"></div>
                                    @elseif($key=='shape' || $key=='frame')
                                        <img src="vendor/laravel-shop/img/filter/{{$key}}/{{$v['value']}}.png" alt="">
                                    @endif
                                    {{$v['name']}}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </li>
        @endforeach
            <li class="position-relative col-12 col-lg-auto p-0 filter-item " style="width: 200px;">
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
                            <a href="/eyeglasses/{{$v['sku']}}">
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
                            </a>
                        @endforeach
                    </ul>
                </div>
                <div class="product-img-list d-flex justify-content-between">
                    <div class="">
                        <ul class="d-flex">
                            @foreach($res['product'][$val['spu']] as $k=>$v)
                                <li data-id="{{$v['id']}}" >
                                    <div class="d-flex ">
                                        <div>
                                            {!! \Aphly\LaravelShop\Models\Product::color($res['filter_arr']['color'],$v['color']) !!}
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="">
                        <ul>
                            @foreach($res['product'][$val['spu']] as $k=>$v)
                                <li data-id="{{$v['id']}}" >
                                    <div class="d-flex ">
                                        <div @if($k) style="display: none" @endif>
                                            <i class="uni app-aixin"></i>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="">
                    <ul>
                        @foreach($res['product'][$val['spu']] as $k=>$v)
                            <li data-id="{{$v['id']}}" @if($k) style="display: none" @endif >
                                <div class="d-flex justify-content-between">
                                    <div>
                                        {{$v['name']}}
                                    </div>
                                    <div>
                                        ${{floatval($v['price'])}}
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>
        @endforeach
    </ul>
</div>
<style>

</style>

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
