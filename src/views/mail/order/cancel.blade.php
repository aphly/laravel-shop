@include('laravel-common::mail.header')
    <div style="font-size: 28px;line-height: 40px;margin-bottom: 10px;">
        Order Cancel
    </div>

    <div style="margin-bottom: 10px;">Hello {{$order->email}}</div>

    <div>
        You have canceled the order. Welcome to purchase next time.
    </div>

@include('laravel-common::mail.footer')