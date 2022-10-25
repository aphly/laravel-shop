@include('laravel-shop::front.common.header')
<div class="top-bar">
   <h5 class="nav-title">首页</h5>
</div>
<div>
    你好
    @if($user)
        {{$user['nickname']}}
    @endif


</div>
@include('laravel-shop::front.common.footer')
