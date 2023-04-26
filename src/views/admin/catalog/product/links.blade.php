<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
    <div>
        @include('laravel-shop::admin.catalog.product.submenu')
    </div>
</div>
<style>

</style>
<div class="imain">
    <form method="post" action="/shop_admin/product/links" class="save_form">
        @csrf
        <div class="links ajaxData">
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
                            <i class="uni app-jian filter_jian"></i> {!! $res['filter'][$val['filter_id']]['name_all'] !!}
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
            url:'/common_admin/'+type+'/ajax?name='+$(_this).val(),
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

    function mount() {
        $('body').on("click", function (e) {
            //let id = $(e.target).data('id')
            if (e.target.className !== 'search_input') {
                $('.search_res').hide();
            }
        });
        $('.links').on('focus keyup', '.search_input_cate', function (e) {
            e.stopPropagation()
            $('.search_res_cate').hide();
            search_ajax(this,'category')
        })
        $('.links').on('click', '.category_jian', function (e) {
            e.stopPropagation()
            $(this).parent().remove();
        })
        $('.links').on('focus keyup', '.search_input_filter', function (e) {
            e.stopPropagation()
            $('.search_res_cate').hide();
            search_ajax(this,'filter')
        })
        $('.links').on('click', '.filter_jian', function (e) {
            e.stopPropagation()
            $(this).parent().remove();
        })
    }

    $(function () {
        mount()
    })
</script>


