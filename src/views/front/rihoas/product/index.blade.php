@include('laravel-shop-front::common.header')
<style>
    .product-category{display:flex;flex-wrap:wrap}
    .product-category li{width:calc(20% - 8.5px);margin:0px 10px 10px 0px;padding:10px;background:#fff;box-shadow:0 2px 12px 2px #eee}
    .product-category li .image{margin-bottom:10px;position:relative;z-index:10}
    .product-category li .name{text-transform:capitalize;font-size:14px;color:#000;height:36px;line-height:18px;overflow:hidden;margin-bottom:5px}
    .product-category li .price{font-size:14px;margin-bottom:5px}
    .img-responsive{max-width:100%;height:auto}
    .product-category > li:nth-child(5n),.product-category li:last-child{margin-right:0}

    .product_list_l .filters1{font-size: 34px;margin-bottom: 20px;font-weight: 600;}
    .product_list_l{width: 20%;margin-right: 20px;}
    .product_list_r{width: calc(80% - 20px);}
    .filters11{font-size: 18px;font-weight: 500; margin: 10px 0;display: flex;justify-content: space-between;cursor: pointer}
    .filters12{display: flex;flex-wrap: wrap;}
    .filters12 dd{width: 100%;line-height: 34px;}
    .filters12 dd a{color:#777;position: relative;}
    .filters12 dd a.active,.filters12 dd a:hover{color:#000;}
    .filters12 .item-link:after{content:"";background:#000;position:absolute;bottom:0px;right:0;width:0;height:1px;-webkit-transition:all .3s ease;transition:all .3s ease}
    .filters12 .item-link.active:not(.disabled):after,.filters12 .item-link:not(.disabled):hover:after{left:0;right:auto;width:100%}

</style>

<div class="container">
    <div class="d-flex">
        <div class="product_list_l">
            <div class="filters">
                <div class="filters1">Filters</div>
                <div>
                    <ul>
                        @foreach($res['filterGroup'] as $val)
                        <li>
                            <div class="filters11">
                                <span>{{$val->name}}</span>
                                <span class="uni app-jia1"></span>
                            </div>
                            <dl class="filters12">
                                @foreach($val->filter as $v)
                                <dd ><a class="item-link" href="">{{$v->name}}</a></dd>
                                @endforeach
                                    <dd ><a class="item-link active" href="">cc</a></dd>
                            </dl>
                        </li>
                        @endforeach
                        @foreach($res['option'] as $val)
                            <li>
                                <div class="filters11">
                                    <span>{{$val->name}}</span>
                                    <span class="uni app-jia1"></span>
                                </div>
                                <dl class="filters12">
                                    @foreach($val->value as $v)
                                        <dd>{{$v->name}}</dd>
                                    @endforeach
                                </dl>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="m_filters">

            </div>
            <div class="m_filters_btn">
                Filters
            </div>
        </div>
        <div class="product_list_r">
            <div >
                <ul style="display: flex;">
                    <li style="line-height: 24px;padding: 2px 10px 2px 30px;background: #e8e8e8;border-radius: 5px;color: #000;font-weight: 500;">aaaa</li>
                </ul>
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
    .product-category > li:nth-child(5n),.product-category li:last-child{margin-right:10px}
    .m_filters_btn{display:block;position:fixed;bottom:50%;right:0;background:#f2f2f2;writing-mode:vertical-rl;padding:20px 10px;z-index:100;border-bottom-right-radius:8px;border-top-right-radius:8px;transform:rotate(180deg)}

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
