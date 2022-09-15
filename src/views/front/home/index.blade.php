@include('laravel-common::front.common.header')
<section class="">
    <style>
        .nlist{display: flex;flex-wrap: wrap;padding: 12px 0;}
        .nlist li{width: calc(16% - 13px);margin: 0 16px 16px 0;}
        .nlist li:nth-child(6n){margin: 0 0 16px 0;}

        .nlist li .pic{width: 100%;text-align: center;height: 160px;}
        .nlist li .pic .novel_status{top: 0;left: 0;width: auto;padding: 0px 10px;font-size: 12px;color:#fff;background-color: rgba(19,20,21,.5);font-weight: 600;border-top-left-radius: 4px;border-bottom-right-radius: 4px;line-height: 22px;}
        .nlist li .pic img{width: 100%;height: 100%;border: 1px solid #000;border-radius: 4px;}

        .nlist .novel_title{font-weight: 600;}
        @media (max-width: 1199.98px) {
            .nlist li{width: calc(33% - 8px);margin: 0 12px 12px 0;}
            .nlist li:nth-child(3n){margin: 0 0px 12px 0;}
        }

        .box1{}
        .home_title{font-size: 24px;font-weight: 700;}
    </style>
    <div class=" container">

        <div class="box1">
            <div class="home_title">Hot</div>
            @if($res['hot']->count())
                <ul class="nlist">
                    @foreach($res['hot'] as $val)
                        <li class="">
                            <div class="pic position-relative">
                                <a href="/novel/{{$val->id}}"><img src="{{$val->image}}" alt=""></a>
                                @if(isset($dict['novel_status'][$val->novel_status]))
                                    <div class="position-absolute novel_status">{{$dict['novel_status'][$val->novel_status]}}</div>
                                @endif
                            </div>
                            <div class="wenzid">
                                <a href="/novel/{{$val->id}}" class="novel_title">{{$val->title}}</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="box2">
            <div class="home_title">New</div>
            @if($res['new']->count())
                <ul class="nlist">
                    @foreach($res['new'] as $val)
                        <li class="">
                            <div class="pic position-relative">
                                <a href="/novel/{{$val->id}}"><img src="{{$val->image}}" alt=""></a>
                                @if(isset($dict['novel_status'][$val->novel_status]))
                                    <div class="position-absolute novel_status">{{$dict['novel_status'][$val->novel_status]}}</div>
                                @endif
                            </div>
                            <div class="wenzid">
                                <a href="/novel/{{$val->id}}" class="novel_title">{{$val->title}}</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="box3">
            <div class="home_title">Recommend</div>
            @if($res['recommend']->count())
                <ul class="nlist">
                    @foreach($res['recommend'] as $val)
                        <li class="">
                            <div class="pic position-relative">
                                <a href="/novel/{{$val->id}}"><img src="{{$val->image}}" alt=""></a>
                                @if(isset($dict['novel_status'][$val->novel_status]))
                                    <div class="position-absolute novel_status">{{$dict['novel_status'][$val->novel_status]}}</div>
                                @endif
                            </div>
                            <div class="wenzid">
                                <a href="/novel/{{$val->id}}" class="novel_title">{{$val->title}}</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="box4">
            <div class="home_title">Update</div>
            @if($res['update']->count())
                <ul class="nlist">
                    @foreach($res['update'] as $val)
                        <li class="">
                            <div class="pic position-relative">
                                <a href="/novel/{{$val->id}}"><img src="{{$val->image}}" alt=""></a>
                                @if(isset($dict['novel_status'][$val->novel_status]))
                                    <div class="position-absolute novel_status">{{$dict['novel_status'][$val->novel_status]}}</div>
                                @endif
                            </div>
                            <div class="wenzid">
                                <a href="/novel/{{$val->id}}" class="novel_title">{{$val->title}}</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</section>
<style>

</style>
<script>

$(function () {

})

</script>
@include('laravel-common::front.common.footer')
