<link rel="stylesheet" href="{{ URL::asset('vendor/laravel-shop/css/product_admin.css') }}">
<div class="top-bar">
    <h5 class="nav-title">商品 - {{$res['product']->name}} </h5>
</div>
<div class="imain">
    <form method="post" @if($res['product']->id) action="/shop_admin/product/special?product_id={{$res['product']->id}}" @else action="/shop_admin/product/special" @endif class="save_form">
        @csrf
        <div class="">
            <ul class="special">
                <li>
                    <span>会员等级</span><span>价格</span><span>开始日期</span><span>结束日期</span>
                    <span  class="op"><i class="uni app-jia" onclick="add_special()"></i></span>
                </li>
                @foreach($res['product_special'] as $val)
                    <li>
                        <span>
                            <select name="product_special[{{$val['id']}}][group_id]" >
                                @foreach($res['group'] as $k=>$v)
                                    <option value="{{$v['id']}}" @if($v['id']==$val['group_id']) selected @endif>{{$v['name']}}</option>
                                @endforeach
                            </select>
                        </span>
                        <span>
                            <input type="text" name="product_special[{{$val['id']}}][price]" value="{{$val['price']??0}}">
                        </span>
                        <span>
                            <input type="datetime-local" name="product_special[{{$val['id']}}][date_start]" value="{{$val['date_start']?date('Y-m-d',$val['date_start'])."T".date('H:i',$val['date_start']):0}}">
                        </span>
                        <span>
                            <input type="datetime-local" name="product_special[{{$val['id']}}][date_end]" value="{{$val['date_end']?date('Y-m-d',$val['date_end'])."T".date('H:i',$val['date_end']):0}}">
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
.special .app-jian:hover{color: #bd0404;}
.special .app-jia:hover{color:#2abb06}
.special .op{text-align: center;}
.special .op i{cursor: pointer;}
.special li{ display: flex;margin-bottom: 10px;}
.special li span{flex: 1;padding: 0 10px;}
.special li span input,.special li span select{ width: 100%;outline: none;height: 32px;line-height: 32px;padding: 0 10px;border: 1px solid #999;border-radius: 4px;}
</style>
<script>
    $(function () {
        $('.special').on('click','.app-jian',function () {
            $(this).closest('li').remove();
        })
    })
    function add_special() {
        let id = randomId(8)
        let html = `<li>
                        <span>
                            <select name="product_special[${id}][group_id]" >
                            @foreach($res['group'] as $k=>$v)
                            <option value="{{$v['id']}}">{{$v['name']}}</option>
                            @endforeach
                            </select>
                        </span>
                        <span>
                            <input type="number" name="product_special[${id}][price]" value="0">
                        </span>
                        <span>
                            <input type="datetime-local" name="product_special[${id}][date_start]" value="">
                        </span>
                        <span>
                            <input type="datetime-local" name="product_special[${id}][date_end]" value="">
                        </span>
                        <span class="op"><i class="uni app-jian "></i></span>
                    </li>`
        $('.special').append(html)
    }
</script>


