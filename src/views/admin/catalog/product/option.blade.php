<link rel="stylesheet" href="{{ URL::asset('vendor/laravel-shop/css/product_admin.css') }}">
<div class="top-bar">
    <h5 class="nav-title">商品 - {{$res['product']->name}} - 选项</h5>
</div>
<style>
    .option{margin-bottom: 20px;}
    .option .search{position: relative}
    .option_name{width: 200px;margin-right: 20px;flex-shrink: 0;}
    .option_value{width: calc(100% - 220px);}
    .option_name .search_input{outline: none;height: 44px;line-height: 44px;width: 100%;padding: 0 10px;border: 1px solid #999;border-radius: 4px}
    .option_name .search_res ul li{padding: 5px 20px 5px 30px;line-height: 30px;cursor: pointer;}
    .option_name .name{color: #999;padding: 3px 20px;}
    .option_ul li{margin-bottom: 5px;}
    .option_ul li.curr{color: #fff; background-color: #1e91cf;border-radius: 4px;}
    .option_ul li:not(.curr):hover{background-color: #eee;border-radius: 4px;}
    .search_delDiv{text-align: center;}
    .search_delDiv i{cursor: pointer;}
    .option_name .text{line-height: 44px;}
    .option_name .search{margin-top: 20px;}
    .option_value_ul_box>li{display:none; }
    .option_value_ul_box>li.curr{display:block;}
    .option_value_ul_box>li>span{flex:1;}
    .option_value_list{}
    .option_value_list ul li{display: flex;margin-bottom: 10px;}
    .option_value_list ul li span{flex: 1;text-align: center;line-height: 44px;margin: 0 10px;}
    .option_value_list ul li span input,.option_value_list ul li span select{outline: none;height: 44px;line-height: 44px;padding: 0 10px; border: 1px solid #999;border-radius: 4px;width: 100%;}
    .option_value_list ul li span:nth-child(1){flex: 2;}
    .option_value_list ul li span:nth-child(2){flex: 1;}
    .option_value_list ul li span:nth-child(3){flex: 1;}
    .option_value_list ul li span:nth-child(4){flex: 1;}
    .option_value_list ul li span:nth-child(5){flex: 1;}
    .option_value_list ul li span:nth-child(6){flex: 1;}
    .option_value_list ul li span:nth-child(7){flex: 1;}
    .option_value_list ul li span i{cursor: pointer;}
    .option_value_list ul li span i:hover{color: #bd0404;}
</style>
<div class="imain">
    <form method="post" action="/shop_admin/product/option" class="save_form">
        @csrf
        <div class="">
            <input type="hidden" name="product_id" value="{{$res['product']->id}}">
            <div class="d-flex option">
                <div class="option_name">
                    <ul class="option_ul">
                        @foreach($res['product_option'] as $key=>$val)
                        <li class="item d-flex @if(!$key) curr @endif" onclick="show_option_value_li({{$val['id']}},this)">
                            <div class="search_delDiv" onclick="search_delDiv(this)"><i class="uni app-jian"></i></div>
                            <div class="text">{{$res['option'][$val['option_id']]['name']}}</div>
                        </li>
                        @endforeach
                    </ul>
                    <div class="search">
                        <input class="search_input" >
                        <div class="search_res"></div>
                    </div>
                </div>
                <div class="option_value">
                    <ul class="option_value_ul_box">
                        @foreach($res['product_option'] as $key=>$val)
                        <li @if(!$key) class="curr" @endif data-option_id="{{$val['option_id']}}" data-product_option_id="{{$val['id']}}">
                            <div class="form-group d-flex">
                                <label class="control-label">必填项</label>
                                <div class="">
                                    <select name="product_option[{{$val['id']}}][{{$val['option_id']}}][required]" class="form-control">
                                        @foreach($dict['yes_no'] as $k1=>$v1)
                                            <option value="{{$k1}}" @if($k1==$val['required']) selected @endif>{{$v1}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="option_value_list">
                                @if($res['option'][$val['option_id']]['type']=='radio')
                                <ul>
                                    <li><span>选项值</span><span>数量</span><span>减少库存</span><span>价格</span>
                                        <span>所需积分</span><span>重量</span><span data-option_id="{{$val['option_id']}}" onclick="add_option_value(this,'{{$val['id']}}')"><i class="uni app-jia"></i></span></li>
                                    @foreach($val['value'] as $k=>$v)
                                        <li>
                                            <span>
                                                <select name="product_option[{{$val['id']}}][{{$val['option_id']}}][option_value][{{$v['id']}}][option_value_id]" id="">
                                                    @foreach($res['option'][$v['option_id']]['value'] as $k1=>$v1)
                                                    <option value="{{$v1['id']}}" @if($v1['id']==$v['option_value_id']) selected @endif>{{$v1['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </span>
                                            <span><input type="number" name="product_option[{{$val['id']}}][{{$val['option_id']}}][option_value][{{$v['id']}}][quantity]" value="{{$v['quantity']}}"></span>
                                            <span>
                                                <select name="product_option[{{$val['id']}}][{{$val['option_id']}}][option_value][{{$v['id']}}][subtract]" class="form-control">
                                                    @foreach($dict['yes_no'] as $k1=>$v1)
                                                        <option value="{{$k1}}" @if($k1==$v['subtract']) selected @endif>{{$v1}}</option>
                                                    @endforeach
                                                </select>
                                            </span>
                                            <span><input type="text" name="product_option[{{$val['id']}}][{{$val['option_id']}}][option_value][{{$v['id']}}][price]" value="{{$v['price']}}"></span>
                                            <span><input type="number" name="product_option[{{$val['id']}}][{{$val['option_id']}}][option_value][{{$v['id']}}][points]" value="{{$v['points']}}"></span>
                                            <span><input type="text" name="product_option[{{$val['id']}}][{{$val['option_id']}}][option_value][{{$v['id']}}][weight]" value="{{$v['weight']}}"></span>
                                            <span><i class="uni app-jian"></i></span>
                                        </li>
                                    @endforeach
                                </ul>
                                @elseif($res['option'][$val['option_id']]['type']=='text')

                                @endif
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    <button class="btn btn-primary" type="submit">保存</button>
                </div>
            </div>


        </div>

    </form>
</div>
<style>

</style>
<script>
    var ajax_res_data = @json($res['option']);
    function search_ajax(_this) {
        $.ajax({
            url:'/shop_admin/product/option_ajax?name='+$(_this).val(),
            dataType: "json",
            success:function (res) {
                ajax_res_data = res.data.list
                let arr = res.data.option_group;
                let html = ``
                for(let i in arr){
                    html += `<div class="search_res_item">
                        <div class="name">${i}</div><ul>`
                    for(let j in arr[i]){
                        html += `<li data-id="${arr[i][j]['id']}" data-type="${arr[i][j]['type']}" onclick="add_option(this)">${arr[i][j]['name']}</li>`
                    }
                    html += `</ul></div>`
                }
                $(_this).next().html(html).show()
            }
        })
    }

    function show_option_value_li(product_option_id,_this) {
        $('.option_ul>li').removeClass('curr')
        $(_this).addClass('curr')
        $('.option_value_ul_box>li').removeClass('curr')
        $('.option_value_ul_box>li[data-product_option_id="'+product_option_id+'"]').addClass('curr')
    }

    function add_option(_this) {
        let id = randomId(8)
        let name = $(_this).text();
        let option_id = $(_this).data('id');
        let option_type = $(_this).data('type');
        $(_this).closest('.search').children('.search_input').val('')
        $('.option_value_ul_box>li').removeClass('curr')
        $('.option_ul>li').removeClass('curr')
        let option_name = `<li class="item d-flex curr" onclick="show_option_value_li('${id}',this)">
                                <div class="search_delDiv" onclick="search_delDiv(this)"><i class="uni app-jian"></i></div>
                                <div class="text">${name}</div>
                           </li>`;
        $('.option_ul').append(option_name);
        let option_value_li_html = option_value_li(option_type,option_id,id);
        let option_value = `<li data-option_id="${option_id}" data-product_option_id="${id}" class="curr">
                            <div class="form-group">
                                <label class="control-label">必填项</label>
                                <div class="">
                                    <select name="product_option[${id}][${option_id}][required]" class="form-control">
                                        @foreach($dict['yes_no'] as $key=>$val)
                                            <option value="{{$key}}">{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="option_value_list">
                                ${option_value_li_html}
                            </div>
                        </li>`;
        $('.option_value_ul_box').append(option_value);
    }

    function option_value_li(type,option_id,id) {
        let html = ``
        if(type=='select' || type=='radio' || type=='checkbox'){
            html += `<ul>
                    <li><span>选项值</span><span>数量</span><span>减少库存</span><span>价格</span>
                    <span>所需积分</span><span>重量</span><span data-option_id="${option_id}" onclick="add_option_value(this,'${id}')"><i class="uni app-jia"></i></span></li>

                </ul>`
        }else if(type=='text'){
        }else if(type=='textarea'){
        }else if(type=='file'){
        }else if(type=='date'){
        }else if(type=='time'){
        }else if(type=='datetime'){

        }
        return html;
    }

    function add_option_value(_this,id){
        let vid = randomId(8)
        let option_id = $(_this).data('option_id')
        let option = ``
        for(let i in ajax_res_data[option_id]['value']){
            option += `<option value="${ajax_res_data[option_id]['value'][i]['id']}">${ajax_res_data[option_id]['value'][i]['name']}</option>`
        }
        let li = `<li>
                    <span>
                    <select name="product_option[${id}][${option_id}][option_value][${vid}][option_value_id]" id="">
                          ${option}
                    </select>
                    </span>
                    <span><input type="number" name="product_option[${id}][${option_id}][option_value][${vid}][quantity]"></span>
                    <span>
                        <select name="product_option[${id}][${option_id}][option_value][${vid}][subtract]" class="form-control">
                            @foreach($dict['yes_no'] as $key=>$val)
                                <option value="{{$key}}">{{$val}}</option>
                            @endforeach
                        </select>
                    </span>
                    <span><input type="text" name="product_option[${id}][${option_id}][option_value][${vid}][price]"></span>
                    <span><input type="number" name="product_option[${id}][${option_id}][option_value][${vid}][points]"></span>
                    <span><input type="text" name="product_option[${id}][${option_id}][option_value][${vid}][weight]"></span>
                    <span><i class="uni app-jian"></i></span>
                </li>`

        $(_this).closest('ul').append(li);
    }


    $(function () {
        $('body').on("click", function (e) {
            //let id = $(e.target).data('id')
            if (e.target.className !== 'search_input') {
                $('.search_res').hide();
            }
        });
        $('.option').on('focus', '.search_input', function (e) {
            e.stopPropagation()
            $('.search_res').hide();
            search_ajax(this)
        })
        $('.option').on('keyup', '.search_input', function (e) {
            e.stopPropagation()
            $('.search_res').hide();
            search_ajax(this)
        })
    })
</script>


