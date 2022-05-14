<link rel="stylesheet" href="{{ URL::asset('vendor/laravel-shop/css/product_admin.css') }}">
<div class="top-bar">
    <h5 class="nav-title">商品 - {{$res['product']->name}} </h5>
</div>
<div class="imain">
    <form method="post" @if($res['product']->id) action="/shop_admin/product/discount?product_id={{$res['product']->id}}" @else action="/shop_admin/product/discount" @endif class="save_form">
        @csrf
        <div class="">
            <ul class="discount">
                <li>
                    <span>会员等级</span><span>数量</span><span>价格</span>
                    <span  class="op"><i class="uni app-jia" onclick="add_discount()"></i></span>
                </li>
                @foreach($res['product_discount'] as $val)
                    <li>
                        <span>
                            <select name="product_discount[{{$val['id']}}][group_id]" >
                                @foreach($res['group'] as $k=>$v)
                                    <option value="{{$v['id']}}" @if($v['id']==$val['group_id']) selected @endif>{{$v['name']}}</option>
                                @endforeach
                            </select>
                        </span>
                        <span>
                            <input type="number" name="product_discount[{{$val['id']}}][quantity]" value="{{$val['quantity']??0}}">
                        </span>
                        <span>
                            <input type="text" name="product_discount[{{$val['id']}}][price]" value="{{$val['price']??0}}">
                        </span>
                        <span class="op"><i class="uni app-jian "></i></span>
                    </li>
                @endforeach
            </ul>
        </div>
        <button class="btn btn-primary" type="submit">保存</button>
    </form>
</div>
<style>
.discount .app-jian:hover{color: #bd0404;}
.discount .app-jia:hover{color:#2abb06}
.discount .op{text-align: center;}
.discount .op i{cursor: pointer;}
.discount li{ display: flex;margin-bottom: 10px;}
.discount li span{flex: 1;padding: 0 10px;}
.discount li span input,.discount li span select{ width: 100%;outline: none;height: 32px;line-height: 32px;padding: 0 10px;border: 1px solid #999;border-radius: 4px;}
</style>
<script>
    $(function () {
        $('.discount').on('click','.app-jian',function () {
            $(this).closest('li').remove();
        })
    })
    function add_discount() {
        let id = randomId(8)
        let html = `<li>
                        <span>
                            <select name="product_discount[${id}][group_id]" >
                            @foreach($res['group'] as $k=>$v)
                            <option value="{{$v['id']}}">{{$v['name']}}</option>
                            @endforeach
                            </select>
                        </span>
                        <span>
                            <input type="number" name="product_discount[${id}][quantity]" value="">
                        </span>
                        <span>
                            <input type="text" name="product_discount[${id}][price]" value="0">
                        </span>
                        <span class="op"><i class="uni app-jian "></i></span>
                    </li>`
        $('.discount').append(html)
    }
</script>


