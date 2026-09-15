@include('laravel-shop::front.common.header')

<section class="information shop_main">
    <div class=" container">
        <div class="d-flex all_breadcrumb">
            <a href="{{url('/')}}"><span>Home</span></a>
            <i class="common-iconfont icon-xiangb"></i>
            <span>{{$res['title']}}</span>
        </div>

        <div class="information_main">
            <div class="mobile information_menu">
                <div class="information_menu_top" onclick="" style="display: flex;justify-content: space-between;padding: 0 10px;">
                    <div>
                        {{$res['informationCategory'][$res['search']['category_id']]['name']}}
                    </div>
                    <div>
                        <i class="uni app-xiangxiajiantou"></i>
                    </div>
                </div>
                <div class="items-all">
                    @foreach($res['informationCategory'] as $v)
                        <a href="/information/index?category_id={{$v['id']}}" @if($v['id']==$res['search']['category_id']) class="active" @endif>
                            <div class="wenzi">{{$v['name']}}</div>
                        </a>
                    @endforeach
                </div>
            </div>
            <div style="display: flex">
                <div class="card-wrap">
                    @if($res['list']->count())
                        @foreach($res['list'] as $v)
                            <div class="card-item">
                                <a href="/information/{{$v['id']}}">
                                    <h3 class="card-title">{{$v['title']}}</h3>
                                    <div class="card-desc">
                                        {!! $v['content'] !!}
                                    </div>
                                </a>
                            </div>
                        @endforeach
                        <div style="width: 100%;">
                            {{$res['list']->links()}}
                        </div>
                    @else
                        <div style=" font-size: 22px;font-weight: 500;text-align: center;  margin-top: 10%;width: 100%">
                            Sorry, your search returned no results.
                        </div>
                    @endif
                </div>
                <div class="card-wrap_right">
                    <div>
                        @foreach($res['informationCategory'] as $v)
                            <a href="/information/index?category_id={{$v['id']}}" @if($v['id']==$res['search']['category_id']) class="active" @endif>
                                <div class="wenzi">{{$v['name']}}</div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<style>
    .card-wrap_right a>div,.items-all a>div{position: relative;text-indent: 20px;}
    .card-wrap_right a>div::before,.items-all a>div::before{content:'';position:absolute;left:0;top:50%;transform:translateY(-50%);width:6px;height:6px;background:#fff;border:1px solid #000;border-radius:50%;opacity:0.6;transition:all 0.3s ease}
    .card-wrap_right a.active>div::before,.items-all a.active>div::before{background: #057ade;border:none;}
    .information_menu{margin:10px 0;background:#f9f9f9;padding:0 10px;border-radius:8px;line-height:50px}
    .information_main{}
    .information_menu .items-all{display: none;padding: 0 10px; border-top: 1px solid #f1f1f1;}
    .card-wrap_right{width: 300px;padding: 20px;background: #fcfbf7;border-radius: 14px;}
    .card-wrap_right .active{color: #0056b3;}
    .card-wrap{display:flex;flex-wrap:wrap;width:calc(100% - 300px)}
    .card-item{width:calc(50% - 20px);margin:0 20px 20px 0;border-radius:14px;padding:20px;background:#f7f7f7;position:relative}
    .card-date{font-size:12px;color:#999;margin-top:10px}
    .card-desc{font-size:15px;color:#777;line-height:1.7;}
    .card-wrap a:hover{box-shadow: 0 2px 12px 2px #eee;}
    .card-wrap_right a{height: 40px;line-height: 40px; }
    .card-wrap_right a{}
    @media (max-width: 1200px) {
        .card-wrap_right{display: none}
        .card-wrap{width: 100%;}
        .card-item{width: 100%;margin:0 0 10px 0;}
    }
</style>

<script>
    $(function () {
        $('.information_menu_top').click(function () {
            $('.items-all').toggle()
            if($('.information_menu_top i.uni').hasClass('app-xiangxiajiantou')){
                $('.information_menu_top i.uni').removeClass('app-xiangxiajiantou').addClass('app-xiangshangjiantou')
            }else{
                $('.information_menu_top i.uni').addClass('app-xiangxiajiantou').removeClass('app-xiangshangjiantou')
            }
        })
    })
</script>
@include('laravel-shop::front.common.footer')
