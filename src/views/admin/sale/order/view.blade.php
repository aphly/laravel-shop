
<div class="top-bar">
    <h5 class="nav-title">order</h5>
</div>
<div class="imain">
    <div>
        <div class="detail">
            <div class="title">The order details</div>
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
                <li><div>Shipping Tracking:</div><div>{{$res['info']->tracking??'-'}}</div></li>
            </ul>
        </div>
        <div class="detail">
            <div class="title">The order product</div>
            <ul class="product">
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
                                <a style="display: flex;" href="/product/{{$val->product_id}}">
                                    <img src="{{$val->image}}">
                                    <div style="display: flex;align-items: center;">
                                        <div>
                                            <div class="product_title wenzi">{{$val->name}}</div>
                                            @if($val->orderOption)
                                                <ul class="option">
                                                    @foreach($val->orderOption as $v)
                                                        <li>{{$v->name}} : {{$v->value}}</li>
                                                    @endforeach
                                                </ul>
                                        </div>
                                        @endif
                                    </div>
                                </a>
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
                    <ul class="total_data">
                        @foreach($res['info']->orderTotal as $val)
                            <li><div></div><div></div><div>{{$val->title}}</div><div>{{$val->value_format}}</div></li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>


</div>
<style>

</style>
<script>

</script>
