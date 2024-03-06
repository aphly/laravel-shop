@include('laravel-front::mail.header')
    <div style="font-size: 28px;line-height: 40px;margin-bottom: 10px;">
        Service Refunded
    </div>
    <div style="padding: 10px;">
        <div style="margin-bottom: 10px;">Our Service #{{$service->id}}</div>

        <div style="margin-bottom: 5px;">
            We have received the product and refunded it, and the final refund amount is {{$service->refund_amount_format}}.
            The Service has been successfully refunded.
        </div>
        <div style="margin-bottom: 5px;">
            Please check if you have received the refund within 48 hours. If not, please contact customer service
        </div>
    </div>

@include('laravel-blog::mail.footer')
