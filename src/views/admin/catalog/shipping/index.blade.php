<div class="top-bar">
    <h5 class="nav-title">shipping</h5>
</div>
<style>
    .table_scroll .table_header li:nth-child(2),.table_scroll .table_tbody li:nth-child(2){flex: 0 0 300px;}
</style>
<div class="imain">
    <div class="itop ">
        <div class="">
            <a class="badge badge-primary ajax_get show_all0_btn" data-href="/shop_admin/shipping/form">添加</a>
        </div>
    </div>

    <form method="post"  @if($res['search']['string']) action="/shop_admin/shipping/del?{{$res['search']['string']}}" @else action="/shop_admin/shipping/del" @endif  class="del_form">
    @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >ID</li>
                    <li >名称</li>
                    <li >价格</li>
                    <li >满免邮</li>
                    <li >geo</li>
                    <li >状态</li>
                    <li >操作</li>
                </ul>
                @if($res['list']->total())
                    @foreach($res['list'] as $v)
                    <ul class="table_tbody">
                        <li><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['id']}}">{{$v['id']}}</li>
                        <li>{{ $v->name }}</li>
                        <li>
                            {{ $v->cost }}
                        </li>
                        <li>
                            {{ $v->free_cost }}
                        </li>
                        <li>
                            @if($v->geoGroup)
                                {{ $v->geoGroup->name }}
                            @else
                                无
                            @endif
                        </li>
                        <li>
                            @if($dict['status'])
                                @if($v->status==1)
                                    <span class="badge badge-success">{{$dict['status'][$v->status]}}</span>
                                @else
                                    <span class="badge badge-secondary">{{$dict['status'][$v->status]}}</span>
                                @endif
                            @endif
                        </li>
                        <li>
                            <a class="badge badge-info ajax_get" data-href="/shop_admin/shipping/form?id={{$v['id']}}">编辑</a>
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


