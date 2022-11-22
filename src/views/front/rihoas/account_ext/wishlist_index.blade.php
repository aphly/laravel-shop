@include('laravel-shop-front::common.header')
<div class="container">
    <div class="d-flex justify-content-between account_info">
        @include('laravel-common-front::account_ext.left_menu')
        <div class="account-main-section">
            <div class="">
                <div class="top-desc d-flex justify-content-between">
                    <h2>Wishlist</h2>
                </div>
                <ul class="list_index">
                    @foreach($res['list'] as $val)
                        <li class="">
                            <div class="d-flex justify-content-between">

                            </div>
                            <div class="address_infox">

                                <a href="javascript:;" data-product_id="{{$val['id']}}" class="delete">
                                    <i class="common-iconfont icon-shanchu"></i>Remove
                                </a>
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
</div>
<script>
$(function () {
    $('.list_index').on('click','.delete',function () {
        if(isDel()) {
            let id = $(this).data('product_id')
            if(id){
                $.ajax({
                    url: '/account/wishlist/' + id+'/remove',
                    dataType: 'json',
                    success: function (res) {
                        if (!res.code) {
                            location.href = res.data.redirect
                        } else {
                            alert_msg(res)
                        }
                    }
                })
            }
        }
    })
})
</script>
@include('laravel-shop-front::common.footer')
