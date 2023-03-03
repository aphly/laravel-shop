@include('laravel-shop-front::common.header')
<link rel="stylesheet" href="{{ URL::asset('static/shop/css/idangerous.swiper.css') }}"/>
<style>
    .product_detail_img{width:700px;position:relative}
    .product_detail_img .big_img{border-right:1px solid #f1f1f1;border-bottom:1px solid #f1f1f1;width:100%;height:600px}
    .product_detail_img .big_img img{width:100%;height:100%}
    .product_detail_img .small_img{margin-top: 10px;}
    .product_detail_img .small_img .swiper-container{text-align:center;width:calc(100% - 50px);}
    .product_detail_img .small_img .swiper-slide{height:90px;width: 90px;}
    .product_detail_img .small_img .swiper-slide img{height:80px;width:80px;margin: 5px;border-radius: 4px;}
    .product_detail_img .small_img .swiper-wrapper .swiper-slide.active img{border:1px solid #000}
    .product_detail_img .lr_icon.left{left:0px;top:0px;width:25px}
    .product_detail_img .lr_icon{position:absolute;width:25px;height:90px}
    .product_detail_img .lr_icon.left > div{background-position:left center}
    .product_detail_img .lr_icon > div{background:url({{URL::asset('static/shop/img/leftright.png')}}) no-repeat;width:100%;height:100%;margin:0 auto;cursor:pointer}
    .product_detail_img .lr_icon.right{right:0px;top:0px;width:25px}
    .product_detail_img .lr_icon.right > div{background-position:right center}

    .product_detail{display: flex;justify-content: space-between;}
    .product_detail_info{width: calc(100% - 740px);margin-left: 40px;}
    .product_detail_info_title{font-size: 40px;}
    .price {font-size: 24px;font-weight: 600;}
    .product_detail_info_title_xia{margin-bottom: 10px;}
    .wishlist_one{}
    .quantity-label{font-size: 16px;font-weight: 500;margin-bottom: 5px;}
    @media (max-width: 1199.98px) {
        .product_detail_img .big_img{height:320px}
        .product_detail{flex-wrap: wrap;}
        .product_detail_img{width:100%;}
        .product_detail_info{width: 100%;margin-left: 0;}
        .product_detail_info_title{font-size: 30px;font-weight: 600; margin-top: 10px;}
    }
</style>
<div class="container">
    <div>
        <div class="product_detail">
            <div class="product_detail_img">
                <div class="big_img aphly_viewer_js">
                    <img src="{{ $res['info_img'][0]['image_src']??URL::asset('static/admin/img/none.png') }}" class="aphly_viewer">
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
            <div class="product_detail_info">
                <div class="product_detail_info_title">
                    {{$res['info']->name}}
                </div>

                <div class="d-flex justify-content-between align-items-center product_detail_info_title_xia">
                    <div class="d-flex price ">
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
                    <div class="form-group quantity">
                        <div class="control-label quantity-label">Quantity</div>
                        <div class="quantity-wrapper">
                            <div class="quantity-down">-</div>
                            <input type="number" name="quantity" onblur="if(value<1)value=1" value="1" class="form-control quantity_js">
                            <div class="quantity-up">+</div>
                        </div>
                    </div>
                    <button id="save-address" class="add_cart_btn " type="submit">Add To Cart</button>
                </form>

            </div>

        </div>
    </div>
    <style>
        .my_tab{border-bottom: 1px solid #d1d1d1;margin-top: 30px;display: flex;}
        .my_tab .my_bt{line-height: 50px;padding: 0 20px;cursor: pointer;color: #888; font-weight: 600;font-size: 16px;}
        .my_tab .my_bt.active{color: #333;border-bottom: 4px solid #333;}
        .description{padding: 15px;}
        .wishlist_one i{font-size: 20px;}
    </style>
    <div class="my_tab">
        <div class="my_bt active">Description</div>
    </div>
    <div class="description">
        <div>{!! $res['info']->desc->description??'' !!}</div>
    </div>

    <input type="hidden" id="quantityInCart" value="{{$res['quantityInCart']}}">

    @if(isset($shop_setting['review']) && $shop_setting['review']==1)
        <div class="my_tab">
            <div class="my_bt active">Reviews ({{$res['review']->total()}})</div>
        </div>
        <div class="review">
        <div class="review1">
            <div class="write_a_review_pre">
                <div class="write_a_review_pre1">Overall Rating : </div>
                <div class="grade-star-bg">
                    <div class="star-progress" style="width: {{$res['reviewRatingAvg_100']}}%;">
                        <i class="common-iconfont icon-xingxing"></i>
                        <i class="common-iconfont icon-xingxing"></i>
                        <i class="common-iconfont icon-xingxing"></i>
                        <i class="common-iconfont icon-xingxing"></i>
                        <i class="common-iconfont icon-xingxing"></i>
                    </div>
                    <div class="star-bg">
                        <i class="common-iconfont icon-xingxing"></i>
                        <i class="common-iconfont icon-xingxing"></i>
                        <i class="common-iconfont icon-xingxing"></i>
                        <i class="common-iconfont icon-xingxing"></i>
                        <i class="common-iconfont icon-xingxing"></i>
                    </div>
                </div>
                <div class="write_a_review_pre2">{{$res['reviewRatingAvg']}}/5</div>
            </div>

            <div class="write_a_review" data-toggle="modal" data-target="#reviewModal">
                Write a review
            </div>
        </div>

        <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reviewModalLabel">Write Review</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form_request_file" enctype="multipart/form-data" method="post" action="/product/{{$res['info']->id}}/review/add" data-fn="review_res" >
                            @csrf
                            <div class="review_form">
                                <div>{{$res['info']->name}}</div>
                                <ul class="input_star">
                                    <li data-val="1" class="on"><i class="common-iconfont icon-xingxing"></i></li>
                                    <li data-val="2" class="on"><i class="common-iconfont icon-xingxing"></i></li>
                                    <li data-val="3" class="on"><i class="common-iconfont icon-xingxing"></i></li>
                                    <li data-val="4" class="on"><i class="common-iconfont icon-xingxing"></i></li>
                                    <li data-val="5" class="on"><i class="common-iconfont icon-xingxing"></i></li>
                                </ul>
                                <input type="hidden" name="rating" class="rating_js" value="5">
                                <textarea name="text" class="form-control"></textarea>
                                <div class="add_photo"><i class="common-iconfont icon-zhaoxiangji"></i>Add Photo</div>
                                <input type="file"  style="display: none" accept="image/gif,image/jpeg,image/jpg,image/png" name="files[image][]" data-next_class="review_img" class="form_input_file add_photo_file" multiple="multiple">
                                <div class="review_img"></div>
                                <button class="">Submit Review</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if($res['review'])
            <ul class="review_list">
                @foreach($res['review'] as $val)
                    <li>
                        <div class="review_left">
                            <div>{{$val->author}}</div>
                            <div class="created_at">{{$val->created_at->format('m-d , Y')}}</div>
                        </div>
                        <div class="review_right">
                            <div>
                                <div class="review_content">{{$val->text}}</div>
                                <div class="grade-star-bg">
                                    <div class="star-progress" style="width: {{$val->rating*20}}%;">
                                        <i class="common-iconfont icon-xingxing"></i>
                                        <i class="common-iconfont icon-xingxing"></i>
                                        <i class="common-iconfont icon-xingxing"></i>
                                        <i class="common-iconfont icon-xingxing"></i>
                                        <i class="common-iconfont icon-xingxing"></i>
                                    </div>
                                    <div class="star-bg">
                                        <i class="common-iconfont icon-xingxing"></i>
                                        <i class="common-iconfont icon-xingxing"></i>
                                        <i class="common-iconfont icon-xingxing"></i>
                                        <i class="common-iconfont icon-xingxing"></i>
                                        <i class="common-iconfont icon-xingxing"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="review_list_img aphly_viewer_js">
                                @foreach($val->img as $v)
                                    <img src="{{$v->image_src}}"  class="aphly_viewer">
                                @endforeach
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            <div>
                {{$res['review']->links('laravel-common-front::common.pagination')}}
            </div>
        @endif
    </div>
    @endif

    <style>
        .review{margin-bottom: 20px;}
        .review1{display: flex;justify-content: space-between;margin: 20px 0 10px;align-items: center;}
        .write_a_review_pre{display: flex;font-weight: 600;}
        .write_a_review_pre .grade-star-bg{margin:0 10px;}
        .write_a_review{padding: 0 26px;font-size: 16px;text-align: center; margin-top: 8px;background: #ddd;border-radius: 4px; height: 48px;line-height: 48px;margin-bottom: 10px;cursor: pointer}
        .review_list{display: flex;flex-wrap: wrap;}
        .review_list li{display: flex;justify-content: space-between;width: 100%;margin-bottom: 10px;padding-bottom: 10px;border-bottom: 1px dashed #ddd;}
        .review_left{width: 200px;}
        .review_right{width: calc(100% - 220px);margin-left: 20px;}
        .created_at{color:#888;}
        .review_list_img{display: flex;flex-wrap: wrap;}
        .review_list_img img{width: 50px;height: 50px;margin-right: 10px;}
        .review_content{margin-bottom: 10px;}

        .review_img{margin-bottom: 10px;display: flex;flex-wrap: wrap;}
        .review_img img{width: 100px;height: 100px;margin: 10px;}
        .review_form textarea{width: 100%;height: 100px;}
        .add_photo{height: 40px;line-height: 40px;text-align: center;border:1px dashed #ddd;margin: 10px 0;cursor: pointer;}
        .add_photo i{margin-right: 5px;font-size: 20px;position: relative;top: 2px;}
        .review_form button{width: 100%;text-align: center;border: none;background: #000;height: 40px;line-height: 40px;color: #fff;}
        .input_star{margin: 10px 0;}
        .input_star li.on i{color:#e17a10;}
        .input_star li i{color: #ddd;}
        .input_star li{margin-right: 5px;cursor: pointer}
        .input_star{display: flex;}

        .grade-star-bg{width: 100px;height: 20px;position: relative;margin-bottom: 10px;top: -3px;}
        .grade-star-bg .star-progress {height: 100%;position: absolute;left: 0;top: 0;display: flex;z-index: 1;overflow: hidden;}
        .grade-star-bg .star-progress i{color: #e17a10;}
        .grade-star-bg i{flex-grow: 0;flex-shrink: 0;display: block;width: 20px;height: 20px;}
        .grade-star-bg .star-bg{height: 100%;position: absolute;left: 0;top: 0; width: 100%;display: flex;}
        .grade-star-bg .star-bg i{color: #ddd;}

        @media (max-width: 1199.98px) {
            .review1{justify-content: left;flex-wrap: wrap;flex-direction: column-reverse;margin-top: 10px;}
            .write_a_review_pre{width: 100%}
            .write_a_review{width: 100%}
        }
    </style>
    <script>
        function review_res(res) {
            if(res.code===1 && res.data.redirect){
                location.href = res.data.redirect+'?redirect={{urlencode(request()->url())}}'
            }else if(res.code===0){
                location.reload()
            }else{
                console.log(res)
                alert_msg(res)
            }
        }
    </script>
</div>
<style>
    .info_option input[type="radio"]{display: none;}
    .info_option label{padding: 10px 20px; border: 1px solid #f1f1f1;margin-right: 10px; border-radius: 2px;cursor: pointer}
    .info_option label img{width:30px;height:30px;margin-right: 10px;}
    .info_option label:hover,.quantity-wrapper div:hover{border: 1px solid #ddd;}
    .info_option label.active{border: 1px solid #333;}

    .add_cart_btn{height: 48px;background: #fff;border: 1px solid #212b36;width: 100%;border-radius: 2px;}
    .add_cart_btn:hover{background: #212b36;color: #fff;}
    .flag_checkbox input{display: none;}
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
        slidesPerView: "auto"
    })

    function changepic(_this) {
        $('.swiper-container .swiper-slide').removeClass('active')
        $(_this).addClass('active')
        $('.big_img img').attr('src', $(_this).data('src')).attr('data-original',$(_this).data('src'));
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
            let price = new Decimal(price_js).plus(radio_price).plus(checkbox_price).plus(select_price).toNumber();
            $('.price_js').html(currency._format(price,'{{$currency[2]['symbol_left']}}','{{$currency[2]['symbol_right']}}'))
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

        $('.input_star').on('click','li',function () {
            $(this).addClass('on')
            $(this).prevAll().addClass('on')
            $(this).nextAll().removeClass('on')
            $('.rating_js').val($(this).data('val'))
        })

        $('.add_photo').click(function () {
            $('.add_photo_file').click();
        })
    })

</script>

@include('laravel-shop-front::common.footer')
