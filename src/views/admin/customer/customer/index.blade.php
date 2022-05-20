<div class="top-bar">
    <h5 class="nav-title">customer</h5>
</div>
<style>
    .table_scroll .table_header li:nth-child(2),.table_scroll .table_tbody li:nth-child(2){flex: 0 0 300px;}
</style>
<div class="imain">
    <div class="itop ">
        <form method="get" action="/shop_admin/customer/index" class="select_form">
        <div class="filter ">
            <input type="search" name="uuid" placeholder="customer uuid" value="{{$res['filter']['uuid']}}">
            <button class="" type="submit">搜索</button>
        </div>
        </form>
        <div class="">
            <a class="badge badge-primary ajax_get show_all0_btn" data-href="/shop_admin/customer/form">添加</a>
        </div>
    </div>

    <form method="post"  @if($res['filter']['string']) action="/shop_admin/customer/del?{{$res['filter']['string']}}" @else action="/shop_admin/customer/del" @endif  class="del_form">
    @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >ID</li>
                    <li >customer identity_type</li>
                    <li >customer nickname</li>
                    <li >操作</li>
                </ul>
                @if($res['list']->total())
                    @foreach($res['list'] as $v)
                    <ul class="table_tbody">
                        <li><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['uuid']}}">{{$v['uuid']}}</li>
                        <li>
                            @foreach($v->user_auth as $val)
                                {{$val->identity_type}} : {{$val->identifier}}
                            @endforeach
                        </li>
                        <li>
                            {{ $v->user->nickname }}
                        </li>
                        <li>
                            <a class="badge badge-info ajax_get" data-href="/shop_admin/customer/form?uuid={{$v['uuid']}}">编辑</a>
                        </li>
                    </ul>
                    @endforeach
                    <ul class="table_bottom">
                        <li>
                            <input type="checkbox" class="delete_box deleteboxall"  onclick="checkAll(this)">
                            <button class="badge badge-danger del" type="submit">删除</button>
                        </li>
                        <li >
                            {{$res['list']->links('laravel-admin::common.pagination')}}
                        </li>
                    </ul>
                @endif
            </div>
        </div>

    </form>
</div>


