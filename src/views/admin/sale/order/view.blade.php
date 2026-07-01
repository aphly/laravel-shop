<style>
    .detail_info ul li{display: flex;margin-bottom: 5px;}
    .detail_info ul li>div{flex: 1;display: flex;align-items: center;}
    .order .detail{margin-bottom: 20px;border-bottom: 1px solid #f1f1f1;padding-bottom: 20px;}
    .order .detail .title{margin-bottom: 10px;font-size: 16px;font-weight: 600;padding-left: 10px;}
    .order .detail .product{}
    .order .detail .product .option{display: flex;align-items: center;flex-wrap: wrap;width: 100%}
    .order .detail .product .option li{width: 100%;margin-bottom: 0}
    .order .detail .product img{width: 80px;height: 80px;margin-right: 10px;}
    .product_title{font-weight: 600;width: 100%;}
    .total_data li:last-child{font-weight: 600}
    .detail_info{padding: 0 10px;}
    .info{margin-bottom: 20px;}
    .info .ititle{font-weight: 600;margin-bottom: 5px;}
    .fw50{display: flex;flex-wrap: wrap;}
    .fw50 .info{width: 48%;margin: 1%;}
    .fw50 .info ul li{display: flex;margin-bottom: 5px;}
    .fw50 .info ul li>div{display: flex;align-items: center;}
    .fw50 .info ul li>div:first-child{flex: 1;}
    .fw50 .info ul li>div:last-child{flex: 2;}
    @media (max-width: 1199.98px) {
        .fw50 .info{width: 100%;margin: 0;}
    }
</style>
<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<div class="imain">
    <div class="order">
        @if($res['info']->order_status_id==1)
        <div><a class="badge badge-primary show_all0_btn ajax_request" data-load="/shop_admin/order/view?id={{$res['info']->id}}" data-href="/shop_admin/order/sync?order_id={{$res['info']->id}}">同步支付状态</a></div>
        @endif

        <div class="detail">
            <div class="title">订单详情</div>
            <div class="detail_info fw50">
                <div class="info">
                    <div class="ititle">基础</div>
                    <ul>
                        <li><div>订单id:</div><div>{{$res['info']->id}}</div></li>
                        <li><div>邮箱:</div><div>{{$res['info']->email}}</div></li>
                        <li><div>用户uid:</div><div>{{$res['info']->uid}}</div></li>
                        <li><div>订单时间:</div><div >{{ $res['info']->created_at->timezone('Asia/Shanghai') }}</div></li>
                    </ul>
                </div>
                <div class="info">
                    <div class="ititle">物流</div>
                    <ul>
                        <li><div>收货地址:</div><div>{{$res['info']->delivery_firstname}} {{$res['info']->delivery_lastname}},
                                {{$res['info']->delivery_address_1}} {{$res['info']->delivery_address_2}},
                                {{$res['info']->delivery_city}}, {{$res['info']->delivery_zone}}, {{$res['info']->delivery_country}},
                                {{$res['info']->delivery_postcode}}, {{$res['info']->delivery_telephone}}
                            </div></li>
                        <li><div>物流方式:</div><div>{{$res['info']->shipping_name}}</div></li>
                        <li><div>物流单号:</div><div>{{$res['info']->tracking_number??'-'}}</div></li>
                    </ul>
                </div>
                <div class="info">
                    <div class="ititle">支付</div>
                    <ul>
                        <li><div>支付方式:</div><div>{{$res['info']->payment_method_name}}</div></li>
                        <li><div>支付流水号:</div><div>{{$res['info']->payment_id}}</div></li>
                        <li><div>货币代码:</div><div>{{$res['info']->currency_code}}</div></li>
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
            <div class="title">商品信息</div>
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
            <div class="title">物流表单</div>
            <div class="detail_info">
                <form method="post" action="/shop_admin/order/save_shipping?order_id={{$res['info']->id}}" class="save_form">
                    @csrf
                    <div>
                        <div class="form-group ">
                            <label >运单号</label>
                            <a target="_blank" href="/tracking/index?order_number={{$res['orderShipping']->waybill_number}}" class="badge badge-primary">
                                {{$res['orderShipping']->waybill_number}}
                            </a>
                            <div class="invalid-feedback"></div>
                        </div>

                        @if($res['orderShipping']->waybill_number)
                            <div class="form-group ">
                                <label >面单</label>
                                <div style="display: flex;justify-content: space-between;">
                                    @if($res['orderShipping']->label_url)
                                        <a target="_blank" href="{{$res['orderShipping']->label_url}}" class="badge badge-primary">
                                            面单图片
                                        </a>
                                    @endif
                                    <a class="badge badge-primary ajax_request" data-load="/shop_admin/order/view?id={{$res['info']->id}}"
                                       data-href="/shop_admin/order/shipping_label?waybill_number={{$res['orderShipping']->waybill_number}}&order_id={{$res['info']->id}}">获取面单</a>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                        @endif

                        <div class="form-group ">
                            <label >包裹重量</label>
                            <input type="text" name="weight" class="form-control" value="{{$res['orderShipping']->weight}}">
                            <div class="invalid-feedback"></div>
                        </div>

                        <button class="btn btn-primary" type="submit">保存</button>
                    </div>
                </form>
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
                                <div >{{$val->created_at->timezone('Asia/Shanghai')}}</div>
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
                            <label >订单状态</label>
                            <select name="order_status_id" class="form-control" id="order_status_id" required>
                                @foreach($res['orderStatus'] as $val)
                                    <option value="{{$val->id}}">{{$val->name}}({{$val->cn_name}})</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label >状态覆盖</label>
                            <input type="checkbox" name="override" value="1">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label >邮件通知</label>
                            <input type="checkbox" name="notify" value="1">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group d-none" id="fee">
                            <label >退款手续费（%）；当手续费设置为100，代表不退款</label>
                            <input type="number" name="fee" class="form-control" value="5">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-group d-none" id="tracking_number">
                            <label >运单号</label>
                            <input type="text" name="tracking_number" class="form-control" value="{{$res['orderShipping']->waybill_number??''}}">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label >备注</label>
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
        if($(this).val()==='3') {
            $('#fee').addClass('d-none')
            $('#tracking_number').removeClass('d-none')
        }else if($(this).val()==='7'){
            $('#tracking_number').addClass('d-none')
            $('#fee').removeClass('d-none')
        }else{
            $('#tracking_number').addClass('d-none')
            $('#fee').addClass('d-none')
        }
    })
})
</script>
