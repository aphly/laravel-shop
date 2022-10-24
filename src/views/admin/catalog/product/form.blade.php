<link rel="stylesheet" href="{{ URL::asset('vendor/laravel-shop/css/product_admin.css') }}">
<div class="top-bar">
    <h5 class="nav-title">商品</h5>
</div>

<div class="imain">
    <form method="post" @if($res['product']->id) action="/shop_admin/product/save?id={{$res['product']->id}}" @else action="/shop_admin/product/save" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">商品名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['product']->name}}" required>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">sku</label>
                <input type="text" name="sku" class="form-control " value="{{$res['product']->sku}}" required>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">quantity</label>
                <input type="number" name="quantity" class="form-control " value="{{$res['product']->quantity??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">price</label>
                <input type="text" name="price" class="form-control " value="{{$res['product']->price??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">需要配送</label>
                <select name="shipping"  class="form-control">
                    @if(isset($dict['yes_no']))
                        @foreach($dict['yes_no'] as $key=>$val)
                            <option value="{{$key}}" @if($res['product']->shipping==$key) selected @endif>{{$val}}</option>
                        @endforeach
                    @endif
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">所需积分</label>
                <input type="text" name="points" class="form-control " value="{{$res['product']->points??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">缺货时状态</label>
                <select name="stock_status_id"  class="form-control">
                    @if(isset($dict['stock_status']))
                        @foreach($dict['stock_status'] as $key=>$val)
                            <option value="{{$key}}" @if($res['product']->stock_status_id==$key) selected @endif>{{$val}}</option>
                        @endforeach
                    @endif
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">weight</label>
                <input type="text" name="weight" class="form-control " value="{{$res['product']->weight??0}}">

                <select name="weight_class_id"  class="form-control">
                    @if(isset($dict['weight_class']))
                        @foreach($dict['weight_class'] as $key=>$val)
                            <option value="{{$key}}" @if($res['product']->weight_class_id==$key) selected @endif>{{$val}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label for="">length</label>
                <input type="text" name="length" class="form-control " value="{{$res['product']->length??0}}">
                <label for="">width</label>
                <input type="text" name="width" class="form-control " value="{{$res['product']->width??0}}">
                <label for="">height</label>
                <input type="text" name="height" class="form-control " value="{{$res['product']->height??0}}">

                <select name="length_class_id"  class="form-control">
                    @if(isset($dict['length_class']))
                        @foreach($dict['length_class'] as $key=>$val)
                            <option value="{{$key}}" @if($res['product']->length_class_id==$key) selected @endif>{{$val}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="form-group">
                <label for="">是否使用库存</label>
                <select name="subtract" class="form-control">
                    @if(isset($dict['yes_no']))
                        @foreach($dict['yes_no'] as $key=>$val)
                            <option value="{{$key}}" @if($res['product']->subtract==$key) selected @endif>{{$val}}</option>
                        @endforeach
                    @endif
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">最小购买数量</label>
                <input type="number" name="minimum" class="form-control " value="{{$res['product']->minimum??1}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">上架时间</label>
                <input type="datetime-local" name="date_available" class="form-control " value="{{$res['product']->date_available?date('Y-m-d',$res['product']->date_available)."T".date('H:i',$res['product']->date_available):0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">状态</label>
                <select name="status"  class="form-control">
                    @if(isset($dict['product_status']))
                        @foreach($dict['product_status'] as $key=>$val)
                            <option value="{{$key}}" @if($res['product']->status==$key) selected @endif>{{$val}}</option>
                        @endforeach
                    @endif
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">排序</label>
                <input type="number" name="sort"  class="form-control " value="{{$res['product']->sort??0}}">
                <div class="invalid-feedback"></div>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">保存</button>
    </form>
</div>

<script>

</script>


