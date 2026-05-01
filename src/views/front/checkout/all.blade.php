@include('laravel-shop::front.common.header')
<style>
    .ext_login{display: flex;justify-content: center}
    .ext_login a{background: #000; color: #fff; padding: 10px 20px;border-radius: 8px;}
    .checkout_info,.shipping_method .checkout_ul li,.checkout_ul li{border:none;box-shadow: 0 0 15px 0 #f1f1f1;font-weight: 600;margin-bottom: 10px;border-radius: 8px;}
    .checkout_ul li[data-disabled="true"]{color: #ccc;cursor: inherit;}
</style>
<div class="container shop_main">
    <div class="">
        {!! $res['breadcrumb'] !!}
    </div>
    <div class="checkout">
        <div class="checkout_l">
            <form action="/checkout/payment" method="post" class="form_request" data-fn="checkout_payment" id="checkout_payment">
                @csrf
                <div class="checkout_box">
                    <div class="checkout_title" style="display: flex;justify-content: space-between;align-items: baseline;">
                        <div>
                            Contact
                        </div>
                        @if(!$email)
                        <div style="font-size: 14px;">
                            Have an account? <a href="{{route('login')}}?redirect={{urlencode(request()->url())}}" style="color:var(--btn_bg)">Log in</a>
                        </div>
                        @endif
                    </div>
                    @if(!$email)
                        <div class="form-group checkout_group">
                            <label class="">Email</label>
                            <input type="text" name="email" onblur="guestEmail(this)" placeholder="Email" class="form-control" autocomplete="off">
                            <div class="invalid-feedback"></div>
                        </div>
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
                                    <div class="" style="line-height: 22px;margin-left: 10px;">Sign in with Google</div>
                                    <div></div>
                                </div>
                            </a>
                        </div>
                    @else
                    <ul class="checkout_info" style="padding: 15px ;border-radius: 8px;">
                        <li>
                            <span>Email</span>
                            <span>{{$email}}</span>
                            <span></span>
                        </li>
                    </ul>
                    @endif
                </div>
                <div class="checkout_box shipping_address">
                    <div class="checkout_title">
                        Delivery Address
                    </div>
                    <input type="hidden" name="address_id" value="{{$res['my_address_first']['id']}}">
                    <ul class="checkout_ul">
                        @foreach($res['my_address'] as $val)
                            <li data-id="{{$val['id']}}" data-firstname="{{$val['firstname']}}" data-lastname="{{$val['lastname']}}"
                                data-address_1="{{$val['address_1']}}" data-address_2="{{$val['address_2']}}"
                                data-city="{{$val['city']}}" data-postcode="{{$val['postcode']}}" data-zone_id="{{$val['zone_id']}}" data-country_id="{{$val['country_id']}}"
                                data-telephone="{{$val['telephone']}}" >
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
                                    <select name="country_id"  required class="form-control input-country">
                                        @foreach($res['country'] as $val)
                                            <option class="country_option" data-name="{{$val['name']}}" value="{{$val['id']}}">{{$val['name']}}</option>
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

                <div class="checkout_box billing_address" style="display: none;">
                    <div class="checkout_title">
                        Billing Address
                        <div class="checkout_title_x">
                            Select the address that matches your card or payment method.
                        </div>
                    </div>
                    <input type="hidden" name="same" id="same" value="1">
                    <ul class="checkout_ul ">
                        <li data-val="1" class="active">
                            <div class="lix">
                                <div class="custom-radio"><div></div></div>
                                <div style="margin-right: auto">Same as Delivery Address</div>
                                <div></div>
                            </div>
                        </li>
                        <li data-val="0">
                            <div class="lix">
                                <div class="custom-radio"><div></div></div>
                                <div style="margin-right: auto">Use a different billing address</div>
                                <div></div>
                            </div>
                            <div class="lix_t">

                                <div class="checkout_group_p">
                                    <div class="form-group checkout_group">
                                        <label class="">First name</label>
                                        <input type="text" name="billing_firstname" placeholder="First name"  class="form-control ">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group checkout_group">
                                        <label class="">Last name</label>
                                        <input type="text" name="billing_lastname"  placeholder="Last name" class="form-control ">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="form-group checkout_group">
                                    <label class="">Address 1</label>
                                    <input type="text" name="billing_address_1"  placeholder="Address 1" class="form-control ">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group checkout_group">
                                    <label class="">Address 2</label>
                                    <input type="text" name="billing_address_2"  placeholder="Apartment, suite, etc. (optional)" class="form-control ">
                                </div>
                                <div class="form-group checkout_group">
                                    <label class="">Country</label>
                                    <select name="billing_country_id" class="form-control input-country">
                                        @foreach($res['country'] as $val)
                                            <option class="country_option" data-name="{{$val['name']}}" value="{{$val['id']}}">{{$val['name']}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group checkout_group">
                                    <label class="">State / Province</label>
                                    <select name="billing_zone_id" class="form-control input-zone">
                                        <option value="" class="zone_option"> --- Please Select --- </option>
                                        @foreach($res['zone'] as $v)
                                            <option value="{{$v['id']}}" data-name="{{$val['name']}}" class="zone_option">{{$v['name']}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="checkout_group_p">
                                    <div class="form-group checkout_group">
                                        <label class="">City</label>
                                        <input type="text" name="billing_city"  placeholder="City" class="form-control ">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="form-group checkout_group">
                                        <label class="">Postcode</label>
                                        <input type="text" name="billing_postcode"  placeholder="Postcode" class="form-control " >
                                        <div class="invalid-feedback"></div>
                                    </div>
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
                            <li data-id="{{$val['id']}}" @if($val['disabled']) data-disabled="true" @endif class="@if($val['id']==$res['shipping_first']['id']) active @endif">
                                <div class="lix">
                                    <div class="custom-radio_r" >
                                        <div>
                                            {{$val['name']}}
                                        </div>
                                        <div class="desc" style="">
                                            @if($val['cost']==0)
                                                FREE On Orders Over {{$val['free_cost_format']}}
                                            @else
                                                {{$val['desc']}}
                                            @endif
                                        </div>
                                        <div>
                                            @if($val['free'])
                                                <span>Free</span>
                                                @if($val['cost']>0)
                                                    <span class="old_price">{{$val['cost_format']}}</span>
                                                @endif
                                            @else
                                                <span>
                                                @if($val['cost']>0)
                                                    {{$val['cost_format']}}
                                                @else
                                                    Free
                                                @endif
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="custom_right"><i class="uni app-zhengque"></i></div>

                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="checkout_box payment_method">
                    <div class="checkout_title">
                        Payment Method
                        <div class="checkout_title_x">
                            All transactions are secure and encrypted.
                        </div>
                    </div>
                    <div style="display: none">
                        @foreach($res['paymentMethod'] as $val)
                            <input type="radio" class="payment_method_id_{{$val['id']}}" name="payment_method_id" value="{{$val['id']}}">
                        @endforeach
                    </div>
                    <ul class="checkout_ul ">
                        @foreach($res['paymentMethod'] as $val)
                            <li data-id="{{$val['id']}}">
                                <div class="lix" >
                                    <div class="custom-radio"><div></div></div>
                                    <div class="payment_name" style="margin-right: auto">{{$val['name']}}</div>
                                    <img src="/static/payment/img/{{$val['name']}}.png">
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="checkout_btn">
                    <button type="submit" id="submit" style="">
                        <i class="common-iconfont icon-dunpai-" style="font-size: 20px;"></i>
                        PAY NOW
                    </button>
                </div>

            </form>
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

    .billing_address .checkout_ul li,.shipping_address .checkout_ul li{flex-wrap: wrap;}
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
<script>
    let country_zone = {};
    $(function () {

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
                        // _this.prev().addClass('prev_item')
                        // _this.next().addClass('next_item')
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

        //payment_method
        $('.payment_method').on('click','li',function () {
            $('.payment_method li').removeClass('active')
            $(this).closest('li').addClass('active')
            let payment_method_id = $(this).data('id')
            $('.payment_method_id_'+payment_method_id).click()
        })
        $('.payment_method li:first').click()


        $('.billing_address').on('click','li',function () {
            $('.billing_address li').removeClass('active')
            $(this).addClass('active')
            let same = $(this).data('val')
            $('#same').val(same)
            if(same){
                $('.billing_address input').attr('required',false)
                $('.billing_address select').attr('required',false)
            }else{
                $('.billing_address input:not([name="billing_address_2"])').attr('required',true)
                $('.billing_address select').attr('required',true)
            }
        })
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
                    }
                }
            })
        },400)
    }
</script>
@include('laravel-shop::front.common.footer')
