@include('laravel-shop-front::common.header')
<section class="container">
    <div class="account_info">
        @include('laravel-common-front::account_ext.left_menu')
        <div class="account-main-section" style="background: transparent;padding: 0;">
            <div class="">
                <div class="top-desc d-flex justify-content-between">
                    <h2>Review</h2>
                </div>
                <ul class="my_review">
                    @foreach($res['list'] as $val)
                        <li class="">
                            <div class="my_review2">
                                <a href="/account_ext/review/detail?id={{$val->id}}">
                                <div class="my_review21">
                                    <div style="color:#999;">{{$val->created_at}}</div>
                                    <div class="my_review211">
                                        <div class="grade-star-bg">
                                            <div class="star-progress" style="width: {{$val->rating*20}}%;">
                                                <i class="common-iconfont icon-xingxing"></i>
                                                <i class="common-iconfont icon-xingxing"></i>
                                                <i class="common-iconfont icon-xingxing"></i>
                                                <i class="common-iconfont icon-xingxing"></i>
                                                <i class="common-iconfont icon-xingxing"></i>
                                            </div>
                                            <div class="star-bg">
                                                <i class="common-iconfont icon-xingxing"></i>
                                                <i class="common-iconfont icon-xingxing"></i>
                                                <i class="common-iconfont icon-xingxing"></i>
                                                <i class="common-iconfont icon-xingxing"></i>
                                                <i class="common-iconfont icon-xingxing"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my_review212">{{$val->text}}</div>
                                </div>
                                </a>
                                <div class="my_review22">
                                @if($val->img->count())
                                    <ul>
                                    @foreach($val->img as $v)
                                        <li><img src="{{\Aphly\Laravel\Models\UploadFile::getPath($v->image)}}" alt=""></li>
                                    @endforeach
                                    </ul>
                                @endif
                                </div>
                                <a href="/product/{{$val->product->id}}">
                                    <div class="my_review1">
                                        <div class="my_review11"><img src="{{\Aphly\Laravel\Models\UploadFile::getPath($val->product->image)}}" alt=""></div>
                                        <div class="my_review12 wenzi">{{$val->product->name}}</div>
                                    </div>
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div>
                    {{$res['list']->links('laravel-common-front::common.pagination')}}
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .my_review1{display: flex;background: #f1f1f1;border-radius: 4px;margin-top: 10px;}
    .my_review11 img{width: 40px;height: 40px;border-radius: 4px;margin-right: 10px;}
    .my_review12{line-height: 40px;height: 40px;width: calc(100% - 50px);}
    .my_review22 ul{display: flex}
    .my_review22 img{width: 60px;height: 60px;border-radius: 4px;margin-right: 5px;}
    .my_review>li{background: #fff;margin-bottom: 10px;border-radius: 4px;padding:15px;}
    .my_review23 a{display:block;padding:5px 10px;border-radius:4px;border:1px solid #f1f1f1;margin-left:20px}
    .my_review211{margin-top: 10px;}
    .my_review212{margin: 10px 0;}
</style>
<script>
$(function () {

})
</script>
@include('laravel-shop-front::common.footer')
