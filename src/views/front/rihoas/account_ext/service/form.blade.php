@include('laravel-shop-front::common.header')
<section class="container">

    <div class="account_info">
        @include('laravel-common-front::account_ext.left_menu')
        <div class="account-main-section">
            <div class="order">

                <div class="top-desc d-flex justify-content-between">
                    <h2>Service</h2>
                </div>

                <div class="form-group">
                    <p>Is received: <b>*</b></p>
                    <ul class="received">
                        <li value="1">yes</li>
                        <li value="2">no</li>
                    </ul>
                </div>

                <form action="/account_ext/service/save?order_id={{$res['orderInfo']->id}}" method="post" class="form_request received1 received_form" data-fn="refund_res">
                    @csrf
                    <input type="hidden" name="is_received" value="2">
                    <input type="hidden" name="service_action_id" value="1">
                    <div>
                        <ul>
                            @foreach($dict['refund_reason'] as $key=>$val)
                            <li>
                                <input type="radio" name="service_reason_id" id="refund_reason_id_{{$key}}" value="{{$key}}">
                                <label for="refund_reason_id_{{$key}}">{{$val}}</label>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="form-group" >
                        <p>Reason: <b>*</b></p>
                        <textarea name="reason" required class="form-control">{{$res['info']->reason}}</textarea>
                    </div>
                    <div class="form-group d-flex">
                        <button class="btn-default save-address" type="submit">Request</button>
                    </div>
                </form>

                <form action="/account_ext/service/save?order_id={{$res['orderInfo']->id}}" method="post" class="form_request received2 received_form d-none" data-fn="return_res">
                    @csrf
                    <input type="hidden" name="is_received" value="1">
                    <div>
                        <input type="radio" name="service_action_id" id="service_action_id_2" required value="2" class="form-control">
                        <label for="service_action_id_2">Return</label>
                        <input type="radio" name="service_action_id" id="service_action_id_3" required value="3" class="form-control">
                        <label for="service_action_id_3">Exchange</label>
                    </div>

                    <ul class="service_product">
                        @foreach($res['orderProduct'] as $val)
                        <li>
                            <input type="checkbox" name="order_product[{{$val->id}}][id]" id="service_product_{{$val->id}}" checked value="{{$val->id}}">
                            <label for="service_product_{{$val->product_id}}">{{$val->name}} (quantity:{{$val->quantity}})</label>
                            <input type="number" name="order_product[{{$val->id}}][quantity]" onblur="if(value<1){value=1}else if(value>={{$val->quantity}}){value={{$val->quantity}}}" value="{{$val->product_id}}">
                        </li>
                        @endforeach
                    </ul>

                    <div class="form-group">
                        <p>Is opened: <b>*</b></p>
                        @if(isset($dict['yes_no']))
                        <select name="is_opened" class="form-control">
                            @foreach($dict['yes_no'] as $key=>$val)
                                <option value="{{$key}}" @if(($res['info']->is_opened??1)==$key) selected @endif>{{$val}}</option>
                            @endforeach
                        </select>
                        @endif
                    </div>

                    <div class="form-group" >
                        <p>Reason: <b>*</b></p>
                        <textarea name="reason" required class="form-control">{{$res['info']->reason}}</textarea>
                    </div>

                    <div class="form-group d-flex">
                        <button class="btn-default  save-address" type="submit">Request</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</section>

<script>
    function refund_res(res,_this) {
        alert_msg(res,true)
    }

    function return_res(res,_this) {
        alert_msg(res,true)
    }

$(function () {
    $('.received').on('click','li',function () {
        $('.received_form').addClass('d-none')
        $('.received'+$(this).val()).removeClass('d-none')
    })
})
</script>

@include('laravel-shop-front::common.footer')
