
<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<div class="imain">
    <form method="post" action="/shop_admin/setting/save" class="save_form">
        @csrf
        <div class="">
            <nav style="margin-bottom: 20px;">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">shop</a>
                    <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">params</a>
                    <a class="nav-link" id="nav-order-tab" data-toggle="tab" href="#nav-order" role="tab" aria-controls="nav-order" aria-selected="false">order</a>
                    <a class="nav-link" id="nav-service-tab" data-toggle="tab" href="#nav-service" role="tab" aria-controls="nav-service" aria-selected="false">service</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="form-group">
                        <label for="">review (是否打开)</label>
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
                        <label for="">退换货姓名(默认)</label>
                        <input type="text" name="setting[service_name]" class="form-control " value="{{$res['setting']['service_name']['value']??''}}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="">退换货地址(默认)</label>
                        <input type="text" name="setting[service_address]" class="form-control " value="{{$res['setting']['service_address']['value']??''}}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="">退换货邮编(默认)</label>
                        <input type="text" name="setting[service_postcode]" class="form-control " value="{{$res['setting']['service_postcode']['value']??''}}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="">退换货电话(默认)</label>
                        <input type="text" name="setting[service_phone]" class="form-control " value="{{$res['setting']['service_phone']['value']??''}}">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="form-group">
                        <label for="">国家</label>
                        <select name="setting[country]" class="form-control" >
                            @if(isset($res['country']))
                                @foreach($res['country'] as $key=>$val)
                                    <option value="{{$key}}" @if(($res['setting']['country']['value']??'')==$key) selected @endif>{{$val['name']}}</option>
                                @endforeach
                            @endif
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="">尺寸单位</label>
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
                        <label for="">重量单位</label>
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
                        <label for="">cancel over 24h (fee 20%)</label>
                        <input type="text" name="setting[order_cancel_fee]" class="form-control " value="{{$res['setting']['order_cancel_fee']['value']??20}}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="">cancel within 24h (fee 10%)</label>
                        <input type="text" name="setting[order_cancel_fee_24]" class="form-control " value="{{$res['setting']['order_cancel_fee_24']['value']??10}}">
                        <div class="invalid-feedback"></div>
                    </div>

                    <div>
                        <div>
                            邮件通知客户
                        </div>
                        <div class="form-group">
                            <label for="">下单</label>
                            <select name="setting[order_paid_notify]" class="form-control" >
                            @if(isset($dict['yes_no']))
                                @foreach($dict['yes_no'] as $key=>$val)
                                    <option value="{{$key}}" @if(($res['setting']['order_paid_notify']['value']??0)==$key) selected @endif>{{$val}}</option>
                                @endforeach
                            @endif
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="">取消</label>
                            <select name="setting[order_canceled_notify]" class="form-control" >
                            @if(isset($dict['yes_no']))
                                @foreach($dict['yes_no'] as $key=>$val)
                                    <option value="{{$key}}" @if(($res['setting']['order_canceled_notify']['value']??0)==$key) selected @endif>{{$val}}</option>
                                @endforeach
                            @endif
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-group">
                            <label for="">退款</label>
                            <select name="setting[order_refunded_notify]" class="form-control" >
                                @if(isset($dict['yes_no']))
                                    @foreach($dict['yes_no'] as $key=>$val)
                                        <option value="{{$key}}" @if(($res['setting']['order_refunded_notify']['value']??0)==$key) selected @endif>{{$val}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-service" role="tabpanel" aria-labelledby="nav-service-tab">
                    <div class="form-group">
                        <label for="">exchange (换货是否打开)</label>
                        <select name="setting[exchange]" class="form-control" >
                            @if(isset($dict['yes_no']))
                                @foreach($dict['yes_no'] as $key=>$val)
                                    <option value="{{$key}}" @if(($res['setting']['exchange']['value']??0)==$key) selected @endif>{{$val}}</option>
                                @endforeach
                            @endif
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="">未收到货 - 退款手续费(%)</label>
                        <input type="text" name="setting[service_refund_fee]" class="form-control " value="{{$res['setting']['service_refund_fee']['value']??30}}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="">收到货 - 退货手续费(%)</label>
                        <input type="text" name="setting[service_return_fee]" class="form-control " value="{{$res['setting']['service_return_fee']['value']??50}}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div>
                        <div>通知售后负责人</div>
                        <div class="form-group">
                            <label for="">售后通知email （空代表不会收到售后通知）</label>
                            <input type="text" name="setting[service_email]" class="form-control " value="{{$res['setting']['service_email']['value']??''}}">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="">售后申请</label>
                            <select name="setting[service_request_notify]" class="form-control" >
                                @if(isset($dict['yes_no']))
                                    @foreach($dict['yes_no'] as $key=>$val)
                                        <option value="{{$key}}" @if(($res['setting']['service_request_notify']['value']??0)==$key) selected @endif>{{$val}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="">客户发货</label>
                            <select name="setting[service_awaiting_notify]" class="form-control" >
                                @if(isset($dict['yes_no']))
                                    @foreach($dict['yes_no'] as $key=>$val)
                                        <option value="{{$key}}" @if(($res['setting']['service_awaiting_notify']['value']??0)==$key) selected @endif>{{$val}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="">售后退款</label>
                            <select name="setting[service_refund_notify]" class="form-control" >
                                @if(isset($dict['yes_no']))
                                    @foreach($dict['yes_no'] as $key=>$val)
                                        <option value="{{$key}}" @if(($res['setting']['service_refund_notify']['value']??0)==$key) selected @endif>{{$val}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                </div>
            </div>

            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>

</div>

