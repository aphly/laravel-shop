@include('laravel-shop::Front.common.header')
<style>
    .product_img .item{margin: 0 10px;}
    .product_img .item .img{width: 160px;height:160px;display: flex; align-items: center; box-shadow: 0 2px 4px rgb(0 0 0 / 20%);position: relative}
    .product_img .item img{width: 100%;}
    .product_img .item input{width: 100%;    text-align: center;}
    .product_img .item .delImg{text-align: center; background: #df6767; color: #fff; border-radius: 50%; margin-top: 5px; position: absolute; right: 5px; top: 5px;height: 24px; width: 24px; cursor: pointer;}
    .product_img .item .delImg:hover{background:#a30606;}
</style>
<div class="container">
    {{$res['info']->name}} {{$res['info']->price}}
    <ul class="d-flex flex-wrap product_img">
        @foreach($res['info']->img as $v)
            <li class="item">
                <div class="img">
                    <img src="{{Storage::url($v['image'])}}" >
                    <div class="delImg" onclick="removeImg({{$v['id']}},this)"><i class="uni app-lajitong"></i></div>
                </div>
                <input type="hidden" name="sort[{{$v['id']}}]" value="{{$v['sort']}}">
            </li>
        @endforeach
    </ul>
    <ul class=" ">
        @foreach($res['info_attr'] as $v)
            <li class="item">
                {{$v['attribute']['name']}} {{$v['text']}}
            </li>
        @endforeach
    </ul>

</div>
<style>
</style>
<script>
$(function () {
    $('#carouselIndicators').carousel()
})
</script>
@include('laravel-shop::Front.common.footer')
