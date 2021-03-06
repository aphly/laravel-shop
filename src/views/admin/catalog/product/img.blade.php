<div class="top-bar">
    <h5 class="nav-title">图片 - {{$res['info']->name}}</h5>
</div>
<style>
    .product_img .item{margin: 0 10px;}
    .product_img .item .img{width: 160px;height:160px;display: flex; align-items: center; box-shadow: 0 2px 4px rgb(0 0 0 / 20%);position: relative}
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
            <input type="file" class="fileUpload" accept="image/gif,image/jpeg,image/jpg,image/png"  multiple="multiple" style="display: none" onchange="uploadImg(this)">
        </label>
        <form method="post" action="/shop_admin/product/{{$res['info']->id}}/img_save" class="save_form" >
            @csrf
            @if($res['info_img'])
                <ul class="d-flex flex-wrap product_img">
                    @foreach($res['info_img'] as $v)
                        <li class="item">
                            <div class="img">
                                <img src="{{Storage::url($v['image'])}}" >
                                <div class="delImg" onclick="removeImg({{$v['id']}},this)"><i class="uni app-lajitong"></i></div>
                                <div class="img_pre img_move"><</div>
                                <div class="img_next img_move">></div>
                            </div>
                            <input type="hidden" name="sort[{{$v['id']}}]" value="{{$v['sort']}}">
                        </li>
                    @endforeach
                </ul>
                <button class="btn btn-info" type="submit" style="margin-top: 20px;">更新排序</button>
            @endif
        </form>
    </div>
</div>
<script>
    $(function () {
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
        let url = '/shop_admin/product/{{$res['info']->id}}/img';
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
