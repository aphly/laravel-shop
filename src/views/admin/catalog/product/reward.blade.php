<div class="top-bar">
    <h5 class="nav-title">商品 - {{$res['product']->name}}</h5>
    <div>
        @include('laravel-shop::admin.catalog.product.submenu')
    </div>
</div>
<div class="imain">
    <form method="post" @if($res['product']->id) action="/shop_admin/product/reward?product_id={{$res['product']->id}}" @else action="/shop_admin/product/reward" @endif class="save_form">
        @csrf
        <div class="">
            <ul class="reward">
                <li><span>会员等级</span><span>奖励积分</span></li>
                @foreach($res['group'] as $val)
                    <li>
                        <span>{{$val['name']}}</span>
                        <span>
                            <input type="number" name="product_reward[{{$val['id']}}]" value="{{$res['product_reward'][$val['id']]['points']??0}}">
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
        <button class="btn btn-primary" type="submit">保存</button>
    </form>
</div>
<style>
.reward{}
.reward li{ display: flex;margin-bottom: 10px;}
.reward li span{flex: 1;}
.reward li span input{ width: 100%;outline: none;height: 32px;line-height: 32px;padding: 0 10px;border: 1px solid #999;border-radius: 4px;}
</style>
<script>

</script>


