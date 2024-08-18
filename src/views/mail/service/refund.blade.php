@include('laravel-shop::mail.header')
    <div style="font-size: 28px;line-height: 40px;margin-bottom: 10px;">
        The order has been refunded
    </div>
    <div style="padding: 10px;">
        <div style="margin-bottom: 10px;">Your Service #{{$service->id}}</div>

        <div style="margin-bottom: 5px;">
            The order has been refunded, and the final refund amount is {{$service->refund_amount_format}}.
        </div>
        <div style="margin-bottom: 5px;">
            Please check if you have received the refund within 48 hours. If not, please contact customer service.
        </div>

    </div>

@include('laravel-shop::mail.footer')
