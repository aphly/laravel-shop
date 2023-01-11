@include('laravel-shop-front::common.header')
<section class="container">
    <style>
        .service_detail ul li{display: flex;margin-bottom: 5px;}
        .service_detail ul li>div{flex: 1;display: flex;align-items: center;}
    </style>
    <div class="account_info">
        @include('laravel-common-front::account_ext.left_menu')
        <div class="account-main-section">
            <div class="service_detail">
                <div class="top-desc d-flex justify-content-between">
                    <h2>Service</h2>
                </div>

                <div class="detail">
                    <div class="title">The service details</div>
                    <ul>
                        <li style="color:#777;">
                            <div>Date Added</div>
                            <div>Service Action</div>
                            <div>Service Status</div>
                            <div>Notes</div>
                        </li>
                        @if($res['serviceHistory'])
                            @foreach($res['serviceHistory'] as $val)
                                <li>
                                    <div>{{$val->created_at}}</div>
                                    <div>{{$dict['service_action'][$val->service_action_id]}}</div>
                                    <div>
                                        {{$dict[$dict['service_action'][$val->service_action_id].'_status'][$val->service_status_id]}}
                                    </div>
                                    <div>{{$val->comment}}</div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>

                @if($res['info']->service_action_id==1)
                    @if($res['info']->service_status_id==1)
                    @elseif($res['info']->service_status_id==2)
                    @elseif($res['info']->service_status_id==3)
                    @elseif($res['info']->service_status_id==4)
                    @elseif($res['info']->service_status_id==5)
                    @endif
                @elseif($res['info']->service_action_id==2)
                    @if($res['info']->service_status_id==1)
                    @elseif($res['info']->service_status_id==2)
                    @elseif($res['info']->service_status_id==3)
                    @elseif($res['info']->service_status_id==4)
                    @elseif($res['info']->service_status_id==5)
                    @endif
                @elseif($res['info']->service_action_id==3)
                    @if($res['info']->service_status_id==1)
                    @elseif($res['info']->service_status_id==2)
                    @elseif($res['info']->service_status_id==3)
                    @elseif($res['info']->service_status_id==4)
                    @elseif($res['info']->service_status_id==5)
                    @endif
                @endif

                <div class="detail">
                    <div class="title">The service details</div>
                    <ul>
                        <li><div>ID:</div><div>{{$res['info']->id}}</div></li>
                        <li><div>Date Added:</div><div>{{$res['info']->created_at}}</div></li>
                    </ul>
                </div>


                <div class="product">
                    @if($res['serviceProduct'])
                        <ul>
                            @foreach($res['serviceProduct'] as $val)
                                <li>
                                    <img src="{{$val->orderProduct->image}}" alt="">{{$val->orderProduct->name}}
                                    {{$val->quantity}}
                                </li>
                            @endforeach
                        </ul>
                    @endif
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
