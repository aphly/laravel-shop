@include('laravel-common-front::common.header')

<section class="information">
    <div class=" container">
        <div class="d-flex all_breadcrumb">
            <a href="{{url('/')}}"><span>Home</span></a>
            <i class="common-iconfont icon-xiangb"></i>
            <a href="{{url('/information/'.$res['info']->id)}}"><span>{{$res['info']->title}}</span></a>
        </div>
        <div class="d-flex ">
            @include('laravel-shop-front::common.information_left')
            <div class="information_right">
                <h2 class="">{{$res['info']->title}}</h2>
                <div class="content">
                    {!! $res['info']->content !!}
                </div>
                @if($res['info']->id===4)
                <div class="contact_us">
                    <form action="/contact_us" method="post" class="form_request" data-fn="contact_us">
                        @csrf
                        <div class="">
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="text" name="email" class="form-control" required placeholder="Email" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="">Content</label>
                                <textarea name="content" class="form-control" required style="height: 200px;"></textarea>
                            </div>
                            <button class="btn btn-primary text-brand" type="submit">Send Message</button>
                        </div>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<style>
    .information h2{margin-bottom: 20px;text-align: center;font-size: 24px;}
    .information{margin-top: 20px}
    .contact_us{margin-top: 20px;}
    .information img{max-width: 100%;}
</style>

<script>
    function contact_us(res) {
        alert_msg(res,false,3000)
    }
</script>
@include('laravel-common-front::common.footer')
