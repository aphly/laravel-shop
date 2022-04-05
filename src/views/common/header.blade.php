@include('laravel-shop::common.header_common')
<style>
    .fixed-top {
        position: fixed;
        top: 0;
        right: 0;
        left: 0;
        z-index: 1030;
    }
    .glasses-main {
        padding-top: 60px;
        padding-bottom: 15px;
    }
</style>
    <div class="fixed-top">
        <div class="container">
            <div class="d-flex justify-content-between">
                <div></div>
                <div class="d-flex">
                    <div></div>
                    <div class="">
                        @if($user = session('user'))
                            <a href="/home" class="uni app-dengluzhanghao"></a>
                            {{$user['nickname']}}
                        @else
                            <a href="/login" class="uni app-dengluzhanghao"></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="glasses-main">
