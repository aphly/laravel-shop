@include('laravel-shop::common.header')
<link rel="stylesheet" href="{{ URL::asset('vendor/laravel/css/login.css') }}">
<section class="login d-flex" >
    <div class="login1">
        <span>
            " 相伴十载，出发下一站 "
        </span>
    </div>
    <div class="login2">
        <form method="post" action="/forget-password/{{$res['token']}}" id="login" class="login_form">
            @csrf
            <div class="login_title">
                <span class="text-center">忘记密码</span>
            </div>

            <h3 class="" style="">
                忘记密码
                <span style="font-size:16px">
                    已有帐号?
                    <a href="/login">登录</a>
                </span>
            </h3>

            <div class="form-group">
                <input type="text" name="credential" class="form-control" placeholder="new password" value="">
                <div class="invalid-feedback"></div>
            </div>

            <div class="d-flex justify-content-between">
                <span></span>
                <sapn><a href="">忘记密码</a></sapn>
            </div>

            <div class="alert alert-warning d-none" id="msg"></div>

            <div class="login_btn">
                <button class="btn btn-primary " type="submit">提交</button>
            </div>

        </form>

        <div class="login_form">
            <div class="position-relative login_other">
                <div class="login_hr"></div>
                <div class="login_hrx">使用第三方帐号直接登录</div>
            </div>
            <hr class="login_hr">
            <p>©{{date('Y')}} - {{env('APP_URL')}}. All rights reserved.</p>
            <p>推荐使用 新版浏览器 访问本站</p>
        </div>
    </div>

</section>
<script>
$(function (){
    $("#login").submit(function (event){
        event.preventDefault()
        event.stopPropagation()
        const form = $(this)
        if(form[0].checkValidity()===false){
        }else{
            let url = form.attr("action");
            let type = form.attr("method");
            if(url && type){
                $('#login input.form-control').removeClass('is-valid').removeClass('is-invalid');
                $.ajax({
                    type,url,
                    data: form.serialize(),
                    dataType: "json",
                    success: function(res){
                        $('#login input.form-control').addClass('is-valid');
                        if(!res.code) {
                            location.href = res.data.redirect
                        }else{
                            $("#msg").text(res.msg).removeClass('d-none');
                        }
                    },
                    complete:function(XMLHttpRequest,textStatus){
                        //console.log(XMLHttpRequest,textStatus)
                    }
                })
            }else{
                console.log('no action')
            }
        }

    })
});
</script>
@include('laravel-shop::common.footer')
