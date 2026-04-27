
<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<div class="imain">
    <form method="post" @if($res['info']->id) action="/shop_admin/user_address/save?id={{$res['info']->id}}" @else action="/shop_admin/user_address/save" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label >id</label>
                <input type="text" readonly class="form-control " value="{{$res['info']->id??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label >uid</label>
                <input type="text" name="uid" required class="form-control " value="{{$res['info']->uid??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label >firstname</label>
                <input type="text" name="firstname" class="form-control " value="{{$res['info']->firstname??''}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label >lastname</label>
                <input type="text" name="lastname" class="form-control " value="{{$res['info']->lastname??''}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label >address_1</label>
                <input type="text" name="address_1" required class="form-control " value="{{$res['info']->address_1??''}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label >address_2</label>
                <input type="text" name="address_2" class="form-control " value="{{$res['info']->address_2??''}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label >city</label>
                <input type="text" name="city" class="form-control " value="{{$res['info']->city??''}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label >postcode</label>
                <input type="text" name="postcode" class="form-control " value="{{$res['info']->postcode??''}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label >telephone</label>
                <input type="text" name="telephone" class="form-control " value="{{$res['info']->telephone??''}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label >country</label>
                <select name="country_id" required id="input-country" class="form-control">
                    <option value=""> --- Please Select --- </option>
                    @foreach($res['country'] as $val)
                        <option value="{{$val['id']}}" @if($val['id']==$res['info']->country_id) selected @endif>{{$val['name']}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label >zone</label>
                <select name="zone_id" required id="input-zone" class="form-control">
                    @if($res['zone'])
                        <option value=""> --- Please Select --- </option>
                        @foreach($res['zone'] as $val)
                            <option value="{{$val['id']}}" @if($val['id']==$res['info']->zone_id) selected @endif>{{$val['name']}}</option>
                        @endforeach
                    @else
                        <option value=""> --- None --- </option>
                    @endif
                </select>
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label >created_at</label>
                <input type="text" readonly class="form-control " value="{{$res['info']->created_at??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label >updated_at</label>
                <input type="text" readonly class="form-control " value="{{$res['info']->updated_at??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>

</div>
<style>

</style>
<script>
    var country_zone = {};
    function mount(){
        $('#input-country').change(function () {
            let country_id = $(this).val();
            if(country_id in country_zone){
                makeZone(country_zone[country_id])
            }else{
                if(country_id){
                    $.ajax({
                        url:'/country/'+country_id+'/zone',
                        dataType: "json",
                        success: function(res){
                            country_zone[country_id] = res.data;
                            makeZone(country_zone[country_id])
                        }
                    })
                }else{
                    let html = '<option value=""> --- None --- </option>';
                    $('#input-zone').html(html)
                }
            }
        })
    }
    $(function () {
        mount()
    })
    function makeZone(data){
        let html = '<option value=""> --- Please Select --- </option>';
        for(let i in data){
            html += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
        }
        $('#input-zone').html(html)
    }
</script>
