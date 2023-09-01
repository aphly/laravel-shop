
<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<div class="imain">
    <form method="post" @if($res['info']->id) action="/shop_admin/information/save?id={{$res['info']->id}}" @else action="/shop_admin/information/save" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">标题</label>
                <input type="text" name="title" required class="form-control " value="{{$res['info']->title}}">
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group d-none" >
                <label for="">内容</label>
                <textarea name="content" id="content" class="form-control ">{{$res['info']->content}}</textarea>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group ">
                <label for="">内容</label>
                <div id="editor—wrapper" style="z-index: 10">
                    <div id="editor-toolbar"></div>
                    <div id="editor-container"></div>
                </div>
            </div>

            <div class="form-group" id="status">
                <label for="">状态</label>
                <select name="status" class="form-control">
                    @foreach($dict['status'] as $key=>$val)
                        <option value="{{$key}}" @if($key===$res['info']->status) selected @endif>{{$val}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>

            <div class="form-group">
                <label for="">查看数</label>
                <input type="number" name="viewed" class="form-control " value="{{$res['info']->viewed??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
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
            server: '/shop_admin/information/img',
            fieldName: 'img',
            maxFileSize:{{$res['imgSize']}}*1024*1024,
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
            html: `{!! $res['info']->content !!}`,
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
