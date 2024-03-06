@include('laravel-blog::mail.header')
    <div style="font-size: 28px;line-height: 40px;margin-bottom: 10px;">
        Service Awaiting
    </div>
    <div style="margin-bottom: 10px;">Service #{{$service->id}}</div>

    <div>
        The product has been shipped.
    </div>

@include('laravel-blog::mail.footer')
