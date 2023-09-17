@include('laravel-common::mail.header')
    <div style="font-size: 28px;line-height: 40px;margin-bottom: 10px;">
        Order Cancel
    </div>
    <div style="margin-bottom: 10px;">Our Order #{{$order->id}}</div>
    <div style="margin-bottom: 5px;">
        You have canceled the order.
    </div>
    <div style="margin-bottom: 5px;">
        The order has been successfully refunded, with a 10% handling fee deducted,
        resulting in a final refund of $20.
    </div>
    <div style="margin-bottom: 5px;">
        Welcome to purchase next time.
    </div>
    <div style="margin-bottom: 5px;">
        Please check if you have received the refund within 48 hours. If not, please contact customer service
    </div>
@include('laravel-common::mail.footer')
