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
            <div class="title">The After Sales details</div>
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
                        <li><div>id:</div><div>{{$res['info']->id}}</div></li>
                        <li><div>订单id:</div><div>{{$res['info']->order->id}}</div></li>
                        <li><div>邮箱:</div><div>{{$res['info']->order->email}}</div></li>
                        <li><div>用户uid:</div><div>{{$res['info']->uid}}</div></li>
                        <li><div>申请时间:</div><div>{{$res['info']->created_at->timezone('Asia/Shanghai')}}</div></li>
                        <li><div>是否收到货:</div><div>{{$dict['yes_no'][$res['info']->is_received]}}</div></li>
                        <li><div>是否打开:</div><div>{{$dict['yes_no'][$res['info']->is_opened]}}</div></li>
                    </ul>
                </div>
                @if($res['info']->img->count())
                    <div class="ititle" style="margin-top: 10px;">图片</div>
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

        <div class="detail">
            <div class="title">状态记录</div>
            <div class="detail_info">
                <ul>
                    <li>
                        <div>日期</div>
                        <div>内容</div>
                    </li>
                    @if($res['serviceHistory'])
                        @foreach($res['serviceHistory'] as $val)
                            <li>
                                <div>{{$val->created_at->timezone('Asia/Shanghai')}}</div>
                                <div>{{$val->content}}</div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>

        <div class="detail">
            <div class="title">添加状态记录</div>
            <div class="detail_info">
                <form method="post" action="/shop_admin/after_sales/history_save" class="save_form">
                    @csrf
                    <div>
                        <input type="hidden" name="after_sales_id" value="{{$res['info']->id}}">
                        <div class="form-group">
                            <label >售后状态</label>
                            <select name="status"  class="form-control " required>
                                @if(isset($dict['after_sales_status']))
                                    @foreach($dict['after_sales_status'] as $key=>$val)
                                        <option value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label >内容</label>
                            <textarea class="form-control" name="content"></textarea>
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

    })
</script>
