
<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<div class="imain">
    <form method="post" action="/shop_admin/config/save" class="save_form">
        @csrf
        <div class="">
            <nav style="margin-bottom: 20px;">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-link active" id="nav-index-tab" data-toggle="tab" href="#nav-index" role="tab" aria-controls="nav-index" aria-selected="true">首页</a>
                    <a class="nav-link " id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">shop</a>
                    <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">params</a>
                    <a class="nav-link" id="nav-order-tab" data-toggle="tab" href="#nav-order" role="tab" aria-controls="nav-order" aria-selected="false">order</a>
                    <a class="nav-link" id="nav-service-tab" data-toggle="tab" href="#nav-service" role="tab" aria-controls="nav-service" aria-selected="false">service</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-index" role="tabpanel" aria-labelledby="nav-index-tab">
                    <div class="form-group">
                        <label >首页商品ids</label>
                        <input type="text" name="setting[index1_k]" class="form-control " value="{{$res['setting']['index1_k']['value']??'Best Sellers'}}">
                        <textarea name="setting[index1_v]" class="form-control " >{{$res['setting']['index1_v']['value']??''}}</textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label >首页商品ids</label>
                        <input type="text" name="setting[index2_k]" class="form-control " value="{{$res['setting']['index2_k']['value']??'New Arrivals'}}">
                        <textarea name="setting[index2_v]" class="form-control " >{{$res['setting']['index2_v']['value']??''}}</textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label >首页商品ids</label>
                        <input type="text" name="setting[index3_k]" class="form-control " value="{{$res['setting']['index3_k']['value']??'New Arrivals'}}">
                        <textarea name="setting[index3_v]" class="form-control " >{{$res['setting']['index3_v']['value']??''}}</textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label >首页商品ids</label>
                        <input type="text" name="setting[index4_k]" class="form-control " value="{{$res['setting']['index4_k']['value']??'New Arrivals'}}">
                        <textarea name="setting[index4_v]" class="form-control " >{{$res['setting']['index4_v']['value']??''}}</textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="tab-pane fade " id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="form-group">
                        <label >review (是否打开)</label>
                        <select name="setting[review]" class="form-control" >
                            @if(isset($dict['yes_no']))
                                @foreach($dict['yes_no'] as $key=>$val)
                                    <option value="{{$key}}" @if(($res['setting']['review']['value']??0)==$key) selected @endif>{{$val}}</option>
                                @endforeach
                            @endif
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label >review限制(需要审核)</label>
                        <select name="setting[review_limit]" class="form-control" >
                            @if(isset($dict['yes_no']))
                                @foreach($dict['yes_no'] as $key=>$val)
                                    <option value="{{$key}}" @if(($res['setting']['review_limit']['value']??0)==$key) selected @endif>{{$val}}</option>
                                @endforeach
                            @endif
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label >全站优惠券</label>
                        <input type="text" name="setting[coupon]" class="form-control " value="{{$res['setting']['coupon']['value']??''}}">
                        <div class="invalid-feedback"></div>
                    </div>
{{--                    <div class="form-group">--}}
{{--                        <label >退换货姓名(默认)</label>--}}
{{--                        <input type="text" name="setting[service_name]" class="form-control " value="{{$res['setting']['service_name']['value']??''}}">--}}
{{--                        <div class="invalid-feedback"></div>--}}
{{--                    </div>--}}
{{--                    <div class="form-group">--}}
{{--                        <label >退换货地址(默认)</label>--}}
{{--                        <input type="text" name="setting[service_address]" class="form-control " value="{{$res['setting']['service_address']['value']??''}}">--}}
{{--                        <div class="invalid-feedback"></div>--}}
{{--                    </div>--}}
{{--                    <div class="form-group">--}}
{{--                        <label >退换货邮编(默认)</label>--}}
{{--                        <input type="text" name="setting[service_postcode]" class="form-control " value="{{$res['setting']['service_postcode']['value']??''}}">--}}
{{--                        <div class="invalid-feedback"></div>--}}
{{--                    </div>--}}
{{--                    <div class="form-group">--}}
{{--                        <label >退换货电话(默认)</label>--}}
{{--                        <input type="text" name="setting[service_phone]" class="form-control " value="{{$res['setting']['service_phone']['value']??''}}">--}}
{{--                        <div class="invalid-feedback"></div>--}}
{{--                    </div>--}}
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="form-group">
                        <label >尺寸单位</label>
                        <select name="setting[length_class]" class="form-control" >
                            @if(isset($dict['length_class']))
                                @foreach($dict['length_class'] as $key=>$val)
                                    <option value="{{$key}}" @if(($res['setting']['length_class']['value']??'')==$key) selected @endif>{{$val}}</option>
                                @endforeach
                            @endif
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label >重量单位</label>
                        <select name="setting[weight_class]" class="form-control" >
                            @if(isset($dict['weight_class']))
                                @foreach($dict['weight_class'] as $key=>$val)
                                    <option value="{{$key}}" @if(($res['setting']['weight_class']['value']??'')==$key) selected @endif>{{$val}}</option>
                                @endforeach
                            @endif
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-order" role="tabpanel" aria-labelledby="nav-order-tab">
                    <div class="form-group">
                        <label >cancel within 24h (fee 10%)</label>
                        <input type="text" name="setting[order_cancel_24]" class="form-control " value="{{$res['setting']['order_cancel_24']['value']??10}}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label >Cancel within 24 to 48 hours (fee 20%)</label>
                        <input type="text" name="setting[order_cancel_24_48]" class="form-control " value="{{$res['setting']['order_cancel_24_48']['value']??20}}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label >cancel over 48h (fee 40%)</label>
                        <input type="text" name="setting[order_cancel_48]" class="form-control " value="{{$res['setting']['order_cancel_48']['value']??40}}">
                        <div class="invalid-feedback"></div>
                    </div>


                </div>
                <div class="tab-pane fade" id="nav-service" role="tabpanel" aria-labelledby="nav-service-tab">
                    <div>
                        <div>创建售后时，通知售后负责人</div>
                        <div class="form-group">
                            <label >售后通知email （空代表不会收到售后通知）</label>
                            <input type="text" name="setting[after_sales_email]" class="form-control " value="{{$res['setting']['after_sales_email']['value']??''}}">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
            </div>

            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>

</div>

