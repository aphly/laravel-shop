<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<style>
    .table_scroll .table_header li:nth-child(2),.table_scroll .table_tbody li:nth-child(2){flex: 0 0 300px;}
</style>
<div class="imain">
    <div class="itop ">
        <form method="get" action="/shop_admin/after_sales/index" class="select_form">
        <div class="search_box ">
            <input type="search" name="id" placeholder="id" value="{{$res['search']['id']}}">
            <input type="search" name="order_id" placeholder="order_id" value="{{$res['search']['order_id']}}">
            <select name="status"   >
                <option value="" selected>全部</option>
                @foreach($dict['after_sales_status'] as $key=>$val)
                    <option value="{{$key}}" @if($res['search']['status']==$key) selected @endif>{{$val}}</option>
                @endforeach
            </select>
            <button class="" type="submit">搜索</button>
        </div>
        </form>
        <div class="">
            <a class="badge badge-primary ajax_html show_all0_btn d-none" data-href="/shop_admin/after_sales/form">添加</a>
        </div>
    </div>

    <form method="post"  @if($res['search']['string']) action="/shop_admin/after_sales/del?{{$res['search']['string']}}" @else action="/shop_admin/after_sales/del" @endif  class="del_form">
    @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >ID</li>
                    <li >uid</li>
                    <li >order_id</li>
                    <li >时间</li>
                    <li >状态</li>
                    <li >操作</li>
                </ul>
                @if($res['list']->total())
                    @foreach($res['list'] as $v)
                    <ul class="table_tbody">
                        <li><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['id']}}">{{$v['id']}}</li>
                        <li>{{ $v['uid'] }}</li>
                        <li>{{ $v['order_id'] }}</li>
                        <li>{{$dict['after_sales_status'][$v->status]}}</li>
                        <li>{{$v->created_at->timezone('Asia/Shanghai')}}</li>
                        <li>
                            <a class="badge badge-info ajax_html" data-href="/shop_admin/after_sales/view?id={{$v['id']}}">查看</a>
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

<script>

</script>
