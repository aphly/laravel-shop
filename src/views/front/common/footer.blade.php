</main>
<style>
    .footerFollow{text-align: center;padding:  10px 0;}
    .footerFollow i{font-size: 20px;padding:  10px;}
</style>
<div class="container">
    <div class="footerFollow" >
        <a href="https://www.instagram.com/aphlyjewelry/" target="_blank" title="Follow us on Instagram"
           class="footer_social" rel="nofollow">
            <i class="common-iconfont icon-instagram" ></i>
        </a>
        <a href="https://www.facebook.com/aphlyjewelry" target="_blank" title="Follow us on Facebook"
            class="footer_social" rel="nofollow" >
            <i class="common-iconfont icon-facebook1" ></i>
        </a>
        <a href="https://twitter.com/aphlyjewelry" target="_blank" title="Follow us on Twitter" class="footer_social"
            rel="nofollow" >
            <i class="common-iconfont icon-a-XCOM" ></i>
        </a>
        <a href="https://www.pinterest.com/aphlyjewelry/" target="_blank" title="Follow us on Pinterest"
            class="footer_social" rel="nofollow" >
            <i class="common-iconfont icon-pinterest" ></i>
        </a>
        <a href="https://www.youtube.com/@AphlyJewelry" target="_blank"
            title="Follow us on Youtube" class="footer_social" rel="nofollow" >
            <i class="common-iconfont icon-youtube" ></i>
        </a>
        <a href="https://www.tiktok.com/@aphlyjewelry" target="_blank" title="Follow us on Tiktok" class="footer_social"
            rel="nofollow" >
            <i class="common-iconfont icon-tiktok" ></i>
        </a>
    </div>
</div>
<footer>
    <div class="footer1">
        <div class="container">
            <div class="footer11">
                <ul>
                    <li>Information</li>
                    <li><a href="{{config('shop.menu.about_us.url')}}">{{config('shop.menu.about_us.name')}}</a></li>
                    <li>
                        <a href="{{config('shop.menu.terms_of_service.url')}}">{{config('shop.menu.terms_of_service.name')}}</a>
                    </li>
                    <li>
                        <a href="{{config('shop.menu.privacy_policy.url')}}">{{config('shop.menu.privacy_policy.name')}}</a>
                    </li>
                    <li><a href="{{config('shop.menu.faq.url')}}">{{config('shop.menu.faq.name')}}</a></li>
                    <li><a href="/information/index?category_id=2">Introduction to Gemstones</a></li>
                </ul>
                <ul style="margin-right: auto">
                    <li>Support</li>
                    <li><a href="{{config('shop.menu.contact_us.url')}}">{{config('shop.menu.contact_us.name')}}</a>
                    </li>
                    <li>
                        <a href="{{config('shop.menu.shipping_policy.url')}}">{{config('shop.menu.shipping_policy.name')}}</a>
                    </li>
                    <li>
                        <a href="{{config('shop.menu.returns_refunds.url')}}">{{config('shop.menu.returns_refunds.name')}}</a>
                    </li>
                    <li><a href="/tracking/index">Tracking Information</a></li>
                    <li><a href="{{config('shop.menu.size_guide.url')}}">{{config('shop.menu.size_guide.name')}}</a></li>
                </ul>
                <ul>
                    <li>Subscribe to our newsletter</li>
                    <li style="margin-bottom: 10px;">A short sentence describing what someone will receive by
                        subscribing
                    </li>
                    <li>
                        <form data-fn="subscribe_res" class="form_request subscribe" action="/subscribe/ajax"
                              method="post">
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
                    <div class="footer21a1" style="">
                        <i class="uni app-world"></i>
                        @if($currency[0] && $currency[1] && $currency[2])
                            <div class="currency_box">
                                <div class="currency_curr">
                                    <div class="baCountry baCountry-{{$currency[2]['code']}}"
                                         style="display: none;"></div>
                                    <span class="ba-chosen ">{{$currency[2]['code']}}</span>
                                </div>
                                <ul class="baDropdown">
                                    @foreach($currency[0] as $val)
                                        <li class="currMovers @if($currency[2]['code']==$val['code']) active @endif"
                                            data-id="{{$val['id']}}">
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
                                    $('.currency_box .baDropdown').on('click', 'li', function () {
                                        let id = $(this).data('id')
                                        $.ajax({
                                            url: '/currency/' + id,
                                            dataType: "json",
                                            success: function (res) {
                                                location.reload()
                                            }
                                        })
                                    })
                                })
                            </script>
                        @endif
                    </div>
                    <div class="footer21a2">
                        <img style="height: 30px;" src="{{ URL::asset('static/shop/img/card.png') }}" alt="">
                    </div>
                </div>
                <div class="footer21b">
                    © {{date('Y')}} <a href="{{url('')}}">{{config('base.title')}}</a> All Rights Reserved.
                </div>
            </div>
        </div>
    </div>
</footer>
<style>
    .ba-chosen {
        padding: 5px 10px;
    }

    .footer21a1 {
        display: flex;
        align-items: center
    }

    .footer2 {
        font-weight: 600;
    }

    .footer21a2 {
    }

    .viewer-list > .viewer-active, .viewer-list > .viewer-active:hover {
        border-top: 2px solid #41c9b0;
    }

    @media (max-width: 1200px) {
        .footer21a1 {
            width: 100%;
            justify-content: center
        }

        .footer21a {
            flex-wrap: wrap;
            text-align: center
        }

        .footer21a2 img {
            width: 80%;
        }
    }
</style>
@if(in_array('Aphly\LaravelStatistics\StatisticsServiceProvider',config('app.providers')))
    <script src="{{ URL::asset('static/statistics/js/statistics.js') }}"
            data-appid="{{config('base.statistics_appid')}}" id="statistics"></script>
@endif
<script src="{{ URL::asset('static/base/admin/js/bootstrap.bundle.min.js') }}"></script>
<script>
    var aphly_viewerjs = document.querySelectorAll('.aphly_viewer_js');
    if (aphly_viewerjs) {
        aphly_viewerjs.forEach(function (item, index) {
            new Viewer(item, {
                url: 'data-original',
                toolbar: false,
                title: false,
                rotatable: false,
                scalable: false,
                keyboard: false,
                filter(image) {
                    if (image.className.indexOf("aphly_viewer") !== -1) {
                        return true;
                    } else {
                        return false;
                    }
                }
            });
        })
    }

    function subscribe_res(res, _this) {
        alert_msg(res.msg)
    }

    function formatLocalTime(timestamp, format = 0) {
        if (!timestamp) {
            return '';
        }
        let ts = timestamp.toString().length === 10 ? timestamp * 1000 : timestamp;
        let d = new Date(Number(ts));
        let year = d.getFullYear();
        let month = String(d.getMonth() + 1).padStart(2, '0');
        let day = String(d.getDate()).padStart(2, '0');
        let hours = String(d.getHours()).padStart(2, '0');
        let minutes = String(d.getMinutes()).padStart(2, '0');
        let seconds = String(d.getSeconds()).padStart(2, '0');
        if (format === 1) {
            return `${month}-${day} , ${year}`;
        } else {
            return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        }
    }

    $(function () {
        $("img.lazy").lazyload({effect: "fadeIn", threshold: 50});
        $('.utc_time').text(function () {

            return formatLocalTime($(this).data('utc_time'), $(this).data('format'))
        })
    })
</script>
</body>
</html>
