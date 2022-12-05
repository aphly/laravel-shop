@include('laravel-shop-front::common.header')
<link rel="stylesheet" href="{{ URL::asset('static/shop/css/idangerous.swiper.css') }}"/>
<style>
    .product_detail_img{max-width:500px;width:100%;position:relative}
    .product_detail_img .big_img{border-right:1px solid #f1f1f1;border-bottom:1px solid #f1f1f1;width:100%;height:500px}
    .product_detail_img .big_img img{width:100%;height:100%}
    .product_detail_img .small_img{height:100px;padding-top:10px;position:relative}
    .product_detail_img .small_img .swiper-container_pc{height:80px}
    .product_detail_img .small_img .swiper-container,.lr_icon{width:450px}
    .product_detail_img .small_img .swiper-container{color:#fff;text-align:center}
    .product_detail_img .small_img .swiper-slide img{height:100%;width:100%}
    .product_detail_img .small_img .swiper-wrapper .swiper-slide.active img{border:1px solid #9d1000}
    .product_detail_img .lr_icon.left{left:0px;top:10px;width:25px}
    .product_detail_img .lr_icon{position:absolute;width:25px;height:80px}
    .product_detail_img .lr_icon.left > div{background-position:left center}
    .product_detail_img .lr_icon > div{background:url({{URL::asset('static/shop/img/leftright.png')}}) no-repeat;width:100%;height:100%;margin:0 auto;cursor:pointer}
    .product_detail_img .lr_icon.right{right:0px;top:10px;width:25px}
    .product_detail_img .lr_icon.right > div{background-position:right center}
</style>
<div class="container">
    <div>
        <div>
            <div class="product_detail_img" id="aphly_viewerjs">
                <div class="big_img ">
                    <img src="{{ $res['info_img'][0]['image_src']??URL::asset('static/admin/img/none.png') }}" id="big_pic" class="aphly_viewer">
                </div>
                @if($res['info_img'])
                    <div class="small_img  position-relative ">
                        <div class="swiper-container swiper-container_pc">
                            <div class="swiper-wrapper">
                                @foreach($res['info_img'] as $v)
                                    <div class="swiper-slide " data-image_id="{{$v['id']}}"
                                         data-src="{{$v['image_src']}}"
                                         onclick="changepic(this)">
                                        <img src="{{$v['image_src']}}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="lr_icon left">
                            <div></div>
                        </div>
                        <div class="lr_icon right">
                            <div></div>
                        </div>
                    </div>
                @endif
            </div>
            <div style="">
                {{$res['info']->name}}
            </div>
            <div class="d-flex price">
                @if($res['special_price'])
                    <span class="normal price_js" data-price="{{$res['special_price']}}">{{$res['special_price_format']}}</span>
                    <span class="special_price">{{$res['info']->price_format}}</span>
                    <span class="price_sale">Sale</span>
                @else
                    @if($res['info_discount'])
                        <span class="normal price_js" data-price="{{$res['info']->price}}">{{$res['info']->price_format}}</span>
                        <ul class="d-flex discount_js">
                            @foreach($res['info_discount'] as $v)
                                <li class="item" style="margin-right: 10px;" data-price="{{$v['price']}}" data-quantity="{{$v['quantity']}}">
                                    {{$v['quantity']}} {{$v['price_format']}}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <span class="normal price_js" data-price="{{$res['info']->price}}">{{$res['info']->price_format}}</span>
                    @endif
                @endif
            </div>
            <div class="wishlist_one">
                @if(in_array($res['info']->id,$res['wishlist_product_ids']))
                    <i class="common-iconfont icon-aixin_shixin" data-product_id="{{$res['info']->id}}" data-csrf="{{csrf_token()}}"></i>
                @else
                    <i class="common-iconfont icon-aixin" data-product_id="{{$res['info']->id}}" data-csrf="{{csrf_token()}}"></i>
                @endif
            </div>
            <div>
                @if($res['shipping'])
                    <div style="text-align: left;margin-bottom:0px">
                        <span style="color: #E36254">
                            <strong>Free Standard Shipping</strong>
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <ul class=" ">
        @foreach($res['info_attr'] as $v)
            <li class="item">
                {{$v['attribute']['name']}} {{$v['text']}}
            </li>
        @endforeach
    </ul>

    <form id="product" class="form_request" method="post" action="/cart/add" data-fn="detail_res">
        @csrf
        <input type="hidden" name="product_id" value="{{$res['info']->id}}">
        <div class="info_option">
            {!! $res['info_option'] !!}
        </div>
        <div class="form-group">
            <div class="control-label">Quantity</div>
            <div class="quantity-wrapper">
                <div class="quantity-down">-</div>
                <input type="number" name="quantity" onblur="if(value<1)value=1" value="1" class="form-control quantity_js">
                <div class="quantity-up">+</div>
            </div>
        </div>
        <button id="save-address" class="add_cart_btn " >Add To Cart</button>
    </form>
    <input type="hidden" id="quantityInCart" value="{{$res['quantityInCart']}}">
</div>
<style>
    .info_option input[type="radio"]{display: none;}
    .info_option label{padding: 10px 20px; border: 1px solid #f1f1f1;margin-right: 10px; border-radius: 2px;cursor: pointer}
    .info_option label img{width:30px;height:30px;margin-right: 10px;}
    .info_option label:hover,.quantity-wrapper div:hover{border: 1px solid #ddd;}
    .info_option label.active{border: 1px solid #333;}

    .quantity-wrapper{display: flex;}
    .quantity-wrapper div,.quantity-wrapper input{text-align: center; line-height: 48px;height: 48px;width: 48px;min-width: 48px;background-color: #fff;border: 1px solid #f1f1f1;border-radius: 2px;}
    .quantity-wrapper div{color: #aaa;font-size: 30px;cursor: pointer;user-select: none}
    .quantity-wrapper input{margin: 0 10px;}

    input[type='number']::-webkit-outer-spin-button,input[type='number']::-webkit-inner-spin-button {-webkit-appearance: none !important;}
    .add_cart_btn{height: 48px;background: #fff;border: 1px solid #212b36;width: 100%;border-radius: 2px;}
    .add_cart_btn:hover{background: #212b36;color: #fff;}
</style>
<script>
    function detail_res(res) {
        $('.cart_num').text(res.data.count);
    }
</script>

<script src="{{ URL::asset('static/shop/js/idangerous.swiper.min.js') }}" type="text/javascript"></script>

<script>
    var detailSwiper = new Swiper('.swiper-container_pc', {
        paginationClickable: true,
        slidesPerView: 5,
    })
    var detailSwiper_m = new Swiper('.swiper-container_m', {
        //loop:true,
        grabCursor: true,
        pagination: '.pagination_img',
        paginationClickable: true
    })

    function changepic(_this) {
        $('#big_pic').attr('src', $(_this).data('src')).attr('data-original',$(_this).data('src'));
    }

    $(function () {
        $('.lr_icon.left').on('click', function (e) {
            detailSwiper.swipePrev()
        })

        $('.lr_icon.right').on('click', function (e) {
            detailSwiper.swipeNext()
        })

        $('.info_option').on('click','input',function () {
            let flag_radio = $(this).closest('.flag_radio')
            if(flag_radio.length>0){
                $(this).closest('div').find('label').removeClass('active')
                $(this).next('label').addClass('active')
                if($(this).data('image_src')){
                    $('.product_detail_img .swiper-slide[data-image_id="'+$(this).data('image_id')+'"]').click()
                }
            }
            let flag_checkbox = $(this).closest('.flag_checkbox')
            if(flag_checkbox.length>0){
                let label = $(this).next('label')
                if(label.hasClass('active')){
                    label.removeClass('active')
                }else{
                    label.addClass('active')
                }
            }
            price()
        })
        $('.info_option').on('change','select',function () {
            price()
        })

        function price() {
            let price_js = $('.price_js').data('price')
            let discount_js = $('.discount_js')
            if(discount_js.length>0){
                let quantity_js = parseInt($('.quantity_js').val())+parseInt($('#quantityInCart').val())
                let discount_js_arr = [],arr = [];
                discount_js.find('li').each(function () {
                    if(quantity_js>=$(this).data('quantity')){
                        arr.push($(this).data('quantity'))
                        discount_js_arr.push({quantity:$(this).data('quantity'),price:$(this).data('price')})
                    }
                })
                let max = Math.max.apply(null, arr);
                for(let i in arr){
                    if(discount_js_arr[i].quantity===max){
                        price_js=discount_js_arr[i].price
                    }
                }
            }
            let radio_price = 0
            $('.flag_radio').each(function () {
                radio_price += $(this).find('input[type="radio"]:checked').data('price')
            })
            let checkbox_price = 0;
            $('.flag_checkbox').each(function () {
                $(this).find('input[type="checkbox"]:checked').each(function () {
                    checkbox_price+=$(this).data('price')
                })
            })
            let select_price = 0;
            $('.flag_select').each(function () {
                $(this).find('select option:selected').each(function () {
                    select_price+=$(this).data('price')
                })
            })
            let price = new Decimal(price_js).plus(radio_price).plus(checkbox_price).plus(select_price).toFixed();
            $('.price_js').html(currency.format(price,'{{$currency[2]['symbol_left']}}','{{$currency[2]['symbol_right']}}'))
        }

        $('.info_option .flag_radio').each(function () {
            $(this).find('input:first').click();
        })

        $('.quantity-wrapper').on('click','.quantity-down', function (e) {
            let input = $(this).parent().find('input')
            let q_curr = parseInt(input.val());
            let quantity = q_curr-1;
            if(quantity>1){
                input.val(quantity)
            }else{
                input.val(1)
            }
            price()
        })

        $('.quantity-wrapper').on('click','.quantity-up', function (e) {
            let input = $(this).parent().find('input')
            let q_curr = parseInt(input.val());
            input.val(q_curr+1)
            price()
        })

        $('.quantity_js').change(function () {
            price()
        })

    })

</script>

@include('laravel-shop-front::common.footer')
