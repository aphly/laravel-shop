
<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<div class="imain">

    <div class="">

        <div class="form-group">
            <label >uid</label>
            <input type="text"  readonly class="form-control " value="{{$res['info']->uid}}">
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group">
            <label >Email</label>
            <input type="text"  readonly class="form-control " value="{{$res['info']->email}}">
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group " >
            <label >内容</label>
            <textarea  readonly class="form-control " style="height: 200px;">{{$res['info']->content}}</textarea>
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group d-none" >
            <label >时间</label>
            <input type="text"  readonly class="form-control " value="{{$res['info']->created_at}}">
            <div class="invalid-feedback"></div>
        </div>
        <form method="post" action="/shop_admin/contact_us/del" class="del_form" data-confirm="true">
            @csrf
            <input style="display: none" type="checkbox" class="delete_box" name="delete[]" checked value="{{$res['info']->id}}">
            <button class="badge badge-danger del" type="submit">删除</button>
        </form>
    </div>

    <div>
        <div style="margin-top: 20px;margin-bottom: 10px;">
            邮件回复
        </div>
        <form method="post" action="/shop_admin/contact_us/reply" class="save_form" data-confirm="true">
            @csrf
            <input type="hidden" name="email" class="form-control " value="{{$res['info']->email}}">
            <input type="hidden" name="id" class="form-control " value="{{$res['info']->id}}">
            <div class="form-group">
                <label >标题</label>
                <input type="text" name="title"  class="form-control " value="">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group " >
                <label >内容</label>
                <textarea name="content"  class="form-control "></textarea>
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">发送回复</button>
        </form>
    </div>

</div>

<script>

</script>
