@Linclude('laravel-front::common.header')
<link rel="stylesheet" href="{{ URL::asset('static/shop/css/swiper-bundle.min.css') }}"/>
<link rel="stylesheet" href="{{ URL::asset('static/base/css/video-js.min.css') }}">
<script src='{{ URL::asset('static/base/js/video.min.js') }}' type='text/javascript'></script>
<style>
    .vjs-volume-panel{order:80}
    .vjs-picture-in-picture-control{order:90}
    .vjs-fullscreen-control{order:100}
    video {object-fit: cover;}
    .video_box{width:60%;margin: 0 auto;}
    .video-js .vjs-control-bar{background-color: rgba(43,51,63,0);}
    .video-js .vjs-volume-vertical{background-color: rgba(43,51,63,0);}
    .video-js{font-size: 12px;width: 100%;}
    .video-js .vjs-big-play-button{background-color: rgba(43,51,63,0);border-radius: 50%; width: 2em; height: 2em; line-height: 1.9em; border: 3px solid #fff;margin-left: -1em;}
    @media (max-width: 1200px) {
        .video_box{width: 100%;}
    }
</style>
<style>
    .add_cart_btn{background: #e7a1a2;border: none;color: #fff}
    .add_cart_btn:hover{background: #e59798;}
    .buy_btn{background: #de8080;color: #fff}
    .buy_btn:hover{background: #d46d6d;}
    .product_detail_img .small_img .swiper-wrapper .swiper-slide.active img{border: 1px solid #d19595;}
    .price_sale_detail{color: #E36254;font-weight: 600;margin-bottom: 10px;}
    .product_detail_info .price .normal{color: #E36254;}

    .info_option .flag_radio .my_radio[data-image_src="true"] label{padding:0;border: none !important;margin-right: 10px;}
    .info_option .flag_radio .my_radio[data-image_src="true"] label span{display: none;}
    .info_option .flag_radio .my_radio[data-image_src="true"] label img{border-radius: 50%;margin-right: 0;padding: 3px;}
    .info_option .flag_radio .my_radio[data-image_src="true"] label:hover{border: none !important;}
    .info_option .flag_radio .my_radio[data-image_src="true"] label.active img{border:2px solid #e59798 !important;padding: 1px;}
    .info_option label img{width: 40px;height:40px;}
</style>
<div class="container shop_main">
    <div>
        {!! $res['breadcrumb'] !!}
    </div>
    <div>
        <div class="product_detail">
            <div class="product_detail_img">
                @if($res['info']->is_color_group)
                    <div class="big_img aphly_viewer_js is_color_group">
                        @if(!empty($res['info_img'][0]))
                            <div class="info_img_big_group">
                                @foreach($res['info_img'][0] as $k0=>$v0)
                                <ul class="info_img_big big_color_group{{$k0}} @if($v0===reset($res['info_img'][0])) active @endif">
                                    @foreach($v0 as $k=>$v)
                                        @if(reset($v0)===$v)
                                            <li data-image_id="{{$v['id']}}" class="on"><img src="{{ $v['image_src'] }}" class="aphly_viewer"></li>
                                        @else
                                            <li data-image_id="{{$v['id']}}" ><img src="{{ $v['image_src'] }}" class="aphly_viewer"></li>
                                        @endif
                                    @endforeach
                                </ul>
                                @endforeach
                            </div>
                        @else
                            <img src="{{ URL::asset('static/base/img/none.png') }}" class="aphly_viewer">
                        @endif
                    </div>
                    @if(!empty($res['info_img'][0]))
                        <div class="small_img_group">
                            @foreach($res['info_img'][0] as $k0=>$v0)
                            <div data-k0="{{$k0}}" class="small_img small_color_group{{$k0}} @if($v0==reset($res['info_img'][0])) active @endif">
                                <div class="swiper" style="overflow: hidden;">
                                    <div class="swiper-button-prev" ></div>
                                    <div class="swiper-wrapper">
                                        @foreach($v0 as $v)
                                            <div class="swiper-slide " data-image_id="{{$v['id']}}"
                                                 data-src="{{$v['image_src']}}"
                                                 onclick="changepic(this)">
                                                <img src="{{$v['image_src']}}">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="swiper-button-next" ></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                @else
                    <div class="big_img aphly_viewer_js is_color_group0">
                        @if(!empty($res['info_img'][0]))
                            <ul class="info_img_big">
                                @foreach($res['info_img'][0] as $v)
                                    @if(reset($res['info_img'][0])===$v)
                                        <li data-image_id="{{$v['id']}}" class="on"><img src="{{ $v['image_src'] }}" class="aphly_viewer "></li>
                                    @else
                                        <li data-image_id="{{$v['id']}}" ><img src="{{ $v['image_src'] }}" class="aphly_viewer"></li>
                                    @endif
                                @endforeach
                            </ul>
                        @else
                            <img src="{{ URL::asset('static/base/img/none.png') }}" class="aphly_viewer">
                        @endif
                    </div>
                    @if(!empty($res['info_img'][0]))
                        <div class="small_img">
                            <div class="swiper" style="overflow: hidden;">
                                <div class="swiper-button-prev" ></div>
                                <div class="swiper-wrapper">
                                    @foreach($res['info_img'][0] as $v)
                                            <div class="swiper-slide " data-image_id="{{$v['id']}}"
                                                 data-src="{{$v['image_src']}}"
                                                 onclick="changepic(this)">
                                                <img src="{{$v['image_src']}}">
                                            </div>
                                    @endforeach
                                </div>
                                <div class="swiper-button-next" ></div>
                            </div>
                        </div>
                    @endif
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
                @if($res['special_price'])
                <div class="price_sale_detail">
                    Final Sale
                </div>
                @endif

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
                    <button class="add_cart_btn " id="add_cart_btn" type="submit">Add To Cart</button>
                </form>
                <button class="buy_btn " id="buy_btn" type="button" onclick="buyNow(this)" style="margin-top: 10px;">Buy Now</button>
            </div>
        </div>
    </div>
    <style>
    .description_img li{text-align: center;}
    </style>
    @if($res['info_attr'])
    <div class="my_box">
        <div class="my_tab">
            <div class="my_bt active">Attribute</div>
        </div>
        <ul class="info_attr">
            @foreach($res['info_attr'] as $v)
                <li class="item wenzi">
                    {{$v['attribute']['name']}} : {{$v['text']}}
                </li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="my_box">
        <div class="my_tab">
            <div class="my_bt active">Description</div>
        </div>
        <div class="description">
            <div>{!! $res['info']->desc->description??'' !!}</div>
        </div>

        <div class="description_video">
            @if(!empty($res['info_video'][1]))
                <div class="">
                    @foreach($res['info_video'][1] as $k0=>$v0)
                        <div class="video_box" style="">
                            <video class="video-js video-js_{{$v0['id']}} vjs-16-9"
                                   controls
                                   preload="auto"
                                   data-setup='{}'>
                                <source src="{{$v0['video_src']}}" type="video/mp4" />
                            </video>
                        </div>
                        <script>
                            videojs(document.querySelector('.video-js_{{$v0['id']}}'),{
                                controlBar:{
                                    volumePanel:{
                                        inline: false,
                                    },
                                    remainingTimeDisplay:{
                                        displayNegative:false
                                    }
                                }
                            });
                        </script>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="description_img">
            @if(!empty($res['info_img'][1]))
                <div class="">
                @foreach($res['info_img'][1] as $k0=>$v0)
                    @if($res['info']->is_color_group)
                        <ul class="description_img_ul description_img_ul{{$k0}}" data-k0="{{$k0}}">
                            @foreach($v0 as $v)
                                <li><img src="{{ $v['image_src'] }}" alt=""></li>
                            @endforeach
                        </ul>
                    @else
                        <ul class="description_img_ul description_img_ul{{$k0}}" data-k0="{{$k0}}">
                            <li><img src="{{ $v0['image_src'] }}" alt=""></li>
                        </ul>
                    @endif
                @endforeach
                </div>
            @endif
        </div>
    </div>

    <input type="hidden" id="quantityInCart" value="{{$res['quantityInCart']}}">

    @if(isset($shop_config['review']) && $shop_config['review']==1)
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
                        <form class="form_request_img_file" enctype="multipart/form-data" method="post" data-image_length="{{$res['review_image_length']}}" data-image_size="{{$res['review_image_size']}}" action="/product/{{$res['info']->id}}/review/add" data-fn="review_res" >
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
                                <textarea name="text" class="form-control" required></textarea>
                                <div class="add_photo"><i class="common-iconfont icon-zhaoxiangji"></i>Add Photo</div>
                                <input type="file" style="display: none" accept="image/gif,image/jpeg,image/jpg,image/png" data-img_list="file_img"
                                       class="input_file_img add_photo_file" multiple="multiple">
                                <div class="file_img"></div>
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
                {{$res['review']->links('larave-front::common.pagination')}}
            </div>
        @endif
    </div>
    @endif
    <script>
        function review_res(res) {
            if(res.code===0){
                if(res.data.redirect){
                    location.href = res.data.redirect+'?redirect={{urlencode(request()->url())}}'
                }else{
                    location.reload()
                }
            }else{
                alert_msg(res)
            }
        }
        $(function () {
            $('.add_photo').click(function () {
                $('.add_photo_file').click();
            })
            //shipping time
            // let date = new Date();
            // let dateArray1 = date.toDateString().split(' ');
            // let shipping1 = dateArray1[1]+ ' ' + dateArray1[2]
            // $('.shipping1').html(shipping1)
            // let dateArray2 =  new Date(date.setDate(date.getDate()+1)).toDateString().split(' ');
            // let shipping2 = dateArray2[1]+ ' ' + dateArray2[2]
            // $('.shipping2').html(shipping2)
            // let dateArray21 =  new Date(date.setDate(date.getDate()+1)).toDateString().split(' ');
            // let shipping21 = dateArray21[1]+ ' ' + dateArray21[2]
            // $('.shipping21').html(shipping21)
            // let dateArray3 =  new Date(date.setDate(date.getDate()+6)).toDateString().split(' ');
            // let shipping3 = dateArray3[1]+ ' ' + dateArray3[2]
            // $('.shipping3').html(shipping3)
            // let dateArray31 =  new Date(date.setDate(date.getDate()+22)).toDateString().split(' ');
            // let shipping31 = dateArray31[1]+ ' ' + dateArray31[2]
            // $('.shipping31').html(shipping31)
        })
    </script>

    @if($res['rand']->count())
    <div class="my_box">
        <div class="my_tab">
            <div class="my_bt active">POPULAR</div>
        </div>
        <ul class=" product-category" style="margin-top: 10px;">
            @foreach($res['rand'] as $key=>$val)
                <li class="">
                    <div class="image">
                        <a href="/product/{{$val->id}}">
                            <img src="{{ URL::asset('static/base/img/none.png') }}" data-original="{{ $val->image_src }}"  class="img-responsive lazy" >
                        </a>
                    </div>
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
                </li>
            @endforeach
        </ul>
    </div>
    @endif
</div>

<script>
    let buy_now = false;
    function detail_res(res) {
        if(!res.code){
            if(buy_now){
                location.href = '/checkout/address?redirect={{urlencode(url('/checkout/address'))}}'
            }else{
                div_fly($('#add_cart_btn'),$('#cart_num'),function () {
                    $('#cart_num').text(res.data.count);
                })
            }
        }
        $('#buy_btn').removeAttr('disabled')
    }
    function buyNow(_this) {
        buy_now = true;
        $('#add_cart_btn').click()
        $(_this).attr('disabled',true).html('<i class="btn_loading app-jiazai uni"></i>');
    }
</script>

<script src="{{ URL::asset('static/shop/js/swiper-bundle.min.js') }}" type="text/javascript"></script>

<script>
    var detailSwiper = new Swiper('.swiper', {
        direction: "horizontal",
        slidesPerView: 4,
        navigation: {
            prevEl: '.swiper-button-prev',
            nextEl: '.swiper-button-next',
        },
        breakpoints: {
            1200: {
                direction: "vertical",
                slidesPerView: 7,
            },
        }
    })

    function changepic(_this) {
        $('.swiper .swiper-slide').removeClass('active')
        $(_this).addClass('active')
        let image_id = $(_this).data('image_id')
        if({{$res['info']->is_color_group}}){
            let p = $('.info_img_big_group li[data-image_id="'+image_id+'"]').closest('ul')
            p.find('li').removeClass('on')
            p.find('li[data-image_id="'+image_id+'"]').addClass('on')
        }else{
            $('.info_img_big li').removeClass('on')
            $('.info_img_big li[data-image_id="'+image_id+'"]').addClass('on')
        }
    }

    $(function () {
        $('.flag_radio').on('click','label',function () {
            $(this).closest('.flag_radio').find('label').removeClass('active')
            $(this).addClass('active')
            if({{$res['info']->is_color_group}} && $(this).closest('.flag_radio').data('is_color')){
                let option_value_id = $(this).data('option_value_id')
                if(option_value_id){
                    $('.info_img_big').removeClass('active')
                    $('.big_color_group'+option_value_id).addClass('active')
                    $('.info_img_big li').removeClass('on')
                    $('.info_img_big li:first-child').addClass('on')

                    $('.small_img').removeClass('active')
                    $('.small_color_group'+option_value_id).addClass('active')
                    $('.small_img .swiper-slide').removeClass('active')
                    $('.small_img .swiper-slide:first-child').addClass('active')
                }
            }
            let input = $(this).siblings('input')
            if(input.data('image_src')){
                $('.product_detail_img .swiper-slide[data-image_id="'+input.data('image_id')+'"]').click()
            }
        })
        $('.flag_radio').on('click','input',function () {
            price()
        })
        $('.flag_checkbox').on('click','label',function () {
            $(this).toggleClass('active')
        })
        $('.flag_checkbox').on('click','input',function () {
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
                radio_price += Number($(this).find('input[type="radio"]:checked').data('price'))
            })
            let checkbox_price = 0;
            $('.flag_checkbox').each(function () {
                $(this).find('input[type="checkbox"]:checked').each(function () {
                    checkbox_price += Number($(this).data('price'))
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
        @if($res['color'])
        $('.flag_radio .div_ul>.position-relative[data-image_src="true"] label[data-option_value_id="'+{{$res['color']}}+'"]').click();
        $('.flag_radio .div_ul>.position-relative:not([data-image_src="true"]):first-child label').click();
        @else
        $('.flag_radio .div_ul>.position-relative:first-child label').click();
        @endif
        price();
    })

</script>

@include('laravel-front::common.footer')
