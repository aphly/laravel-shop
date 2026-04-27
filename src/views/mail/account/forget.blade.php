@include('laravel-shop::mail.header')
<div>
    <div style="padding:20px 0;">
        <div style="margin-top: 10px;font-size: 20px;margin-bottom: 20px;">Dear Customer,</div>
        <div style="margin-top: 20px;">
            <a href="{{$userAuth->siteUrl}}/account/forget-password/{{$userAuth->token}}" style="display: inline-block;padding: 10px 20px;
                    background: #089b0e;color: #ffff;text-decoration: none; border-radius: 4px;">Reset Password</a>
        </div>
        <div style="margin-top: 20px;">
            We have received your password reset request.
        </div>
        <div style="margin-top: 10px;">If you did not make this request or no longer wish to reset your password, please simply ignore this email.</div>
    </div>

</div>
@include('laravel-shop::mail.footer')
