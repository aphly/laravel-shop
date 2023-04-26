<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<div class="imain">
    <form method="post" @if($res['review']->id) action="/shop_admin/review/save?id={{$res['review']->id}}" @else action="/shop_admin/review/save" @endif class="save_form">
        @csrf
        <div class="review">
            <div class="form-group">
                <label for="">作者</label>
                <input type="text" name="author" class="form-control " value="{{$res['review']->author}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">商品</label>
                <input type="hidden" name="product_id" id="product_id" value="{{$res['review']->product_id}}">
                <div class="search" >
                    <input class="search_input search_input_product form-control "
                        @if($res['product'])
                        value="{{$res['product']->name}}"
                        @endif
                    >
                    <div class="search_res"></div>
                </div>
            </div>
            <div class="form-group">
                <label for="">内容</label>
                <textarea name="text" rows="10" class="form-control ">{{$res['review']->text}}</textarea>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">评级</label>
                <div class="form-check form-check-inline" >
                @if(isset($dict['rating']))
                    @foreach($dict['rating'] as $key=>$val)
                        <label class="form-check-label" style="margin-right: 10px;">
                            <input class="form-check-input" type="radio" name="rating" @if($res['review']->rating==$key) checked @endif value="{{$key}}"> {{$val}}
                        </label>
                    @endforeach
                @endif
                </div>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">添加日期</label>
                <input type="datetime-local" class="form-control " name="date_add" value="{{$res['review']->date_add?date('Y-m-d',$res['review']->date_add)."T".date('H:i',$res['review']->date_add):0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">状态</label>
                <select name="status" class="form-control">
                    @if(isset($dict['status']))
                        @foreach($dict['status'] as $key=>$val)
                            <option value="{{$key}}" @if($res['review']->status==$key) selected @endif>{{$val}}</option>
                        @endforeach
                    @endif
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
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
<script>

</script>
