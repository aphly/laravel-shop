
<div class="top-bar">
    <h5 class="nav-title">customer</h5>
</div>
<div class="imain">
    <form method="post" @if($res['customer']->uuid) action="/shop_admin/customer/save?uuid={{$res['customer']->uuid}}" @else action="/shop_admin/customer/save" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">uuid</label>
                <input type="text" class="form-control " readonly value="{{$res['customer']->uuid}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">用户组</label>
                <select name="group_id" class="form-control " >
                    @foreach($res['customer_group'] as $val)
                    <option value="{{$val['id']}}" @if($res['customer']->group_id==$val['id']) selected @endif>{{$val['name']}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">地址</label>
                <select name="address_id" class="form-control " >
                    @if($res['customer_addr'])
                        @foreach($res['customer_addr'] as $val)
                            <option value="{{$val['address_id']}}" @if($res['customer']->address_id==$val['address_id']) selected @endif>{{$val['country_name']}} {{$val['zone_name']}} {{$val['city']}} {{$val['address_1']}}</option>
                        @endforeach
                    @endif
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>

</div>
<style>

</style>
<script>

</script>
