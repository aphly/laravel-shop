@include('laravel-common::mail.header')
    <div style="font-size: 28px;line-height: 40px;margin-bottom: 10px;">
        Order Refunded
    </div>
    <div style="padding: 10px;">
        <div style="margin-bottom: 10px;">Our Order #{{$order->id}}</div>
        <div style="margin-bottom: 10px;">
            We are very sorry, but due to the current shortage of goods, we are unable to ship. We will cancel the order and issue a refund.
        </div>

        @if($order->refund_fee)
            <div style="margin-bottom: 5px;">
                The order has been successfully refunded.
                This transaction deducts a {{$order->refund_fee}}% transaction tax, and the final refund amount is {{$order->refund_amount}}
            </div>
        @endif
        <div style="margin-bottom: 5px;">
            Please check if you have received the refund within 48 hours. If not, please contact customer service
        </div>
    </div>

    <div style="margin-bottom: 10px;font-size: 12px;padding: 10px;background: #f9f9f9;border-radius: 10px;">
        <div class="detail">
            <ul class="order_info" style="padding-left: 0;">
                <li style=" display: flex;justify-content: space-between;margin-bottom: 5px;">
                    <div style="width: 46%;flex-shrink: 0;color: #666;">Order ID:</div><div>{{$order->id}}</div>
                </li>
                <li style=" display: flex;justify-content: space-between;margin-bottom: 5px;">
                    <div style="width: 46%;flex-shrink: 0;color: #666;">Date Added:</div><div>{{$order->created_at}}</div>
                </li>
                <li style=" display: flex;justify-content: space-between;margin-bottom: 5px;">
                    <div style="width: 46%;flex-shrink: 0;color: #666;">Payment Method:</div>
                    <div>{{$order->payment_method_name}}</div>
                </li>
                <li style=" display: flex;justify-content: space-between;margin-bottom: 5px;">
                    <div style="width: 46%;flex-shrink: 0;color: #666;">Shipping Address:</div>
                    <div>{{$order->address_firstname}} {{$order->address_lastname}},
                        {{$order->address_address_1}} {{$order->address_address_2}},
                        {{$order->address_city}}, {{$order->address_zone}}, {{$order->address_country}},
                        {{$order->address_postcode}}, {{$order->address_telephone}}
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
@include('laravel-common::mail.footer')
