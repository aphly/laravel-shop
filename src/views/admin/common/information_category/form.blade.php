
<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<div class="imain">
    <form method="post" @if($res['info']->id) action="/shop_admin/information_category/save?id={{$res['info']->id}}" @else action="/shop_admin/information_category/save" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label >名称</label>
                <input type="text" name="name" required class="form-control " value="{{$res['info']->name}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label >状态</label>
                <select name="status" class="form-control">
                    @foreach($dict['status'] as $key=>$val)
                        <option value="{{$key}}" @if($key===$res['info']->status) selected @endif>{{$val}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>

</div>

<script>

</script>
