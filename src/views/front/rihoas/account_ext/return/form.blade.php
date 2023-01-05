@include('laravel-shop-front::common.header')
<section class="container">
    <style>

    </style>
    <div class="account_info">
        @include('laravel-common-front::account_ext.left_menu')
        <div class="account-main-section">
            <div class="order">
                <div class="top-desc d-flex justify-content-between">
                    <h2>Return</h2>
                </div>
                <form method="post" action="/account_ext/return/form?id={{request()->query('id')??0}}" class="form_request" data-fn="return_res">
                    @csrf
                    <input type="hidden" name="address_id" value="{{request()->query('address_id')??0}}">
                    <div class="form-group">
                        <p>First Name: <b>*</b></p>
                        <input type="text" name="firstname" required value="{{$res['info']->firstname}}" placeholder="First Name" class="form-control" >
                    </div>
                    <div class="form-group">
                        <p>Last Name: <b>*</b></p>
                        <input type="text" name="lastname" required value="{{$res['info']->lastname}}" placeholder="Last Name" class="form-control">
                    </div>

                    <div class="form-group">
                        <p>Address Line1: <b>*</b></p>
                        <input required name="address_1" type="text" class="form-control address1" value="{{$res['info']->address_1}}" placeholder="Address 1" >
                    </div>
                    <div class="form-group">
                        <div class=" ">
                            <p>Address Line2: </p>
                            <input name="address_2" type="text" class="form-control address2" value="{{$res['info']->address_2}}" placeholder="Address 2">
                        </div>
                    </div>
                    <div class="form-group">
                        <p>City: <b>*</b></p>
                        <input required name="city" type="text" class="form-control city" value="{{$res['info']->city}}" placeholder="City" >
                    </div>
                    <div class="form-group">
                        <p>Post Code: <b>*</b></p>
                        <input required name="postcode" value="{{$res['info']->postcode}}" placeholder="Post Code" type="text" class="form-control postcode">
                    </div>

                    <div class="form-group is-valid">
                        <p>State / Province: <b>*</b></p>
                        <select name="zone_id" required id="input-zone" class="form-control country ">
                            @if($res['zone'])
                                <option value=""> --- Please Select --- </option>
                                @foreach($res['zone'] as $val)
                                    <option value="{{$val['id']}}" @if($val['id']==$res['info']->zone_id) selected @endif>{{$val['name']}}</option>
                                @endforeach
                            @else
                                <option value=""> --- None --- </option>
                            @endif
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>


                    <div class="form-group d-flex">
                        <button class="btn-default  save-address" type="submit">Save</button>
                        <a href="/account_ext/address" class="btn-cancel">Cancel</a>
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
