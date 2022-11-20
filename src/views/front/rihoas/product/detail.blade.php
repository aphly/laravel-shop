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
            <div>
                {{$res['info']->name}}
            </div>
            <div class="d-flex price">
                <span class="normal">{{$res['info']->price}}</span>
                @if(!empty($res['info_special']) && $res['info_special']->price)
                    <span class="special_price">{{$res['info_special']->price}}</span>
                    <span class="price_sale">Sale</span>
                @endif
            </div>
            <div>
                @if($res['shipping'])
                    <div style="text-align: left;margin-bottom:0px">
                        <span style="font-size: 14px; color: #E36254">
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

    <ul class=" ">
        @foreach($res['info_discount'] as $v)
            <li class="item">
                {{$v['quantity']}} {{$v['price']}}
            </li>
        @endforeach
    </ul>

    <form id="product" class="" method="post" action="/cart/add">
        @csrf
        <input type="hidden" name="product_id" value="{{$res['info']->id}}">
        <div class="info_option">
            {!! $res['info_option'] !!}
        </div>
        <div class="form-group">
            <div class="control-label">Quantity</div>
            <div class="quantity-wrapper">
                <div class="quantity-down">-</div>
                <input type="number" name="quantity" value="1" class="form-control">
                <div class="quantity-up">+</div>
            </div>
        </div>
        <button id="save-address" class="add_cart_btn " >Add To Cart</button>
    </form>

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

    input[type='number']::-webkit-outer-spin-button,input[type='number']::-webkit-inner-spin-button {
        -webkit-appearance: none !important;
    }
    .add_cart_btn{height: 48px;background: #fff;border: 1px solid #212b36;width: 100%;border-radius: 2px;}
    .add_cart_btn:hover{background: #212b36;color: #fff;}
</style>
<script>
    let form_id = '#product'
    $(function (){
        $(form_id).submit(function (){
            const form = $(this)
            if(form[0].checkValidity()===false){
            }else{
                let url = form.attr("action");
                let type = form.attr("method");
                if(url && type){
                    $(form_id+' input.form-control').removeClass('is-valid').removeClass('is-invalid');
                    let btn_html = $(form_id+' button[type="submit"]').html();
                    $.ajax({
                        type,url,
                        data: form.serialize(),
                        dataType: "json",
                        beforeSend:function () {
                            $(form_id+' button[type="submit"]').attr('disabled',true).html('<i class="btn_loading app-jiazai uni"></i>');
                        },
                        success: function(res){
                            $('.cart_num').text(res.data.count);
                        },
                        complete:function(XMLHttpRequest,textStatus){
                            $(form_id+' button[type="submit"]').removeAttr('disabled').html(btn_html);
                        }
                    })
                }else{
                    console.log('no action')
                }
            }
            return false;
        })

    });
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

        $('.info_option').on('click',' label',function () {
            $(this).closest('div').find('label').removeClass('active')
            $(this).addClass('active')
            if($(this).data('image_src')){
                $('.product_detail_img .swiper-slide[data-image_id="'+$(this).data('image_id')+'"]').click()
            }
        })
        $('.info_option .radio label:first').click();
        $('.quantity-wrapper').on('click','.quantity-down', function (e) {
            let input = $(this).parent().find('input')
            let q_curr = parseInt(input.val());
            let quantity = q_curr-1;
            if(quantity>0){
                input.val(quantity)
            }else{
                input.val(0)
            }
        })

        $('.quantity-wrapper').on('click','.quantity-up', function (e) {
            let input = $(this).parent().find('input')
            let q_curr = parseInt(input.val());
            input.val(q_curr+1)
        })

    })
</script>

@include('laravel-shop-front::common.footer')
