@include('laravel-common::mail.header')
    <div style="font-size: 28px;line-height: 40px;margin-bottom: 10px;">
        Service Refusal
    </div>
    <div style="margin-bottom: 10px;">Our service #{{$service->id}}</div>

    <div>
        {{$serviceHistory->comment??'Your request has been rejected'}}
    </div>

@include('laravel-common::mail.footer')
