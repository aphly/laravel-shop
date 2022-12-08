<div class="top-bar">
    <h5 class="nav-title">order</h5>
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
            <button class="" type="submit">搜索</button>
        </div>
        </form>
        <div class="">
            <a class="badge badge-primary ajax_get show_all0_btn" data-href="/shop_admin/order/form">添加</a>
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
                            <a class="badge badge-info ajax_get" data-href="/shop_admin/order/view?id={{$v['id']}}">查看</a>
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


