@include('laravel-shop::front.common.header')
<style>
    .gs-reg-form{margin-top: 70px;width: 49%;box-sizing: border-box;}
    .gs-reg-form .form-control{height: 50px;font-size: 16px;}
    .gs-form-block{font-size: 16px;font-weight: bold;}
    .gs-reg-form-p .s_hr{width: 1px;background: #dadada;height: 600px;margin-top: 100px;}
    .gs-reg-form-p .descrip{font-size: 16px;margin-bottom: 20px;}
    .togglePassword{position:absolute;right:0;top:0;width:45px;height:100%;padding-right:25px;cursor: pointer;}
    .loginBtn,.createBtn{font-weight:600;width:100%;color:#ffffff;background:#04A5C2;border-radius:10px;height:50px;margin-top:20px;font-size:16px}

    .split-line{margin-bottom:0;font-size:16px;margin-top:20px}
    .split-line{display:flex;justify-content:space-between;flex-wrap:nowrap;align-items:center;margin-bottom:18px;}
    .signInWith {font-size: 18px;}
</style>
<div class="container">
    <div class="d-flex justify-content-between gs-reg-form-p">
        <form class="gs-reg-form form-horizontal" style="padding-right: 80px;" id="login" novalidate="novalidate" method="post" action="/login">
            @csrf
            <div class="row loginContent">
                <div class="col-12 text-center" style="margin-bottom: 24px;">
                    <h1 class="title d-none d-lg-block">Sign In</h1>
                    <span class="descrip">Sign in with email</span>
                </div>
                <div class="col-12 gs-form-block mt-4">
                    <label>Email</label>
                    <div class="form-row">
                        <div class="form-group col-12">
                            <input type="email" name="identifier" class="form-control" value="" autocomplete="off" placeholder="you@example.com">
                        </div>
                    </div>
                    <label>Password</label>
                    <div class="form-row">
                        <div class="form-group col-12">
                            <input type="password" name="credential" class="form-control" value="" autocomplete="off" placeholder="Enter 6 characters or more">
                            <img src="{{ URL::asset('vendor/laravel-shop/img/home/defaut.svg') }}"
                                 data-src1="{{ URL::asset('vendor/laravel-shop/img/home/defaut.svg') }}"
                                 data-src2="{{ URL::asset('vendor/laravel-shop/img/home/check.svg') }}"
                                 class="default togglePassword">
                        </div>
                    </div>
                    <div class="col-12 forgotLink" style="margin-bottom: 14px;">
                        <a href="/customer/forgot_password" class="color-link-defaut">
                            <span>Forgot your password?</span>
                        </a>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn loginBtn">
                            Login
                        </button>
                    </div>
                </div>
                <div class="split-line col-12">
                    <div class="xian"></div>
                    <div>Or</div>
                    <div class="xian"></div>
                </div>
                <div class="signInWith text-center col-12 mt-4">Sign in with</div>
                <div class="row col-12 sign-groupBtn">
                    <div class="col-6 facebook">
                        <a href="/login/facebook" class="btn facebookBtn">
                            <img src="acebook.svg">
                        </a>
                    </div>
                    <div class="col-6 amazon">
                        <a href="/login/google" class="btn amazonBtn">
                            <img src="google.svg">
                        </a>
                    </div>
                </div>
            </div>
        </form>
        <div class="s_hr"></div>
        <form class="gs-reg-form form-horizontal" style="padding-left: 80px;" id="register" novalidate="novalidate" method="post" action="/register">
            @csrf
            <div class="row createContent">
                <div class="col-12 text-center create-container">
                    <h1 class="title d-none d-lg-block">
                        <div class="d-inline-block position-relative">
                            Create Account
                        </div>
                    </h1>
                    <div class="descrip">
                        Please provide the following
                        <br>information to create an account
                    </div>
                </div>
                <div class="col-12 gs-form-block">
                    <div class="form-row">
                        <div class="col-lg-12 col-12">
                            <label>Email</label>
                            <div class="form-group">
                                <input type="email" name="identifier" class="form-control" value="" autocomplete="off" placeholder="you@example.com">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-lg-12 col-12">
                            <label>Password</label>
                            <div class="form-group col-12 p-0">
                                <input id="register_password" type="password" name="credential" class="form-control password" value="" autocomplete="off" placeholder="Enter 6 characters or more">
                                <img src="{{ URL::asset('vendor/laravel-shop/img/home/defaut.svg') }}"
                                     data-src1="{{ URL::asset('vendor/laravel-shop/img/home/defaut.svg') }}"
                                     data-src2="{{ URL::asset('vendor/laravel-shop/img/home/check.svg') }}"
                                     class="default togglePassword">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-lg-12 col-12">
                            <label>Confirm Password</label>
                            <div class="form-group col-12 p-0">
                                <input type="password" name="password_confirmation" class="form-control" value="" autocomplete="off" placeholder="Enter 6 characters or more">
                                <img src="{{ URL::asset('vendor/laravel-shop/img/home/defaut.svg') }}"
                                     data-src1="{{ URL::asset('vendor/laravel-shop/img/home/defaut.svg') }}"
                                     data-src2="{{ URL::asset('vendor/laravel-shop/img/home/check.svg') }}"
                                     class="default togglePassword">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 p-0">
                        <label class="checkbox_select special-check d-flex">
                            <div class="checkbox-attr">
                                <input type="checkbox" name="newsletter" value="1" id="sign" checked="checked">
                                <label for="sign" class="iconfont icon-gou"></label>
                            </div>
                            <span class="align-middle">Sign me up for the Special Deals Newsletter.</span>
                        </label>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-12 d-flex">
                            <span class="align-middle policy">
                                By creating your account, you agree to our
                                <a href="/doc/privacy" class="color-link-blue">
                                    Privacy Policy.
                                </a>
                            </span>
                        </div>
                    </div>
                    <div class="col-12 p-0">
                        <button class="btn createBtn">
                            Register
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(function (){
        $('.togglePassword').click(function () {
            if($(this).hasClass('default')){
                $(this).attr('src',$(this).data('src2'))
                $(this).removeClass('default');
                $(this).siblings().attr('type','text')
            }else{
                $(this).attr('src',$(this).data('src1'))
                $(this).addClass('default');
                $(this).siblings().attr('type','password')
            }
        })
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
                            console.log(res);
                            $('#login input.form-control').addClass('is-valid');
                            if(!res.code) {
                                location.href = res.data.redirect
                            }else if(res.code===11000){
                                for(var item in res.data){
                                    let str = ''
                                    res.data[item].forEach((elem, index)=>{
                                        str = str+elem+'<br>'
                                    })
                                    let obj = $('#login input[name="'+item+'"]');
                                    obj.removeClass('is-valid').addClass('is-invalid');
                                    obj.next('.invalid-feedback').html(str);
                                }
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
        $("#register").submit(function (event){
            event.preventDefault()
            event.stopPropagation()
            const form = $(this)
            if(form[0].checkValidity()===false){
            }else{
                let url = form.attr("action");
                let type = form.attr("method");
                if(url && type){
                    $('#register input.form-control').removeClass('is-valid').removeClass('is-invalid');
                    $.ajax({
                        type,url,
                        data: form.serialize(),
                        dataType: "json",
                        success: function(res){
                            console.log(res);
                            $('#register input.form-control').addClass('is-valid');
                            if(!res.code) {
                                location.href = res.data.redirect
                            }else if(res.code===11000){
                                for(var item in res.data){
                                    let str = ''
                                    res.data[item].forEach((elem, index)=>{
                                        str = str+elem+'<br>'
                                    })
                                    let obj = $('#login input[name="'+item+'"]');
                                    obj.removeClass('is-valid').addClass('is-invalid');
                                    obj.next('.invalid-feedback').html(str);
                                }
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
@include('laravel-shop::front.common.footer')
