@include('laravel-blog::mail.header')
    <div style="font-size: 28px;line-height: 40px;margin-bottom: 10px;">
        Service Agree
    </div>
    <div style="margin-bottom: 10px;">Our service #{{$service->id}}</div>
    <div>
        {{$serviceHistory->comment??'Your request has been approved'}}
    </div>

@include('laravel-blog::mail.footer')
