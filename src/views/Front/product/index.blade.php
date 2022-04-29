@include('laravel-shop::Front.common.header')
<style>
</style>

<div class="container">
    <ul class="row">
        @foreach($res['list'] as $key=>$val)
            <li class="col-lg-4">
                <div class="product-text">
                    <span class="product-icon-text-style2">New</span>
                </div>
                {{$val['name']}}
            </li>
        @endforeach
    </ul>
    <div>
        {{$res['list']->links('laravel-shop::common.pagination')}}
    </div>
</div>
<style>

</style>

<script>
$(function () {
    $('.filter-down').on('click','.filter_where',function () {
        let str = $(this).data('key')+'='+$(this).data('val')
        if($(this).hasClass("checked")){
            urlOption.__del(str,1)
        }else{
            urlOption.__set(str,1)
        }
    })
    $('.filter-down').on('click','.filter_orderby',function () {
        let str = $(this).data('key')+'='+$(this).data('val')
        if($(this).hasClass("checked")){
            urlOption._del('sort',$(this).data('key')+'_'+$(this).data('val'),1)
        }else{
            urlOption._set('sort',$(this).data('key')+'_'+$(this).data('val'),1)
        }
    })
    $('.product-img img').on({
        mouseover : function(){
            $(this).attr('src',$(this).data('src'));
        },
        mouseout : function(){
            $(this).attr('src',$(this).data('original'));
        }
    })
})
</script>

@include('laravel-shop::Front.common.footer')
