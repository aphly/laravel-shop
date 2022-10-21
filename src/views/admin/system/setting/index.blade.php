
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
                    <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">本地参数</a>
                    <a class="nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">选项</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                    <div class="form-group">
                        <label for="">email</label>
                        <input type="text" name="config[email]" class="form-control " value="{{$res['config']['email']['value']??''}}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="">telephone</label>
                        <input type="text" name="config[telephone]" class="form-control " value="{{$res['config']['telephone']['value']??''}}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="">address</label>
                        <input type="text" name="config[address]" class="form-control " value="{{$res['config']['address']['value']??''}}">
                        <div class="invalid-feedback"></div>
                    </div>

                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="form-group">
                        <label for="">国家</label>
                        <select name="config[country]" class="form-control" >
                            @if(isset($res['country']))
                                @foreach($res['country'] as $key=>$val)
                                    <option value="{{$key}}" @if(($res['config']['country']['value']??'')==$key) selected @endif>{{$val['name']}}</option>
                                @endforeach
                            @endif
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="">货币</label>
                        <select name="config[currency]" class="form-control" >
                            @if(isset($res['currency']))
                                @foreach($res['currency'] as $key=>$val)
                                    <option value="{{$key}}" @if(($res['config']['currency']['value']??'')==$key) selected @endif>{{$val['name']}}</option>
                                @endforeach
                            @endif
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="">尺寸单位</label>
                        <select name="config[length_class]" class="form-control" >
                            @if(isset($dict['length_class']))
                                @foreach($dict['length_class'] as $key=>$val)
                                    <option value="{{$key}}" @if(($res['config']['length_class']['value']??'')==$key) selected @endif>{{$val}}</option>
                                @endforeach
                            @endif
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="">重量单位</label>
                        <select name="config[weight_class]" class="form-control" >
                            @if(isset($dict['weight_class']))
                                @foreach($dict['weight_class'] as $key=>$val)
                                    <option value="{{$key}}" @if(($res['config']['weight_class']['value']??'')==$key) selected @endif>{{$val}}</option>
                                @endforeach
                            @endif
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <div class="form-group">
                        <label for="">默认会员等级</label>
                        <select name="config[group]" class="form-control" >
                            @if(isset($res['group']))
                                @foreach($res['group'] as $key=>$val)
                                    <option value="{{$key}}" @if(($res['config']['group']['value']??'')==$key) selected @endif>{{$val['name']}}</option>
                                @endforeach
                            @endif
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
            </div>


            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>

</div>

