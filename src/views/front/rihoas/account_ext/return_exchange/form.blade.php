@include('laravel-shop-front::common.header')
<section class="container">
    <style>

    </style>
    <div class="account_info">
        @include('laravel-common-front::account_ext.left_menu')
        <div class="account-main-section">
            <div class="order">
                <div class="top-desc d-flex justify-content-between">
                    <h2>Return Exchange</h2>
                </div>
                <form method="post" action="/account_ext/return_exchange/save?order_id={{$res['orderInfo']->id}}&product_id={{$res['orderProduct']->product_id}}" class="form_request" data-fn="return_res">
                    @csrf

                    <div>
                        <a href="/product/{{$res['orderProduct']->product_id}}">{{$res['orderProduct']->name}}</a>
                    </div>

                    <div class="d-flex">
                        <p>Action: <b>*</b></p>
                        @foreach($res['returnExchangeAction'] as $val)
                            <div class="form-group">
                                <input type="radio" name="return_exchange_action_id" id="return_exchange_action_id_{{$val['id']}}" required value="{{$val['id']}}" class="form-control" >
                                <label for="return_exchange_action_id_{{$val['id']}}">{{$val['name']}}</label>
                            </div>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <p>First Name: <b>*</b></p>
                        <input type="text" name="firstname" required value="{{$res['info']->firstname}}" placeholder="First Name" class="form-control" >
                    </div>

                    <div class="form-group">
                        <p>Last Name: <b>*</b></p>
                        <input type="text" name="lastname" required value="{{$res['info']->lastname}}" placeholder="Last Name" class="form-control">
                    </div>

                    <div class="form-group">
                        <p>Quantity: <b>*</b></p>
                        <input type="text" name="quantity" required value="{{$res['info']->quantity}}" placeholder="Quantity" class="form-control">
                    </div>

                    <div class="form-group">
                        <p>Telephone: <b>*</b></p>
                        <input type="text" name="telephone" required value="{{$res['info']->telephone}}" placeholder="Telephone" class="form-control">
                    </div>

                    <div class="form-group">
                        <p>Is opened: <b>*</b></p>
                        <select name="opened" class="form-control">
                        @if(isset($dict['yes_no']))
                            @foreach($dict['yes_no'] as $key=>$val)
                                <option value="{{$key}}" @if(($res['info']->opened??1)==$key) selected @endif>{{$val}}</option>
                            @endforeach
                        @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <p>Comment: <b>*</b></p>
                        <input type="text" name="comment" required value="{{$res['info']->comment}}" placeholder="Comment" class="form-control">
                    </div>

                    <div class="form-group d-flex">
                        <button class="btn-default  save-address" type="submit">Save</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</section>
<script>
$(function () {

})
</script>
@include('laravel-shop-front::common.footer')
