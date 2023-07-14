<style>

</style>
<div class="items-info-list-all">
    <div class="items-info-list">
        @foreach($res['list'] as $val)
            <div class="items-info ">
                <div class="items-img">
                    <img src="{{$val['product']['image_src']}}" >
                </div>
                <div class="items-lists">
                    <ul>
                        <li>
                            <strong>{{$val['product']['name']}}</strong>
                        </li>
                        <li class="option_name_str wenzi">
                            @if($val['option_value_str'])
                            {{$val['option_value_str']}}
                            @endif
                        </li>
                        <li class="price_qty">
                            <span>Price: {{$val['price_format']}}</span>
                            <span>Qty: {{$val['quantity']}}</span>
                        </li>
                    </ul>
                </div>
                <div class="items-subtotal">
                    <span>{{$val['total_format']}}</span>
                    @if($val['discount'])
                    <span class="discount">-{{$val['discount_format']}}</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    <div class="checkout-totals">
        <div class="items-price">
            @if(isset($res['total_data']['totals']))
                <ul>
                    @foreach($res['total_data']['totals'] as $key=>$val)
                        @if($key!='total')
                        <li class="order-list">
                            <span class="sub-total subtotal-subtotal">{{$val['title']}}</span>
                            <span class="items-right prices price-symbol">{{$val['value_format']}}</span>
                        </li>
                        @endif
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="items-total-price order-list">
            <span>Order Total:</span>
            <span class="items-right js-total-amount">{{$res['total_data']['total_format']}}</span>
        </div>
    </div>
</div>
