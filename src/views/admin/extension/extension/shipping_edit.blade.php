<div class="top-bar">
    <h5 class="nav-title">{{$res['name']}}</h5>
</div>
<style>
    .table_scroll .table_header li:nth-child(2),.table_scroll .table_tbody li:nth-child(2){flex: 0 0 300px;}
</style>
<div class="imain">

    <form method="post"  action="/shop_admin/extension/{{$res['cname']}}/edit?name={{$res['name']}}"  class="save_form">
    @csrf
        <div class="">
            @foreach($res['list'] as $v)
                @if($v['key']=='status')
                    <div class="form-group">
                        <label for="">{{$v['key']}}</label>
                        <select name="setting[{{$v['key']}}]"  class="form-control ">
                            @if(isset($dict['status']))
                                @foreach($dict['status'] as $key=>$val)
                                    <option value="{{$key}}" @if($v['value']==$key) selected @endif>{{$val}}</option>
                                @endforeach
                            @endif
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                @else
                    <div class="form-group">
                        <label for="">{{$v['key']}}</label>
                        <input type="text" name="setting[{{$v['key']}}]" class="form-control " value="{{$v['value']}}">
                        <div class="invalid-feedback"></div>
                    </div>
                @endif
            @endforeach

            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
</div>


