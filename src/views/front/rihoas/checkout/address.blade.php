@include('laravel-shop-front::common.header')
<style>
</style>
<div class="container shop_main">
    <div class="">
        {!! $res['breadcrumb'] !!}
    </div>
    <div class="checkout">
        <div class="checkout_l">
            <div class="checkout_box">
                <div class="checkout_title">
                    Contact information
                </div>
                <ul class="checkout_info">
                    <li>
                        <span>Contact</span>
                        <span>{{$id}}</span>
                        <span></span>
                    </li>
                </ul>
            </div>
            <form action="/checkout/address" method="post" class="form_request" data-fn="checkout_address" id="checkout_address">
                @csrf
                <div class="my_address checkout_box">
                    <div class="checkout_title">
                        My Address
                    </div>
                    <ul class="checkout_ul">
                    @foreach($res['my_address'] as $val)
                        <li data-id="{{$val['id']}}" data-firstname="{{$val['firstname']}}" data-lastname="{{$val['lastname']}}"
                            data-address_1="{{$val['address_1']}}" data-address_2="{{$val['address_2']}}"
                            data-city="{{$val['city']}}" data-postcode="{{$val['postcode']}}" data-zone_id="{{$val['zone_id']}}" data-country_id="{{$val['country_id']}}"
                            data-telephone="{{$val['telephone']}}">
                            <label>
                                <input type="radio" name="address_id" value="{{$val['id']}}">
                                <span style="margin-right: auto;">{{$val['firstname']}} {{$val['lastname']}}, {{$val['address_1']}}, {{$val['address_2']}},
                                {{$val['city']}}, {{$val['zone_name']}}, {{$val['country_name']}}, {{$val['postcode']}}, {{$val['telephone']}}</span>
                                <span></span>
                            </label>
                        </li>
                    @endforeach
                        <li data-id="0" class="active"><label><input type="radio" name="address_id" checked value="0"><span style="margin-right: auto;">Use a new address</span></label></li>
                    </ul>
                </div>

                <div class="shipping_address">
                    <div class="checkout_title">
                        Shipping address
                    </div>
                    <div>
                        <div class="form-group checkout_address_group">
                            <label class="">Country</label>
                            <select name="country_id" id="input-country" required class="form-control ">
                            @foreach($res['country'] as $val)
                                <option class="country_option" value="{{$val['id']}}">{{$val['name']}}</option>
                            @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group checkout_address_group">
                            <label class="">State / Province</label>
                            <select name="zone_id" id="input-zone" class="form-control">
                                <option value="0" class="zone_option"> --- None --- </option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="checkout_address_group_p">
                            <div class="form-group checkout_address_group">
                                <label class="">First name</label>
                                <input type="text" name="firstname" placeholder="First name" required class="form-control ">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group checkout_address_group">
                                <label class="">Last name</label>
                                <input type="text" name="lastname" required placeholder="Last name" class="form-control ">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group checkout_address_group">
                            <label class="">Address 1</label>
                            <input type="text" name="address_1" required placeholder="Address 1" class="form-control ">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group checkout_address_group">
                            <label class="">Address 2</label>
                            <input type="text" name="address_2"  placeholder="Address 2" class="form-control ">
                        </div>
                        <div class="checkout_address_group_p">
                            <div class="form-group checkout_address_group">
                                <label class="">City</label>
                                <input type="text" name="city" required placeholder="City" class="form-control ">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group checkout_address_group">
                                <label class="">Postcode</label>
                                <input type="text" name="postcode" required placeholder="Postcode" class="form-control " >
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group checkout_address_group">
                            <label class="">Telephone</label>
                            <input type="text" name="telephone"  placeholder="Telephone" class="form-control ">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="checkout_btn">
                    <div class="checkout_btn_l"><a href="/cart"><i class="common-iconfont icon-xiangl"></i>Return to cart</a></div>
                    <button type="submit">Continue to shipping</button>
                </div>
            </form>
        </div>
        <div class="checkout_r">
            @include('laravel-shop-front::checkout.right')
        </div>
    </div>

