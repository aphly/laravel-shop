@include('laravel-shop::Front.common.header')
<style>
    .product_img .item{margin: 0 10px;}
    .product_img .item .img{width: 160px;height:160px;display: flex; align-items: center; box-shadow: 0 2px 4px rgb(0 0 0 / 20%);position: relative}
    .product_img .item img{width: 100%;}
    .product_img .item input{width: 100%;    text-align: center;}
    .product_img .item .delImg{text-align: center; background: #df6767; color: #fff; border-radius: 50%; margin-top: 5px; position: absolute; right: 5px; top: 5px;height: 24px; width: 24px; cursor: pointer;}
    .product_img .item .delImg:hover{background:#a30606;}
    label img{width: 50px;height: 50px;}
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
        url:'/cart',
        type:'post',
        data:$('#product input[type=\'text\'],#product input[type=\'number\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
        success:function (res) {
            console.log(res)
        }
    })
}

$(function () {

})

</script>
@include('laravel-shop::Front.common.footer')
