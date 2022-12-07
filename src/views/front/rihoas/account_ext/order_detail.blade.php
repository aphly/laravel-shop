@include('laravel-shop-front::common.header')
<section class="container">
    <style>

    </style>
    <div class="account_info">
        @include('laravel-common-front::account_ext.left_menu')
        <div class="account-main-section">
            <div class="">
                <div class="top-desc d-flex justify-content-between">
                    <h2>ORDER INFORMATION</h2>
                </div>
                <div>
                    <div>The shipping details</div>
                    <ul>
                        <li>
                            <div>Date Added</div>
                            <div>Order Status</div>
                            <div>Notes</div>
                        </li>
                        @if($res['orderHistory'])
                            @foreach($res['orderHistory'] as $val)
                                <li>
                                    <div>{{$val->created_at}}</div>
                                    <div>{{$val->orderStatus->name}}</div>
                                    <div>{{$val->comment}}</div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
                <div>
                    <div>The order details</div>
                    <ul>
                        <li><div>Order ID:</div><div>{{$res['info']->id}}</div></li>
                        <li><div>Date Added:</div><div>{{$res['info']->created_at}}</div></li>
                        <li><div>Payment Method:</div><div>{{$res['info']->payment_method_name}}</div></li>
                        <li><div>Shipping Method:</div><div>{{$res['info']->shipping_name}}</div></li>
                        <li><div>Shipping Address:</div><div>{{$res['info']->address_firstname}} {{$res['info']->address_lastname}},
                                {{$res['info']->address_address_1}} {{$res['info']->address_address_2}},
                                {{$res['info']->address_city}}, {{$res['info']->address_zone}}, {{$res['info']->address_country}},
                                {{$res['info']->address_postcode}}, {{$res['info']->address_telephone}}
                            </div></li>

                    </ul>
                </div>
                <div>
                    <div>The order product</div>
                    <ul>
                        <li>
                            <div>Product Name</div>
                            <div>Quantity</div>
                            <div>Price</div>
                            <div>Total</div>
                        </li>
                        @if($res['orderProduct'])
                            @foreach($res['orderProduct'] as $val)
                                <li>
                                    <div>
                                        <img src="{{$val->image}}" style="width: 100px;height: 100px;">
                                        {{$val->name}}
                                    </div>
                                    <div>{{$val->quantity}}</div>
                                    <div>{{$val->price_format}}</div>
                                    <div>{{$val->total_format}}</div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                    <div>
                        @if($res['info']->orderTotal)
                        <ul>
                            @foreach($res['info']->orderTotal as $val)
                            <li><div>{{$val->title}}</div><div>{{$val->value_format}}</div></li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
$(function () {

})
</script>
@include('laravel-shop-front::common.footer')
