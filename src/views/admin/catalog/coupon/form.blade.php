
<div class="top-bar">
    <h5 class="nav-title">coupon</h5>
</div>
<div class="imain">
    <form method="post" @if($res['coupon']->id) action="/shop_admin/coupon/save?id={{$res['coupon']->id}}" @else action="/shop_admin/coupon/save" @endif class="save_form">
        @csrf
        <div class="coupon ajaxData">
            <div class="form-group">
                <label for="">名称</label>
                <input type="text" name="name" required class="form-control " value="{{$res['coupon']->name}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">折扣券代码</label>
                <input type="text" name="code" required class="form-control " value="{{$res['coupon']->code}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">类型</label>
                <select name="type" class="form-control " required>
                    <option value="1">百分比</option>
                    <option value="2">固定金额</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">折扣</label>
                <input type="text" name="discount" required class="form-control " value="{{$res['coupon']->discount}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">最低订单金额</label>
                <input type="text" name="total" class="form-control " value="{{$res['coupon']->total??0}}">
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label for="">分类</label>
                <div class="search">
                    <input class="search_input search_input_category" >
                    <div class="search_res"></div>
                </div>
                <div class="search_text">
                    @foreach($res['coupon_category'] as $val)
                        <div class="product-category">
                            <i class="uni app-jian category_jian"></i> {!! $res['category'][$val['category_id']]['name'] !!}
                            <input type="hidden" name="coupon_category[{{$val['category_id']}}]" value="{{$val['category_id']}}">
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="form-group">
                <label for="">商品</label>
                <div class="search">
                    <input class="search_input search_input_product" >
                    <div class="search_res"></div>
                </div>
                <div class="search_text">
                    @foreach($res['coupon_product'] as $val)
                        <div class="product-category">
                            <i class="uni app-jian category_jian"></i> {!! $res['product'][$val['product_id']]['name'] !!}
                            <input type="hidden" name="coupon_product[{{$val['product_id']}}]" value="{{$val['product_id']}}">
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <label for="">开始日期</label>
                <input type="datetime-local" class="form-control " name="date_start" value="{{$res['coupon']->date_start?date('Y-m-d',$res['coupon']->date_start)."T".date('H:i',$res['coupon']->date_start):0}}">
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label for="">结束日期</label>
                <input type="datetime-local" class="form-control " name="date_end" value="{{$res['coupon']->date_end?date('Y-m-d',$res['coupon']->date_end)."T".date('H:i',$res['coupon']->date_end):0}}">
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label for="">每张折扣券可以使用次数</label>
                <input type="number" name="uses_total" class="form-control " value="{{$res['coupon']->uses_total??0}}">
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label for="">每个会员可以使用次数</label>
                <input type="number" name="uses_customer" class="form-control " value="{{$res['coupon']->uses_customer??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">状态</label>
                <select name="status"  class="form-control">
                    @if(isset($dict['status']))
                        @foreach($dict['status'] as $key=>$val)
                            <option value="{{$key}}" @if($res['coupon']->status==$key) selected @endif>{{$val}}</option>
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
    function search_ajax(_this,type) {
        $.ajax({
            url:'/common_admin/'+type+'/ajax?name='+$(_this).val(),
            dataType: "json",
            success:function (res) {
                let arr = res.data.list;
                let html = ``
                for(let i in arr){
                    if(type=='category'){
                        html += `<div class="search_res_item"><div class="name" data-id="${arr[i][type+'_id']}" data-name="${arr[i]['name']}" onclick="show_input(this,'${type}')">${arr[i]['name']}</div><ul></div>`
                    }else{
                        html += `<div class="search_res_item"><div class="name" data-id="${arr[i]['id']}" data-name="${arr[i]['name']}" onclick="show_input(this,'${type}')">${arr[i]['name']}</div><ul></div>`
                    }
                }
                $(_this).next().html(html).show()
            }
        })
    }

    function show_input(_this,type) {
        let id = $(_this).data('id');
        let name = $(_this).data('name');
        let html = `<div class="product-category">
                        <i class="uni app-jian category_jian"></i> ${name}
                        <input type="hidden" name="coupon_${type}[${id}]" value="${id}">
                    </div>`
        $(_this).closest('.form-group').children('.search_text').append(html)
    }

    $(function () {
        $('body').on("click", function (e) {
            //let id = $(e.target).data('id')
            if (e.target.className !== 'search_input') {
                $('.search_res').hide();
            }
        });
        $('.coupon').on('focus', '.search_input_category', function (e) {
            e.stopPropagation()
            $('.search_res_cate').hide();
            search_ajax(this,'category')
        })
        $('.coupon').on('keyup', '.search_input_category', function (e) {
            e.stopPropagation()
            $('.search_res_cate').hide();
            search_ajax(this,'category')
        })
        $('.coupon').on('click', '.category_jian', function (e) {
            e.stopPropagation()
            $(this).parent().remove();
        })
        $('.coupon').on('focus', '.search_input_product', function (e) {
            e.stopPropagation()
            $('.search_res_cate').hide();
            search_ajax(this,'product')
        })
        $('.coupon').on('keyup', '.search_input_product', function (e) {
            e.stopPropagation()
            $('.search_res_cate').hide();
            search_ajax(this,'product')
        })
    })
</script>
