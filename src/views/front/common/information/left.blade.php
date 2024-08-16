<ul class="information_left">
    @php
        $path = parse_url(request()->url(), PHP_URL_PATH)
    @endphp
    @foreach(config('shop.menu') as $val)
        <li @if($path===$val['url']) class="active" @endif>
            <a href="{{$val['url']}}">{{$val['name']}}</a>
        </li>
    @endforeach
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
