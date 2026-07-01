<div class="size-guide-content">

    @if(in_array(5,$res['info_category']))
        <div style="text-align: center;">
            <a href="/size_guide" style="font-weight: 600; padding: 10px;background: #d9d9d9; border-radius: 8px;">Size Guide Link</a>
        </div>
    @elseif(in_array(1,$res['info_category']))
        <div class="size_guide_title">
            Size Guide
        </div>
        @include('laravel-shop::front.product.aphly.size_guide_necklace')
    @elseif(in_array(2,$res['info_category']))
        <div class="size_guide_title">
            Size Guide
        </div>
        @include('laravel-shop::front.product.aphly.size_guide_ring')
    @elseif(in_array(3,$res['info_category']))
        <div class="size_guide_title">
            Size Guide
        </div>
        @include('laravel-shop::front.product.aphly.size_guide_bracelet')
    @else
        <div style="text-align: center;">
            <a href="/size_guide" style="font-weight: 600; padding: 10px;background: #d9d9d9; border-radius: 8px;">Size Guide Link</a>
        </div>
    @endif
</div>

<style>
    .size-guide-content{margin-top: 20px;}

    .size_guide_title{font-weight: 600;font-size: 18px;text-align: center}
    .size-guide-content .content-items{display:block;overflow-y: auto;}
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

