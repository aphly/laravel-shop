@include('laravel-shop-front::common.header')
<section class="container">

    <div class="account_info">
        @include('laravel-common-front::account_ext.left_menu')
        <div class="account-main-section">
            <div class="order">
                // /account_ext/return_exchange/save?order_id={{$res['orderInfo']->id}}
                <div class="top-desc d-flex justify-content-between">
                    <h2>Refund</h2>
                </div>

                <div class="form-group">
                    <p>Is received: <b>*</b></p>
                    @if(isset($dict['yes_no']))
                        <select name="received" class="form-control">
                            @foreach($dict['yes_no'] as $key=>$val)
                                <option value="{{$key}}" @if(($res['info']->received??1)==$key) selected @endif>{{$val}}</option>
                            @endforeach
                        </select>
                    @endif
                </div>

                <form action="/account_ext/service/refund?order_id={{$res['orderInfo']->id}}" method="post" class="form_request" data-fn="refund_res">
                    @csrf
                    <input type="hidden" name="is_received" value="2">
                    <input type="hidden" name="return_exchange_action_id" value="1">
                    <div class="form-group" >
                        <p>Reason: <b>*</b></p>
                        <textarea name="reason" required class="form-control">{{$res['info']->reason}}</textarea>
                    </div>
                    <div class="form-group d-flex">
                        <button class="btn-default save-address" type="submit">Request</button>
                    </div>
                </form>



            </div>
        </div>
    </div>
</section>

<script>
    function refund_res(res,form_class) {

    }


$(function () {

})
</script>

@include('laravel-shop-front::common.footer')
