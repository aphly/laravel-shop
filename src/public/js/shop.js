$(function () {
    $('.wishlist_one').on('click','i', function () {
        let product_id = $(this).data('product_id')
        product_id = parseInt(product_id);
        let _this = this
        debounce_fn(function () {
            wishlist_one(product_id,_this)
        },400,product_id,_this)
    })
})

function wishlist_one(product_id,_this) {
    let csrf = $(_this).data('csrf')
    if(product_id && csrf){
        $.ajax({
            url:'/wishlist/product/'+product_id,
            type:'post',
            data:{'_token':csrf},
            dataType: "json",
            success:function (res) {
                if(!res.code){
                    if($(_this).hasClass('icon-aixin_shixin')){
                        $(_this).removeClass('icon-aixin_shixin').addClass('icon-aixin')
                    }else{
                        $(_this).removeClass('icon-aixin').addClass('icon-aixin_shixin')
                    }
                    $('.wishlist_num').text(res.data.count)
                }
            }
        })
    }
}
