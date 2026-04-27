@include('laravel-shop::mail.header')
    <div style="padding: 10px">
        <div style="margin-top: 10px;font-size: 20px;margin-bottom: 20px;">Dear Customer,</div>
        <div style="margin-bottom: 10px;">Thank you for your payment for Order #{{$order->id}}.</div>

        <div style="margin-bottom: 10px;">This email is to confirm that we have successfully received your order and payment.</div>
        <div style="margin-bottom: 10px;">Please review the details below to ensure they are correct.</div>
        <div style="margin-bottom: 10px;">We will send you a shipping confirmation email once your order has been dispatched.</div>
    </div>

@include('laravel-shop::mail.footer')
