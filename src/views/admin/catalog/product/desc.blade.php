<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
    <div>
        @include('laravel-shop::admin.catalog.product.submenu')
    </div>
</div>
<div class="imain">
    <form method="post" @if($res['product']->id) action="/shop_admin/product/desc?product_id={{$res['product']->id}}" @else action="/shop_admin/product/desc" @endif class="save_form">
        @csrf
        <div class="">

            <div class="form-group d-none" >
                <label for="">商品描述</label>
                <textarea name="description" id="content" class="form-control ">{{$res['product_desc']->description}}</textarea>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group ">
                <label for="">商品描述</label>
                <div id="editor—wrapper" style="z-index: 10">
                    <div id="editor-toolbar"></div>
                    <div id="editor-container"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="">meta_description</label>
                <input type="text" name="meta_description" class="form-control " value="{{$res['product_desc']->meta_description}}">
                <div class="invalid-feedback"></div>
            </div>
        </div>
        <button class="btn btn-primary" type="submit">保存</button>
    </form>
</div>

<script>
    $(function () {
        const { createEditor, createToolbar } = window.wangEditor
        const editorConfig = {
            onChange(editor) {
                $('#content').html(editor.getHtml());
            },
            MENU_CONF: {}
        }
        editorConfig.MENU_CONF['uploadImage'] = {
            server: '/news/img',
            fieldName: 'newsImg',
            maxFileSize: 1*1024*1024,
            maxNumberOfFiles: 10,
            allowedFileTypes: ['image/*'],
            meta: {
                _token: '{{csrf_token()}}'
            },
            metaWithUrl: true,
            withCredentials: false,
            timeout: 5 * 1000,
        }
        const editor = createEditor({
            selector: '#editor-container',
            html: `{!! $res['product_desc']->description !!}`,
            config: editorConfig,
            mode: 'simple',
        })
        const toolbarConfig = {}
        const toolbar = createToolbar({
            editor,
            selector: '#editor-toolbar',
            config: toolbarConfig,
            mode: 'simple',
        })
    })
</script>


