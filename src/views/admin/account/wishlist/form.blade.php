
<div class="top-bar">
    <h5 class="nav-title">{!! $res['breadcrumb'] !!}</h5>
</div>
<div class="imain">
    <form method="post" @if($res['info']->id) action="/shop_admin/Wishlist/save?id={{$res['info']->id}}" @else action="/shop_admin/Wishlist/save" @endif class="save_form">
        @csrf
        <div class="">
            <div class="form-group">
                <label for="">id</label>
                <input type="text" readonly class="form-control " value="{{$res['info']->id??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">uuid</label>
                <input type="text" name="uuid" readonly class="form-control " value="{{$res['info']->uuid??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">product_id</label>
                <input type="text" name="product_id" readonly class="form-control " value="{{$res['info']->product_id??''}}">
                <div class="invalid-feedback"><a href="/product/{{$res['info']->product_id}}">{{$res['info']->product->name}}</a></div>
            </div>

            <div class="form-group">
                <label for="">created_at</label>
                <input type="text" readonly class="form-control " value="{{$res['info']->created_at??0}}">
                <div class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label for="">updated_at</label>
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
