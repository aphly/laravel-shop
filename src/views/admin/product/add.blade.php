<script src='{{ URL::asset('vendor/laravel/js/bootstrap-treeview.js') }}' type='text/javascript'></script>
<link rel="stylesheet" href="{{ URL::asset('vendor/laravel-shop/css/product.css') }}">
<div class="top-bar">
    <h5 class="nav-title">商品新增</h5>
</div>
<style>

</style>
<div class="imain">
    <form method="post" action="/shop-admin/product/add" class="save_form">
        @csrf
        <div class="tes">
            <div class="form-group">
                <label for="exampleInputEmail1">商品名称</label>
                <input type="text" name="name" class="form-control " value="">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">spu</label>
                <input type="text" name="spu" class="form-control " value="">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">sku</label>
                <input type="text" name="sku" class="form-control " value="">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">分类</label>
                <input type="hidden" name="cate_id" class="form-control " value="">
                <div class="fast_select" id="fast_select">
                    <div class="form-control select_text"  onclick="show_cate('fast_select')"></div>
                    <div class="treeview" style="display: none;"></div>
                </div>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">gender</label>
                <div class="d-flex libs_input">
                    {!! \Aphly\LaravelShop\Models\Product\Product::checkbox('gender',$res['filter_arr']['gender']) !!}
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">size</label>
                <input type="text" name="size" class="form-control " value="" readonly>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">frame_width</label>
                <input type="text" name="frame_width" class="form-control " value="" >
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">lens_width</label>
                <input type="text" name="lens_width" class="form-control " value="" >
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">lens_height</label>
                <input type="text" name="lens_height" class="form-control " value="" >
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">bridge_width</label>
                <input type="text" name="bridge_width" class="form-control " value="" >
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">arm_length</label>
                <input type="text" name="arm_length" class="form-control " value="" >
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">shape</label>
                <div class="d-flex libs_input">
                    {!! \Aphly\LaravelShop\Models\Product\Product::radio('shape',$res['filter_arr']['shape']) !!}
                </div>
            </div>
            <div class="form-group">
                <label for="">material</label>
                <div class="d-flex libs_input">
                    {!! \Aphly\LaravelShop\Models\Product\Product::checkbox('material',$res['filter_arr']['material']) !!}
                </div>
            </div>
            <div class="form-group">
                <label for="">frame</label>
                <div class="d-flex libs_input">
                    {!! \Aphly\LaravelShop\Models\Product\Product::radio('frame',$res['filter_arr']['frame']) !!}
                </div>
            </div>
            <div class="form-group">
                <label for="">color</label>
                <div class="d-flex libs_input">
                    {!! \Aphly\LaravelShop\Models\Product\Product::checkbox('color',$res['filter_arr']['color']) !!}
                </div>
            </div>
            <div class="form-group">
                <label for="">feature</label>
                <div class="d-flex libs_input">
                    {!! \Aphly\LaravelShop\Models\Product\Product::checkbox('feature',$res['filter_arr']['feature']) !!}
                </div>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">price</label>
                <input type="text" name="price" class="form-control " value="">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">old_price</label>
                <input type="text" name="old_price" class="form-control " value="">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">积分</label>
                <input type="text" name="points" class="form-control " value="">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">重量g</label>
                <input type="text" name="weight" class="form-control " value="">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">库存</label>
                <input type="text" name="quantity" class="form-control " value="">
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
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">description</label>
                <textarea type="text" name="description" class="form-control "></textarea>
                <div class="invalid-feedback"></div>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">保存</button>
    </form>
</div>

<script>
    var cate = @json($res['cate']);
    var data = toTree(treeData(cate));
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
    })
    function show_cate() {
        $('#fast_select .treeview').toggle();
    }
</script>


