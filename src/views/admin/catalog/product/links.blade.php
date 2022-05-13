<link rel="stylesheet" href="{{ URL::asset('vendor/laravel-shop/css/product_admin.css') }}">
<div class="top-bar">
    <h5 class="nav-title">商品 - {{$res['product']->name}}</h5>
</div>
<style>
    .links .search_text{padding: 10px; margin-bottom: 20px;background-color: #f5f5f5;box-shadow: inset 0 1px 1px rgb(0 0 0 / 5%);min-height: 150px;border: 1px solid #e3e3e3;}
    .links .search{position: relative;}
    .links .search_input {
        outline: none;
        height: 32px;
        line-height: 32px;
        width: 100%;
        padding: 0 10px;
        border: 1px solid #999;
        border-radius: 4px;
    }
    .links .search_res_item .name{padding: 5px 20px;line-height: 30px;cursor: pointer;}
    .links .search_res_item .name:hover{background: #f1f1f1;}
    .links .category_jian:hover{color: #bd0404;}
    .links .category_jian{cursor: pointer}
</style>
<div class="imain">
    <form method="post" action="/shop_admin/product/links" class="save_form">
        @csrf
        <div class="links">
            <input type="hidden" name="product_id" value="{{$res['product']->id}}">
            <div class="form-group">
                <label for="">分类</label>
                <div class="search">
                    <input class="search_input search_input_cate" >
                    <div class="search_res"></div>
                </div>
                <div class="search_text">
                    @foreach($res['product_category'] as $val)
                        <div class="product-category">
                            <i class="uni app-jian category_jian"></i> {!! $res['category'][$val['category_id']]['name'] !!}
                            <input type="hidden" name="product_category[{{$val['category_id']}}]" value="{{$val['category_id']}}">
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="form-group">
                <label for="">筛选</label>
                <div class="search">
                    <input class="search_input search_input_filter" >
                    <div class="search_res"></div>
                </div>
                <div class="search_text">
                    @foreach($res['product_filter'] as $val)
                        <div class="product-category">
                            <i class="uni app-jian category_jian"></i> {!! $res['filter'][$val['filter_id']]['name_all'] !!}
                            <input type="hidden" name="product_filter[{{$val['filter_id']}}]" value="{{$val['filter_id']}}">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">保存</button>
    </form>
</div>

<script>
    function search_ajax(_this,type) {
        $.ajax({
            url:'/shop_admin/product/'+type+'_ajax?name='+$(_this).val(),
            dataType: "json",
            success:function (res) {
                let arr = res.data.list;
                let html = ``
                for(let i in arr){
                    if(type=='category'){
                        html += `<div class="search_res_item"><div class="name" data-id="${arr[i][type+'_id']}" data-name="${arr[i]['name']}" onclick="show_input(this,'${type}')">${arr[i]['name']}</div><ul></div>`
                    }else{
                        html += `<div class="search_res_item"><div class="name" data-id="${arr[i]['id']}" data-name="${arr[i]['name_all']}" onclick="show_input(this,'${type}')">${arr[i]['name_all']}</div><ul></div>`
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
                        <input type="hidden" name="product_${type}[${id}]" value="${id}">
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
        $('.links').on('focus', '.search_input_cate', function (e) {
            e.stopPropagation()
            $('.search_res_cate').hide();
            search_ajax(this,'category')
        })
        $('.links').on('keyup', '.search_input_cate', function (e) {
            e.stopPropagation()
            $('.search_res_cate').hide();
            search_ajax(this,'category')
        })
        $('.links').on('click', '.category_jian', function (e) {
            e.stopPropagation()
            $(this).parent().remove();
        })
        $('.links').on('focus', '.search_input_filter', function (e) {
            e.stopPropagation()
            $('.search_res_cate').hide();
            search_ajax(this,'filter')
        })
        $('.links').on('keyup', '.search_input_filter', function (e) {
            e.stopPropagation()
            $('.search_res_cate').hide();
            search_ajax(this,'filter')
        })
    })
</script>


