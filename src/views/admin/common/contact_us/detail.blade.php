
<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<div class="imain">

    <div class="">
        <div class="form-group">
            <label for="">uuid</label>
            <input type="text"  readonly class="form-control " value="{{$res['info']->uuid}}">
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group">
            <label for="">Email</label>
            <input type="text"  readonly class="form-control " value="{{$res['info']->email}}">
            <div class="invalid-feedback"></div>
        </div>

        <div class="form-group " >
            <label for="">内容</label>
            <textarea  readonly class="form-control ">{{$res['info']->content}}</textarea>
            <div class="invalid-feedback"></div>
        </div>
        <div class="form-group d-none" >
            <label for="">时间</label>
            <input type="text"  readonly class="form-control " value="{{$res['info']->created_at}}">
            <div class="invalid-feedback"></div>
        </div>
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
                <label for="">标题</label>
                <input type="text" name="title"  class="form-control " value="">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group " >
                <label for="">内容</label>
                <textarea name="content"  class="form-control "></textarea>
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">发送回复</button>
        </form>
    </div>

</div>

<script>

</script>
