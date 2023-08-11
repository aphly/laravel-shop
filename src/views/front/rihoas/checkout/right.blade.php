<style>
.items-img{position: relative}
.items-lists .title{font-weight: 500;line-height: 25px;height: 25px;}
.items-qty{position:absolute;right:-5px;width:20px;height:20px;background:#999;color:#fff;border-radius:50%;text-align:center;top:-5px;font-size:12px;line-height:20px}
</style>
<div class="items-info-list-all">
    <div class="items-info-list">
        @foreach($res['list'] as $val)
            <div class="items-info ">
                <div class="items-img">
                    <a href="/product/{{$val['product']['id']}}"><img src="{{$val['product']['image_src']}}" ></a>
                    <div class="items-qty">{{$val['quantity']}}</div>
                </div>
                <div class="items-lists">
                    <a href="/product/{{$val['product']['id']}}">
                        <ul>
                            <li class="title wenzi">
                                {{$val['product']['name']}}
                            </li>
                            <li class="option_name_str wenzi">
                                @if($val['option_value_str'])
                                {{$val['option_value_str']}}
                                @endif
                            </li>
                            <li class="price_qty">
                                <span>Price: {{$val['price_format']}}</span>
                            </li>
                        </ul>
                    </a>
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
