@include('laravel-shop::common.header')
<div class="container">
    <div class="top-bar">
        <h5 class="nav-title">首页</h5>
    </div>
    <div class="d-flex">
        @include('laravel-shop::account.leftmenu')
        <div>
            你好
            @if(session('user'))
                {{session('user')['nickname']}}

                <a href="/logout">注销</a>

                {{session('user')['identifier']??''}}
                {{session('user')['identity_type']??''}}
                <a href="/email/verify">校验邮箱</a>
            @endif
        </div>

    </div>
</div>

@include('laravel-shop::common.footer')
