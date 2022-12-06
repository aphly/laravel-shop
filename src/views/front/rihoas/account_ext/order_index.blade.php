@include('laravel-shop-front::common.header')
<section class="container">
    <style>

    </style>
    <div class="account_info">
        @include('laravel-common-front::account_ext.left_menu')
        <div class="account-main-section">
            <div class="">
                <div class="top-desc d-flex justify-content-between">
                    <h2>Order</h2>
                </div>
                <ul class="list_index">
                    <li>
                        <span>Order ID</span>
                        <span>Order Status</span>
                        <span>Date Added</span>
                        <span>No. of Products</span>
                        <span>Total</span>
                        <span>Option</span>
                    </li>
                    @foreach($res['list'] as $val)
                        <li class="">
                            <span>{{$val->id}}</span>
                            <span>{{$val->orderStatus->name}}</span>
                            <span>{{$val->created_at}}</span>
                            <span>{{$val->items}}</span>
                            <span>{{$val->total_format}}</span>
                            <span><a href="/account/order/detail?id={{$val->id}}">view</a></span>
                        </li>
                    @endforeach
                </ul>
                <div>
                    {{$res['list']->links('laravel-common-front::common.pagination')}}
                </div>
            </div>
        </div>
    </div>
</section>
<script>
$(function () {

})
</script>
@include('laravel-shop-front::common.footer')
