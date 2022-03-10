<div class="top-bar">
    <h5 class="nav-title">用户管理</h5>
</div>
<div class="imain">
    <form method="post" action="/shop-admin/product/{{$res['info']['id']}}/edit" class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="exampleInputEmail1">商品名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['info']['name']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">分类</label>
                <input type="text" name="cate_id" class="form-control " value="{{$res['info']['cate_id']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">现价</label>
                <input type="text" name="price" class="form-control " value="{{$res['info']['price']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">原价</label>
                <input type="text" name="old_price" class="form-control " value="{{$res['info']['old_price']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">积分</label>
                <input type="text" name="points" class="form-control " value="{{$res['info']['points']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">重量kg</label>
                <input type="text" name="weight" class="form-control " value="{{$res['info']['weight']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">库存</label>
                <input type="text" name="quantity" class="form-control " value="{{$res['info']['quantity']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">是否使用库存</label>
                <select name="is_stock"  class="form-control">
                    <option value="1">是</option>
                    <option value="0">否</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">状态</label>
                <select name="status"  class="form-control">
                    <option value="1">上架</option>
                    <option value="0">下架</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
</div>




