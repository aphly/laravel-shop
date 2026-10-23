<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<style>
    .table_scroll .table_header li:nth-child(3),.table_scroll .table_tbody li:nth-child(3){flex: 0 0 30%;}
</style>
<div class="imain">
    <div class="itop ">
        <form method="get" action="/shop_admin/salesperson/index" class="select_form">
        <div class="search_box ">
            <input type="search" name="name" placeholder="salesperson name" value="{{$res['search']['name']}}">
            <button class="" type="submit">搜索</button>
        </div>
        </form>
        <div class="">
            <a class="badge badge-primary ajax_html show_all0_btn" data-href="/shop_admin/salesperson/form">添加</a>
        </div>
    </div>

    <form method="post"  @if($res['search']['string']) action="/shop_admin/salesperson/del?{{$res['search']['string']}}" @else action="/shop_admin/salesperson/del" @endif  class="del_form">
    @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >ID</li>
                    <li >姓名</li>
                    <li >链接参数</li>
                    <li >平台</li>
                    <li >状态</li>
                    <li >操作</li>
                </ul>
                @if($res['list']->total())
                    @foreach($res['list'] as $v)
                    <ul class="table_tbody">
                        <li><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['id']}}">{{$v['id']}}</li>
                        <li>{{ $v['name'] }}</li>
                        <li>?sp_id={{ $v['id'] }}</li>
                        <li>
                            @if($dict['salesperson_platform'])
                                @if($v['salesperson_platform'])
                                    <span class="badge badge-success">{{$dict['salesperson_platform'][$v['platform']]}}</span>
                                @else
                                    <span class="badge badge-secondary">{{$dict['salesperson_platform'][$v['platform']]}}</span>
                                @endif
                            @endif
                        </li>
                        <li>
                            @if($dict['status'])
                                @if($v['status'])
                                    <span class="badge badge-success">{{$dict['status'][$v['status']]}}</span>
                                @else
                                    <span class="badge badge-secondary">{{$dict['status'][$v['status']]}}</span>
                                @endif
                            @endif
                        </li>
                        <li>
                            <a class="badge badge-info ajax_html" data-href="/shop_admin/salesperson/form?id={{$v['id']}}">编辑</a>
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


