@include('laravel-shop-front::common.header')
<section class="container">
    <div class="account_info">
        @include('laravel-common-front::account_ext.left_menu')
        <div class="account-main-section">
            <div class="">
                <div class="top-desc d-flex justify-content-between">
                    <h2>Service</h2>
                </div>
                <ul class="list_index">
                    <li>
                        <span>Service ID</span>
                        <span>Order ID</span>
                        <span>Status</span>
                        <span>Received</span>
                        <span>Date Added</span>
                        <span>Option</span>
                    </li>
                    @foreach($res['list'] as $val)
                        <li class="">
                            <span>{{$val->id}}</span>
                            <span>{{$val->order_id}}</span>
                            <span>{{$dict[$dict['service_action'][$val->service_action_id].'_status'][$val->service_status_id]}}</span>
                            <span>{{$val->is_received}}</span>
                            <span>{{$val->created_at}}</span>
                            <span>
                                <a href="/account_ext/service/detail?id={{$val->id}}" class="btn">view</a>
                                @if($val->service_status_id==1)
                                <a href="/account_ext/service/del?id={{$val->id}}" class="btn a_request" data-fn="del_res" data-_token="{{csrf_token()}}">del</a>
                                @endif
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
    function del_res(res,_this) {
        alert_msg(res,true)
    }
$(function () {

})
</script>
@include('laravel-shop-front::common.footer')