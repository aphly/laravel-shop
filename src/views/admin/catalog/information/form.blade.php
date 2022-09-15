
<div class="top-bar">
    <h5 class="nav-title">information</h5>
</div>
<div class="imain">
    <form method="post" @if($res['information']->id) action="/shop_admin/information/save?id={{$res['information']->id}}" @else action="/shop_admin/information/save" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">标题</label>
                <input type="text" name="title" class="form-control " value="{{$res['information']->title}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">内容</label>
                <textarea name="description" rows="10" class="form-control ">{!! $res['information']->description !!}</textarea>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">meta_title</label>
                <input type="text" name="meta_title" class="form-control " value="{{$res['information']->meta_title}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">meta_keyword</label>
                <input type="text" name="meta_keyword" class="form-control " value="{{$res['information']->meta_keyword}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">meta_description</label>
                <input type="text" name="meta_description" class="form-control " value="{{$res['information']->meta_description}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">状态</label>
                <select name="status" class="form-control">
                    @if(isset($dict['status']))
                        @foreach($dict['status'] as $key=>$val)
                            <option value="{{$key}}" @if($res['information']->status==$key) selected @endif>{{$val}}</option>
                        @endforeach
                    @endif
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">排序</label>
                <input type="number" name="sort" class="form-control " value="{{$res['information']->sort??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>

</div>
