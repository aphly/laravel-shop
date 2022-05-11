<link rel="stylesheet" href="{{ URL::asset('vendor/laravel-shop/css/product_admin.css') }}">
<div class="top-bar">
    <h5 class="nav-title">商品 - {{$res['product']->name}} - 选项</h5>
</div>
<style>
    .option{margin-bottom: 20px;}
    .option .search{position: relative}
    .option_name{width: 200px}
    .option_value{}
    .option_name .search_input{outline: none;height: 44px;line-height: 44px;width: 100%;padding: 0 10px;border: 1px solid #999;border-radius: 4px}
    .option_name .search_res ul li{padding: 5px 20px 5px 30px;line-height: 30px;cursor: pointer;}
</style>
<div class="imain">
    <form method="post" action="/shop_admin/product/option" class="save_form">
        @csrf
        <div class="">
            <input type="hidden" name="product_id" value="{{$res['product']->id}}">
            <div class="d-flex option">
                <div class="option_name">
                    <ul>
                        <li></li>
                    </ul>
                    <div class="search">
                        <input class="search_input" oninput="search_ajax(this)">
                        <div class="search_res"></div>
                    </div>
                </div>
                <div class="option_value">

                </div>
            </div>


        </div>
        <button class="btn btn-primary" type="submit">保存</button>
    </form>
</div>
<style>

</style>
<script>
    var ajax_res_data = {};
    function search_ajax(_this) {
        $.ajax({
            url:'/shop_admin/product/option_ajax?name='+$(_this).val(),
            dataType: "json",
            success:function (res) {
                ajax_res_data = res.data.list
                let arr = res.data.list;
                let html = ``
                for(let i in arr){
                    html += `<div class="search_res_item">
                        <div class="name">${arr[i]['name']}</div>`

                    html += `</div>`
                }
                $(_this).next().html(html).show()
            }
        })
    }



    function attribute_addDiv() {
        let html = `<li class="item d-flex">
                        <div class="search">
                            <input class="search_input" oninput="search_ajax(this)">
                            <div class="search_res"></div>
                        </div>
                        <div class="text"></div>
                        <div class="search_delDiv" onclick="search_delDiv(this)"><i class="uni app-lajitong"></i></div>
                    </li>`;
        $('.add_div ul').append(html);
    }
    function search_delDiv(_this) {
        $(_this).parent().remove()
    }

    function show_text(_this) {
        $(_this).closest('.item').children('.text').html(
            `<textarea type="text" name="attribute[${$(_this).data('id')}]"></textarea>`
        )
        $(_this).closest('.search').children('input').val($(_this).data('name'))
        $(_this).closest('.search_res').hide()
    }
    $(function () {
        $('body').on("click", function (e) {
            //let id = $(e.target).data('id')
            if (e.target.className !== 'search_input') {
                $('.search_res').hide();
            }
        });
        $('.add_div').on('focus', '.search_input', function (e) {
            e.stopPropagation()
            $('.search_res').hide();
        })
    })
</script>


