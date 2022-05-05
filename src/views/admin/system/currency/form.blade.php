
<div class="top-bar">
    <h5 class="nav-title">currency</h5>
</div>
<div class="imain">
    <form method="post" @if($res['currency']->id) action="/shop-admin/currency/save?id={{$res['currency']->id}}" @else action="/shop-admin/currency/save" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['currency']->name}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">code</label>
                <input type="text" name="code" class="form-control " value="{{$res['currency']->code}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">symbol_left</label>
                <input type="text" name="symbol_left" class="form-control " value="{{$res['currency']->symbol_left}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">symbol_right</label>
                <input type="text" name="symbol_right" class="form-control " value="{{$res['currency']->symbol_right}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">decimal_place</label>
                <input type="text" name="decimal_place" class="form-control " value="{{$res['currency']->decimal_place}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">value</label>
                <input type="text" name="value" class="form-control " value="{{$res['currency']->value}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">状态</label>
                <select name="status" class="form-control">
                    <option value="1" @if($res['currency']->status) selected @endif>开启</option>
                    <option value="0" @if(!$res['currency']->status) selected @endif>关闭</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>

</div>

