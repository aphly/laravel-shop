@include('laravel-shop::mail.header')
<div>
    <div style="padding:20px 0;">
        <div style="margin-top: 10px;font-size: 20px;margin-bottom: 20px;">Dear Customer,</div>
        <div style="margin-top: 20px;">
            Your account password is: {{$password}}
        </div>
    </div>
</div>
@include('laravel-shop::mail.footer')
