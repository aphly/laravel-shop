@include('laravel-shop-front::common.header')
<link rel="stylesheet" href="{{ URL::asset('static/shop/css/idangerous.swiper.css') }}"/>
<style>

</style>
<div class="container shop_main">
    <div>
        {!! $res['breadcrumb'] !!}
    </div>
    <div>
        <div class="product_detail">
            <div class="product_detail_img">
                <div class="big_img aphly_viewer_js">
                    <img src="{{ $res['info_img'][0]['image_src']??URL::asset('static/base/img/none.png') }}" class="aphly_viewer">
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
                    <button class="add_cart_btn " type="submit">Add To Cart</button>
                </form>

            </div>

        </div>
    </div>
    <style>

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
                {{$res['review']->links('laravel-common-front::common.pagination')}}
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
            let date = new Date();
            let dateArray1 = date.toDateString().split(' ');
            let shipping1 = dateArray1[1]+ ' ' + dateArray1[2]
            $('.shipping1').html(shipping1)
            let dateArray2 =  new Date(date.setDate(date.getDate()+1)).toDateString().split(' ');
            let shipping2 = dateArray2[1]+ ' ' + dateArray2[2]
            $('.shipping2').html(shipping2)
            let dateArray21 =  new Date(date.setDate(date.getDate()+1)).toDateString().split(' ');
            let shipping21 = dateArray21[1]+ ' ' + dateArray21[2]
            $('.shipping21').html(shipping21)
            let dateArray3 =  new Date(date.setDate(date.getDate()+6)).toDateString().split(' ');
            let shipping3 = dateArray3[1]+ ' ' + dateArray3[2]
            $('.shipping3').html(shipping3)
            let dateArray31 =  new Date(date.setDate(date.getDate()+22)).toDateString().split(' ');
            let shipping31 = dateArray31[1]+ ' ' + dateArray31[2]
            $('.shipping31').html(shipping31)
        })
    </script>
</div>

<script>
    function detail_res(res) {
        $('.cart_num').text(res.data.count);
        alert_msg(res)
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

    })

</script>

@include('laravel-shop-front::common.footer')
