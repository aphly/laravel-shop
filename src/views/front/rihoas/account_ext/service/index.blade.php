@include('laravel-shop-front::common.header')
<section class="container">
    <div class="account_info">
        @include('laravel-common-front::account_ext.left_menu')
        <div class="account-main-section" style="background: transparent;">
            <div class="">
                <div class="top-desc d-flex justify-content-between">
                    <h2>My Service</h2>
                </div>
                <ul class="list_index">
                    @foreach($res['list'] as $val)
                        <li class="">
                            <div class="d-flex justify-content-between">
                                <span>Service ID</span>
                                <span>{{$val->id}}</span>
                            </div>

                            <div class="d-flex justify-content-between">
                                <span>Status</span>
                                <span>{{$dict[$dict['service_action'][$val->service_action_id].'_status'][$val->service_status_id]}}</span>
                            </div>

                            <div class="d-flex justify-content-between">
                                <span>Order ID</span>
                                <span>{{$val->order_id}}</span>
                            </div>

                            <div class="d-flex justify-content-between">
                                <span>Date Added</span>
                                <span>{{$val->created_at}}</span>
                            </div>

                            <div class="service_list_btn">
                                <a href="/account_ext/service/detail?id={{$val->id}}" class="btn">Detail</a>
                                @if($val->service_status_id==1)
                                    <a href="/account_ext/service/del?id={{$val->id}}" class="btn a_request" data-fn="del_res" data-_token="{{csrf_token()}}">Del</a>
                                @endif
                            </div>
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
    .list_index{}
    .list_index li{margin-bottom: 10px;background: #fff;border-radius: 8px;padding: 15px;border: 1px solid #f1f1f1;}
    .list_index li>div{line-height: 26px;}
    .service_list_btn{margin-top: 10px;display: flex;flex-direction: row-reverse;padding-top: 10px;}
    .service_list_btn a{display:block;padding:0px 10px;border-radius:4px;border:1px solid #333;margin-left:20px;line-height: 34px;}
</style>
<script>
    function del_res(res,_this) {
        alert_msg(res,true)
    }
$(function () {

})
</script>
@include('laravel-shop-front::common.footer')
