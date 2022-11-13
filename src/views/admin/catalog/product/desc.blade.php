<div class="top-bar">
    <h5 class="nav-title">商品 - {{$res['product']->name}}</h5>
    <div>
        @include('laravel-shop::admin.catalog.product.submenu')
    </div>
</div>
<div class="imain">
    <form method="post" @if($res['product']->id) action="/shop_admin/product/desc?product_id={{$res['product']->id}}" @else action="/shop_admin/product/desc" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">商品描述</label>
                <textarea name="description" class="form-control " rows="20">{{$res['product_desc']->description}}</textarea>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">meta_description</label>
                <input type="text" name="meta_description" required class="form-control " value="{{$res['product_desc']->meta_description}}">
                <div class="invalid-feedback"></div>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">保存</button>
    </form>
</div>

<script>

</script>


