@include('laravel-common::mail.header')
    <div style="font-size: 28px;line-height: 40px;margin-bottom: 10px;">
        Order Paid
    </div>
    <div style="margin-bottom: 10px;">Dear {{$order->email}}</div>
    <div style="margin-bottom: 10px;">
        <div>Thank you for your payment for orders xxxxxxx.</div>
        <div>We will be dispatching these items within the next 3 days.</div>
    </div>
@include('laravel-common::mail.footer')
