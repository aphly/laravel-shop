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

        .title_p{margin-bottom: 5px;}

        .received li{width: 48%;line-height: 34px;color: #333;border-radius: 6px;text-align: center;border: 1px solid #f1f1f1;cursor: pointer;}
        .received li.active{color: var(--btn_bg);border: 1px solid var(--btn_bg);}
        .service_action label{margin-bottom: 0;line-height: 44px;cursor: pointer;}
        .service_action input{ height: 44px;margin-right: 10px;}
        .service_action>div{margin-right: 20px;}
        .service_action>h5{margin-bottom: 10px;}
        .service_product li{margin-bottom: 10px; }
        .serviceOrderOption dd{margin-right: 10px;}
        .serviceOrderOptionx dd{margin-right: 10px;}
        .service_product1 input[type="checkbox"]{ width: 20px; height: 20px;cursor: pointer;}
        .orderProductImg img{width: 100%;height: 100%;}

        .orderInfo{background: #fff;padding:15px; border-radius: 8px;margin-bottom: 10px;}
        .orderInfo li{display: flex;}
        .orderInfo li>div{margin-right: 20px;}
        .orderInfo li>div:first-child{width: 100px;color:#666;}

        .service_action_ul li{flex:1;color: #333;border-radius: 6px;text-align: center;border: 1px solid #f1f1f1;cursor: pointer;margin: 0 10px;padding:10px 0;display: flex;justify-content: center;align-items: center;}
        .service_action_ul li.active{color: var(--btn_bg);border: 1px solid var(--btn_bg);}
        .quantity-wrapper div, .quantity-wrapper input{height: 30px;line-height: 30px;width: 30px; min-width: 30px;padding: 0;}
        .service_action_ul_res li{display: none;}
        .service_action_ul_res li.active{display: block;color: var(--btn_bg);}
        .service_form{margin-bottom: 10px;background: #fff;padding:15px; border-radius: 8px;}
        .file_img img{width: 80px;height: 80px;margin-right: 10px;}

        #is_opened{display: none}
    </style>
    <div class="account_info">
        @include('laravel-shop::front.account.left_menu')
        <div class="account-main-section" style="background: transparent;">
            <div class="order">
                <div class="top-desc d-flex justify-content-between">
                    <h2>After Sales</h2>
                </div>

                <div style="" class="orderInfo">
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

                <form action="/account_ext/after_sales/save?order_id={{$res['orderInfo']->id}}" method="post" enctype="multipart/form-data" class="form_request_img_file received2 service_form" data-fn="after_sales_res">
                    @csrf
                    <div class="form-group">
                        <p class="title_p">Is Received: <b>*</b></p>
                        @if(isset($dict['shop_yes_no']))
                            <select name="is_received" id="is_received" class="form-control">
                                @foreach($dict['shop_yes_no'] as $key=>$val)
                                    <option value="{{$key}}" @if(($res['info']->is_opened)==$key) selected @endif>{{$val}}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>

                    <div class="form-group" id="is_opened">
                        <p class="title_p">Is Opened: <b>*</b></p>
                        @if(isset($dict['shop_yes_no']))
                        <select name="is_opened" class="form-control">
                            @foreach($dict['shop_yes_no'] as $key=>$val)
                                <option value="{{$key}}" @if(($res['info']->is_opened)==$key) selected @endif>{{$val}}</option>
                            @endforeach
                        </select>
                        @endif
                    </div>

                    <div class="form-group">
                        <div class="add_photo"><i class="common-iconfont icon-zhaoxiangji"></i>Add Photo</div>
                        <input type="file" style="display: none" accept="image/gif,image/jpeg,image/jpg,image/png" data-img_list="file_img"
                               class="input_file_img add_photo_file" multiple="multiple">
                        <div class="file_img"></div>
                    </div>

                    <div class="form-group" >
                        <p class="title_p">Content: <b>*</b></p>
                        <textarea name="content" required class="form-control" style="height: 200px;">{{$res['info']->content}}</textarea>
                    </div>

                    <div class="form-group d-flex">
                        <button class="btn-default save-address account_btn" type="submit">Request</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</section>

<script>
    function after_sales_res(res,_this) {
        alert_res(res)
    }

$(function () {

    $('.add_photo').click(function () {
        $('.add_photo_file').click();
    })

    $('#is_received').change(function () {
        let val = $(this).val()
        if(val==='1'){
            $('#is_opened').show()
        }else{
            $('#is_opened').hide()
        }
    })
})
</script>

@include('laravel-shop::front.common.footer')
