@include('laravel-shop::front.common.header')
<link rel="stylesheet" href="{{ URL::asset('static/base/front/css/account.css') }}">

<div class=" container">
    <div class="account_msg">
        <p>{{$res['msg']}}</p>
    </div>
</div>


@include('laravel-shop::front.common.footer')
