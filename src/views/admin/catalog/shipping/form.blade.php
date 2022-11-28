<div class="top-bar">
    <h5 class="nav-title">shipping</h5>
</div>
<div class="imain">
    <form method="post" @if($res['info']->id) action="/shop_admin/shipping/save?id={{$res['info']->id}}" @else action="/shop_admin/shipping/save" @endif class="save_form">
        @csrf
        <div class="review">
            <div class="form-group">
                <label for="">名称</label>
                <input type="text" name="name" required class="form-control " value="{{$res['info']->name}}">
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label for="">描述</label>
                <textarea name="desc" rows="5"  class="form-control ">{{$res['info']->desc}}</textarea>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label for="">价格</label>
                <input type="text" name="cost" class="form-control " value="{{$res['info']->cost}}">
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label for="">满免邮</label>
                <input type="text" name="free_cost" class="form-control " value="{{$res['info']->free_cost}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">默认</label>
                <select name="default" class="form-control">
                    @if(isset($dict['yes_no']))
                        @foreach($dict['yes_no'] as $key=>$val)
                            <option value="{{$key}}" @if($res['info']->default==$key) selected @endif>{{$val}}</option>
                        @endforeach
                    @endif
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">状态</label>
                <select name="status" class="form-control">
                    @if(isset($dict['status']))
                        @foreach($dict['status'] as $key=>$val)
                            <option value="{{$key}}" @if($res['info']->status==$key) selected @endif>{{$val}}</option>
                        @endforeach
                    @endif
                </select>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label for="">排序</label>
                <input type="number" name="sort" class="form-control " value="{{$res['info']->sort}}">
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label for="">区域</label>
                <select name="geo_group_id" class="form-control">
                    <option value="0" @if(!$res['info']->geo_group_id) selected @endif>无</option>
                    @if(isset($res['geoGroup']))
                        @foreach($res['geoGroup'] as $key=>$val)
                            <option value="{{$val['id']}}" @if($res['info']->geo_group_id==$val['id']) selected @endif>{{$val['name']}}</option>
                        @endforeach
                    @endif
                </select>
                <div class="invalid-feedback"></div>
            </div>

            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>

</div>

