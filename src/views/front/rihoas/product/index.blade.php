@include('laravel-shop-front::common.header')
<style>
    .product-category{display:flex;flex-wrap:wrap}
    .product-category li{width:calc(25% - 10px);margin:0px 10px 10px 0px;padding:10px;background:#fff;box-shadow:0 2px 12px 2px #eee}
    .product-category li .image{margin-bottom:10px;position:relative;z-index:10}
    .product-category li .name{text-transform:capitalize;font-size:14px;color:#000;height:36px;line-height:18px;overflow:hidden;margin-bottom:5px}
    .product-category li .price{font-size:14px;margin-bottom:5px}
    .img-responsive{max-width:100%;height:auto}
    .product-category > li:nth-child(4n),.product-category li:last-child{margin-right:0}

    .product_list_l .filters1{font-size: 34px;margin-bottom: 20px;font-weight: 600;}
    .product_list_l{width: 20%;margin-right: 20px;min-height: 500px;background: #fff;padding: 20px;border-radius: 4px;}
    .product_list_r{width: calc(80% - 20px);}
    .filters11{font-size: 18px;font-weight: 500; margin: 10px 0;display: flex;justify-content: space-between;cursor: pointer}
    .filters12{display: flex;flex-wrap: wrap;}
    .filters12 dd{width: 100%;line-height: 34px;}
    .filters12 dd a{color:#777;position: relative;}
    .filters12 dd a.active,.filters12 dd a:hover{color:#000;}
    .filters12 .item-link:after{content:"";background:#000;position:absolute;bottom:0px;right:0;width:0;height:1px;-webkit-transition:all .3s ease;transition:all .3s ease}
    .filters12 .item-link.active:not(.disabled):after,.filters12 .item-link:not(.disabled):hover:after{left:0;right:auto;width:100%}
    .clear_all{background: transparent !important;}
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
                $('html,body').css('height','inherit').css('overflow','inherit')
            }else{
                $('html,body').css('height','100%').css('overflow','hidden')
            }
            product_list_l.toggle(200);
        })
    })
    function m_filters_btn_hide() {
        $('.product_list_l').toggle(200);
        $('html,body').css('height','inherit').css('overflow','inherit')
    }
</script>
<div class="container">
    <div class="d-flex">
        <div class="product_list_l">
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
                (()=>{
                    let filter_res = '';
                    $('.filter_filter .item-link.active').each(function (index,item) {
                        filter_res+=`<li class="filter_filter_li" data-id="${$(item).data('id')}"><span class="uni app-guanbi" ></span><span>${$(item).text()}</span></li>`
                    })
                    $('.filter_option .item-link.active').each(function (index,item) {
                        filter_res+=`<li class="filter_option_li" data-id="${$(item).data('id')}"><span class="uni app-guanbi" ></span><span>${$(item).text()}</span></li>`
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
                    }
                })
                $('.product_list_r1_sort').on('click','a',function () {
                    let sort = $(this).data('sort')
                    urlOption._set('sort',sort,true)
                })
            })
        </script>
        <style>
            .filter_res{margin-bottom: 10px;display: flex;line-height: 28px;align-items: center;flex-wrap: wrap;}
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
            .product_list_r1 .results{color:#777}

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
                        <div class="image">
                            @if(isset($res['product_option'][$val->id]['product_option_value']) && isset($res['product_image'][$val->id]))
                                <dl class="product_image">
                                    @foreach($res['product_image'][$val->id] as $k=>$v)
                                        @if($k)
                                            <dd data-image_id="{{$v['id']}}"><img  src="{{$v['image_src']}}" /></dd>
                                        @else
                                            <dd class="active" data-image_id="{{$v['id']}}"><img  src="{{$v['image_src']}}" /></dd>
                                        @endif
                                    @endforeach
                                </dl>
                            @else
                                <a href="/product/{{$val->id}}">
                                    <img src="{{ $val->image_src }}" class="img-responsive" >
                                </a>
                            @endif
                        </div>
                        <div class="product_option">
                            @if(isset($res['product_option'][$val->id]['product_option_value']))
                                <dl>
                                    @foreach($res['product_option'][$val->id]['product_option_value'] as $v)
                                        @if($v['product_image'] && $v['product_image']['image_src'])
                                            <dd data-image_id="{{$v['product_image']['id']}}"><img src="{{$v['product_image']['image_src']}}" alt=""></dd>
                                        @elseif($v['option_value'] && $v['option_value']['image_src'])
                                            <dd><img src="{{$v['option_value']['image_src']}}" alt=""></dd>
                                        @endif
                                    @endforeach
                                </dl>
                            @endif
                        </div>
                        <div class="p_name"><a href="/product/{{$val->id}}">{{$val->name}}</a></div>
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
                    </li>
                @endforeach
            </ul>
            <div>
                {{$res['list']->links('laravel-common-front::common.pagination')}}
            </div>
        </div>
    </div>
</div>

<style>
.special_price{opacity: 0.5;text-decoration: line-through;}
.price_sale{color: #e36254;}
.price span{margin-right: 10px;}

.product_option dl{display: flex;}
.product_option dl dd{border: 1px solid #ffffff;padding: 4px;}
.product_option dl dd.active{border: 1px solid saddlebrown}
.product_option img{width: 28px;height: 28px;}

.product_image img{width: 100%;}
.product_image dd{display: none}
.product_image dd.active{display: block}
.wishlist_one{}
.wishlist_one i{width: 20px;height: 20px;display: block;cursor: pointer;text-align: center;}
.p_name{font-weight: 600;}
.m_filters_btn{display: none;}
@media (max-width: 1199.98px) {
    .product-category li{width: calc(50% - 5px);}
    .product-category > li:nth-child(2n),.product-category li:last-child{margin-right:0}

    .m_filters_btn{ color: #000; font-weight: 600;font-size: 12px;display:block;position:fixed;bottom:50%;right:0;background:#fafafa;writing-mode:vertical-rl;padding:20px 10px;z-index:100;border-bottom-right-radius:8px;border-top-right-radius:8px;transform:rotate(180deg)}

    .product_list_r{width:100%;}
    .product_list_l{background:transparent;display:none;position: fixed;left: 0;width: 100%;padding:0;z-index: 1002;top: 60px;height: calc(100% - 60px);}
    .product_list_l_box1{width: calc(100% - 50px);background: #fff;padding: 20px;height: 100%;overflow-y: auto;}
    .product_list_l_box2{width: 50px;}
    .product_list_l_box{display: flex;height: 100%;}
    .product_list_r1{margin-bottom: 5px;}
}
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
                product_image.find('dd[data-image_id="'+image_id+'"]').addClass('active')
            }
        })
    })


</script>

@include('laravel-shop-front::common.footer')
