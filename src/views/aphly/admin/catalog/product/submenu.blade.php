@if(isset($res['product']) && $res['product']->id)
    <?php
        $curr_path = request()->path();
    ?>
    <div style="display: flex;align-items: center;height: 100%;">
        <a class="badge @if($curr_path=='shop_admin/product/edit') badge-info @else badge-secondary @endif ajax_html" data-href="/shop_admin/product/edit?product_id={{$res['product']->id}}">编辑</a>
        <a class="badge @if($curr_path=='shop_admin/product/desc') badge-info @else badge-secondary @endif ajax_html" data-href="/shop_admin/product/desc?product_id={{$res['product']->id}}">描述</a>
        <a class="badge @if($curr_path=='shop_admin/product/special') badge-info @else badge-secondary @endif ajax_html" data-href="/shop_admin/product/special?product_id={{$res['product']->id}}">特价</a>
        <a class="badge @if($curr_path=='shop_admin/product/video') badge-info @else badge-secondary @endif ajax_html" data-href="/shop_admin/product/video?product_id={{$res['product']->id}}">视频</a>
        <a class="badge @if($curr_path=='shop_admin/product/img') badge-info @else badge-secondary @endif ajax_html" data-href="/shop_admin/product/img?product_id={{$res['product']->id}}">图片</a>
        <a class="badge @if($curr_path=='shop_admin/product/option') badge-info @else badge-secondary @endif ajax_html" data-href="/shop_admin/product/option?product_id={{$res['product']->id}}">选项</a>
        <a class="badge @if($curr_path=='shop_admin/product/links') badge-info @else badge-secondary @endif ajax_html" data-href="/shop_admin/product/links?product_id={{$res['product']->id}}">关联</a>
        <a class="badge @if($curr_path=='shop_admin/product/attribute') badge-info @else badge-secondary @endif ajax_html" data-href="/shop_admin/product/attribute?product_id={{$res['product']->id}}">属性</a>
        <a class="badge @if($curr_path=='shop_admin/product/discount') badge-info @else badge-secondary @endif ajax_html" data-href="/shop_admin/product/discount?product_id={{$res['product']->id}}">批发打折</a>
    </div>
@endif
