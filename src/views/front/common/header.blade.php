@include('laravel-shop::Front.common.header_common')
<style>
    .fixed-top{position:fixed;top:0;right:0;left:0;z-index:1030;height: 60px;border-bottom: 1px solid #d1d1d1;background-color: #f3f9fa;}
    .glasses-main{padding-top:60px;padding-bottom:15px;}
    .top_left{line-height: 60px;}
    .top_left img{max-height: 100%;width: 150px;}
    .top_left ul li{}
    .nav_num{display:inline-block;vertical-align:text-bottom;width:26px;height:26px;line-height:26px;border-radius:100%;background:#3ea0c0;overflow:hidden;white-space:nowrap;color:#fff;text-align:center;}
    .nav-r i{ color: #333;font-size: 26px;margin-right: 5px;}
    .nav-r{margin: 0 10px;}

    .nav > li .dropdown-menu {margin: 0;}
    .nav > li:hover .dropdown-menu {display: block;}
</style>
    <div class="fixed-top">
        <div class="container">
            <div class="d-flex justify-content-between">
                <div class="d-flex top_left">
                    <img class="" src="" alt="logo">
                    <ul class="nav nav-pills">
                        @foreach($category as $val)
                        <li class="dropdown">
                            <a href="/product/category?id={{$val['id']}}">{{$val['name']}}</a>
                            @if(isset($val['child']))
                            <ul class="dropdown-menu">
                                @foreach($val['child'] as $v)
                                <li><a href="/product/category?id={{$v['id']}}">{{$v['name']}}</a></li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="d-flex align-items-center" >
                    <div></div>
                    <div class="d-flex">
                        <form class="d-flex" method="get" action="/search">
                            <input class="form-control input-search" type="search" placeholder="Search..." name="name" id="input-search-item" >
                            <button class="uni app-ai-search" type="button"></button>
                            <button class="uni app-guanbi" type="button"></button>
                        </form>
                        <a href=""><div class="d-flex nav-heart nav-r  align-items-center">
                            <i class="uni app-aixin"></i>
                            <div class="nav_num">0</div>
                        </div></a>
                        <a href=""><div class="d-flex nav-cart nav-r  align-items-center">
                            <i class="uni app-gouwuche"></i>
                            <div class="nav_num">0</div>
                        </div></a>
                        @if(session('user'))
                            <a href="/account/customer" class="nav-r">
                                <i class="uni app-login"></i>
                            </a>
                        @else
                            <a href="/login" class="nav-r">
                                <i class="uni app-dengluzhanghao"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="glasses-main">
