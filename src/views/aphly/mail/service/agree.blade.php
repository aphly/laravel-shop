@include(config('shop.pre').'::mail.header')
    <div style="font-size: 28px;line-height: 40px;margin-bottom: 10px;">
        Your after-sales request has been approved
    </div>
    <div style="margin-bottom: 10px;">Your service #{{$service->id}}</div>
    <div>
        {{$serviceHistory->comment??'Your after-sales request has been approved'}}
    </div>

@include(config('shop.pre').'::mail.footer')
