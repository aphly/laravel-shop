@include('laravel-shop-front::common.header')
<section class="container">

    <div class="account_info">
        @include('laravel-common-front::account_ext.left_menu')
        <div class="account-main-section">
            <div class="order">

                <div class="top-desc d-flex justify-content-between">
                    <h2>Return Exchange</h2>
                </div>

                <div class="form-group">
                    <p>Is received: <b>*</b></p>
                    <ul>
                        <li>yes</li>
                        <li>no</li>
                    </ul>
                </div>

                <form action="/account_ext/service/refund?order_id={{$res['orderInfo']->id}}" method="post" class="form_request" data-fn="refund_res">
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

                <form action="/account_ext/service/return_exchange?order_id={{$res['orderInfo']->id}}" method="post" class="form_request" data-fn="return_res">
                    @csrf
                    <input type="hidden" name="is_received" value="1">
                    <div>
                        <input type="radio" name="return_exchange_action_id" id="return_exchange_action_id_2" required value="2" class="form-control">
                        <label for="return_exchange_action_id_2">return</label>
                        <input type="radio" name="return_exchange_action_id" id="return_exchange_action_id_3" required value="3" class="form-control">
                        <label for="return_exchange_action_id_3">exchange</label>
                    </div>
                    <ul>
                        @foreach($res['orderProduct'] as $val)
                        <li>
                            <a href="/product/{{$val->product_id}}">{{$val->name}}</a>
                            <input type="checkbox" name="product[]" value="{{$val->product_id}}">
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
    function refund_res(res,form_class) {

    }

    function return_res(res,form_class) {

    }

$(function () {

})
</script>

@include('laravel-shop-front::common.footer')
