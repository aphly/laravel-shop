<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
    <div>
        @include('laravel-shop::admin.catalog.product.submenu')
    </div>
</div>
<style>

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
                            <div class="search_delDiv" onclick="search_delDiv({{$val['id']}},this)"><i class="uni app-jian"></i></div>
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
                                <label class="control-label option_required">必填项</label>
                                <div class="">
                                    <select name="product_option[{{$val['id']}}][{{$val['option_id']}}][required]" class="form-control">
                                        @foreach($dict['yes_no'] as $k1=>$v1)
                                            <option value="{{$k1}}" @if($k1==$val['required']) selected @endif>{{$v1}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="option_value_list">
                                @if($res['option'][$val['option_id']]['type']=='radio' || $res['option'][$val['option_id']]['type']=='select' || $res['option'][$val['option_id']]['type']=='checkbox')
                                <ul>
                                    <li><span>选项值</span> @if($res['option'][$val['option_id']]['type']=='radio' || $res['option'][$val['option_id']]['type']=='select') <span>关联图片</span> @endif <span>数量</span><span>减少库存</span><span>价格</span>
                                        <span>排序</span><span data-option_id="{{$val['option_id']}}" onclick="add_option_value(this,'{{$val['id']}}','{{$res['option'][$val['option_id']]['type']}}')"><i class="uni app-jia"></i></span></li>
                                    @foreach($val['value_arr'] as $k=>$v)
                                        <li>
                                            <span>
                                                <select name="product_option[{{$val['id']}}][{{$val['option_id']}}][option_value][{{$v['id']}}][option_value_id]" id="">
                                                    @foreach($res['option'][$v['option_id']]['value'] as $k1=>$v1)
                                                    <option value="{{$v1['id']}}" @if($v1['id']==$v['option_value_id']) selected @endif>{{$v1['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </span>
                                            @if($res['option'][$val['option_id']]['type']=='radio')
                                            <span>
                                                <label>
                                                    <input type="hidden" name="product_option[{{$val['id']}}][{{$val['option_id']}}][option_value][{{$v['id']}}][product_image_id]" value="{{$v['product_image_id']}}">
                                                    @if($v['product_image_id'] && $res['product_image'][$v['product_image_id']])
                                                        <div class="imglist" data-id="product_option[{{$val['id']}}][{{$val['option_id']}}][option_value][{{$v['id']}}][product_image_id]"
                                                             data-image_id="{{$v['product_image_id']}}" data-image_src="{{$res['product_image'][$v['product_image_id']]['image_src']}}">
                                                            <img src="{{$res['product_image'][$v['product_image_id']]['image_src']}}" alt="">
                                                        </div>
                                                    @else
                                                        <div class="imglist" data-image_id="0" data-id="product_option[{{$val['id']}}][{{$val['option_id']}}][option_value][{{$v['id']}}][product_image_id]">
                                                           +
                                                        </div>
                                                    @endif
                                                </label>
                                            </span>
                                            @endif
                                            <span><input type="number" name="product_option[{{$val['id']}}][{{$val['option_id']}}][option_value][{{$v['id']}}][quantity]" value="{{$v['quantity']}}"></span>
                                            <span>
                                                <select name="product_option[{{$val['id']}}][{{$val['option_id']}}][option_value][{{$v['id']}}][subtract]" class="form-control">
                                                    @foreach($dict['yes_no'] as $k1=>$v1)
                                                        <option value="{{$k1}}" @if($k1==$v['subtract']) selected @endif>{{$v1}}</option>
                                                    @endforeach
                                                </select>
                                            </span>
                                            <span><input type="text" name="product_option[{{$val['id']}}][{{$val['option_id']}}][option_value][{{$v['id']}}][price]" value="{{$v['price']}}"></span>
                                            <span><input type="text" name="product_option[{{$val['id']}}][{{$val['option_id']}}][option_value][{{$v['id']}}][sort]" value="{{$v['sort']}}"></span>
                                            <span><i class="uni app-jian option_value_jian"></i></span>
                                        </li>
                                    @endforeach
                                </ul>
                                @elseif($res['option'][$val['option_id']]['type']=='text')
                                    <div class="form-group">
                                        <label class="control-label">选项值</label>
                                        <div class="">
                                            <input type="text" name="product_option[{{$val['id']}}][{{$val['option_id']}}][value]" value="{{$val['value']}}" placeholder="选项值" class="form-control">
                                        </div>
                                    </div>
                                @elseif($res['option'][$val['option_id']]['type']=='textarea')
                                    <div class="form-group">
                                        <label class="control-label">选项值</label>
                                        <div class="">
                                            <textarea name="product_option[{{$val['id']}}][{{$val['option_id']}}][value]" rows="5" placeholder="选项值" class="form-control">{{$val['value']}}</textarea>
                                        </div>
                                    </div>
                                @elseif($res['option'][$val['option_id']]['type']=='date' || $res['option'][$val['option_id']]['type']=='time' || $res['option'][$val['option_id']]['type']=='datetime-local')
                                    <div class="form-group">
                                        <label class="control-label">选项值</label>
                                        <div class="">
                                            <input type="{{$res['option'][$val['option_id']]['type']}}" name="product_option[{{$val['id']}}][{{$val['option_id']}}][value]" value="{{$val['value']}}" placeholder="选项值" class="form-control">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>

            </div>
            <div class="d-flex justify-content-end" style="margin-right: 20px">
                <button class="btn btn-primary" type="submit">保存</button>
            </div>

        </div>
    </form>
</div>
<div class="modal fade" id="product_image" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">关联图片</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if($res['product_image'])
                    <ul class="d-flex flex-wrap product_img">
                        <li class="item" data-id="0">
                            <div class="img" style="display: flex;justify-content: center;align-items: center;">
                                +
                                <i class="uni app-duigouxiao"></i>
                            </div>
                        </li>
                        @foreach($res['product_image'] as $v)
                            <li class="item" data-id="{{$v['id']}}" data-image="{{$v['image_src']}}">
                                <div class="img">
                                    <img src="{{$v['image_src']}}" >
                                    <i class="uni app-duigouxiao"></i>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="modal-footer">
                <a class="btn btn-secondary ajax_get" data-href="/shop_admin/product/img?product_id={{$res['product']->id}}" data-fn="$('#product_image').modal('toggle')">添加图片</a>
                <button type="button" class="btn btn-primary" data-dismiss="modal">完成</button>
            </div>
        </div>
    </div>
</div>
<style>
    .product_img li{margin: 1%;border:1px solid #f1f1f1;border-radius: 4px;cursor: pointer}
    .product_img li img{width: 100%;height: 100%;}
    .product_img li.active{border:1px solid #0da9c4;}
    .product_img li .img{position: relative;width: 100px;height: 100px; }
    .product_img li i{display: none;width: 20px;height: 20px;top: 5px;left: 5px;}
    .product_img li.active i{display: block;position: absolute;color:#0da9c4; }
    .imglist{border:1px solid #ddd;width: 32px;height: 32px;display: flex;align-items: center;justify-content: center;cursor: pointer;}
    .imglist img{width: 100%;height: 100%;}
</style>
<script>
    var ajax_res_data = @json($res['option']);
    function search_ajax(_this) {
        $.ajax({
            url:'/shop_admin/option/ajax?name='+$(_this).val(),
            dataType: "json",
            success:function (res) {
                ajax_res_data = res.data.list
                let arr = res.data.option_group;
                let html = ``
                for(let i in arr){
                    html += `<div class="search_res_item">
                        <div class="name">${i}</div><ul>`
                    if(arr[i].length>0){
                        for(let j in arr[i]){
                            html += `<li data-id="${arr[i][j]['id']}" data-type="${arr[i][j]['type']}" onclick="add_option(this)">${arr[i][j]['name']}</li>`
                        }
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

    function search_delDiv(product_option_id,_this){
        $(_this).closest('.item').remove();
        $('.option_value_ul_box>li[data-product_option_id="'+product_option_id+'"]').remove();
    }

    function add_option(_this) {
        let id = randomStr(8)
        let name = $(_this).text();
        let option_id = $(_this).data('id');
        let option_type = $(_this).data('type');
        $(_this).closest('.search').children('.search_input').val('')
        $('.option_value_ul_box>li').removeClass('curr')
        $('.option_ul>li').removeClass('curr')
        let option_name = `<li class="item d-flex curr" onclick="show_option_value_li('${id}',this)">
                                <div class="search_delDiv" onclick="search_delDiv('${id}',this)"><i class="uni app-jian"></i></div>
                                <div class="text">${name}</div>
                           </li>`;
        $('.option_ul').append(option_name);
        let option_value_li_html = option_value_li(option_type,option_id,id);
        let option_value = `<li data-option_id="${option_id}" data-product_option_id="${id}" class="curr">
                            <div class="form-group d-flex">
                                <label class="control-label option_required">必填项</label>
                                <div class="">
                                    <select name="product_option[${id}][${option_id}][required]" class="form-control">
                                        @foreach($dict['yes_no'] as $key=>$val)
                                            <option value="{{$key}}" @if($key) selected @endif>{{$val}}</option>
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
            if(type=='radio'){
                html += `<ul>
                    <li><span>选项值</span><span>关联图片</span><span>数量</span><span>减少库存</span><span>价格</span>
                    <span>排序</span><span data-option_id="${option_id}" onclick="add_option_value(this,'${id}','${type}')"><i class="uni app-jia"></i></span></li>
                </ul>`
            }else{
                html += `<ul>
                    <li><span>选项值</span><span>数量</span><span>减少库存</span><span>价格</span>
                    <span>排序</span><span data-option_id="${option_id}" onclick="add_option_value(this,'${id}','${type}')"><i class="uni app-jia"></i></span></li>
                </ul>`
            }
        }else if(type=='text'){
            html += `<div class="form-group">
                        <label class="control-label">选项值</label>
                        <div class="">
                            <input type="text" name="product_option[${id}][${option_id}][value]" value="" placeholder="选项值" class="form-control">
                        </div>
                    </div>`
        }else if(type=='textarea'){
            html += `<div class="form-group">
                        <label class="control-label">选项值</label>
                        <div class="">
                            <textarea name="product_option[${id}][${option_id}][value]" rows="5" placeholder="选项值" class="form-control"></textarea>
                        </div>
                    </div>`
        }else if(type=='date' || type=='time' || type=='datetime-local'){
            html += `<div class="form-group">
                        <label class="control-label">选项值</label>
                        <div class="">
                            <input type="${type}" name="product_option[${id}][${option_id}][value]" value="" placeholder="选项值" class="form-control">
                        </div>
                    </div>`
        }
        return html;
    }

    function add_option_value(_this,id,type){
        let vid = randomStr(8)
        let option_id = $(_this).data('option_id')
        let option = ``
        for(let i in ajax_res_data[option_id]['value']){
            option += `<option value="${ajax_res_data[option_id]['value'][i]['id']}">${ajax_res_data[option_id]['value'][i]['name']}</option>`
        }
        let sub = '';
        if(type=='radio'){
            sub = `<span>
                        <label>
                            <input type="hidden" name="product_option[${id}][${option_id}][option_value][${vid}][product_image_id]" value="">
                            <div class="imglist" data-id="product_option[${id}][${option_id}][option_value][${vid}][product_image_id]">+</div>
                        </label>
                    </span>`
        }
        let li = `<li>
                    <span>
                    <select name="product_option[${id}][${option_id}][option_value][${vid}][option_value_id]" id="">
                          ${option}
                    </select>
                    </span>
                    ${sub}
                    <span><input type="number" name="product_option[${id}][${option_id}][option_value][${vid}][quantity]" value="1"></span>
                    <span>
                        <select name="product_option[${id}][${option_id}][option_value][${vid}][subtract]" class="form-control">
                            @foreach($dict['yes_no'] as $key=>$val)
                                <option value="{{$key}}" @if(!$key) selected @endif>{{$val}}</option>
                            @endforeach
                        </select>
                    </span>
                    <span><input type="text" name="product_option[${id}][${option_id}][option_value][${vid}][price]" value="0"></span>
                    <span><input type="text" name="product_option[${id}][${option_id}][option_value][${vid}][sort]" value="0"></span>
                    <span><i class="uni app-jian option_value_jian"></i></span>
                </li>`
        $(_this).closest('ul').append(li);
    }

    function mount() {
        $('body').off('click').on("click", function (e) {
            //let id = $(e.target).data('id')
            if (e.target.className !== 'search_input') {
                $('.search_res').hide();
            }
        });

        $('.product_img').on('click','li',function () {
            $('.product_img li').removeClass('active')
            $(this).addClass('active')
            let old_id = $('.product_img').attr('data-id');
            let image_id = $(this).data('id')
            if(image_id){
                $('.imain input[name="'+old_id+'"]').val($(this).data('id'))
                $('.imain .imglist[data-id="'+old_id+'"]').attr('data-image_id',$(this).data('id'))
                    .attr('data-image_src',$(this).data('image'))
                    .html('<img src="'+$(this).data('image')+'" />')
            }else{
                $('.imain input[name="'+old_id+'"]').val(0)
                $('.imain .imglist[data-id="'+old_id+'"]').html('+')
            }
        })

        $('.imain').on('click', '.imglist', function (e) {
            e.stopPropagation()
            $('#product_image').modal('toggle').find('.product_img').attr('data-id',$(this).data('id'));
            let image_id = $(this).attr('data-image_id');
            let image_src = $(this).attr('data-image_src');
            if(image_id && image_src){
                $('.product_img li').each(function (){
                    let _this = $(this)
                    if(_this.data('id')==image_id && _this.data('image')===image_src){
                        _this.addClass('active')
                    }else{
                        _this.removeClass('active')
                    }
                })
            }
        })

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

        $('.option').on('click', '.option_value_jian', function (e) {
            e.stopPropagation()
            $(this).closest('li').remove()
        })
    }

    $(function () {
        mount()
    })
</script>


