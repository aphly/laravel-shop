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
    .info{margin-bottom: 10px;}
    .info .ititle{font-weight: 600;margin-bottom: 5px;}
    .detail_info{padding: 0 10px;}
</style>
<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<div class="imain">
    <div class="order">
        <div class="detail">
            <div class="title">The service details</div>
            <ul class="product" style="padding: 0 10px;margin-bottom: 10px;">
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
            <div class="detail_info">
                <div class="info">
                    <div class="ititle">详情</div>
                    <ul>
                        <li><div>类型:</div><div>{{$dict['service_action'][$res['info']->service_action_id]}}</div></li>
                        <li><div>id:</div><div>{{$res['info']->id}}</div></li>
                        <li><div>订单id:</div><div>{{$res['info']->order->id}}</div></li>
                        <li><div>邮箱:</div><div>{{$res['info']->order->email}}</div></li>
                        <li><div>用户uuid:</div><div>{{$res['info']->uuid}}</div></li>
                        <li><div>申请时间:</div><div>{{$res['info']->created_at}}</div></li>
                        <li><div>是否收到货:</div><div>{{$dict['yes_no'][$res['info']->is_received]}}</div></li>
                        <li><div>是否打开:</div><div>{{$dict['yes_no'][$res['info']->is_opened]}}</div></li>
                        <li><div>退款总额:</div><div>{{$res['info']->amount_format}}</div></li>
                        <li><div>退款金额(扣除{{$res['info']->refund_fee}}%手续费后):</div><div>{{$res['info']->refund_amount_format}}</div></li>
                        <li><div>原因:</div><div>{{$res['info']->reason}}</div></li>
                    </ul>
                </div>
                @if($res['info']->img->count())
                    <div class="ititle" style="margin-top: 10px;">Images</div>
                    <ul class="service_upload">
                        @foreach($res['info']->img as $val)
                            <li>
                                <img src="{{$val->image_src}}" alt="" style="width: 100px;height: 100px;">
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        @if($res['serviceProduct']->count())
        <div class="detail">
            <div class="title">The return product</div>
            <div class="detail_info">
                <ul class="product">
                    <li>
                        <div>商品名称</div>
                        <div>数量</div>
                        <div>价格</div>
                    </li>
                    @foreach($res['serviceProduct'] as $val)
                        <li>
                            <div style="display: flex;">
                                <img src="{{$val->orderProduct->image}}">
                                <div style="display: flex;align-items: center;">
                                    <div>
                                        <div class="product_title wenzi">{{$val->orderProduct->name}}</div>
                                        @if($val->orderOption)
                                            <ul class="option">
                                                @foreach($val->orderOption as $v)
                                                    <li>{{$v->name}} : {{$v->value}}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div>{{$val->quantity}}</div>
                            <div>{{$val->total_format}}</div>
                        </li>
                    @endforeach
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
        @endif
        <div class="detail">
            <div class="title">状态记录</div>
            <div class="detail_info">
                <ul>
                    <li>
                        <div>Action</div>
                        <div>日期</div>
                        <div>状态</div>
                        <div>备注</div>
                    </li>
                    @if($res['serviceHistory'])
                        @foreach($res['serviceHistory'] as $val)
                            <li>
                                <div>{{$dict['service_action'][$val->service_action_id]}}</div>
                                <div>{{$val->created_at}}</div>
                                <div>{{$dict[$dict['service_action'][$val->service_action_id].'_status'][$val->service_status_id]}}</div>
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
                <form method="post" action="/shop_admin/service/history_save" class="save_form">
                    @csrf
                    <div>
                        <input type="hidden" name="service_id" value="{{$res['info']->id}}">
                        <div class="form-group">
                            <label for="">售后状态</label>
                            <select name="service_status_id" id="service_status_id{{$res['info']->service_action_id}}" class="form-control " required>
                                @if($res['info']->service_action_id==1)
                                    @foreach($dict['refund_status'] as $key=>$val)
                                        <option value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                @elseif($res['info']->service_action_id==2)
                                    @foreach($dict['return_status'] as $key=>$val)
                                        <option value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                @elseif($res['info']->service_action_id==3)
                                    @foreach($dict['exchange_status'] as $key=>$val)
                                        <option value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="">状态覆盖</label>
                            <input type="checkbox" name="override" value="1">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="">邮件通知</label>
                            <input type="checkbox" name="notify" value="1">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="">备注</label>
                            <textarea class="form-control" name="comment"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>
                        @if($res['info']->service_action_id==2)
                            <div id="shipping_info" style="display: none;">
                                <div class="form-group">
                                    <label for="">退货人姓名</label>
                                    <input type="text" name="service_name" class="form-control" value="{{$res['info']->service_name??$res['shop_setting']['service_name']}}">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label for="">退货人地址</label>
                                    <input type="text" name="service_address" class="form-control" value="{{$res['info']->service_address??$res['shop_setting']['service_address']}}">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label for="">退货人邮编</label>
                                    <input type="text" name="service_postcode" class="form-control" value="{{$res['info']->service_postcode??$res['shop_setting']['service_postcode']}}">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <label for="">退货人电话</label>
                                    <input type="text" name="service_phone" class="form-control" value="{{$res['info']->service_phone??$res['shop_setting']['service_phone']}}">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="form-group" id="fee" style="display: none;">
                                <label for="">退货的手续费（%）；当手续费设置为100，代表不退款</label>
                                <input type="number" name="fee" class="form-control" value="5">
                                <div class="invalid-feedback"></div>
                            </div>
                        @endif
                        <div>状态必须为complete 才能进行退款操作</div>
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
        @if($res['info']->service_action_id==2)
        $('#service_status_id2').change(function () {
            let shipping = $('#shipping_info');
            shipping.hide();
            if($(this).val()==3){
                shipping.show();
            }
            let fee = $('#fee');
            fee.hide();
            if($(this).val()==6){
                fee.show();
            }
        })
        @endif
    })
</script>
