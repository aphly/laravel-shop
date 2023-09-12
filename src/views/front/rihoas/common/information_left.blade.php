<ul class="information_left">
    <li @if($res['info']->id===1) class="active" @endif>
        <a href="/information/1">About Us</a>
    </li>
    <li @if($res['info']->id===2) class="active" @endif>
        <a href="/information/2">Terms of Service</a>
    </li>
    <li @if($res['info']->id===3) class="active" @endif>
        <a href="/information/3">Privacy Policy</a>
    </li>
    <li @if($res['info']->id===4) class="active" @endif>
        <a href="/information/4">Contact Us</a>
    </li>
    <li @if($res['info']->id===5) class="active" @endif>
        <a href="/information/5">Refund Policy</a>
    </li>
    <li @if($res['info']->id===6) class="active" @endif>
        <a href="/information/6">Shipping</a>
    </li>
    <li @if($res['info']->id===7) class="active" @endif>
        <a href="/information/7">Payment</a>
    </li>
    <li @if($res['info']->id===8) class="active" @endif>
        <a href="/information/8">FAQ</a>
    </li>
</ul>

<style>
    .information_left{width: 240px;margin-right: 20px;padding: 20px; background: #fafafa;}
    .information_left li{}
    .information_left li.active a{color: #19bfbf;}
    .information_left li a{line-height: 40px;font-weight: 600;}
    .information_right{width: calc(100% - 260px);padding:0 20px;}
    @media (max-width: 1200px) {
        .information_left{display: none}
        .information_right{width: 100%;}
    }
</style>
