
<div class="top-bar">
    <h5 class="nav-title">group</h5>
</div>
<div class="imain">
    <form method="post" @if($res['group']->id) action="/shop_admin/group/save?id={{$res['group']->id}}" @else action="/shop_admin/group/save" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['group']->name}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">描述</label>
                <input type="text" name="description" class="form-control " value="{{$res['group']->description}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">排序</label>
                <input type="number" name="sort" class="form-control " value="{{$res['group']->sort??0}}">
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