</div>
<style>
    .checkout_address_group_p{display: flex;justify-content: space-between;}
    .checkout_address_group_p>div{width: 48%;}

    .checkout_address_group select{height: 46px;line-height: 46px;}
    .checkout_address_group input{height: 46px;line-height: 46px;outline: none;transition: padding-top 0.5s;background: transparent}
    .checkout_address_group{width: 100%;position: relative;}
    .checkout_address_group label{position: absolute;top: 0;width: 100%;opacity: 1;z-index: -1;color: #999;transition: opacity 0.5s;line-height: 46px;}
    .checkout_address_group.form-group_show label{z-index: 1;padding: 0 10px;font-size: 12px;color: #999;line-height: 26px;}
    .checkout_address_group.form-group_show input{padding-top: 20px;}
    .checkout_address_group input:focus{border-color:#0178ff;box-shadow:none;outline: none;border-width: 2px;}
</style>
<script>
    let country_zone = {};
    let curr_address_id = {{$res['curr_address_id']}};
    $(function () {
        $('.my_address').on('click','li',function () {
            $('.my_address li').removeClass('active')
            $(this).addClass('active')
            //let address_id = $(this).data('id');
            //$('input[name="address_id"]').val(address_id)
            if($(this).data('id')===0){
                $('.country_option').attr("selected", false)
                $('#input-zone').html('<option value="0"> --- None --- </option>')
                document.getElementById("checkout_address").reset();
                $('.checkout_address_group').removeClass('form-group_show')
            }else{
                let obj = $(this).data();
                for(let i in obj){
                    let input = $('input[name="'+i+'"]')
                    input.val(obj[i])
                    input.parent().addClass('form-group_show')
                }
                let country_id = $(this).data('country_id');
                $('.country_option[value="'+country_id+'"]').attr("selected", true)
                let zone_id = $(this).data('zone_id');
                $('select[name="zone_id"]').attr('selected',false)
                setCountry(country_id,setZone,zone_id)
            }
        })

        $('.checkout_address_group').on('input','input',function () {
            if($(this).val()){
                $(this).parent().addClass('form-group_show')
            }else{
                $(this).parent().removeClass('form-group_show')
            }
        })

        $('#input-country').change(function () {
            let country_id = $(this).val();
            setCountry(country_id)
        })

        if(curr_address_id){
            $('.my_address li[data-id="'+curr_address_id+'"] label').click();
        }
    })

    function setZone(res,country_id,zone_id) {
        country_zone[country_id] = [];
        for(let i in res.data){
            country_zone[country_id].push(res.data[i])
        }
        makeZone(country_zone[country_id])
        $('#input-zone .zone_option[value="'+zone_id+'"]').attr("selected", true)
    }

    function setCountry(country_id,fn=false,zone_id=false) {
        if(country_id in country_zone){
            makeZone(country_zone[country_id])
            if(zone_id){
                $('#input-zone .zone_option[value="'+zone_id+'"]').attr("selected", true)
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
                            makeZone(country_zone[country_id])
                        }
                    }
                })
            }else{
                let html = '<option value="0"> --- None --- </option>';
                $('#input-zone').html(html)
            }
        }
    }
    function makeZone(data){
        //console.log(data)
        let html = '';
        if(data.length){
            html = '<option value="" class="zone_option"> --- Please Select --- </option>';
            for(let i in data){
                html += '<option class="zone_option" value="'+data[i].id+'">'+data[i].name+'</option>';
            }
        }else{
            html = '<option value="0" class="zone_option"> --- None --- </option>';
        }
        $('#input-zone').html(html)
    }
    function checkout_address(res,_this) {
        if(!res.code){
            location.href = res.data.redirect
        }else if(res.code===11000){
            form_err_11000(res,_this);
        }
    }
</script>
@include('laravel-shop-front::common.footer')
