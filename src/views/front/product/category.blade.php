@include('laravel-shop::front.common.header')
<style>
    .product-category{display:flex;flex-wrap:wrap}
    .product-category li{width:calc(20% - 8.5px);margin:0px 10px 10px 0px;padding:10px;background:#fff;box-shadow:0 2px 12px 2px #eee}
    .product-category li .image{margin-bottom:10px;position:relative;z-index:10}
    .product-category li .name{text-transform:capitalize;font-size:14px;color:#000;height:36px;line-height:18px;overflow:hidden;margin-bottom:5px}
    .product-category li .price{font-size:14px;margin-bottom:5px}
    .img-responsive{max-width:100%;height:auto}
    .product-category > li:nth-child(5n),.product-category li:last-child{margin-right:0}
</style>
<div class="container">
    <ul class=" product-category">
        @foreach($res['list'] as $key=>$val)
            <li class="">
                <div class="image">
                    <a href="/product/{{$val->id}}">
                        <img src="{{ \Aphly\LaravelShop\Models\Catalog\ProductImage::render($val->image) }}" class="img-responsive">
                    </a>
                </div>
                <div class="name"><a href="/product/{{$val->id}}">{{$val->name}}</a></div>
                <div class="price">
                    <span class="normal">{{$val->price}}</span>
                </div>
            </li>
        @endforeach
    </ul>
    <div>
        {{$res['list']->links('laravel-common::front.common.pagination')}}
    </div>
</div>
<style>

</style>

<script>
    $(function () {

    })
</script>

@include('laravel-shop::front.common.footer')
