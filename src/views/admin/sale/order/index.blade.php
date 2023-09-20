<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<style>
    .table_scroll .table_header li:nth-child(2),.table_scroll .table_tbody li:nth-child(2){flex: 0 0 300px;}
</style>
<div class="imain">
    <div class="itop ">
        <form method="get" action="/shop_admin/order/index" class="select_form">
        <div class="search_box ">
            <input type="search" name="id" placeholder="id" value="{{$res['search']['id']}}">
            <input type="search" name="email" placeholder="email" value="{{$res['search']['email']}}">
            <select name="status">
                <option value="">全部</option>
                @foreach($res['orderStatus'] as $val)
                <option value="{{$val->id}}" @if($res['search']['status']==$val->id) selected @endif>{{$val->cn_name}}</option>
                @endforeach
            </select>
            <button class="" type="submit">搜索</button>
        </div>
        </form>
        <div class="">
            <a class="badge badge-primary xls_download show_all0_btn" data-href="/shop_admin/order/download?{{$res['search']['string']}}">下载</a>
            <a class="badge badge-primary  show_all0_btn" href="javascript:void(0)" onclick="$('#shipped').modal('show');">上传物流</a>
        </div>
    </div>

    <form method="post"  @if($res['search']['string']) action="/shop_admin/order/del?{{$res['search']['string']}}" @else action="/shop_admin/order/del" @endif  class="del_form">
    @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >ID</li>
                    <li >邮箱</li>
                    <li >总计</li>
                    <li >国家</li>
                    <li >日期</li>
                    <li >状态</li>
                    <li >操作</li>
                </ul>
                @if($res['list']->total())
                    @foreach($res['list'] as $v)
                    <ul class="table_tbody">
                        <li><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['id']}}">{{$v['id']}}</li>
                        <li>{{ $v['email'] }}</li>
                        <li>{{ $v['total_format'] }}</li>
                        <li>{{ $v['address_country'] }}</li>
                        <li>{{ $v['created_at'] }}</li>
                        <li>{{ $v->orderStatus->name }}</li>
                        <li>
                            <a class="badge badge-info ajax_html" data-href="/shop_admin/order/view?id={{$v['id']}}">查看</a>
                        </li>
                    </ul>
                    @endforeach
                    <ul class="table_bottom">
                        <li>
                            <input type="checkbox" class="delete_box deleteboxall"  onclick="checkAll(this)">
                            <button class="badge badge-danger del" type="submit">删除</button>
                        </li>
                        <li >
                            {{$res['list']->links('laravel::admin.pagination')}}
                        </li>
                    </ul>
                @endif
            </div>
        </div>

    </form>
</div>


<div class="modal fade ajax_modal" id="shipped" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">上传物流单号</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="/shop_admin/order/shipped" class="save_form_file" enctype="multipart/form-data" data-fn="save_form_file_res">
                    @csrf
                    <div class="">
                        <div class="form-group">
                            <label for="">选择</label>
                            <input type="file" class="form-control-file" name="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                        </div>
                        <button class="btn btn-primary" type="submit">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function save_form_file_res(res, that) {
        //console.log(res,that)
        alert_msg(res);
        $('#shipped').modal('hide');
    }
</script>
