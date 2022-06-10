@include('laravel-shop::front.common.header')
<link rel="stylesheet" href="{{ URL::asset('vendor/laravel-shop/css/idangerous.swiper.css') }}" />
<style>
    label img{width: 50px;height: 50px;}

    .product_detail_img{max-width: 500px;width: 100%;position: relative;}
    .product_detail_img .big_img{border-right:1px solid #f1f1f1;border-bottom:1px solid #f1f1f1;width: 100%;height: 500px;}
    .product_detail_img .big_img img{width:100%;height:100%}
    .product_detail_img .small_img{height:100px;padding-top:10px;position: relative;}
    .product_detail_img .small_img .swiper-container_pc{height:80px}
    .product_detail_img .small_img .swiper-container,.lr_icon{width:450px}
    .product_detail_img .small_img .swiper-container{color:#fff;text-align:center}
    .product_detail_img .small_img .swiper-slide img {height: 100%;width: 100%;}
    .product_detail_img .small_img .swiper-wrapper .swiper-slide.active img {border: 1px solid #9d1000;}
    .product_detail_img .lr_icon.left{left:0px;top:10px;width:25px}
    .product_detail_img .lr_icon{position:absolute;width:25px;height:80px}
    .product_detail_img .lr_icon.left>div{background-position:left center}
    .product_detail_img .lr_icon>div{background:url({{ URL::asset('vendor/laravel-shop/img/leftright.png') }}) no-repeat;width:100%;height:100%;margin:0 auto;cursor:pointer}
    .product_detail_img .lr_icon.right{right:0px;top:10px;width:25px}
    .product_detail_img .lr_icon.right>div{background-position:right center}
    .product_detail_img .zoomdiv.show {visibility: visible;}
    .product_detail_img .jqZoomPup{z-index:999;display:none;position:absolute;top:0px;left:0px;box-sizing:content-box;width:250px;height:250px;background:#fff;opacity:0.5;filter:alpha(Opacity=50);cursor:pointer}
    .product_detail_img .zoomdiv{visibility:hidden;z-index:999;position:absolute;top:0;left:510px;width:500px;height:500px;background:#fff;text-align:center;overflow:hidden}
</style>
<div class="container">
    <div>
        <div>
            <div class="product_detail_img">
                <div class="big_img J_zoom" >
                    <img src="{{$oss_url?$oss_url.$res['info']->image:Storage::url($res['info']->image)}}" id="big_pic" class="zoom-img">
                </div>
                @if(count($res['info']->img))
                <div class="small_img  position-relative ">
                    <div class="swiper-container swiper-container_pc">
                        <div class="swiper-wrapper">
                            @foreach($res['info']->img as $v)
                            <div class="swiper-slide " data-src="{{$oss_url?$oss_url.$v['image']:Storage::url($v['image'])}}" onclick="changepic(this)">
                                <img src="{{$oss_url?$oss_url.$v['image']:Storage::url($v['image'])}}">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="lr_icon left"><div></div></div>
                    <div class="lr_icon right"><div></div></div>
                </div>
                @endif
            </div>
            <div>
                {{$res['info']->name}} {{$res['info']->price}}
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
    {{$res['info_special']->price??''}}
    {{$res['info_reward']->points??''}}

    <ul class=" ">
        @foreach($res['info_discount'] as $v)
            <li class="item">
               {{$v['quantity']}} {{$v['price']}}
            </li>
        @endforeach
    </ul>
    <form id="product" class="form-horizontal bv-form ">
        @csrf
        <input type="hidden" name="product_id" value="{{$res['info']->id}}">
        {!! $res['info_option'] !!}
        <div class="form-group">
            <label class="control-label" for="input-quantity">数量</label>
            <input type="number" name="quantity" value="1" class="form-control">
        </div>
        <button id="save-address" class="btn-default w120" onclick="cart_add(event)">Add Cart</button>
    </form>

</div>
<style>
</style>
<script>
function cart_add(e) {
    e.preventDefault();
    e.stopPropagation();
    $.ajax({
        url:'/cart/add',
        type:'post',
        data:$('#product input[type=\'text\'],#product input[type=\'number\'],#product input[type=\'date\'],#product input[type=\'time\'],#product input[type=\'datetime-local\'],  #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
        success:function (res) {
            console.log(res)
        }
    })
}

$(function () {

})

</script>

<script src="{{ URL::asset('vendor/laravel-shop/js/idangerous.swiper.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('vendor/laravel-shop/js/jqzoom.js') }}" type="text/javascript"></script>
<script>
    var detailSwiper = new Swiper('.swiper-container_pc',{
        paginationClickable: true,
        slidesPerView: 5,
    })
    $('.lr_icon.left').on('click', function(e){
        detailSwiper.swipePrev()
    })
    $('.lr_icon.right').on('click', function(e){
        detailSwiper.swipeNext()
    })
    var detailSwiper_m = new Swiper('.swiper-container_m',{
        //loop:true,
        grabCursor: true,
        pagination: '.pagination_img',
        paginationClickable: true
    })
    function changepic(_this){
        $('#big_pic').attr('src',$(_this).data('src'));
    }
    $(function () {
        $('.small_img .swiper-wrapper ').on('mouseenter','.swiper-slide',function () {
            $('.small_img .swiper-wrapper .swiper-slide').removeClass('active')
            $(this).addClass('active')
            $('#big_pic').attr('src',$(this).data('src'));
        })
        $('.J_zoom').jqzoom({
            width: 500,
            height: 500,
        });
    })
</script>

@include('laravel-shop::front.common.footer')
