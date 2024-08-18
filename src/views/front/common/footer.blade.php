</main>
<footer>
    <div class="footer1">
        <div class="container">
            <div class="footer11">
                <ul>
                    <li>Information</li>
                    <li><a href="{{config('shop.menu.about_us.url')}}">{{config('shop.menu.about_us.name')}}</a></li>
                    <li><a href="{{config('shop.menu.terms_of_service.url')}}">{{config('shop.menu.terms_of_service.name')}}</a></li>
                    <li><a href="{{config('shop.menu.privacy_policy.url')}}">{{config('shop.menu.privacy_policy.name')}}</a></li>
                    <li><a href="{{config('shop.menu.faq.url')}}">{{config('shop.menu.faq.name')}}</a></li>
                </ul>
                <ul style="margin-right: auto">
                    <li>Support</li>
                    <li><a href="{{config('shop.menu.contact_us.url')}}">{{config('shop.menu.contact_us.name')}}</a></li>
                    <li><a href="{{config('shop.menu.shipping_policy.url')}}">{{config('shop.menu.shipping_policy.name')}}</a></li>
                    <li><a href="{{config('shop.menu.returns_refunds.url')}}">{{config('shop.menu.returns_refunds.name')}}</a></li>
                    <li><a href="{{config('shop.menu.size_guide.url')}}">{{config('shop.menu.size_guide.name')}}</a></li>
                </ul>
                <ul>
                    <li>Subscribe to our newsletter</li>
                    <li style="margin-bottom: 10px;">A short sentence describing what someone will receive by subscribing</li>
                    <li>
                        <form data-fn="subscribe_res" class="form_request subscribe" action="/subscribe/ajax" method="post">
                            @csrf
                            <input type="text" name="email" autocomplete="off" placeholder="Your email">
                            <button type="submit">Subscribe</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer2">
        <div class="container">
            <div class="footer21">
                <div class="footer21a">
                    <div>
                        <i class="uni app-world"></i>
                    </div>
                    @if($currency[0] && $currency[1] && $currency[2])
                        <div class="currency_box">
                            <div class="currency_curr">
                                <div class="baCountry baCountry-{{$currency[2]['code']}}" style="display: none;"></div>
                                <span class="ba-chosen ">{{$currency[2]['code']}}</span>
                            </div>
                            <ul class="baDropdown">
                                @foreach($currency[0] as $val)
                                    <li class="currMovers @if($currency[2]['code']==$val['code']) active @endif" data-id="{{$val['id']}}">
                                        <div class="baCountry baCountry-{{$val['code']}}"></div>
                                        <span class="curChoice wenzi">{{$val['name']}} ({{$val['code']}})</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <script>
                            let currency_data = @json($currency[0]);
                            $(function () {
                                $('.currency_box .currency_curr').click(function () {
                                    $('.baDropdown').toggle();
                                })
                                $('.currency_box .baDropdown').on('click','li',function () {
                                    let id  =$(this).data('id')
                                    $.ajax({
                                        url:'/currency/'+id,
                                        dataType: "json",
                                        success: function(res){
                                            location.reload()
                                        }
                                    })
                                })
                            })
                        </script>
                    @endif
                </div>
                <div class="footer21b">
                    © {{date('Y')}} <a href="{{url('')}}">{{config('base.title')}}</a> All Rights Reserved.
                </div>
            </div>
        </div>
    </div>
</footer>
<style>
</style>
@if(in_array('Aphly\LaravelStatistics',$comm_module))
    <script src="{{ URL::asset('static/statistics/js/statistics.js') }}" data-appid="{{config('base.statistics_appid')}}" id="statistics"></script>
@endif
<script src="{{ URL::asset('static/base/admin/js/bootstrap.bundle.min.js') }}"></script>
<script>
    var aphly_viewerjs = document.querySelectorAll('.aphly_viewer_js');
    if(aphly_viewerjs){
        aphly_viewerjs.forEach(function (item,index) {
            new Viewer(item,{
                url: 'data-original',
                toolbar:false,
                title:false,
                rotatable:false,
                scalable:false,
                keyboard:false,
                filter(image) {
                    if(image.className.indexOf("aphly_viewer") !== -1){
                        return true;
                    }else{
                        return false;
                    }
                }
            });
        })
    }
    function subscribe_res(res,_this) {
        alert_msg(res.msg)
    }
    $(function() {
        $("img.lazy").lazyload({effect : "fadeIn",threshold :50});
    })
</script>
</body>
</html>
