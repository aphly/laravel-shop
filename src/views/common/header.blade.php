@include('laravel-shop::common.header_common')
<style>
    .fixed-top{position:fixed;top:0;right:0;left:0;z-index:1030;height: 60px;border-bottom: 1px solid #d1d1d1;background-color: #f3f9fa;}
    .glasses-main{padding-top:60px;padding-bottom:15px;}
    .top_left{line-height: 60px;}
    .top_left img{max-height: 100%;width: 150px;}
    .top_left ul li{}
    .nav_num{display:inline-block;vertical-align:text-bottom;width:26px;height:26px;line-height:26px;border-radius:100%;background:#3ea0c0;overflow:hidden;white-space:nowrap;color:#fff;text-align:center;}
    .nav-r i{ color: #333;font-size: 26px;}

</style>
    <div class="fixed-top">
        <div class="container">
            <div class="d-flex justify-content-between">
                <div class="d-flex top_left">
                    <img class="" src="//d22qih3asjv3x0.cloudfront.net/1/static/public/statics/images/gs-logo-2021.svg" alt="logo">
                    <ul class="d-flex">
                        <li>Eyeglasses</li>
                        <li>Sunglasses</li>
                        <li>Collections</li>
                        <li>Sale</li>
                    </ul>
                </div>
                <div class="d-flex">
                    <div></div>
                    <div class="d-flex">
                        <form class="d-flex" method="get" action="/search">
                            <input class="form-control input-search" type="search" placeholder="Search..." name="name" id="input-search-item" >
                            <button class="uni app-ai-search" type="button"></button>
                            <button class="uni app-guanbi" type="button"></button>
                        </form>
                        <a href=""><div class="d-flex nav-heart nav-r">
                            <i class="uni app-aixin"></i>
                            <div class="nav_num">0</div>
                        </div></a>
                        <a href=""><div class="d-flex nav-cart nav-r">
                            <i class="uni app-gouwuche"></i>
                            <div class="nav_num">0</div>
                        </div></a>
                        @if($user = session('user'))
                            <a href="/account" class="nav-r">
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
