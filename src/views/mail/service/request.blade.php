@include('laravel-common::mail.header')
    <div style="font-size: 28px;line-height: 40px;margin-bottom: 10px;">
        Service Request
    </div>
    <div style="margin-bottom: 10px;">From {{$service->order->email}}</div>

    <div class="detail">
        <ul class="service_detail">
            <li><div>ID:</div><div>{{$service->id}}</div></li>
            <li><div>Date Added:</div><div>{{$service->created_at}}</div></li>
            <li><div>Reason:</div><div>{{$service->reason}}</div></li>
            @if($service->service_action_id==1)
                <li><div>Refund Amount ({{$service->refund_fee}}% fee):</div><div>{{$service->refund_amount_format}}</div></li>
            @elseif($service->service_action_id==2)
                @if($service->refund_amount)
                    <li><div>Actual refund:</div><div>{{$service->refund_amount_format}}</div></li>
                @else
                    <li><div>Maximum refund amount:</div><div>{{$service->amount_format}}</div></li>
                @endif
            @endif
            @if($service->service_action_id==2)
                @if($service->service_status_id>=3)
                    <li><div>Name </div><div>{{$service->service_name}}</div></li>
                    <li><div>Address </div><div>{{$service->service_address}}</div></li>
                    <li><div>Postcode </div><div>{{$service->service_postcode}}</div></li>
                    <li><div>Phone </div><div>{{$service->service_phone}}</div></li>
                @endif
                @if($service->service_status_id>=4)
                    <li><div>Express delivery name </div><div>{{$service->c_shipping}}</div></li>
                    <li><div>Tracking number </div><div>{{$service->c_shipping_no}}</div></li>
                @endif
            @endif
        </ul>
        @if($service->img->count())
            <ul class="service_upload" style="margin-top: 10px;">
                @foreach($service->img as $val)
                    <li>
                        <img src="{{$val->image_src}}" alt="" style="width: 100px;height: 100px;">
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

@include('laravel-common::mail.footer')
