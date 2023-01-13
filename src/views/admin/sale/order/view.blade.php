<style>
    .order ul li{display: flex;margin-bottom: 5px;}
    .order ul li>div{flex: 1;display: flex;align-items: center;}
    .order .detail{margin-bottom: 20px;border-bottom: 1px solid #f1f1f1;padding-bottom: 20px;}
    .order .detail .title{margin-bottom: 10px;font-size: 16px;font-weight: 600;padding-left: 10px;}
    .order .detail .product{}
    .order .detail .product .option{display: flex;align-items: center;flex-wrap: wrap;width: 100%}
    .order .detail .product .option li{width: 100%;margin-bottom: 0}
    .order .detail .product img{width: 80px;height: 80px;margin-right: 10px;}
    .product_title{font-weight: 600;width: 100%;}
    .total_data li:last-child{font-weight: 600}
    .info{margin-bottom: 20px;}
    .info .ititle{font-weight: 600;margin-bottom: 5px;}
    .detail_info{padding: 0 10px;}
</style>
<div class="top-bar">
    <h5 class="nav-title">order</h5>
</div>
<div class="imain">
    <div class="order">
        <div class="detail">
            <div class="title">The order details</div>
            <div class="detail_info">
                <div class="info">
                    <div class="ititle">Info</div>
                    <ul>
                        <li><div>订单id:</div><div>{{$res['info']->id}}</div></li>
                        <li><div>邮箱:</div><div>{{$res['info']->email}}</div></li>
                        <li><div>用户uuid:</div><div>{{$res['info']->uuid}}</div></li>
                        <li><div>订单时间:</div><div>{{$res['info']->created_at}}</div></li>
                    </ul>
                </div>
                <div class="info">
                    <div class="ititle">物流</div>
                    <ul>
                        <li><div>收货地址:</div><div>{{$res['info']->address_firstname}} {{$res['info']->address_lastname}},
                                {{$res['info']->address_address_1}} {{$res['info']->address_address_2}},
                                {{$res['info']->address_city}}, {{$res['info']->address_zone}}, {{$res['info']->address_country}},
                                {{$res['info']->address_postcode}}, {{$res['info']->address_telephone}}
                            </div></li>
                        <li><div>物流方式:</div><div>{{$res['info']->shipping_name}}</div></li>
                        <li><div>物流单号:</div><div>{{$res['info']->shipping_no??'-'}}</div></li>
                    </ul>
                </div>
                <div class="info">
                    <div class="ititle">支付</div>
                    <ul>
                        <li><div>支付方式:</div><div>{{$res['info']->payment_method_name}}</div></li>
                        <li><div>支付流水号:</div><div>{{$res['info']->payment_id}}</div></li>
                        <li><div>货币代码:</div><div>{{$res['info']->currency_code}}</div></li>
                        <li><div>货币汇率比例:</div><div>{{$res['info']->currency_value}}</div></li>
                    </ul>
                </div>
                <div class="info">
                    <div class="ititle">客户浏览器</div>
                    <ul>
                        <li><div>IP 地址</div><div>{{$res['info']->ip}}</div></li>
                        <li><div>user_agent</div><div>{{$res['info']->user_agent}}</div></li>
                        <li><div>accept_language</div><div>{{$res['info']->accept_language}}</div></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="detail">
            <div class="title">The order product</div>
            <div class="detail_info">
                <ul class="product">
                    <li>
                        <div>商品名称</div>
                        <div>数量</div>
                        <div>价格</div>
                        <div>小计</div>
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
        <div class="detail">
            <div class="title">状态记录</div>
            <div class="detail_info">
                <ul>
                    <li>
                        <div>日期</div>
                        <div>状态</div>
                        <div>备注</div>
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
        </div>

        <div class="detail">
            <div class="title">添加状态记录</div>
            <div class="detail_info">
                <form method="post" action="/shop_admin/order/history_save" class="save_form">
                    @csrf
                    <div>
                        <input type="hidden" name="order_id" value="{{$res['info']->id}}">
                        <div class="form-group">
                            <label for="">订单状态</label>
                            <select name="order_status_id" class="form-control" id="order_status_id" required>
                                @foreach($res['orderStatus'] as $val)
                                    <option value="{{$val->id}}">{{$val->name}}({{$val->cn_name}})</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="">状态覆盖</label>
                            <input type="checkbox" name="override" value="1">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group d-none" id="shipping_no">
                            <label for="">运单</label>
                            <input type="text" name="shipping_no" class="form-control" value="">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="">备注</label>
                            <textarea class="form-control" name="comment"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        <button class="btn btn-primary" type="submit">保存</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
<style>

</style>
<script>
$(function () {
    $('#order_status_id').change(function () {
        if($(this).val()==3){
            $('#shipping_no').removeClass('d-none')
        }else{
            $('#shipping_no').addClass('d-none')
        }
    })
})
</script>
