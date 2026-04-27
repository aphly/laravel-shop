@include('laravel-shop::front.common.header')
<section class="container">
    <style>
        .order_product{margin-top: 10px;}
        .order_product .option{display: flex;align-items: center;flex-wrap: wrap;width: 100%}
        .order_product .option li{width: 100%;margin-bottom: 0}
        .order_product img{width: 70px;height: 70px;margin-right: 10px;}
        .product_total p{width: 100%;}
        .order_product21{font-size: 16px;}
        .order_product1{width: 80px;}
        .order_product2{width: calc(100% - 155px);margin-left: 10px;margin-right: 5px}
        .order_product3{width: 60px;color:#999;text-align: right;}
        .order_product22{color:#999;}
        .order_total li{display: flex;justify-content: space-between;margin-bottom: 5px;}
        .order_product dd{margin-bottom: 5px;}

        .service_detail{}
        .service_detail li{display: flex;justify-content: space-between;line-height: 26px;}
        .service_detail li>div:first-child{color: #999;}
        .detail{background: #fff;border-radius: 8px;padding: 15px;}
        .detail .btn{padding: 0px 10px; border-radius: 4px;border: 1px solid #333; line-height: 34px;}
        .order_detail_title {font-weight: 500; border-top: 1px solid #f1f1f1;padding-top: 15px;}
    </style>
    <div class="account_info">
        @include('laravel-shop::front.account.left_menu')
        <div class="account-main-section" style="background: transparent;">
            <div class="service_detail">
                <div class="top-desc d-flex justify-content-between">
                    <h2>After Sales Information</h2>
                </div>

                <div class="detail">
                    <div class="order_detail_title">
                        After Sales Information
                    </div>
                    <ul class="service_detail">
                        <li><div>After Sales id</div><div>{{$res['info']->id}}</div></li>
                        <li><div>After Sales Status</div><div>
                                @if(!$res['info']->status)
                                    <span class="badge badge-primary" style="line-height: 21px;">{{$dict['after_sales_status'][$res['info']->status]}}</span>
                                @else
                                    <span class="badge badge-success" style="line-height: 21px;">{{$dict['after_sales_status'][$res['info']->status]}}</span>
                                @endif
                            </div></li>
                        <li><div>Date Added</div><div class="utc_time" data-utc_time="{{$res['info']->created_at->timestamp}}"></div></li>
                    </ul>
                    @if($res['info']->img->count())
                        <ul class="service_upload" style="margin-top: 10px;">
                            @foreach($res['info']->img as $val)
                                <li>
                                    <img src="{{$val->image_src}}" alt="" style="width: 100px;height: 100px;">
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="orderInfo detail">
                    <div class="order_detail_title">
                        Order Information
                    </div>
                    <ul>
                        <li><div>Order id</div><div>{{$res['orderInfo']->id}}</div></li>
                        <li><div>Order Total</div><div>{{$res['orderInfo']->total_format}}</div></li>
                        <li><div>Order Status</div><div>{{$res['orderInfo']->orderStatus->name}}</div></li>
                    </ul>
                    <dl class="order_product">
                        @foreach($res['orderProduct'] as $val)
                            <dd class="d-flex">
                                <div class="order_product1">
                                    <a href="/product/{{$val->product_id}}"><img src="{{$val->image}}" alt=""></a>
                                </div>
                                <div class="order_product2">
                                    <a href="/product/{{$val->product_id}}">
                                        <div class="order_product21 wenzi">{{$val->name}}</div>
                                    </a>
                                    @if($val->orderOption)
                                        <ul class="option order_product22">
                                            @foreach($val->orderOption as $v)
                                                <li>{{$v->name}} : {{$v->value}}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                                <div class="order_product3">
                                    <div class="order_product23">{{$val->price_format}}</div>
                                    <div class="order_product24">×{{$val->quantity}}</div>
                                </div>
                            </dd>
                        @endforeach
                    </dl>
                </div>


                @if($res['afterSalesHistory']->count())
                <div class="detail">
                    <div class="order_detail_title">
                        After Sales History
                    </div>
                    <dl class="my_step">
                        @foreach($res['afterSalesHistory'] as $val)
                            <dd class="">
                                <div class="my_step1">
                                    <div class="my_step11"></div>
                                    <div style="margin-right: auto" class="my_step12 utc_time" data-utc_time="{{$val->created_at->timestamp}}"></div>
                                    @if($res['info']->uid!=$val->uid)
                                    <div style="color: #09b337;">Aphly</div>
                                    @endif
                                </div>
                                <div class="my_step2">
                                    <div class="my_step22">
                                        <div class="my_step222">{{$val->content}}</div>
                                    </div>
                                </div>
                            </dd>
                        @endforeach
                    </dl>

                </div>
                @endif
                @if(!$res['info']->status)
                <div class="">
                    <form class="form_request service_detail_form" method="post" action="/account_ext/after_sales/save_history?id={{$res['info']->id}}" data-fn="history_res">
                        @csrf
                        <div class="form-group" >
                            <p class="title_p">Content: <b>*</b></p>
                            <textarea name="content" required class="form-control" style="height: 200px;">{{$res['info']->content}}</textarea>
                        </div>
                        <div class="form-group d-flex">
                            <button class="btn-default save-address account_btn" type="submit">Save</button>
                        </div>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
<style>
    .product img{width: 100px;height: 100px;}
    .service_detail_form{background: #fff;border-radius: 8px;}
    .service_detail_form input{margin: 10px 0}
</style>
<script>
    function history_res(res,that) {
        alert_res(res)
    }

</script>
@include('laravel-shop::front.common.footer')
