<div class="top-bar">
    <h5 class="nav-title">商品 - {{$res['product']->name}} - 属性</h5>
    <div>
        @include('laravel-shop::admin.catalog.product.submenu')
    </div>
</div>
<div class="imain">
    <form method="post" action="/shop_admin/product/attribute" class="save_form">
        @csrf
        <div class="">
            <input type="hidden" name="product_id" value="{{$res['product']->id}}">
            <div onclick="attribute_addDiv()" class="add_div_btn"><i class="uni app-jia"></i> 新增</div>

            <div class="add_div add_div_attribute">
                <ul>
                    <li class="item d-flex">
                        <div class="search">属性</div><div class="text">值</div>
                    </li>
                    @foreach($res['product_attribute'] as $val)
                        <li class="item d-flex justify-content-between">
                            <div class="search">
                                <input class="search_input" readonly value="{{$val['attribute']['name']??''}}">
                                <div class="search_res"></div>
                            </div>
                            <div class="text"><textarea type="text" name="attribute[{{$val['attribute_id']}}]">{{$val['text']}}</textarea></div>
                            <div class="search_delDiv" onclick="search_delDiv(this)"><i class="uni app-lajitong"></i></div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">保存</button>
    </form>
</div>
<style>

</style>
<script>
    function attribute_addDiv() {
        let html = `<li class="item d-flex">
                        <div class="search">
                            <input class="search_input search_input_js" >
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
    function search_ajax(_this) {
        $.ajax({
            url:'/shop_admin/attribute/ajax?name='+$(_this).val(),
            dataType: "json",
            success:function (res) {
                let arr = res.data.list;
                let html = ``
                for(let i in arr){
                    html += `<div class="search_res_item"><div class="groupname">${arr[i]['groupname']}</div><ul>`
                    for(let j in arr[i]['child']){
                        html += `<li data-id="${j}" data-groupname="${arr[i]['groupname']}" data-name="${arr[i]['child'][j]}" onclick="show_text(this)">${arr[i]['child'][j]}</li>`
                    }
                    html += `</ul></div>`
                }
                $(_this).next().html(html).show()
            }
        })
    }
    function show_text(_this) {
        $(_this).closest('.item').children('.text').html(
            `<textarea type="text" name="attribute[${$(_this).data('id')}]"></textarea>`
        )
        $(_this).closest('.search').children('input').val($(_this).data('name'))
        $(_this).closest('.search_res').hide()
    }
    function mount() {
        $('body').off('click').on("click", function (e) {
            //let id = $(e.target).data('id')
            if (e.target.className !== 'search_input') {
                $('.search_res').hide();
            }
        });
        $('.add_div').on('focus', '.search_input_js', function (e) {
            e.stopPropagation()
            $('.search_res').hide();
            search_ajax(this)
        })
        $('.add_div').on('keyup', '.search_input_js', function (e) {
            e.stopPropagation()
            $('.search_res').hide();
            search_ajax(this)
        })
    }
    $(function () {
        mount()
    })
</script>


