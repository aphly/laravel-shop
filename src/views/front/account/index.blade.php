@include('laravel-shop::front.common.header')
<link rel="stylesheet" href="{{ URL::asset('static/base/front/css/account.css') }}">
<section class="container">
    <style>
        .avatar{width: 200px;height: 200px;margin-top: 20px;cursor: pointer}
        .avatar img{width: 100%;height: 100%;border-radius: 50%;}
        .avatar i{font-size: 100px;}

    </style>
    <div class="account_info">
        @include('laravel-shop::front.account.left_menu')
        <div class="account-main-section">
            <div class="top-desc d-flex justify-content-between">
                <h2>Dashboard</h2>
            </div>
            <div style="margin-bottom: 20px;">
                <div class="account_avatar avatar" onclick="$('.form-control-file').click()">
                    <img class="lazy " src="{{$user->avatar_src}}" />
                </div>
                <canvas id="avatar_canvas" style="display: none"></canvas>
            </div>

            <div style="display: none">
                <input type="file" accept="image/gif,image/jpeg,image/jpg,image/png" id="image" name="image" class="form-control-file " >
            </div>

            <form action="/account/index" method="post" class="form_request" data-fn="account_res">
                @csrf
                <div class="form-group">
                    <label >nickname</label>
                    <input type="text" name="nickname" class="form-control " value="{{$user->nickname}}">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="form-group">
                    <label >password</label>
                    <input type="password" name="password" class="form-control " value="">
                    <div class="invalid-feedback"></div>
                </div>

                @foreach($user->userAuth as $val)
                    <div class="form-group">
                        <label >{{$val->id_type}}</label>
                        <input type="text" name="{{$val->id_type}}" class="form-control " readonly value="{{$val->id}}">
                        <div class="invalid-feedback"></div>
                    </div>
                @endforeach
                <button class="btn btn-primary" type="submit">Save</button>
            </form>
        </div>
    </div>
</section>
<script>
    function account_res(res,that) {

    }
    let uploading = false
    $(function () {
        $('#image').change(function (e) {
            $('.account_avatar').hide()
            $('#avatar_canvas').show()
            const file = e.target.files[0];
            const reader = new FileReader();
            reader.onload = function(event) {
                const img = new Image();
                img.onload = function() {
                    let wh = 200;
                    const canvas = document.getElementById('avatar_canvas');
                    const ctx = canvas.getContext('2d');
                    const scaleSize = wh / Math.max(img.width, img.height);
                    const width = img.width * scaleSize;
                    const height = img.height * scaleSize;
                    canvas.width = wh;
                    canvas.height = wh;
                    let mw = (wh- width)/2
                    let mh = (wh- height)/2
                    ctx.drawImage(img, mw, mh, width, height);
                    canvas.toBlob(function(blob) {
                        const formData = new FormData();
                        formData.append('image', blob, 'canvas-upload.png');
                        formData.append('_token', '{{csrf_token()}}');
                        if(!uploading){
                            uploading = true
                            $.ajax({
                                type:'post',
                                url:'/account/avatar',
                                data: formData,
                                contentType: false,
                                processData: false,
                                dataType: "json",
                                success: function(res){
                                    if(!res.code) {
                                        $('.account_avatar img').attr('src',res.data.avatar)
                                        $('.account_avatar').show()
                                        $('#avatar_canvas').hide()
                                    }else{
                                        alert_msg(res.msg);
                                    }
                                },
                                complete:function(XMLHttpRequest,textStatus){
                                    //console.log(XMLHttpRequest,textStatus)
                                    uploading = false
                                }
                            })
                        }else{
                            alert_msg("Uploading in progress")
                        }

                    }, 'image/png',1);
                };
                img.src = event.target.result;
            };
            reader.readAsDataURL(file);
        })
    })

</script>
@include('laravel-shop::front.common.footer')
