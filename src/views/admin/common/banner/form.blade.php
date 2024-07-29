
<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<div class="imain">
    <form method="post" @if($res['info']->id) action="/shop_admin/banner/save?id={{$res['info']->id}}" @else action="/shop_admin/banner/save" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">key</label>
                <input type="text" name="key" required class="form-control " value="{{$res['info']->key}}">
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label for="">url</label>
                <input type="text" name="url" class="form-control " value="{{$res['info']->url}}">
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label for="">title</label>
                <input type="text" name="title"  class="form-control " value="{{$res['info']->title}}">
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label for="">img</label>
                <input type="text" name="img" required class="form-control " value="{{$res['info']->img}}">
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label for="">img_m</label>
                <input type="text" name="img_m"  class="form-control " value="{{$res['info']->img_m}}">
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group" id="status">
                <label for="">状态</label>
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
