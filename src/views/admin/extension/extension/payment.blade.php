<div class="top-bar">
    <h5 class="nav-title">{{$res['cname']}}</h5>
</div>
<style>
    .table_scroll .table_header li:nth-child(2),.table_scroll .table_tbody li:nth-child(2){flex: 0 0 300px;}
</style>
<div class="imain">
    <div class="table_scroll">
        <div class="table">
            <ul class="table_header">
                <li >name</li>
                <li >status</li>
                <li >sort</li>
                <li >操作</li>
            </ul>
            @foreach($res['list'] as $v)
            <ul class="table_tbody">
                <li>
                    {{$v['name']}}
                </li>
                <li>
                    @if($dict['status'])
                        @if($v['status']==1)
                            <span class="badge badge-success">{{$dict['status'][$v['status']]}}</span>
                        @else
                            <span class="badge badge-secondary">{{$dict['status'][$v['status']]}}</span>
                        @endif
                    @endif
                </li>
                <li>
                    {{$v['sort']}}
                </li>
                <li>
                    @if(!$v['installed'])
                        <a class="badge badge-info ajax_post" data-href="{{$v['install']}}">安装</a>
                    @else
                        <a class="badge badge-danger ajax_post" data-href="{{$v['uninstall']}}">卸载</a>
                        <a class="badge badge-info ajax_get" data-href="{{$v['edit']}}">编辑</a>
                    @endif

                </li>
            </ul>
            @endforeach
        </div>
    </div>

</div>


