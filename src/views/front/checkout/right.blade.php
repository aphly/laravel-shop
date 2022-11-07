<div>
    <div class="items-info-list">
        @foreach($res['list'] as $val)
            <div class="items-info ">
                <div class="items-img" style="width: 120px;">
                    <img src="{{\Aphly\LaravelShop\Models\Catalog\ProductImage::render($val['product']['image'])}}"
                         alt="" aria-hidden="true" style="max-width: 100%;">
                </div>
                <div class="items-lists">
                    <ul>
                        <li>
                            <span><strong>{{$val['product']['name']}}</strong></span>
                        </li>
                        <li>
                            <span>price: </span>
                            <span>{{$val['price_format']}}</span>
                        </li>
                        <li>
                            <span>qty: </span>
                            <span>{{$val['quantity']}}</span>
                        </li>
                        <li>
                            <span>subtotal: </span>
                            <span>{{$val['total_format']}}</span>
                        </li>
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
    <div id="checkout-total">
        <div class="items-price">
            @if(isset($res['total_data']['totals']))
                <ul>
                    @foreach($res['total_data']['totals'] as $val)
                        <li class="order-list">
                            <p>
                                <span class="sub-total subtotal-subtotal">{{$val['title']}}:</span>
                                <span class="items-right prices price-symbol">{{$val['value_format']}}</span>
                            </p>
                        </li>
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
