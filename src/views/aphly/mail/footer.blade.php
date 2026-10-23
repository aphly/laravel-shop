
    <div style="color:#999;text-align: center;margin-top: 50px">This is a system-generated email. Please do not reply.</div>
    <div style="border-top: 1px solid #d6d6d6;margin: 20px 0;"></div>
    <div style="font-size: 12px;">
        <ul style="display: flex;padding: 0 0;font-size: 12px;justify-content: center">
            <li style="list-style: none;"><a style="" href="{{url(config('shop.menu.about_us.url'))}}">{{config('shop.menu.about_us.name')}}</a></li>
            <li style="list-style: none;margin: 0 10px;color: #999;">|</li>
            <li style="list-style: none;"><a style="" href="{{url(config('shop.menu.shipping_policy.url'))}}">{{config('shop.menu.shipping_policy.name')}}</a></li>
            <li style="list-style: none;margin: 0 10px;color: #999;">|</li>
            <li style="list-style: none;"><a style="" href="{{url('/account_ext/order')}}">My Order</a></li>
            <li style="list-style: none;margin: 0 10px;color: #999;">|</li>
            <li style="list-style: none;"><a style="" href="{{url('/account_ext/after_sales')}}">After-sales</a></li>
        </ul>
        <div style="margin-top: 10px;text-align: center">
            If you have any questions, please contact us at <a href="mailto:{{config('base.email')}}" style="color: #333;">{{config('base.email')}}</a> via our customer support page.
        </div>

        <div style="margin-top: 10px;text-align: center">
            © {{date('Y')}} <a href="{{url('')}}" style="color: #333;">{{config('base.title')}}</a> All Rights Reserved.
        </div>
    </div>
</div>
</div>
