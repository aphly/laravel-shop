@include('laravel-shop::mail.header')
<div>
    <div style="font-weight: 600;font-size: 22px;">Aphly Account Password</div>
    <div style="padding:20px 0;">
        <div style="margin-top: 10px;">Hi {{$email}}</div>
        <div style="margin-top: 20px;">
            Your Aphly account password: {{$password}}
        </div>
    </div>
</div>
@include('laravel-shop::mail.footer')
