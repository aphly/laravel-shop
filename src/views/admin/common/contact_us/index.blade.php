<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<style>
    .table_scroll .table_header li:nth-child(3),.table_scroll .table_tbody li:nth-child(3){flex: 0 0 300px;}
    .table_scroll .table_header li:nth-child(4),.table_scroll .table_tbody li:nth-child(4){flex: 0 0 300px;}
</style>
<div class="imain">
    <div class="itop ">
        <form method="get" action="/shop_admin/contact_us/index" class="select_form">
        <div class="search_box ">
            <input type="search" name="email" placeholder="email" value="{{$res['search']['email']}}">
            <button class="" type="submit">搜索</button>
        </div>
        </form>
    </div>
    <form method="post"  @if($res['search']['string']) action="/shop_admin/contact_us/del?{{$res['search']['string']}}" @else action="/shop_admin/contact_us/del" @endif  class="del_form">
    @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >ID</li>
                    <li >Email</li>
                    <li >是否查看</li>
                    <li >是否回复</li>
                    <li >操作</li>
                </ul>
                @if($res['list']->total())
                    @foreach($res['list'] as $v)
                    <ul class="table_tbody">
                        <li><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['id']}}">{{$v['id']}}</li>
                        <li class="wenzi">{{$v['email']}}</li>
                        <li >
                            @if($dict['yes_no'])
                                {{$dict['yes_no'][$v->is_view]}}
                            @endif
                        </li>
                        <li >
                            @if($dict['yes_no'])
                                {{$dict['yes_no'][$v->is_reply]}}
                            @endif
                        </li>
                        <li >
                            {{$v['content']}}
                        </li>
                        <li>
                            <a class="badge badge-info ajax_get" data-href="/shop_admin/contact_us/form?id={{$v['id']}}">查看</a>
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


