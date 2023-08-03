@include('laravel-common::mail.header')
    <div style="font-size: 28px;line-height: 40px;margin-bottom: 10px;">
        Order Shipped
    </div>
    <div style="margin-bottom: 10px;">Dear {{$order->email}}</div>
    <div>
        <div>We are happy to tell you we have dispatched your order! You can track its progress with the following tracking number:xxxxxx.</div>
        <div>You can also track the delivery of your order yourself here: www.xxxxx.com.
            It usually takes about 30 days for your order arrive, but as this is the shopping season,
            the logistics companies are very busy and some orders may takes lightly longer to arrive.</div>
    </div>

@include('laravel-common::mail.footer')
