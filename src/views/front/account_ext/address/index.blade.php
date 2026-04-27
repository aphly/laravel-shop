@include('laravel-shop::front.common.header')
<style>
    .address_info{margin-bottom: 0px;}
    .address_info span{font-weight: 600;margin-left: 10px;}
    .address_info p{margin-bottom: 5px;}
    .address_info i{font-style: normal;width: 100px;display: inline-block}
    .address_infox i{margin-right: 5px;}
    .address_infox a{margin-right: 20px;}
    .my_btn_add_f{text-align: center}
    .my_btn_add{border-radius: 8px;padding: 10px 20px;width: 100%; display: block;background: var(--btn_bg); color: #fff;text-align: center;}
</style>
<div class="container">
    <div class="d-flex justify-content-between account_info">
        @include('laravel-shop::front.account.left_menu')
        <div class="account-main-section">
            <div class="">
                <div class="top-desc d-flex justify-content-between">
                    <h2>Delivery Address</h2>
                </div>
                <ul class="list_index">
                    @foreach($res['list'] as $val)
                    <li class="">
                        <div class="d-flex justify-content-between">
                            <div class="address_info">
                                <p><i>Name:</i> <span>{{$val['firstname']}} {{$val['lastname']}}</span></p>
                                <p><i>Address:</i> <span>{{$val['address_1']}} , {{$val['city']}} ,
                                        {{$val['zone_id']?$res['zone'][$val['zone_id']]['name']:''}} ,
                                        {{$res['country'][$val['country_id']]['name']}}</span></p>
                                <p><i>Postcode:</i> <span>{{$val['postcode']}}</span></p>
                                <p><i>Telephone:</i> <span>{{$val['telephone']}}</span></p>
                            </div>
                            <div class="">
                                @if($user->address_id == $val['id'])
                                    <span class="badge badge-success">default</span>
                                @endif
                            </div>
                        </div>
                        <div class="address_infox d-flex">
                            <a href="/account_ext/address/save?address_id={{$val['id']}}" class="my_btn">
                                <i class="common-iconfont icon-bianjishuru"></i>Edit
                            </a>
                            <a href="javascript:;" data-address_id="{{$val['id']}}" class="delete my_btn">
                                <i class="common-iconfont icon-shanchu"></i>Remove
                            </a>
                        </div>
                    </li>
                    @endforeach
                </ul>
                <div class="my_btn_f">
                    <a href="/account_ext/address/save" class="my_btn_add">
                        <i class="uni app-jia1"></i>
                    </a>
                </div>

                <div>
                    {{$res['list']->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(function () {
    $('.list_index').on('click','.delete',function () {
        if(isDel()){
            let id = $(this).data('address_id')
            if(id){
                $.ajax({
                    url:'/account_ext/address/'+id+'/remove',
                    dataType:'json',
                    success:function (res) {
                        alert_res(res)
                    }
                })
            }
        }
    })
})
</script>
@include('laravel-shop::front.common.footer')
