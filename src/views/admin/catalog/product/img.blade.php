<div class="top-bar">
    <h5 class="nav-title">图片 </h5>
</div>
<div class="imain">
    <input type="file" style="margin-bottom: 20px;" accept="image/gif,image/jpeg,image/jpg,image/png" id="img" multiple="multiple" class="form-control-file" onchange="uploadImg(this)">
    <form method="post" action="/shop_admin/product/{{$res['info']['id']}}/img_save" class="save_form" >
        @csrf
        <ul class="d-flex flex-wrap product_img">
            @foreach($res['info_img'] as $v)
                <li class="item">
                    <div class="img">
                        <img src="{{Storage::url($v['src'])}}" >
                        <div class="delImg" onclick="removeImg({{$v['id']}},this)">X</div>
                    </div>
                    <input type="number" name="sort[{{$v['id']}}]" value="{{$v['sort']}}">
                </li>
            @endforeach
        </ul>
        <button class="btn btn-primary" type="submit" style="margin-top: 20px;">保存</button>
    </form>
</div>
<style>
.product_img .item{margin: 0 10px;}
.product_img .item .img{width: 200px;height:200px;display: flex; align-items: center; box-shadow: 0 2px 4px rgb(0 0 0 / 20%);position: relative}
.product_img .item img{width: 100%;}
.product_img .item input{width: 100%;    text-align: center;}
.product_img .item .delImg{text-align: center; background: #a30606; color: #fff; border-radius: 50%; margin-top: 5px; position: absolute; right: 5px; top: 5px; width: 20px; cursor: pointer;}
</style>
<script>
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
    function uploadImg(_this){
        let formData = new FormData();
        for (let i = 0; i < $(_this)[0].files.length; i++) {
            formData.append("file[]", $(_this)[0].files[i]);
        }
        formData.append('_token', '{{csrf_token()}}');
        let url = '/shop_admin/product/{{$res['info']['id']}}/img';
        let type = 'post';
        if(url && type){
            $.ajax({
                type,url,
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(res){
                    console.log(res.data);
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
</script>
