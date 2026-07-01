@include('laravel-shop::front.common.header')
<style>
    .ext_login{display: flex;justify-content: center}
    .ext_login a{background: #000; color: #fff; padding: 10px 20px;border-radius: 8px;}
    .checkout_info,.shipping_method .checkout_ul li,.checkout_ul li{border:none;box-shadow: 0 0 15px 0 #f1f1f1;font-weight: 600;margin-bottom: 10px;border-radius: 8px;}
    .checkout_ul li[data-disabled="true"]{color: #ccc;cursor: inherit;}
    .shipping_address .checkout_ul li{display: block}
    .email_active{border: 1px solid var(--btn_bg);border-radius: 8px;box-shadow: 0 0 15px 0 #f1f1f1;}
</style>
<div class="container shop_main">
    <div class="">
        {!! $res['breadcrumb'] !!}
    </div>
    <div class="checkout">
        <div class="checkout_l">
            <form action="/checkout/payment_paypal" method="post" id="checkout_payment">
                @csrf
                <div class="checkout_box">
                    <div class="checkout_title" style="display: flex;justify-content: space-between;align-items: baseline;">
                        <div>
                            Contact
                        </div>
                        @if(!$user)
                        <div style="font-size: 14px;">
                            Have an account? <a href="{{route('login')}}?redirect={{urlencode(request()->url())}}" style="color:var(--btn_bg)">Log in</a>
                        </div>
                        @endif
                    </div>
                    @if($user)
                        <div class="form-group checkout_group form-group_show ">
                            <label class="">Email</label>
                            <input type="email" name="email" value="{{$email}}" placeholder="Email" class="email_active form-control" autocomplete="off">
                            <div class="invalid-feedback"></div>
                        </div>
                    @else
                        <div class="form-group checkout_group ">
                            <label class="">Email</label>
                            <input type="email" name="email" onblur="guestEmail(this)" placeholder="Email" class="email_active form-control" autocomplete="off">
                            <div class="invalid-feedback"></div>
                        </div>
                    @endif
                    @if(!$user)
                        <div class="ext_login">
                            <a class="google" href="/oauth/google">
                                <div class="d-flex justify-content-between">
                                    <div class="ext_icon">
                                        <svg width="22" height="22" xmlns="http://www.w3.org/2000/svg">
                                            <g fill="none" fill-rule="evenodd">
                                                <path d="M20.6 11.227c0-.709-.064-1.39-.182-2.045H11v3.868h5.382a4.6 4.6 0 0 1-1.996 3.018v2.51h3.232c1.891-1.742 2.982-4.305 2.982-7.35z" fill="#4285F4"></path>
                                                <path d="M11 21c2.7 0 4.964-.895 6.618-2.423l-3.232-2.509c-.895.6-2.04.955-3.386.955-2.605 0-4.81-1.76-5.595-4.123H2.064v2.59A9.996 9.996 0 0 0 11 21z" fill="#34A853"></path>
                                                <path d="M5.405 12.9c-.2-.6-.314-1.24-.314-1.9 0-.66.114-1.3.314-1.9V6.51H2.064A9.996 9.996 0 0 0 1 11c0 1.614.386 3.14 1.064 4.49l3.34-2.59z" fill="#FBBC05"></path>
                                                <path d="M11 4.977c1.468 0 2.786.505 3.823 1.496l2.868-2.868C15.959 1.99 13.695 1 11 1 7.09 1 3.71 3.24 2.064 6.51l3.34 2.59C6.192 6.736 8.396 4.977 11 4.977z" fill="#EA4335"></path>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="" style="line-height: 22px;margin-left: 10px;">Google</div>
                                    <div></div>
                                </div>
                            </a>
                            <a class="google" href="/oauth/facebook" style="margin-left: 20px;">
                                <div class="d-flex justify-content-between">
                                    <div class="ext_icon">
                                        <svg  t="1780923527719" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="5062" width="22" height="22"><path d="M725.333333 149.333333a21.333333 21.333333 0 0 0-21.333333-21.333333H597.333333a203.52 203.52 0 0 0-213.333333 192v115.2H277.333333a21.333333 21.333333 0 0 0-21.333333 21.333333v110.933334a21.333333 21.333333 0 0 0 21.333333 21.333333H384v285.866667a21.333333 21.333333 0 0 0 21.333333 21.333333h128a21.333333 21.333333 0 0 0 21.333334-21.333333v-285.866667h111.786666a21.333333 21.333333 0 0 0 20.906667-15.786667l30.72-110.933333a21.333333 21.333333 0 0 0-20.48-26.88H554.666667V320a42.666667 42.666667 0 0 1 42.666666-38.4h106.666667a21.333333 21.333333 0 0 0 21.333333-21.333333z" fill="#0065e1" p-id="5063"></path></svg>
                                    </div>
                                    <div class="" style="line-height: 22px;margin-left: 10px;">Facebook</div>
                                    <div></div>
                                </div>
                            </a>
                        </div>
                    @endif
                </div>
                <div class="checkout_box shipping_address">
                    <div class="checkout_title">
                        Delivery Address
                    </div>
                    <input type="hidden" name="address_id" value="{{$res['my_address_first']['id']}}">
                    <ul class="checkout_ul">
                        @foreach($res['my_address'] as $val)
                            <li data-id="{{$val['id']}}"  >
                                <div class="lix">
                                    <div class="custom-radio"><div></div></div>
                                    <div style="margin-right: auto;width: calc(100% - 60px);">
                                        <div class="wenzi">{{$val['address_1']}}</div>
                                        <div class="wenzi" style="font-size: 12px;color: #666;">
                                            {{$val['firstname']}} {{$val['lastname']}} , {{$val['telephone']}}
                                        </div>
                                    </div>
                                    <a href="/account_ext/address/save?address_id={{$val['id']}}" style="padding: 5px;">
                                        <i class="common-iconfont icon-bianjishuru"></i>
                                    </a>
                                </div>
                            </li>
                        @endforeach
                        <li data-id="0"  >
                            <div class="lix">
                                <div class="custom-radio"><div></div></div>
                                <div style="margin-right: auto">Use a new address</div>
                                <div></div>
                            </div>
                            <div class="lix_t">
                                <div class="checkout_group_p">
                                    <div class="form-group checkout_group">
                                        <label class="">First name </label>
                                        <input type="text" name="firstname" placeholder="First name *" required class="form-control ">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group checkout_group">
                                        <label class="">Last name </label>
                                        <input type="text" name="lastname" required placeholder="Last name *" class="form-control ">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-group checkout_group">
                                    <label class="">Address 1 </label>
                                    <input type="text" name="address_1" required placeholder="Address 1 *" class="form-control ">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group checkout_group">
                                    <label class="">Address 2</label>
                                    <input type="text" name="address_2"  placeholder="Apartment, suite, etc. (optional)" class="form-control ">
                                </div>
                                <div class="form-group checkout_group">
                                    <label class="">Country </label>
                                    @if($res['country_first'])
                                        <input type="hidden" id="country_code" name="country_code" value="{{$res['country_first']['iso_code_2']}}">
                                    @else
                                        <input type="hidden" id="country_code" name="country_code" value="">
                                    @endif
                                    <select name="country_id"  required class="form-control input-country">
                                        @foreach($res['country'] as $val)
                                            <option class="country_option" data-country_code="{{$val['iso_code_2']}}" value="{{$val['id']}}">{{$val['name']}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group checkout_group">
                                    <label class="">State / Province </label>
                                    <select name="zone_id" required class="form-control input-zone">
                                        <option value="" class="zone_option"> --- Please Select --- </option>
                                        @foreach($res['zone'] as $v)
                                            <option value="{{$v['id']}}" data-name="{{$val['name']}}" class="zone_option">{{$v['name']}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="checkout_group_p">
                                    <div class="form-group checkout_group">
                                        <label class="">City </label>
                                        <input type="text" name="city" required placeholder="City *" class="form-control ">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group checkout_group">
                                        <label class="">Postcode </label>
                                        <input type="text" name="postcode" required placeholder="Postcode *" class="form-control " >
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-group checkout_group">
                                    <label class="">Telephone </label>
                                    <input type="text" name="telephone"  placeholder="Telephone *" class="form-control ">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </li>
                    </ul>

                </div>

                <div class="checkout_box shipping_method">
                    <div class="checkout_title">
                        Shipping Method
                        <div class="checkout_title_x">
                            Choose a shipping method.
                        </div>
                    </div>
                    <div style="display: none">
                        @foreach($res['shipping'] as $val)
                            @if($val['id']==$res['shipping_first']['id'])
                                <input class="shipping_id_{{$val['id']}}" checked type="radio" name="shipping_id" value="{{$val['id']}}" >
                            @else
                                <input class="shipping_id_{{$val['id']}}" type="radio" name="shipping_id" value="{{$val['id']}}" >
                            @endif
                        @endforeach
                    </div>

                    <ul class="checkout_ul ">
                        @foreach($res['shipping'] as $val)
                            <li @if($val['desc']=='coupon') style="display: none" @endif data-id="{{$val['id']}}" @if($val['disabled']) data-disabled="true" @endif class="@if($val['id']==$res['shipping_first']['id']) active @endif">
                                <div class="lix">
                                    <div class="custom-radio_r" >
                                        <div>
                                            {{$val['name']}}
                                        </div>
                                        <div class="desc" style="">
                                            @if($val['cost']==0)
                                                @if($val['desc']=='coupon')
                                                    The coupon includes free shipping
                                                @else
                                                    Free shipping for orders over {{$val['free_cost_format']}}
                                                @endif
                                            @else
                                                {{$val['desc']}}
                                            @endif
                                        </div>
                                        <div>
                                            <span>
                                            @if($val['cost']>0)
                                                {{$val['cost_format']}}
                                            @else
                                                Free
                                            @endif
                                            </span>
                                        </div>
                                    </div>
                                    <div class="custom_right"><i class="uni app-zhengque"></i></div>

                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </form>
            <div class="checkout_box payment_method">
                <div class="checkout_title">
                    Payment Method
                    <div class="checkout_title_x">
                        All transactions are secure and encrypted.
                    </div>
                </div>
                <div style="display: flex;justify-content: center;font-weight: 600;margin-bottom: 20px;font-size: 18px;">
                    <div style="margin-right: 10px;">Order Total:</div>
                    <div class="js-total_all">
                        @if($res['total_data']['totals']['total']['value_old']!=$res['total_data']['totals']['total']['value'])
                            <span class="items-right js-total-amount  price_format">{{$res['total_data']['totals']['total']['value_format']}}</span>
                            <span class="price_old_format js-total-amount_old">{{$res['total_data']['totals']['total']['value_old_format']}}</span>
                        @else
                            <span class="items-right js-total-amount">{{$res['total_data']['totals']['total']['value_format']}}</span>
                        @endif
                    </div>
                </div>

                <div id="paypal-button-container" class="paypal-button-container"></div>
            </div>


        </div>
        <div class="checkout_r">
            @include('laravel-shop::front.checkout.right')
        </div>
    </div>

</div>
<style>

    .checkout_btn button{padding: 10px;}
    .shipping_address .checkout_ul li .lix{}
    .checkout_group_p{display: flex;justify-content: space-between;}
    .checkout_group_p>div{width: 48%;}

    .checkout_group select{height: 50px;line-height: 50px;border-radius:8px;}
    .checkout_group input{height: 50px;line-height: 50px;outline: none;transition: padding-top 0.5s;background: transparent}
    .checkout_group{width: 100%;position: relative;}
    .checkout_group label{position: absolute;top: 0;width: 100%;opacity: 1;z-index: -1;color: #999;transition: opacity 0.5s;line-height: 46px;}
    .checkout_group.form-group_show label{z-index: 1;padding: 0 10px;font-size: 12px;color: #999;line-height: 26px;}
    .checkout_group.form-group_show input{padding-top: 20px;}
    .checkout_group input:focus{border-color:#0178ff;outline: none;border-width: 2px;}
    .checkout_group{}
    .checkout_group input{border-radius:8px;background: #fff;}

    .checkout_ul li{display: flex;justify-content: space-between;margin-bottom:10px; border-radius: 8px;}
    /*.checkout_ul li:first-child{border-top-left-radius: 8px;border-top-right-radius: 8px;}*/
    /*.checkout_ul li:last-child{border-bottom-left-radius: 8px;border-bottom-right-radius: 8px;}*/
    .checkout_ul li.disabled{ background: #f1f1f1;}
    .checkout_ul .desc{font-size: 10px;color: #666;}
    .checkout_ul li.active .custom-radio{border:1px solid var(--btn_bg)}
    .checkout_ul li.active .custom-radio>div{background:var(--btn_bg);width:12px;height:12px;border-radius:50%}
    .checkout_ul li .lix{padding:0 20px;margin-bottom:0;width:100%;display:flex;justify-content:space-between;align-items:center;height: 50px;}
    .custom-radio{width:18px;height:18px;background-color:#fff;border-radius:50%;border:1px solid #333;cursor:pointer;display:flex;justify-content:center;align-items:center}
    .checkout_ul li .custom-radio{margin-right: 10px;}
    .checkout_title_x{color: #707070;font-size: 13px;}

    .prev_item{border-bottom: none !important;}
    .next_item{border-top: none !important;}

    .lix_t{background: #f5f5f5;width: 100%; padding: 15px;display: none}
    .checkout_ul .active .lix_t{display: block}

    .shipping_method .checkout_ul{
        display: flex;flex-wrap: wrap;
    }
    .shipping_method .checkout_ul li{
        width: calc((100% - 10px) / 2);
        padding: 10px;
        border-radius:8px;
        margin-right:10px;margin-bottom: 10px;
    }
    .shipping_method .checkout_ul li .lix{height: auto;position: relative}
    .shipping_method .checkout_ul li:nth-child(2n){
        margin-right:0;
    }
    .custom-radio_r{
        width: calc(100% - 30px);
    }
    .payment_name::first-letter {
        text-transform: uppercase;
    }
    .desc{margin-bottom: 10px}
    .active .custom_right{display: block;}
    .active .custom_right .app-zhengque{color:var(--btn_bg);}
    .custom_right{display: none;position: absolute;right: 20px;top:calc(50% - 12px);}
    label span{color: darkred;}

    @media (max-width: 1200px) {
        .shipping_method .checkout_ul li{
            width: 100%;
            margin-right:0;
            margin-bottom: 10px;
        }
    }
</style>
<script src="https://www.paypal.com/sdk/js?client-id={{$res['ClientID']}}&locale=en_US"></script>
<script >
    function form_err_11000(res,that) {
        let input_group = that.find('.input_group');
        input_group.removeClass('group_is-invalid')
        let first_ms = ''
        for(let i in res.data){
            let str = ''
            res.data[i].forEach((elem, index)=>{
                str = str+elem+'<br>'
            })
            form_err(that,i,str)
            if(!first_ms){
                first_ms = res.data[i][0]
                let offsetTop = that.find('*[name="'+i+'"]').offset().top - 150
                $('html, body').animate({ scrollTop: offsetTop }, 600);
            }
        }
        alert_msg(first_ms)
    }
    let paypalButtonsInstance = null;
    function renderPayPalButton() {
        if (paypalButtonsInstance) {
            paypalButtonsInstance.close();
        }
        paypalButtonsInstance = paypal.Buttons({
                onInit: function(data, actions) {
                    paypalButtonInstance = actions;
                },
                style: {
                    shape: "pill",
                    layout: "vertical",
                    color: "gold",
                    label: "buynow",
                    disableMaxWidth: true
                },
                async createOrder() {
                    let that = $('#checkout_payment')
                    try{
                        const response = await fetch("/checkout/payment_paypal", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                            },
                            body: JSON.stringify(that.serializeArray().reduce((obj, item) => ({
                                ...obj,
                                [item.name]: item.value
                            }), {})),
                        });
                        const res = await response.json();
                        console.log('res:',res);
                        if (!res.code) {
                            return res.data.paypal_id;
                        } else {
                            if (res.code === 11000) {
                                form_err_11000(res, that);
                            } else if (res.code === 2) {
                                alert_msg(res.msg)
                            } else if (res.code === 11) {
                                alert_msg(res.msg)
                            } else {
                                alert_msg(res.msg)
                            }
                        }
                        throw new Error(res.msg);
                    }catch (e) {
                        throw e
                    }
                },
                onCancel(data, actions) {
                    console.log("PayPal onCancel");
                    actions.redirect('{{url('/account_ext/order')}}')
                },
                onError: function(error) {
                    console.log("PayPal onError：", error);
                    renderPayPalButton();
                },
                async onApprove(data, actions) {
                    //console.log('onApprove',data, actions)
                    const response = await fetch(`/checkout/capture_paypal`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: JSON.stringify({
                            paypal_id: data.orderID,
                        }),
                    });
                    const res = await response.json();
                    if(res.code){
                        alert_msg(res.msg)
                    }
                    const errorDetail = res.data?.details?.[0];
                    if (errorDetail?.issue === "INSTRUMENT_DECLINED") {
                        return actions.restart();
                    } else if (errorDetail) {
                        alert_msg(`${errorDetail.description} (${res.data.debug_id})`)
                    } else if (!res.data.purchase_units) {
                        alert_msg(res.msg)
                    } else {
                        actions.redirect('{{url('/account_ext/order')}}')
                    }
                },
            })
        paypalButtonsInstance.render('#paypal-button-container');
    }
    renderPayPalButton()
</script>

<script>
    let country_zone = {};
    $(function () {
        $('select').change(function () {
            $(this).removeClass('is-invalid')
        })
        $('.shipping_address').on('click','li',function () {
            $('.shipping_address li').removeClass('active')
            $(this).addClass('active')
            let address_id = $(this).data('id');
            $('input[name="address_id"]').val(address_id)
            if(address_id){
                $('.shipping_address input').attr('required',false)
                $('.shipping_address select').attr('required',false)
            }else{
                $('.shipping_address input:not([name="address_2"])').attr('required',true)
                $('.shipping_address select').attr('required',true)
            }
        })
        $('.shipping_address li:first').click()

        $('.checkout_group').on('input','input',function () {
            if($(this).val()){
                $(this).parent().addClass('form-group_show')
            }else{
                $(this).parent().removeClass('form-group_show')
            }
        })

        $('.input-country').change(function () {
            let country_id = $(this).val();
            $('#country_code').val($(this).find('option:selected').data('country_code'))
            setCountry(country_id,false,false,this)
        })

        //shipping_method
        let shipping_method_flag = false
        $('.shipping_method').on('click','li',function () {
            let id = $(this).data('id')
            let disabled = $(this).data('disabled')
            let _this = $(this)
            if(!shipping_method_flag && !disabled){
                shipping_method_flag = true
                $.ajax({
                    url:'/checkout/shipping',
                    dataType: "json",
                    type:"post",
                    data:{'shipping_id':id},
                    success: function(res){
                        $('.shipping_method li').removeClass('active').removeClass('prev_item').removeClass('next_item')
                        _this.addClass('active')
                        $('.shipping_id_'+id).click()

                        $('.totals_shipping .items-left').text(res.data.total_data.totals.shipping.title)
                        $('.totals_shipping .items-right').text(res.data.total_data.totals.shipping.value_format)

                        $('.js-total-amount').text(res.data.total_data.totals.total.value_format)
                        $('.js-total-amount_old').text(res.data.total_data.totals.total.value_old_format)
                    },
                    complete:function () {
                        shipping_method_flag = false
                    }
                })
            }
        })
        //$('.shipping_method li:first').find('.lix').click()

    })

    function setZone(res,country_id,zone_id,_this) {
        let checkout_box = $(_this).closest('.checkout_box')
        country_zone[country_id] = [];
        for(let i in res.data){
            country_zone[country_id].push(res.data[i])
        }
        makeZone(country_zone[country_id],_this)
        checkout_box.find('.input-zone .zone_option[value="'+zone_id+'"]').attr("selected", true)
    }

    function setCountry(country_id,fn=false,zone_id=false,_this) {
        let checkout_box = $(_this).closest('.checkout_box')
        if(country_id in country_zone){
            makeZone(country_zone[country_id],_this)
            if(zone_id){
                checkout_box.find('.input-zone .zone_option[value="'+zone_id+'"]').attr("selected", true)
            }
        }else{
            if(country_id){
                $.ajax({
                    url:'/country/'+country_id+'/zone',
                    dataType: "json",
                    success: function(res){
                        if(fn){
                            fn(res,country_id,zone_id)
                        }else{
                            country_zone[country_id] = [];
                            for(let i in res.data){
                                country_zone[country_id].push(res.data[i])
                            }
                            makeZone(country_zone[country_id],_this)
                        }
                    }
                })
            }else{
                let html = '<option value="0"> --- None --- </option>';
                checkout_box.find('.input-zone').html(html)
            }
        }
    }

    function makeZone(data,_this){
        let checkout_box = $(_this).closest('.checkout_box')
        let html = '';
        if(data.length){
            html = '<option value="" class="zone_option"> --- Please Select --- </option>';
            for(let i in data){
                html += '<option data-name='+data[i].name+' class="zone_option" value="'+data[i].id+'">'+data[i].name+'</option>';
            }
        }else{
            html = '<option value="0" class="zone_option"> --- None --- </option>';
        }
        checkout_box.find('.input-zone').html(html)
    }

    function checkout_payment(res,that) {
        if(!res.code){
            location.href = res.data.redirect
        }else if(res.code===11000){
            form_err_11000(res,that);
        }else if(res.code===2){
            alert_msg(res.msg)
        }else{
            alert_msg(res.msg)
        }
    }

    function guestEmail(_this) {
        let that = $(_this).closest('form');
        let url = '/checkout/email'
        $(_this).removeClass('is-valid').removeClass('is-invalid');
        debounce_fn(function () {
            $.ajax({
                url,
                type:'get',
                data:{'email':$(_this).val()},
                dataType: "json",
                success:function (res) {
                    if(res.code===11000){
                        form_err_11000(res,that);
                    }else if(res.code===1){
                        location.reload()
                    }
                }
            })
        },400)
    }
</script>
@include('laravel-shop::front.common.footer')
