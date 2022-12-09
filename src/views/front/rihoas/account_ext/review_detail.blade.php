@include('laravel-shop-front::common.header')
<section class="container">
    <style>
        .order ul li{display: flex;margin-bottom: 5px;}
        .order ul li>div{flex: 1;display: flex;align-items: center;}
        .order .detail{margin-bottom: 20px;}
        .order .detail .title{margin-bottom: 5px;font-size: 16px;font-weight: 600}
        .order .detail .product{}
        .order .detail .product .option{display: flex;align-items: center;flex-wrap: wrap;width: 100%}
        .order .detail .product .option li{width: 100%;margin-bottom: 0}
        .order .detail .product img{width: 80px;height: 80px;margin-right: 10px;}
        .product_title{font-weight: 600;width: 100%;}
        .total_data li:last-child{font-weight: 600}
    </style>
    <div class="account_info">
        @include('laravel-common-front::account_ext.left_menu')
        <div class="account-main-section">
            <div class="order">
                <div class="top-desc d-flex justify-content-between">
                    <h2>REVIEW INFORMATION</h2>
                </div>

                <div class="detail">
                    <div class="title">The review details</div>
                    <ul>
                        <li><div>ID:</div><div>{{$res['info']->id}}</div></li>
                        <li><div>Date Added:</div><div>{{$res['info']->created_at}}</div></li>
                        <li><div>Author:</div><div>{{$res['info']->author}}</div></li>
                        <li><div>Product:</div><div><a href="/product/{{$res['info']->product->id}}">{{$res['info']->product->name}}</a></div></li>
                        <li><div>Rank:</div><div>{{$res['info']->rating}}</div></li>
                        <li><div>Content:</div><div>{{$res['info']->text}}</div></li>
                    </ul>
                </div>

                <style>
                    .reviewImage ul img{width: 100px;height: 100px;}
                    .reviewImage ul{display: flex;flex-wrap: wrap;}
                </style>
                <div class="reviewImage">
                    @if($res['reviewImage'])
                        <ul>
                            @foreach($res['reviewImage'] as $val)
                                <li><img src="{{$val->image_src}}" alt=""></li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<script>
$(function () {

})
</script>
@include('laravel-shop-front::common.footer')
