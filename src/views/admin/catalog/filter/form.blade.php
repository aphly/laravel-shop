
<div class="top-bar">
    <h5 class="nav-title">filter</h5>
</div>
<div class="imain">
    <form method="post" @if($res['filterGroup']->id) action="/shop-admin/filter/save?id={{$res['filterGroup']->id}}" @else action="/admin/filter/save" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['filterGroup']->name}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">状态</label>
                <select name="status" class="form-control">
                    <option value="1" @if($res['filterGroup']->status) selected @endif>开启</option>
                    <option value="0" @if(!$res['filterGroup']->status) selected @endif>关闭</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">排序</label>
                <input type="number" name="sort" class="form-control " value="{{$res['filterGroup']->sort}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group filter">
                <div onclick="filter_addDiv()" class="add_div_btn"><i class="uni app-jia"></i> Filter Values</div>
                <div class="add_div">
                    <ul class="add_div_ul">
                        <li class="d-flex">
                            <div class="filter1">名称</div>
                            <div class="filter2">排序</div>
                        </li>
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
        let id = randomId(8);
        let html = `<li class="d-flex" data-id="${id}">
                        <div class="filter1"><input type="text" name="value[${id}][name]"></div>
                        <div class="filter2"><input type="number" name="value[${id}][sort]"></div>
                        <div class="filter3" onclick="filter_delDiv(this)"><i class="uni app-lajitong"></i></div>
                    </li>`;
        $('.add_div ul').append(html);
    }
    function filter_delDiv(_this) {
        $(_this).parent().remove()
    }
</script>
