<link rel="stylesheet" href="{{ URL::asset('vendor/laravel-shop/css/product.css') }}">
<div class="top-bar">
    <h5 class="nav-title">商品</h5>
</div>
<style>

</style>
<div class="imain">
    <form method="post" action="/shop-admin/product/add" class="save_form">
        @csrf
        <div class="tes">
            <div class="form-group">
                <label for="">商品名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['product']->name}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">sku</label>
                <input type="text" name="sku" class="form-control " value="{{$res['product']->sku}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">quantity</label>
                <input type="number" name="quantity" class="form-control " value="{{$res['product']->quantity}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">price</label>
                <input type="text" name="price" class="form-control " value="{{$res['product']->price}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">需要配送</label>
                <select name="shipping"  class="form-control">
                    <option value="1">是</option>
                    <option value="0">否</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">所需积分</label>
                <input type="text" name="points" class="form-control " value="{{$res['product']->points}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">缺货时状态</label>
                <select name="stock_status_id"  class="form-control">
                    @if(isset($res['dict']['stock_status']))
                        @foreach($res['dict']['stock_status'] as $val)
                        <option value="{{$val['value']}}">{{$val['name']}}</option>
                        @endforeach
                    @endif
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">weight</label>
                <input type="text" name="weight" class="form-control " value="{{$res['product']->weight}}">
                <select name="weight_class_id"  class="form-control">
                    @if(isset($res['dict']['weight_class']))
                        @foreach($res['dict']['weight_class'] as $val)
                            <option value="{{$val['value']}}">{{$val['name']}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label for="">是否使用库存</label>
                <select name="is_stock"  class="form-control">
                    <option value="1">是</option>
                    <option value="0">否</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">状态</label>
                <select name="status"  class="form-control">
                    <option value="1">上架</option>
                    <option value="0">下架</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">description</label>
                <textarea type="text" name="description" class="form-control "></textarea>
                <div class="invalid-feedback"></div>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">保存</button>
    </form>
</div>

<script>

</script>


