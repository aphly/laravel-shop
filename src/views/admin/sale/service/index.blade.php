<div class="top-bar">
    <h5 class="nav-title">order</h5>
</div>
<style>
    .table_scroll .table_header li:nth-child(2),.table_scroll .table_tbody li:nth-child(2){flex: 0 0 300px;}
</style>
<div class="imain">
    <div class="itop ">
        <form method="get" action="/shop_admin/service/index" class="select_form">
        <div class="search_box ">
            <input type="search" name="id" placeholder="id" value="{{$res['search']['id']}}">
            <input type="search" name="order_id" placeholder="order_id" value="{{$res['search']['order_id']}}">
            <button class="" type="submit">搜索</button>
        </div>
        </form>
        <div class="">
            <a class="badge badge-primary ajax_get show_all0_btn" data-href="/shop_admin/service/form">添加</a>
        </div>
    </div>

    <form method="post"  @if($res['search']['string']) action="/shop_admin/service/del?{{$res['search']['string']}}" @else action="/shop_admin/service/del" @endif  class="del_form">
    @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >ID</li>
                    <li >Uuid</li>
                    <li >order_id</li>
                    <li >action</li>
                    <li >状态</li>
                    <li >是否收到货</li>
                    <li >操作</li>
                </ul>
                @if($res['list']->total())
                    @foreach($res['list'] as $v)
                    <ul class="table_tbody">
                        <li><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['id']}}">{{$v['id']}}</li>
                        <li>{{ $v['uuid'] }}</li>
                        <li>{{ $v['order_id'] }}</li>
                        <li>{{ $dict['service_action'][$v->service_action_id] }}</li>
                        <li>{{$dict[$dict['service_action'][$v->service_action_id].'_status'][$v->service_status_id]}}</li>
                        <li>
                            @if($dict['yes_no'])
                                {{$dict['yes_no'][$v['is_received']]}}
                            @endif
                        </li>
                        <li>
                            <a class="badge badge-info ajax_get" data-href="/shop_admin/service/view?id={{$v['id']}}">查看</a>
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


