<div class="top-bar">
    <h5 class="nav-title">商品管理</h5>
</div>
<style>
    .table_scroll .table_header li:nth-child(4),.table_scroll .table_tbody li:nth-child(4){flex: 0 0 300px;}
    .manager_role{background: #2878a7; color: #fff; border-radius: 4px; padding: 0 2px;}
</style>
<div class="imain">
    <div class="itop ">
        <form method="get" action="/shop_admin/product/index" class="select_form">
        <div class="filter ">
            <input type="search" name="name" placeholder="商品名称" value="{{$res['filter']['name']}}">
            <select name="status" >
                @if(isset($dict['product_status']))
                    <option value="0" @if(!$res['filter']['status']) selected @endif>全部</option>
                    @foreach($dict['product_status'] as $key=>$val)
                        <option value="{{$key}}" @if($res['filter']['status']==$key) selected @endif>{{$val}}</option>
                    @endforeach
                @endif
            </select>
            <button class="" type="submit">搜索</button>
        </div>
        </form>
        <div class=""><a data-href="/shop_admin/product/form" class="badge badge-info ajax_get add">新增</a></div>
    </div>

    <form method="post"  @if($res['filter']['string']) action="/shop_admin/product/del?{{$res['filter']['string']}}" @else action="/shop_admin/product/del" @endif  class="del_form">
    @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >ID</li>
                    <li >商品名称</li>
                    <li >图片</li>
                    <li ></li>
                    <li >状态</li>
                    <li >操作</li>
                </ul>
                @if($res['list']->total())
                    @foreach($res['list'] as $v)
                    <ul class="table_tbody">
                        <li><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['id']}}">{{$v['id']}}</li>
                        <li>{{$v['name']}}</li>
                        <li>

                        </li>
                        <li>
                            搜索
                        </li>
                        <li>
                            @if($dict['product_status'])
                                @if($v->status==1)
                                    <span class="badge badge-success">{{$dict['product_status'][$v->status]}}</span>
                                @else
                                    <span class="badge badge-secondary">{{$dict['product_status'][$v->status]}}</span>
                                @endif
                            @endif
                        </li>
                        <li>
                            <a class="badge badge-info ajax_get" data-href="/shop_admin/product/form?id={{$v['id']}}">编辑</a>
                            <a class="badge badge-info ajax_get" data-href="/shop_admin/product/desc_form?product_id={{$v['id']}}">描述</a>
                            <a class="badge badge-info ajax_get" data-href="/shop_admin/product/{{$v['id']}}/img">图片</a>
                        </li>
                    </ul>
                    @endforeach
                    <ul class="table_bottom">
                        <li>
                            <input type="checkbox" class="delete_box deleteboxall"  onclick="checkAll(this)">
                            <button class="badge badge-danger del" type="submit">删除</button>
                        </li>
                        <li>
                            {{$res['list']->links('laravel-admin::common.pagination')}}
                        </li>
                    </ul>
                @endif
            </div>
        </div>

    </form>
</div>

