<script src='{{ URL::asset('vendor/laravel/js/bootstrap-treeview.js') }}' type='text/javascript'></script>
<div class="top-bar">
    <h5 class="nav-title">商品管理</h5>
</div>
<div class="imain">
    <form method="post" action="/shop-admin/product/{{$res['info']['id']}}/edit" class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="exampleInputEmail1">商品名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['info']['name']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">分类</label>
                <input type="hidden" name="cate_id" class="form-control " value="{{$res['info']['cate_id']}}">
                <div class="fast_select" id="fast_select">
                    <div class="form-control select_text"  onclick="show_cate('fast_select')"></div>
                    <div class="treeview" style="display: none;"></div>
                </div>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">现价</label>
                <input type="text" name="price" class="form-control " value="{{$res['info']['price']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">原价</label>
                <input type="text" name="old_price" class="form-control " value="{{$res['info']['old_price']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">积分</label>
                <input type="text" name="points" class="form-control " value="{{$res['info']['points']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">重量kg</label>
                <input type="text" name="weight" class="form-control " value="{{$res['info']['weight']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">库存</label>
                <input type="text" name="quantity" class="form-control " value="{{$res['info']['quantity']}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">是否使用库存</label>
                <select name="is_stock"  class="form-control">
                    <option value="1">是</option>
                    <option value="0">否</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">状态</label>
                <select name="status"  class="form-control">
                    <option value="1">上架</option>
                    <option value="0">下架</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
</div>

<script>
    var cate = @json($res['cate']);
    var select_ids = @json($res['select_ids']);
    var data = toTree(treeData(cate,select_ids));
    $(function () {
        var bTree =$('.fast_select .treeview').treeview({
            levels: 3,
            collapseIcon:'uni app-arrow-right-copy',
            expandIcon:'uni app-arrow-right',
            selectedBackColor:'#f3faff',
            selectedColor:'#212529',
            data,
            //multiSelect:true,
            onNodeSelected: function(event, data) {
                makeInput();
                $('#fast_select .treeview').toggle();
            },
        });
        var makeInput = function () {
            let arr = bTree.treeview('getSelected');
            let html = '';
            for(let i in arr){
                html += `<div data-nodeid="${arr[i].nodeId}">${arr[i].text} </div> `
                $('input[name="cate_id"]').val(arr[i].id);
            }
            $("#fast_select .select_text").html(html);
        }
        makeInput();
    })
    function show_cate() {
        $('#fast_select .treeview').toggle();
    }
</script>


