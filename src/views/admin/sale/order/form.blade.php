
<div class="top-bar">
    <h5 class="nav-title">order</h5>
</div>
<div class="imain">
    <form method="post" @if($res['order']->id) action="/shop_admin/order/save?id={{$res['order']->id}}" @else action="/shop_admin/order/save" @endif class="save_form">
        @csrf
        <div class="coupon ajaxData">
            <div class="form-group">
                <label for="">名称</label>
                <input type="text" name="name" required class="form-control " value="{{$res['order']->name}}">
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label for="">类型</label>
                <select name="type" class="form-control " required>
                    <option value="1">百分比</option>
                    <option value="2">固定金额</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>


            <div class="form-group">
                <label for="">分类</label>
                <div class="search">
                    <input class="search_input search_input_category" >
                    <div class="search_res"></div>
                </div>
                <div class="search_text">
                    @foreach($res['coupon_category'] as $val)
                        <div class="product-category">
                            <i class="uni app-jian category_jian"></i> {!! $res['category'][$val['category_id']]['name'] !!}
                            <input type="hidden" name="coupon_category[{{$val['category_id']}}]" value="{{$val['category_id']}}">
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <label for="">商品</label>
                <div class="search">
                    <input class="search_input search_input_product" >
                    <div class="search_res"></div>
                </div>
                <div class="search_text">
                    @foreach($res['coupon_product'] as $val)
                        <div class="product-category">
                            <i class="uni app-jian category_jian"></i> {!! $res['product'][$val['product_id']]['name'] !!}
                            <input type="hidden" name="coupon_product[{{$val['product_id']}}]" value="{{$val['product_id']}}">
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <label for="">开始日期</label>
                <input type="datetime-local" class="form-control " name="date_start" value="{{$res['order']->date_start?date('Y-m-d',$res['order']->date_start)."T".date('H:i',$res['order']->date_start):0}}">
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label for="">状态</label>
                <select name="status"  class="form-control">
                    @if(isset($dict['status']))
                        @foreach($dict['status'] as $key=>$val)
                            <option value="{{$key}}" @if($res['order']->status==$key) selected @endif>{{$val}}</option>
                        @endforeach
                    @endif
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>

</div>
<style>

</style>
<script>

</script>
