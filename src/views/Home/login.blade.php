@include('laravel-shop::common.header')

<div class="container">
    <div class="d-flex justify-content-between">
        <form class="gs-reg-form form-horizontal" id="login" novalidate="novalidate" method="post" action="/login">
            @csrf
            <div class="row loginContent">
                <div class="col-12 text-center">
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
                            <img src="//d22qih3asjv3x0.cloudfront.net/1/static/public/statics/images/login_regist/defaut.svg" id="togglePassword" class="default">
                            <img src="//d22qih3asjv3x0.cloudfront.net/1/static/public/statics/images/login_regist/check.svg" id="togglePassword" class="default checkPassword">
                        </div>
                    </div>
                    <div class="col-12 forgotLink">
                        <a href="/customer/forgot_password" class="color-link-defaut">
                            <i>Forgot your password?</i>
                        </a>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn loginBtn">
                            Login
                        </button>
                    </div>
                </div>

                <div class="split-line col-12">
                    Or
                </div>

                <div class="signInWith text-center col-12 mt-4">Sign in with</div>
                <div class="row col-12 sign-groupBtn">
                    <div class="col-6 facebook">
                        <a href="/login/facebook" class="btn facebookBtn">
                            <img src="//d22qih3asjv3x0.cloudfront.net/1/static/public/statics/images/login/facebook.svg">
                        </a>
                    </div>
                    <div class="col-6 amazon">
                        <a href="/login/google" class="btn amazonBtn">
                            <img src="//d22qih3asjv3x0.cloudfront.net/1/static/public/statics/images/login_regist/google.svg">
                        </a>
                    </div>
                </div>
            </div>
        </form>
        <div></div>
        <form class="gs-reg-form gs-reg-form2 form-horizontal" id="register" novalidate="novalidate" method="post" action="/register">
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
                                <img src="//d22qih3asjv3x0.cloudfront.net/1/static/public/statics/images/login_regist/defaut.svg" id="togglePassword" class="default">
                                <img src="//d22qih3asjv3x0.cloudfront.net/1/static/public/statics/images/login_regist/check.svg" id="togglePassword" class="default checkPassword">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-lg-12 col-12">
                            <label>Confirm Password</label>
                            <div class="form-group col-12 p-0">
                                <input type="password" name="password_confirmation" class="form-control" value="" autocomplete="off" placeholder="Enter 6 characters or more">
                                <img src="//d22qih3asjv3x0.cloudfront.net/1/static/public/statics/images/login_regist/defaut.svg" id="togglePassword" class="default">
                                <img src="//d22qih3asjv3x0.cloudfront.net/1/static/public/statics/images/login_regist/check.svg" id="togglePassword" class="default checkPassword">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 p-0">
                        <label class="checkbox_select special-check">
                            <div class="checkbox-attr">
                                <input type="checkbox" name="newsletter" value="1" id="sign" checked="checked">
                                <label for="sign" class="iconfont icon-gou"></label>
                            </div>
                            <span class="align-middle">Sign me up for the Special Deals Newsletter.</span>
                        </label>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-12">
                            <span class="align-middle policy">
                                By creating your account, you agree to our
                                <br>
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
@include('laravel-shop::common.footer')
