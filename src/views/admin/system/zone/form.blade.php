
<div class="top-bar">
    <h5 class="nav-title">zone</h5>
</div>
<div class="imain">
    <form method="post" @if($res['zone']->id) action="/shop_admin/zone/save?id={{$res['zone']->id}}" @else action="/shop_admin/zone/save" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['zone']->name}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">code</label>
                <input type="text" name="code" class="form-control " value="{{$res['zone']->code}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">country_id</label>
                <select name="country_id" class="form-control">
                    @foreach($res['country'] as $key=>$val)
                    <option value="{{$key}}" @if($res['zone']->country_id==$key) selected @endif>{{$val['name']}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">状态</label>
                <select name="status" class="form-control">
                    @if(isset($dict['status']))
                        @foreach($dict['status'] as $key=>$val)
                            <option value="{{$key}}" @if($res['zone']->status==$key) selected @endif>{{$val}}</option>
                        @endforeach
                    @endif
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>

</div>

