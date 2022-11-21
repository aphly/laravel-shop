@include('laravel-shop-front::common.header')
<div class="container">
    <nav aria-label="breadcrumb" class="row col-12 mt-lg-3">
        <ol class="breadcrumb breadcrumb-wrapper col-12 m-0 pt-0 pb-0 font-14">
            <li class="breadcrumb-item"><a href="/index"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="/customer/account">Account</a></li>
            <li class="breadcrumb-item"><a href="/customer/wishlist">Wishlist</a></li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between">
        @include('laravel-shop-front::customer.leftmenu')
        <div class="main-section">
            <div class="gs-account">
                <div class="top-desc text-left">
                    <h1 class="d-flex justify-content-between">
                        Wishlist
                    </h1>
                </div>
                <div class="row account-info wishlist">
                    @foreach($res['list'] as $val)
                    <div class="col-12 mt-5">
                        <p class="address-name">Name: {{$val['firstname']}} {{$val['lastname']}} @if($res['customer']['address_id'] == $val['id']) <span class="badge badge-success pull-right">default</span> @endif</p>
                        <p class="address-cont">Address: {{$val['address_1']}} , {{$val['address_2']}} , {{$val['city']}} , {{$val['firstname']}} , {{$res['zone'][$val['zone_id']]['name']??''}} , {{$res['country'][$val['country_id']]['name']??''}}</p>
                        <p class="address-phone">Postcode: {{$val['postcode']}}</p>
                        <p class="col01">
                            <a href="/customer/address/save?address_id={{$val['id']}}">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <a href="javascript:;" data-product_id="{{$val['product_id']}}" class="delete ml-5">
                                <i class="fa fa-trash"></i> Remove
                            </a>
                        </p>
                    </div>
                    @endforeach
                </div>
                <div>
                    {{$res['list']->links('laravel-shop::common.pagination')}}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(function () {
    $('.wishlist').on('click','.delete',function () {
        let id = $(this).data('product_id')
        $.ajax({
            url:'/customer/wishlist/remove/'+id,
            dataType:'json',
            success:function (res) {
                if(!res.code) {
                    location.href = res.data.redirect
                }else{
                    alert_msg(res)
                }
            }
        })
    })
})
</script>
@include('laravel-shop-front::common.footer')
