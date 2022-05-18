
<div class="top-bar">
    <h5 class="nav-title">customer</h5>
</div>
<div class="imain">
    <form method="post" @if($res['customer']->id) action="/shop_admin/customer/save?id={{$res['customer']->id}}" @else action="/shop_admin/customer/save" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['customer']->name}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">描述</label>
                <input type="text" name="description" class="form-control " value="{{$res['customer']->description}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">排序</label>
                <input type="number" name="sort" class="form-control " value="{{$res['customer']->sort??0}}">
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
