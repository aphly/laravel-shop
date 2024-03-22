@include(config('base.view_namespace_front_blade').'::common.header')
<section class="container">
    <style>
        .wishlist_img{width: 80px;height: 80px;margin-right: 20px;}
        .wishlist_img img{width: 100%;height: 100%;border-radius: 4px;}
        .wishlist_name{margin-bottom: 10px;}
        .delete i{margin-right: 5px;}
    </style>
    <div class="account_info">
        @include(config('base.view_namespace_front_blade').'::account.left_menu')
        <div class="account-main-section">
            <div class="">
                <div class="top-desc d-flex justify-content-between">
                    <h2>Wishlist</h2>
                </div>
                <ul class="list_index">
                    @foreach($res['list'] as $val)
                        <li class="">
                            <div class="d-flex align-items-center">
                                <div class="wishlist_img">
                                    <a href="/product/{{$val['product_id']}}"><img src="{{$res['productData'][$val['product_id']]->image_src}}" alt=""></a>
                                </div>
                                <div style="margin-right: auto;">
                                    <a href="/product/{{$val['product_id']}}"><div class="wishlist_name">{{$res['productData'][$val['product_id']]->name}}</div></a>
                                    <div class="d-flex price">
                                        @if($res['productData'][$val['product_id']]->special)
                                            <span class="normal">{{$res['productData'][$val['product_id']]->special}}</span>
                                            <span class="special_price">{{$res['productData'][$val['product_id']]->price}}</span>
                                            <span class="price_sale">Sale</span>
                                        @else
                                            @if($res['productData'][$val['product_id']]->discount)
                                                <span class="normal">{{$res['productData'][$val['product_id']]->discount}}</span>
                                                <span class="special_price">{{$res['productData'][$val['product_id']]->price}}</span>
                                                <span class="price_sale">Sale</span>
                                            @else
                                                <span class="normal">{{$res['productData'][$val['product_id']]->price}}</span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <a href="javascript:;" data-id="{{$val['id']}}" class="delete">
                                        <i class="common-iconfont icon-shanchu" ></i>Remove
                                    </a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div>
                    {{$res['list']->links()}}
                </div>
            </div>
        </div>
    </div>
</section>
<script>
$(function () {
    $('.list_index').on('click','.delete',function () {
        if(isDel()) {
            let id = $(this).data('id')
            if(id){
                $.ajax({
                    url: '/account_ext/wishlist/'+id+'/remove',
                    dataType: 'json',
                    type:'post',
                    data:{'_token':'{{csrf_token()}}'},
                    success: function (res) {
                        if (!res.code) {
                            location.reload()
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
@include(config('base.view_namespace_front_blade').'::common.footer')
