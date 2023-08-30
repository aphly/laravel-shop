<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
    <div>
        @include('laravel-shop::admin.catalog.product.submenu')
    </div>
</div>
<style>
    .product_img .item{margin: 0 10px 10px;width: 160px;}
    .product_img .item .img{width: 100%;height:160px;display: flex; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.2);position: relative}
    .product_img .item img{width: 100%;}
    .product_img .item input{width: 100%;    text-align: center;}
    .product_img .item .delImg{text-align: center; background: #df6767; color: #fff; border-radius: 50%; margin-top: 5px; position: absolute; right: 5px; top: 5px;height: 24px; width: 24px; cursor: pointer;}
    .product_img .item .delImg:hover{background:#a30606;}
    .img_pre{left:5px;}
    .img_next{right:5px;}
    .img_move:hover{background: #fff;}
    .img_move{border-radius: 50%;position:absolute;top:40%;cursor:pointer;width:30px;height:30px;color: #333;text-align:center;line-height:26px;font-size:20px;}
</style>
<div class="imain">
    <div style="margin-bottom: 50px;">
        <label>
            <div class="btn btn-primary">
                选择图片
            </div>
            <input type="file" class="fileUpload" accept="image/gif,image/jpeg,image/jpg,image/png,image/webp"  multiple="multiple" style="display: none" onchange="uploadImg(this)">
        </label>
        <form method="post" action="/shop_admin/product/img_save?product_id={{$res['product']->id}}" class="save_form" >
            @csrf
            @if($res['info_img']->count())
                <ul class="d-flex flex-wrap product_img">
                    @foreach($res['info_img'] as $v)
                        <li class="item">
                            <div class="img" style="margin-bottom: 5px;">
                                <img src="{{$v['image_src']}}" >
                                <div class="delImg" onclick="removeImg({{$v['id']}},this)"><i class="uni app-lajitong"></i></div>
                                <div class="img_pre img_move" style="display: flex;align-items: center;justify-content: center;"><i class="uni app-fanhui1" style="display: block;"></i></div>
                                <div class="img_next img_move" style="display: flex;align-items: center;justify-content: center;"><i class="uni app-fanhui1" style="transform: rotate(180deg);display: block;"></i></div>
                            </div>
                            <input type="text" style="margin-bottom: 5px;" class="form-control" name="imgs[sort][{{$v['id']}}]" value="{{$v['sort']}}">
                            <select name="imgs[type][{{$v['id']}}]" class="form-control" style="margin-bottom: 5px;">
                                <option value="0" @if($v['type']===0) selected @endif>橱窗</option>
                                <option value="1" @if($v['type']===1) selected @endif>描述</option>
                                <option value="2" @if($v['type']===2) selected @endif>选项</option>
                            </select>
                            @if(!empty($res['info_option_value']))
                            <select name="imgs[option_value_id][{{$v['id']}}]" class="form-control" >
                                @foreach($res['info_option_value']->value as $v1)
                                    @if($v1->id===$v['option_value_id'])
                                        <option value="{{$v1->id}}" selected>{{$v1->name}}</option>
                                    @else
                                        <option value="{{$v1->id}}">{{$v1->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            @endif
                        </li>
                    @endforeach
                </ul>
                <button class="btn btn-info" type="submit" style="margin-top: 20px;">更新</button>
            @endif
        </form>
    </div>
</div>
<script>
    function mount() {
        $('.product_img').on('click','.img_pre',function () {
            let curr = $(this).closest('.item');
            let pre = curr.prev();
            if(pre.length){
                pre.before(curr.prop("outerHTML"))
                curr.remove();
            }
            resetSort()
        })
        $('.product_img').on('click','.img_next',function () {
            let curr = $(this).closest('.item');
            let next = curr.next();
            if(next.length){
                next.after(curr.prop("outerHTML"))
                curr.remove();
            }
            resetSort()
        })
    }
    $(function () {
        mount()
    })

    function resetSort(){
        let items = $('.product_img .item')
        let count = items.length
        for(let i=0;i<count;i++){
            let obj = $(items[i])
            obj.find('input[type="hidden"]').val(count-i);
        }
    }

    function uploadImg(_this){
        let formData = new FormData();
        for (let i = 0; i < $(_this)[0].files.length; i++) {
            formData.append("file[]", $(_this)[0].files[i]);
        }
        formData.append('_token', '{{csrf_token()}}');
        let url = '/shop_admin/product/img?product_id={{$res['product']->id}}';
        let type = 'post';
        if(url && type){
            $.ajax({
                type,url,
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(res){
                    alert_msg(res)
                    if(!res.code) {
                        $("#iload").load(res.data.redirect);
                    }
                },
                complete:function(XMLHttpRequest,textStatus){
                    //console.log(XMLHttpRequest,textStatus)
                }
            })
        }else{
            console.log('no action'+url+type)
        }
    }

    function removeImg(id,_this){
        let url = '/shop_admin/product_img/'+id+'/del';
        $.ajax({
            url,
            dataType: "json",
            success: function(res){
                alert_msg(res)
                if(!res.code) {
                    $(_this).parent().parent().remove();
                }
            }
        })
    }

</script>
