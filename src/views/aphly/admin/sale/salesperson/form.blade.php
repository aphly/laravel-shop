
<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<div class="imain">
    <form method="post" @if($res['salesperson']->id) action="/shop_admin/salesperson/save?id={{$res['salesperson']->id}}" @else action="/shop_admin/salesperson/save" @endif class="save_form">
        @csrf
        <div class=" ajaxData">
            <div class="form-group">
                <label >名称</label>
                <input type="text" name="name" required class="form-control " value="{{$res['salesperson']->name}}">
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label >平台</label>
                <select name="platform"  class="form-control">
                    @if(isset($dict['salesperson_platform']))
                        @foreach($dict['salesperson_platform'] as $key=>$val)
                            <option value="{{$key}}" @if($res['salesperson']->platform==$key) selected @endif>{{$val}}</option>
                        @endforeach
                    @endif
                </select>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label >状态</label>
                <select name="status"  class="form-control">
                    @if(isset($dict['status']))
                        @foreach($dict['status'] as $key=>$val)
                            <option value="{{$key}}" @if($res['salesperson']->status===$key) selected @endif>{{$val}}</option>
                        @endforeach
                    @endif
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
