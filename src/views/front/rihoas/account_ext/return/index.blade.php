@include('laravel-shop-front::common.header')
<section class="container">
    <div class="account_info">
        @include('laravel-common-front::account_ext.left_menu')
        <div class="account-main-section">
            <div class="">
                <div class="top-desc d-flex justify-content-between">
                    <h2>Return</h2>
                    <a href="/account_ext/return/form">+ Add</a>
                </div>
                <ul class="list_index">
                    <li>
                        <span>Return ID</span>
                        <span>Product</span>
                        <span>Order ID</span>
                        <span>Opened</span>
                        <span>Date Added</span>
                        <span>Option</span>
                    </li>
                    @foreach($res['list'] as $val)
                        <li class="">
                            <span>{{$val->id}}</span>
                            <span><a href="/product/{{$val->product->id}}">{{$val->product->name}}</a></span>
                            <span>{{$val->order_id}}</span>
                            <span>{{$val->opened}}</span>
                            <span>{{$val->created_at}}</span>
                            <span>
                                <a href="/account_ext/return/detail?id={{$val->id}}" class="btn">view</a>
                                <a href="/account_ext/return/form?id={{$val->id}}" class="btn">edit</a>
                                <a href="/account_ext/return/del?id={{$val->id}}" class="btn">del</a>
                            </span>
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
<style>
    .list_index{padding: 0 10px;}
    .list_index li{display: flex;margin-bottom: 0;height: 40px;line-height: 40px;}
    .list_index li span{flex:1;}
    .list_index li span .btn{display: inline-block;background-color: var(--default-bg);padding:0 10px;color: #fff;border-radius: 4px;height: 30px;line-height: 30px;}
</style>
<script>
$(function () {

})
</script>
@include('laravel-shop-front::common.footer')
