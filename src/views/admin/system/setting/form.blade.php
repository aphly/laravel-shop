
<div class="top-bar">
    <h5 class="nav-title">country</h5>
</div>
<div class="imain">
    <form method="post" @if($res['country']->id) action="/shop_admin/country/save?id={{$res['country']->id}}" @else action="/shop_admin/country/save" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['country']->name}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">iso_code_2</label>
                <input type="text" name="iso_code_2" class="form-control " value="{{$res['country']->iso_code_2}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">iso_code_3</label>
                <input type="text" name="iso_code_3" class="form-control " value="{{$res['country']->iso_code_3}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">address_format</label>
                <input type="text" name="address_format" class="form-control " value="{{$res['country']->address_format}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">postcode_required</label>
                <select name="postcode_required" class="form-control">
                    <option value="1" @if($res['country']->postcode_required) selected @endif>开启</option>
                    <option value="0" @if(!$res['country']->postcode_required) selected @endif>关闭</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">状态</label>
                <select name="status" class="form-control">
                    <option value="1" @if($res['country']->status) selected @endif>开启</option>
                    <option value="0" @if(!$res['country']->status) selected @endif>关闭</option>
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
