@include('laravel-shop::mail.header')

    <div style="padding: 10px">
        <div style="margin-top: 10px;font-size: 20px;margin-bottom: 20px;">Dear Customer,</div>
        <div style="margin-bottom: 10px;">Thank you for your payment for Order #{{$order->id}}.</div>

        <div style="margin-bottom: 10px;">This email is to confirm that we have successfully received your order and payment.</div>
        <div style="margin-bottom: 10px;">Please review the details below to ensure they are correct.</div>
        <div style="margin-bottom: 10px;">We will send you a shipping confirmation email once your order has been dispatched.</div>
    </div>

    <div style="margin-bottom: 10px;padding: 10px;font-size: 12px;background: #f9f9f9;;border-radius: 10px;">
        <div class="detail">
            <ul class="order_info" style="padding-left: 0;">
                <li style=" display: flex;justify-content: space-between;margin-bottom: 5px;">
                    <div style="width: 46%;flex-shrink: 0;color: #666;">Order ID:</div><div>{{$order->id}}</div>
                </li>
                <li style=" display: flex;justify-content: space-between;margin-bottom: 5px;">
                    <div style="width: 46%;flex-shrink: 0;color: #666;">Date Added:</div><div>{{$order->created_at->timezone('America/New_York')->format('Y-m-d h:i A (ET)')}}</div>
                </li>
                <li style=" display: flex;justify-content: space-between;margin-bottom: 5px;">
                    <div style="width: 46%;flex-shrink: 0;color: #666;">Payment Method:</div>
                    <div>{{$order->payment_method_name}}</div>
                </li>
                <li style=" display: flex;justify-content: space-between;margin-bottom: 5px;">
                    <div style="width: 46%;flex-shrink: 0;color: #666;">Delivery Address:</div>
                    <div>{{$order->delivery_firstname}} {{$order->delivery_lastname}},
                        {{$order->delivery_address_1}} {{$order->delivery_address_2}},
                        {{$order->delivery_city}}, {{$order->delivery_zone}}, {{$order->delivery_country}},
                        {{$order->delivery_postcode}}, {{$order->delivery_telephone}}
                    </div>
                </li>
            </ul>
        </div>
        <ul class="order_product" style="padding-left: 0;">
            @foreach($order->orderProduct as $val)
                <li style="display: flex;justify-content: space-around;">
                    <div style="">
                        <a href="{{url('/product/'.$val->product_id)}}"><img style="width: 66px;height: 66px; margin-right: 10px;" src="{{$val->image}}" alt=""></a>
                    </div>
                    <div style="margin-left: 10px;margin-right:auto;">
                        <a href="{{url('/product/'.$val->product_id)}}">
                            <div class="order_product21 wenzi">{{$val->name}}</div>
                        </a>
                        @if($val->orderOption)
                            <ul style="display: flex;align-items: center;flex-wrap: wrap; width: 100%; color: #999;padding:0;">
                                @foreach($val->orderOption as $v)
                                    <li style="width: 100%;margin-bottom: 0;list-style: none;">{{$v->name}} : {{$v->value}}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div  style="width: 60px;color: #999;text-align: right;">
                        <div class="order_product23">{{$val->price_format}}</div>
                        <div class="order_product24">×{{$val->quantity}}</div>
                    </div>
                </li>
            @endforeach
        </ul>
        <div>
            @if($order->orderTotal)
                <ul class="order_total" style="padding-left: 0;">
                    @foreach($order->orderTotal as $val)
                        <li style="display: flex;justify-content: space-between;margin-bottom: 5px;">
                            <div>{{$val->title}}</div>
                            <div>{{$val->value_format}}</div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@include('laravel-shop::mail.footer')
