<div class="top-bar">
    <h5 class="nav-title">setting</h5>
</div>
<style>
    .table_scroll .table_header li:nth-child(2),.table_scroll .table_tbody li:nth-child(2){flex: 0 0 300px;}
</style>
<div class="imain">

    <form method="post"  @if($res['filter']['string']) action="/shop_admin/country/del?{{$res['filter']['string']}}" @else action="/shop_admin/country/del" @endif  class="del_form">
    @csrf
        <div class="table_scroll">
            <div class="table">
                <ul class="table_header">
                    <li >ID</li>
                    <li >country name</li>
                    <li >iso_code_2</li>
                    <li >iso_code_3</li>
                    <li >状态</li>
                    <li >操作</li>
                </ul>
                @if($res['list']->total())
                    @foreach($res['list'] as $v)
                    <ul class="table_tbody">
                        <li><input type="checkbox" class="delete_box" name="delete[]" value="{{$v['id']}}">{{$v['id']}}</li>
                        <li>{{ $v['name'] }}</li>
                        <li>
                            {{$v['iso_code_2']}}
                        </li>
                        <li>
                            {{$v['iso_code_3']}}
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
                            <a class="badge badge-info ajax_get" data-href="/shop_admin/country/form?id={{$v['id']}}">编辑</a>
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


