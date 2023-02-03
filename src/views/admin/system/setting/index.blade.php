
<div class="top-bar">
    <h5 class="nav-title">setting</h5>
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
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="form-group">
                        <label for="">email</label>
                        <input type="text" name="setting[email]" class="form-control " value="{{$res['setting']['email']['value']??''}}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="">telephone</label>
                        <input type="text" name="setting[telephone]" class="form-control " value="{{$res['setting']['telephone']['value']??''}}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="">address</label>
                        <input type="text" name="setting[address]" class="form-control " value="{{$res['setting']['address']['value']??''}}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="">review (是否打开)</label>
                        <select name="setting[review]" class="form-control" >
                            @if(isset($dict['yes_no']))
                                @foreach($dict['yes_no'] as $key=>$val)
                                    <option value="{{$key}}" @if(($res['setting']['review']['value']??2)==$key) selected @endif>{{$val}}</option>
                                @endforeach
                            @endif
                        </select>
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
                        <label for="">货币</label>
                        <select name="setting[currency]" class="form-control" >
                            @if(isset($res['currency']))
                                @foreach($res['currency'] as $key=>$val)
                                    <option value="{{$key}}" @if(($res['setting']['currency']['value']??'')==$key) selected @endif>{{$val['name']}}</option>
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
                        <label for="">cancel over 24h (fee 30%)</label>
                        <input type="text" name="setting[order_cancel_fee]" class="form-control " value="{{$res['setting']['order_cancel_fee']['value']??30}}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="">cancel within 24h (fee 10%)</label>
                        <input type="text" name="setting[order_cancel_fee_24]" class="form-control " value="{{$res['setting']['order_cancel_fee_24']['value']??10}}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="">exchange (是否打开)</label>
                        <select name="setting[exchange]" class="form-control" >
                            @if(isset($dict['yes_no']))
                                @foreach($dict['yes_no'] as $key=>$val)
                                    <option value="{{$key}}" @if(($res['setting']['exchange']['value']??2)==$key) selected @endif>{{$val}}</option>
                                @endforeach
                            @endif
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div>
                        <div>
                            Order status email notify
                        </div>
                        <div class="form-group">
                            <label for="">Processing</label>
                            <select name="setting[order_status_processing_notify]" class="form-control" >
                            @if(isset($dict['yes_no']))
                                @foreach($dict['yes_no'] as $key=>$val)
                                    <option value="{{$key}}" @if(($res['setting']['order_status_processing_notify']['value']??2)==$key) selected @endif>{{$val}}</option>
                                @endforeach
                            @endif
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="">Shipped</label>
                            <select name="setting[order_status_shipped_notify]" class="form-control" >
                            @if(isset($dict['yes_no']))
                                @foreach($dict['yes_no'] as $key=>$val)
                                    <option value="{{$key}}" @if(($res['setting']['order_status_shipped_notify']['value']??2)==$key) selected @endif>{{$val}}</option>
                                @endforeach
                            @endif
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="">Canceled</label>
                            <select name="setting[order_status_canceled_notify]" class="form-control" >
                            @if(isset($dict['yes_no']))
                                @foreach($dict['yes_no'] as $key=>$val)
                                    <option value="{{$key}}" @if(($res['setting']['order_status_canceled_notify']['value']??2)==$key) selected @endif>{{$val}}</option>
                                @endforeach
                            @endif
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-group">
                            <label for="">Refunded</label>
                            <select name="setting[order_status_refunded_notify]" class="form-control" >
                                @if(isset($dict['yes_no']))
                                    @foreach($dict['yes_no'] as $key=>$val)
                                        <option value="{{$key}}" @if(($res['setting']['order_status_refunded_notify']['value']??2)==$key) selected @endif>{{$val}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-group">
                            <label for="">Service</label>
                            <select name="setting[order_status_service_notify]" class="form-control" >
                            @if(isset($dict['yes_no']))
                                @foreach($dict['yes_no'] as $key=>$val)
                                    <option value="{{$key}}" @if(($res['setting']['order_status_service_notify']['value']??2)==$key) selected @endif>{{$val}}</option>
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

