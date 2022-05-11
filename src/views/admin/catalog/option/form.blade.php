
<div class="top-bar">
    <h5 class="nav-title">option</h5>
</div>
<div class="imain">
    <form method="post" id="option_form" @if($res['option']->id) action="/shop_admin/option/save?id={{$res['option']->id}}" @else action="/shop_admin/option/save" @endif >
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">名称</label>
                <input type="text" name="name" class="form-control " value="{{$res['option']->name}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">类型</label>
                <select name="type" class="form-control" id="type">
                    <optgroup label="选择">
                        <option value="select" @if($res['option']->type=='select') selected @endif>下拉列表</option>
                        <option value="radio" @if($res['option']->type=='radio') selected @endif>单选按钮组</option>
                        <option value="checkbox" @if($res['option']->type=='checkbox') selected @endif>复选框</option>
                    </optgroup>
                    <optgroup label="文字录入">
                        <option value="text" @if($res['option']->type=='text') selected @endif>单行文本</option>
                        <option value="textarea" @if($res['option']->type=='textarea') selected @endif>多行文本区</option>
                    </optgroup>
                    <optgroup label="文件">
                        <option value="file" @if($res['option']->type=='file') selected @endif>文件</option>
                    </optgroup>
                    <optgroup label="日期">
                        <option value="date" @if($res['option']->type=='date') selected @endif>日期</option>
                        <option value="time" @if($res['option']->type=='time') selected @endif>时间</option>
                        <option value="datetime" @if($res['option']->type=='datetime') selected @endif>日期 &amp; 时间</option>
                    </optgroup>
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">状态</label>
                <select name="status" class="form-control">
                    @if(isset($dict['status']))
                        @foreach($dict['status'] as $key=>$val)
                            <option value="{{$key}}" @if($res['option']->status==$key) selected @endif>{{$val}}</option>
                        @endforeach
                    @endif
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">排序</label>
                <input type="number" name="sort" class="form-control " value="{{$res['option']->sort??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group filter option_op"
                 @if($res['option']->type)
                    @if($res['option']->type=='select' || $res['option']->type=='radio' || $res['option']->type=='checkbox')
                    @else
                        style="display: none"
                    @endif
                 @endif
                     >
                <div onclick="filter_addDiv()" class="add_div_btn"><i class="uni app-jia"></i> option Values</div>
                <div class="add_div">
                    <ul class="add_div_ul">
                        <li class="d-flex">
                            <div class="filter1">名称</div>
                            <div class="filter11">图片</div>
                            <div class="filter2">排序</div>
                        </li>
                        @if($res['optionValue'])
                            @foreach($res['optionValue'] as $key=>$val)
                                <li class="d-flex">
                                    <div class="filter1"><input type="text" name="value[{{$val->id}}][name]" value="{{$val->name}}"></div>
                                    <div class="filter11">
                                        <label class="" data-id="{{$val->id}}">
                                            @if($val->image)
                                                <input type="text" class="fileUpload_text" value="{{$val->image}}" name="value[{{$val->id}}][image]" >
                                                <div class="imglist"><img src="{{Storage::url($val->image)}}"></div>
                                            @else
                                                <input type="file" class="fileUpload" accept="image/gif,image/jpeg,image/jpg,image/png"  name="value[{{$val->id}}][image]" >
                                                <div class="imglist">+</div>
                                            @endif
                                        </label>
                                    </div>
                                    <div class="filter2"><input type="number" name="value[{{$val->id}}][sort]" value="{{$val->sort}}"></div>
                                    <div class="filter3" onclick="filter_delDiv(this)"><i class="uni app-lajitong"></i></div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>

        </div>
    </form>
    <button class="btn btn-primary" type="submit" onclick="optionSave()">保存</button>
</div>
<style>
    .filter .filter1{width: 40%;margin: 5px 2%;}
    .filter .filter11{width: 10%;margin: 5px 2%;}
    .filter .filter2{width: 20%;margin: 5px 2%;}
    .filter .filter3{display: flex;align-items: center;cursor: pointer;}
    .filter .filter3:hover{color: red;}
    .fileUpload,.fileUpload_text{display: none;}
    .imglist{border:1px solid #ddd;width: 32px;height: 32px;display: flex;align-items: center;justify-content: center;cursor: pointer;}
    .imglist img{width: 100%;height: 100%;}
</style>
<script>
    var option_form = '#option_form'
    function optionSave() {
        let formData = new FormData();
        $(option_form).find('input,select').each(function(){
            if($(this).attr('type')!='file'){
                formData.append($(this).attr('name'), $(this).val());
            }else{
                formData.append($(this).attr('name'), $(this)[0].files[0]);
            }
        });
        let url = $(option_form).attr("action");
        $.ajax({
            url,
            type:"post",
            data:formData,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(res){
                alert_msg(res)
                if(!res.code && res.data.redirect) {
                    iload(res.data.redirect);
                }
            }
        })
    }

    function filter_addDiv() {
        let id = randomId(8);
        let html = `<li class="d-flex" data-id="${id}">
                        <div class="filter1"><input type="text" name="value[${id}][name]"></div>
                        <div class="filter11">
                            <label>
                                <input type="file" class="fileUpload" accept="image/gif,image/jpeg,image/jpg,image/png"  name="value[${id}][image]" >
                                <div class="imglist">+</div>
                            </label>
                        </div>
                        <div class="filter2"><input type="number" name="value[${id}][sort]" value="0"></div>
                        <div class="filter3" onclick="filter_delDiv(this)"><i class="uni app-lajitong"></i></div>
                    </li>`;
        $('.add_div ul').append(html);
    }
    function filter_delDiv(_this) {
        $(_this).parent().remove()
    }
    $(function () {
        $(option_form).on('change',".fileUpload",function (e) {
            e.stopPropagation();
            let img_html = ''
            let img_obj = $(this)[0];
            for (let i = 0; i < img_obj.files.length; i++) {
                let src = URL.createObjectURL(img_obj.files[i]);
                img_html += `<img data-file_id="i" src="${src}">`
            }
            $(this).next().html(img_html);
        })
        $(option_form).on('click',".fileUpload_text",function (e) {
            e.stopPropagation()
            let p = $(this).parent();
            let img_html = `<input type="file" class="fileUpload" accept="image/gif,image/jpeg,image/jpg,image/png"  name="value[${p.data('id')}][image]" >
                                                <div class="imglist">+</div>`
            p.html(img_html);
        })
        $('#type').change(function () {
            let val = $(this).val()
            if(val=='select' || val=='radio' || val=='checkbox'){
                $('.option_op').show();
            }else{
                $('.option_op').hide();
            }
        })
    })

</script>
