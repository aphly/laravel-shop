<style>
    .checkout{display: flex;flex-wrap: wrap;}
    .checkout_l{width: 60%;margin-right: 20px;background-color: #fff;border-radius: 4px;padding: 20px;}
    .checkout_r{width: calc(40% - 20px);}

    .items-info-list-all{padding: 20px;}
    .items-info-list{}
    .items-info-list .items-info{display:flex;margin-bottom: 10px;}
    .items-info-list .items-info .items-img{width: 70px;height: 70px;display: flex;align-items: center;justify-content: center;}
    .items-info-list .items-info .items-img img{max-width: 100%;max-height: 100%;border-radius: 4px;}
    .option_name_str{color: #999;}
    .items-subtotal{width: 60px;display: flex;align-items: center;justify-content: flex-end;font-weight: 600}
    .items-lists{width: calc(100% - 160px);margin: 0 10px;}
    .checkout-totals{border-top: 1px solid #ddd;padding: 20px 0;}
    .order-list{display: flex;justify-content: space-between;margin-bottom: 10px;}
    .items-total-price{padding-top: 20px;border-top: 1px solid #ddd;font-size: 18px;}
    .items-price{padding-bottom: 10px;}
    .order-list .items-right{font-weight: 600;}
    .items-info-list{padding: 20px 0;}
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
                        @if($val['option_name_str'])
                            <li class="option_name_str">
                                {{$val['option_name_str']}}
                            </li>
                        @endif
                        <li>
                            <span>qty: {{$val['quantity']}}</span>
                            <span>price: {{$val['price_format']}}</span>
                        </li>
                    </ul>
                </div>
                <div class="items-subtotal">
                    <span>{{$val['total_format']}}</span>
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
