
<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<div class="imain">
    <form method="post" @if($res['attributeGroup']->id) action="/shop_admin/attribute/save?id={{$res['attributeGroup']->id}}" @else action="/shop_admin/attribute/save" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['attributeGroup']->name}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">状态</label>
                <select name="status" class="form-control">
                    @if(isset($dict['status']))
                        @foreach($dict['status'] as $key=>$val)
                            <option value="{{$key}}" @if($res['attributeGroup']->status==$key) selected @endif>{{$val}}</option>
                        @endforeach
                    @endif
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">排序</label>
                <input type="number" name="sort" class="form-control " value="{{$res['attributeGroup']->sort??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group filter">
                <div onclick="filter_addDiv()" class="add_div_btn"><i class="uni app-jia"></i> Attribute Values</div>
                <div class="add_div">
                    <ul class="add_div_ul">
                        <li class="d-flex">
                            <div class="filter1">名称</div>
                            <div class="filter2">排序</div>
                        </li>
                        @if($res['attribute'])
                            @foreach($res['attribute'] as $key=>$val)
                                <li class="d-flex">
                                    <div class="filter1"><input type="text" name="value[{{$val->id}}][name]" value="{{$val->name}}"></div>
                                    <div class="filter2"><input type="number" name="value[{{$val->id}}][sort]" value="{{$val->sort}}"></div>
                                    <div class="filter3" onclick="filter_delDiv(this)"><i class="uni app-lajitong"></i></div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>

</div>
<style>
    .filter .filter1{width: 50%;margin: 5px 2%;}
    .filter .filter2{width: 30%;margin: 5px 2%;}
    .filter .filter3{display: flex;align-items: center;cursor: pointer;}
    .filter .filter3:hover{color: red;}
</style>
<script>
    function filter_addDiv() {
        let id = randomStr(8);
        let html = `<li class="d-flex" data-id="${id}">
                        <div class="filter1"><input type="text" name="value[${id}][name]"></div>
                        <div class="filter2"><input type="number" name="value[${id}][sort]" value="0"></div>
                        <div class="filter3" onclick="filter_delDiv(this)"><i class="uni app-lajitong"></i></div>
                    </li>`;
        $('.add_div ul').append(html);
    }
    function filter_delDiv(_this) {
        $(_this).parent().remove()
    }
</script>
