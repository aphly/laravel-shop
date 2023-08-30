@include('laravel-shop-front::common.header')
<style>

</style>
<script>
    $(function () {
        $('.filters11').click(function () {
            let obj = $(this).find('.uni')
            if(obj.hasClass('app-jia1')){
                obj.removeClass('app-jia1').addClass('app-jian1')
            }else{
                obj.removeClass('app-jian1').addClass('app-jia1')
            }
            $(this).next().slideToggle()
        })
        $('.m_filters_btn').click(function () {
            let product_list_l = $('.product_list_l')
            let display = product_list_l.css('display')
            if(display!=='none'){
                $('html').removeClass('no_scroll')
            }else{
                $('html').addClass('no_scroll')
            }
            product_list_l.toggle(200);
        })
    })
    function m_filters_btn_hide() {
        $('.product_list_l').toggle(100);
        $('html').removeClass('no_scroll')
    }
</script>
<div class="container shop_main">
    <div>
        {!! $res['breadcrumb'] !!}
    </div>
    <div class="d-flex">
        <div class="product_list_l">
            <div class="product_list_l1">
                <div class="product_list_l_box">
                    <div class="product_list_l_box1">
                        <div class="filters">
                            <div class="filters1">Filters</div>
                            <div>
                                <ul class="filter_filter">
                                    @foreach($res['filterGroup'] as $val)
                                        <li >
                                            <div class="filters11">
                                                <span>{{$val->name}}</span>
                                                <span class="uni app-jia1"></span>
                                            </div>
                                            <dl class="filters12">
                                                @foreach($val->filter as $v)
                                                    <dd><a class="item-link @if(in_array($v->id,$res['filte_filter'])) active @endif" data-id="{{$v->id}}" href="javascript:void(0)">{{$v->name}}</a></dd>
                                                @endforeach
                                            </dl>
                                        </li>
                                    @endforeach
                                </ul>
                                <ul class="filter_price">
                                    <li >
                                        <div class="filters11">
                                            <span>Price</span>
                                            <span class="uni app-jia1"></span>
                                        </div>
                                        <dl class="filters12">
                                            @foreach($res['price'] as $val)
                                            <dd><a class="item-link @if($val[0]==$res['filter_data']['price']) active @endif" data-price="{{$val[0]}}" href="javascript:void(0)">{{$val[1]}}</a></dd>
                                            @endforeach
                                        </dl>
                                    </li>
                                </ul>
                                <ul class="filter_option">
                                    @foreach($res['option'] as $val)
                                        <li >
                                            <div class="filters11">
                                                <span>{{$val->name}}</span>
                                                <span class="uni app-jia1"></span>
                                            </div>
                                            <dl class="filters12">
                                                @foreach($val->value as $v)
                                                    <dd><a class="item-link @if(in_array($v->id,$res['filte_option_value'])) active @endif" data-id="{{$v->id}}" href="javascript:void(0)">{{$v->name}}</a></dd>
                                                @endforeach
                                            </dl>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="product_list_l_box2" onclick="m_filters_btn_hide()"></div>
                </div>
            </div>
        </div>
        <div class="m_filters_btn">
            Filters
        </div>
        <script>
            $(function () {
                $('.filter_filter').on('click','.item-link',function () {
                    if($(this).hasClass('active')){
                        $(this).removeClass('active')
                    }else{
                        $(this).addClass('active')
                    }
                    let filter_ids=[];
                    $('.filter_filter .item-link.active').each(function (index,item) {
                        filter_ids.push($(item).data('id'))
                    })
                    let filter = filter_ids.join(',');
                    urlOption._set('filter',filter,true)
                })
                $('.filter_option').on('click','.item-link',function () {
                    if($(this).hasClass('active')){
                        $(this).removeClass('active')
                    }else{
                        $(this).addClass('active')
                    }
                    let filter_ids=[];
                    $('.filter_option .item-link.active').each(function (index,item) {
                        filter_ids.push($(item).data('id'))
                    })
                    let filter = filter_ids.join(',');
                    urlOption._set('option_value',filter,true)
                });
                $('.filter_price').on('click','.item-link',function () {
                    $('.filter_price .item-link').removeClass('active')
                    $(this).addClass('active')
                    let price='';
                    $('.filter_price .item-link.active').each(function (index,item) {
                        price = $(item).data('price')
                    })
                    if(price){
                        urlOption._set('price',price,true)
                    }
                });
                (()=>{
                    let filter_res = '';
                    $('.filter_filter .item-link.active').each(function (index,item) {
                        filter_res+=`<li class="filter_filter_li" data-id="${$(item).data('id')}"><span class="uni app-guanbi" ></span><span>${$(item).text()}</span></li>`
                    })
                    $('.filter_option .item-link.active').each(function (index,item) {
                        filter_res+=`<li class="filter_option_li" data-id="${$(item).data('id')}"><span class="uni app-guanbi" ></span><span>${$(item).text()}</span></li>`
                    })
                    $('.filter_price .item-link.active').each(function (index,item) {
                        filter_res+=`<li class="filter_price_li" data-price="${$(item).data('price')}"><span class="uni app-guanbi" ></span><span>${$(item).text()}</span></li>`
                    })
                    if(filter_res){
                        filter_res+='<li class="clear_all"><a href="/product" class=" filter-link-text">Clear All</a></li>'
                    }
                    $('.filter_res_pre').html(filter_res)
                })();
                $('.filter_res_pre').on('click','li:not(".clear_all")',function () {
                    if($(this).attr('class')==='filter_filter_li'){
                        let id = $(this).data('id')
                        $('.filter_filter .active[data-id="'+id+'"]').click();
                    }else if($(this).attr('class')==='filter_option_li'){
                        let id = $(this).data('id')
                        $('.filter_option .active[data-id="'+id+'"]').click();
                    }else if($(this).attr('class')==='filter_price_li'){
                        urlOption._del('price',true)
                    }
                })
                $('.product_list_r1_sort').on('click','a',function () {
                    let sort = $(this).data('sort')
                    urlOption._set('sort',sort,true)
                })
            })
        </script>
        <style>
            .filter_res{display: flex;line-height: 28px;align-items: center;flex-wrap: wrap;}
            .filter_res ul{display: flex;margin-right: 10px;flex-wrap: wrap;}
            .filter_res ul li{margin-right:10px;margin-bottom:10px;line-height: 24px;padding: 2px 10px;display: flex;align-items: center;background: #e8e8e8;border-radius: 5px;color: #000;font-weight: 500;cursor: pointer}
            .filter_res ul li .app-guanbi{margin-right:5px;font-size: 12px;font-weight: 600}
            .filter_res ul li:hover{background: #000;color:#fff;}
            .filter-link-text{color:#777;cursor: pointer;text-decoration: underline;font-weight: 600}
            .filter-link-text:hover{color:#000;}
            .product_list_r1{justify-content: space-between;line-height: 44px;margin-bottom: 10px;}
            .product_list_r1 button{border: none;background: transparent;}
            .product_list_r1 .dropdown-menu{border: none;box-shadow:0 10px 30px rgba(0,0,0,0.2);background: #f8f8f8;}
            .product_list_r1 .btn-group button,.product_list_r1 .dropdown-menu a{font-weight: 500}
            .product_list_r1 .results{color:#777;font-weight: 600;}
        </style>
        <div class="product_list_r">
            <div class="d-flex product_list_r1">
                <div class="results">
                    Showing all {{$res['list']->count()}} results
                </div>
                <div class="btn-group">
                    <button type="button" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        @foreach($res['sort'] as $key=>$val)
                            @if($key==$res['filter_data']['sort'])
                                {{$val}}
                            @endif
                        @endforeach
                    </button>
                    <div class="dropdown-menu dropdown-menu-right product_list_r1_sort">
                        @foreach($res['sort'] as $key=>$val)
                        <a class="dropdown-item" href="javascript:void(0)" data-sort="{{$key}}">{{$val}}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="filter_res">
                <ul class="filter_res_pre"></ul>
            </div>
            <ul class=" product-category">
                @foreach($res['list'] as $key=>$val)
                    <li class="">
                        @if($res['is_color'] && !empty($res['product_image'][$val->id]))
                            <div class="image">
                                <a href="/product/{{$val->id}}">
                                @if($res['product_image'])
                                    <dl class="product_image">
                                        @foreach($res['product_image'][$val->id][0] as $k=>$v)
                                            @if(reset($res['product_image'][$val->id][0])==$v)
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
                                <a href="/product/{{$val->id}}">
                                    <img src="{{ URL::asset('static/base/img/none.png') }}" data-original="{{ $val->image_src }}"  class="img-responsive lazy" >
                                </a>
                            </div>
                        @endif
                        <a href="/product/{{$val->id}}"><div class="p_name">{{$val->name}}</div></a>
                        <div class="p_name_x d-flex justify-content-between">
                            <div class="d-flex price">
                                @if($val->special)
                                    <span class="normal">{{$val->special}}</span>
                                    <span class="special_price">{{$val->price}}</span>
                                    <span class="price_sale">Sale</span>
                                @else
                                    @if($val->discount)
                                        <span class="normal">{{$val->discount}}</span>
                                        <span class="special_price">{{$val->price}}</span>
                                        <span class="price_sale">Sale</span>
                                    @else
                                        <span class="normal">{{$val->price}}</span>
                                    @endif
                                @endif
                            </div>
                            <div class="wishlist_one">
                                @if(in_array($val->id,$res['wishlist_product_ids']))
                                    <i class="common-iconfont icon-aixin_shixin" data-product_id="{{$val->id}}" data-csrf="{{csrf_token()}}"></i>
                                @else
                                    <i class="common-iconfont icon-aixin" data-product_id="{{$val->id}}" data-csrf="{{csrf_token()}}"></i>
                                @endif
                            </div>
                        </div>
                        @if($res['is_color'] && !empty($res['product_image'][$val->id]) && isset($res['product_option'][$val->id]['product_option_value']))
                            <div class="product_option">
                                <dl>
                                    @foreach($res['product_option'][$val->id]['product_option_value'] as $v)
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
                    </li>
                @endforeach
            </ul>
            <div>
                {{$res['list']->links('laravel-common-front::common.pagination')}}
            </div>
        </div>
    </div>
</div>

@if($res['is_color'])
<style>
    .product_option dl dd.active{border:none;}
    .product_option dl dd img{border-radius: 50%;padding: 3px;cursor: pointer;}
    .product_option dl dd.active img{padding: 1px;border: 2px solid #e59798;}
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
