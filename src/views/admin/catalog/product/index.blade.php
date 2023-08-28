<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<style>
    .table_scroll .table_header li:nth-child(3),.table_scroll .table_tbody li:nth-child(3){flex: 0 0 100px;}
    .table ul.table_header li:last-child, .table ul.table_tbody li:last-child{flex: 0 0 500px;}
</style>
<div class="imain">
    <div class="itop ">
        <form method="get" action="/shop_admin/product/index" class="select_form">
        <div class="search_box ">
            <input type="search" name="name" placeholder="商品名称" value="{{$res['search']['name']}}">
            <select name="status" >
                @if(isset($dict['product_status']))
                    <option value="" @if(!$res['search']['status']) selected @endif>全部</option>
                    @foreach($dict['product_status'] as $key=>$val)
                        <option value="{{$key}}" @if($res['search']['status']==$key) selected @endif>{{$val}}</option>
                    @endforeach
                @endif
            </select>
            <button class="" type="submit">搜索</button>
        </div>
        </form>
        <div class=""><a data-href="/shop_admin/product/add" class="badge badge-info ajax_get add">新增</a></div>
    </div>

    <form method="post"  @if($res['search']['string']) action="/shop_admin/product/del?{{$res['search']['string']}}" @else action="/shop_admin/product/del" @endif  class="del_form">
    @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >ID</li>
                    <li >图片</li>
                    <li >商品名称</li>
                    <li >价格</li>
                    <li >状态</li>
                    <li >操作</li>
                </ul>
                @if($res['list']->total())
                    @foreach($res['list'] as $v)
                    <ul class="table_tbody">
                        <li><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['id']}}">{{$v['id']}}</li>
                        <li>
                            @if($v['image_src'])
                                <img style="width: 30px;height: 30px;" src="{{$v['image_src']}}" />
                            @endif
                        </li>
                        <li><a href="/product/{{$v['id']}}">{{$v['name']}}</a></li>
                        <li>{{$v['price']}}</li>
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
                            <a class="badge badge-info ajax_get" data-href="/shop_admin/product/edit?product_id={{$v['id']}}">编辑</a>
                            <a class="badge badge-info ajax_get" data-href="/shop_admin/product/desc?product_id={{$v['id']}}">描述</a>
                            <a class="badge badge-info ajax_get" data-href="/shop_admin/product/special?product_id={{$v['id']}}">特价</a>
                            <a class="badge badge-info ajax_get" data-href="/shop_admin/product/links?product_id={{$v['id']}}">关联</a>
                            <a class="badge badge-info ajax_get" data-href="/shop_admin/product/img?product_id={{$v['id']}}">图片</a>
                            <a class="badge badge-info ajax_get" data-href="/shop_admin/product/attribute?product_id={{$v['id']}}">属性</a>
                            <a class="badge badge-info ajax_get" data-href="/shop_admin/product/option?product_id={{$v['id']}}">选项</a>
                            <a class="badge badge-info ajax_get d-none" data-href="/shop_admin/product/reward?product_id={{$v['id']}}">奖励积分</a>
                            <a class="badge badge-info ajax_get" data-href="/shop_admin/product/discount?product_id={{$v['id']}}">批发打折</a>
                        </li>
                    </ul>
                    @endforeach
                    <ul class="table_bottom">
                        <li>
                            <input type="checkbox" class="delete_box deleteboxall"  onclick="checkAll(this)">
                            <button class="badge badge-danger del" type="submit">删除</button>
                        </li>
                        <li>
                            {{$res['list']->links('laravel::admin.pagination')}}
                        </li>
                    </ul>
                @endif
            </div>
        </div>

    </form>
</div>

