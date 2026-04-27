
<div class="sidebar-menu">
    <div class="sidebar-menu-list">
        @php
        $uri = request()->path()
        @endphp
        <div class="sidebar-menu-title">My Account
            <i class="uni app-guanbi" onclick="$('.sidebar-menu').hide()"></i>
        </div>
        <ul class="sidebar-menu-content">
            <li><a href="/account/index" @if('account/index'==$uri) class="active" @endif>Dashboard</a></li>
            <li><a href="/account_ext/wishlist" @if('account_ext/wishlist'==$uri) class="active" @endif>My Wishlist</a></li>
            <li><a href="/account_ext/address" @if('account_ext/address'==$uri || 'account_ext/address/save'==$uri) class="active" @endif>My Address Book</a></li>
            <li><a href="/account_ext/subscribe" @if('account_ext/subscribe'==$uri) class="active" @endif>My Subscribe</a></li>
        </ul>

        <div class="sidebar-menu-title">Order Details</div>
        <ul class="sidebar-menu-content">
            <li><a href="/account_ext/order" @if('account_ext/order'==$uri || 'account_ext/order/detail'==$uri) class="active" @endif>My Orders</a></li>
            <li><a href="/account_ext/review" @if('account_ext/review'==$uri || 'account_ext/review/detail'==$uri) class="active" @endif>My Reviews</a></li>
            <li ><a href="/account_ext/after_sales" @if('account_ext/after_sales'==$uri || 'account_ext/after_sales/form'==$uri || 'account_ext/after_sales/detail'==$uri) class="active" @endif>After Sales</a></li>
        </ul>
        <div class="sidebar-menu-title">Service</div>
        <ul class="sidebar-menu-content">
            <li><a href="/account/logout" @if('account/logout'==$uri) class="active" @endif style="color:#a13838;">Logout</a></li>
        </ul>
        <div class="sidebar-menu-content" style="">
            <span>Need help? We're here to help you:</span>
            <div class="phone">
                <b>{{ config('base.email') }}</b> <br>
                <span>9:00 AM to 6:00 PM Mon to Fri. (EST)</span>
            </div>
        </div>
    </div>
</div>
<style>
    .sidebar-menu{width:280px;overflow:hidden;background: #fff;border-radius: 4px;padding: 20px}
    .sidebar-menu .sidebar-menu-title{padding-top:5px;padding-bottom:7px;margin:0 auto 10px;font-size:18px;font-weight:500}
    .sidebar-menu ul li{list-style:inside;color:#d8d8d8;padding-bottom:5px}
    .sidebar-menu ul li a{font-size:15px;color:#333}
    .sidebar-menu ul li a.active{color: #0da9c4;}
    .sidebar-menu-content{margin-bottom: 15px;}

    .account-main-section{width: calc(100% - 300px);margin-left: 20px;background: #fff;border-radius: 4px;padding: 20px}
    .account_info{margin-top: 10px;display: flex;justify-content: space-between;}
    .top-desc{margin-bottom: 10px;align-items: baseline;}
    .top-desc h2{margin-bottom: 0;}
    .top-desc a{font-size: 16px;}
    .list_index{}
    .list_index li{margin-bottom: 20px;}

    .form_request .form-group{margin-bottom: 20px;}
    .form_request .form-group p{margin-bottom: 10px;}
    .form_request .form-group p b{color: darkred;}
    .sidebar-menu-title i{display: none;}
    .my_btn{ display: block; padding: 0 10px; border-radius: 4px;border: 1px solid #333;line-height: 34px;}
    @media (max-width: 1199.98px) {
        .account_info{flex-wrap: wrap;}
        .account-main-section{width: 100%;margin-left: 0;margin-bottom: 20px; padding: 0px;}
        .sidebar-menu-title i{display: block;padding:0 10px;cursor: pointer}
        .sidebar-menu-title{display: flex;justify-content: space-between;}
        .sidebar-menu-list{height: 40px;}
        .sidebar-menu{display: none}
    }
</style>

