@include('laravel-shop::front.common.header')

<div class="container " style="margin-top: 20px;">
    <div style="line-height: 50px;text-align: center;font-size: 22px;margin-bottom: 20px;font-weight: 600;">Size Guide</div>
    <div id="size-chart">
        <ul class="size-guide-navs">
            <li class="nav-items select" data-nav-key="ringSize">Ring</li>
            <li class="nav-items" data-nav-key="braceletSize">Bracelet</li>
            <li class="nav-items" data-nav-key="necklaceSize">Necklace</li>
        </ul>
        <div class="separator">&nbsp;</div>
        <div class="size-guide-content">
            @include('laravel-shop::front.product.aphly.size_guide_ring')
            @include('laravel-shop::front.product.aphly.size_guide_bracelet')
            @include('laravel-shop::front.product.aphly.size_guide_necklace')
        </div>
    </div>
</div>
<style>
    .size-guide-navs{display:flex}
    .size-guide-navs .nav-items{flex:1;font-size:14px;background-color:#eee;padding:10px;margin-right:5px;text-align:center;cursor:pointer;border-radius: 4px}
    .size-guide-navs .nav-items.select{background-color:#df9494;color:#fff}

    .size-guide-content{margin-top: 20px;}
    .size_guide_title{font-weight: 600;font-size: 18px;text-align: center}
    .size-guide-content .content-items{display:none}
    .size-guide-content .content-items.select{display:block; overflow-y: auto;}
    .separator{margin:10px;height:1px}
    .size-guide-content .content-items .short-describe{margin:10px 0;font-size:14px;color:#222;}
    .size-guide-content .content-items .steps-list .items{display:flex;margin-bottom:20px;flex-wrap: wrap;}
    .content-items .notes-wrapper{margin-bottom:20px}
    .size-guide-content .content-items .steps-list .items .media{width:100%}
    .size-guide-content .content-items .steps-list .items .media img{}
    .size-guide-content .content-items .steps-list .items .step-describe{width:100%}
    .size-guide-content .content-items .steps-list .items .step-describe .step-title{font-size:14px;font-weight:600;color:#444;margin-bottom:15px}
    .size-guide-content .content-items .notes-wrapper .notes-title{font-size:15px;font-weight:600;margin-bottom:10px}
    .size-guide-content .content-items .notes-wrapper .notes-list .items,.step-content{font-size:14px;color:#222;}
    .size-guide-content .content-items .notes-wrapper .notes-list .items .num{margin-right:10px}
    .size-guide-content .content-items .table-wrapper{border-top:1px solid #ccc;overflow-x:auto;overflow-y:hidden;width:100%;-ms-overflow-style:-ms-autohiding-scrollbar;-webkit-overflow-scrolling:touch;margin-bottom:20px;position:static;border-top:none}
    .size-guide-content .content-items table{width:100%;text-align: center;}
    .size-guide-content .content-items .table-wrapper table.size-table th,.size-guide-content .content-items .table-wrapper table.size-table td{padding:10px 0;text-align:center;font-size:14px;overflow:hidden;text-overflow:ellipsis;word-break:break-word;border:1px solid #ddd;}
    .size-guide-content .content-items .table-wrapper table.necklace-size-table thead th:last-child{width:50%}
    .size-guide-content .content-items .table-wrapper table.necklace-size-table tbody>tr:nth-of-type(even){background-color:#f4f4f4}
    .size-guide-content .content-items .table-wrapper table.size-table th{background-color:#f4f4f4}
</style>
<script type="text/javascript">
    $(function () {
        $(".size-guide-navs .nav-items").click(function () {
            var index = jQuery(".size-guide-navs .nav-items").index(this);
            $(this).addClass("select").siblings().removeClass("select");
            $(".size-guide-content .content-items")
                .eq(index)
                .addClass("select")
                .siblings()
                .removeClass("select");
        });
        $('.size-guide-navs .nav-items:first').click()
    });''
</script>
@include('laravel-shop::front.common.footer')
