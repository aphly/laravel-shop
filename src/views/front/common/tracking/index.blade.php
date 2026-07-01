@include('laravel-shop::front.common.header')
<div class="container">
    <div style="font-weight: 600;font-size: 18px;margin-top: 10px;">
        {{$res['title']}}
    </div>
    @if(!$res['order_number'])
        <div >
            <form action="/tracking/index" method="post" class="form_request" data-fn="tracking_res">
                @csrf
                <div class="form-group" style="margin-top: 10px;">
                    <label >Order Number</label>
                    <input type="text" name="order_number" value="{{$res['order_number']}}" class="form-control" required placeholder="Please enter Order Number" autocomplete="off">
                </div>
                <button class="btn btn-primary text-brand" style="width: 100%;height: 40px;" type="submit">Search</button>
            </form>
        </div>
    @else
        <div>
            <div class="package_box">
                <div style="">
                    <div class="tracking_left">Tracking Number</div>
                    <div class="">{{$res['order_number']}}</div>
                </div>
            </div>
        </div>
    @endif
    <div style="margin-top: 20px;margin-bottom: 50px;" class="tracking_res">
        <div class="package_box">
            <div style="">
                <div class="tracking_left">Delivery Address</div>
                <div class="addr"></div>
            </div>
        </div>
        <ul id="track_events" class="track_events"></ul>
    </div>
    <div class="tracking_loading"><i class="btn_loading app-jiazai uni"></i></div>
</div>

<style>
    .tracking_loading{text-align: center;margin-top: 20px;display: none;}
    .tracking_loading .app-jiazai{font-size: 30px;}
    .package_box{margin-top: 10px;}
    .track_events{margin-top: 10px;}
    .form_request .form-group{margin-bottom: 10px}
    .tracking_left{font-size: 16px;font-weight: 600;}
    .track_events li{color: #aaa;display: flex;margin-top: 10px;position: relative}
    .track_events li:first-child{font-weight: 600;color:#000;}
    .track_events li .flag2{margin-left: 20px;}
    .track_events li .flag3{margin-left: 20px;}
    .track_events li  .flag1{display: flex;justify-content: center;width: 16px;align-items: center;}
    .track_events li .flag1a{position: absolute;top:4px;border-radius: 50%;border:2px solid #aaa;width: 6px;height:6px;}
    .track_events li .flag1b{position: absolute;top: 4px;width: 0;border-style: dashed;border-left-width: 1px;border-color:#aaa;height: 100%;transform: scale(0.5);}
    .icon-chenggong{    color: #43a524; z-index: 1; position: relative;}
    .tracking_res{display: none;}
</style>

<script>
    function tracking_res(res,that) {
        if(res.code){
            alert_res(res)
            return
        }
        let html = '';
        if(res.data.tracking.success){
            let track_events  = res.data.tracking.result[0]['track_Info']['track_events']
            if(track_events){
                let sortArr = track_events.sort((a, b) => {
                    return new Date(b.process_utc_time) - new Date(a.process_utc_time);
                });
                sortArr.forEach((item, index)=>{
                    let LocalTime = utcToLocal(item.process_utc_time)
                    html += `<li>
                                <div class="flag1"><div class="flag1a"></div><div class="flag1b"></div></div>
                                <div>
                                    <div class="flag2">${LocalTime}</div>
                                    <div class="flag3">${item.process_content}</div>
                                </div>
                            </li>`
                })
            }

            $('.addr').html(res.data.orderInfo.addr)

        }
        $('#track_events').html(html)
        $('.tracking_res').show();
    }

    function utcToLocal(utcTime) {
        const date = new Date(utcTime);
        return date.toLocaleString({
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        }).replace(/\//g, '-');
    }

    $(function () {
        request_url()
    })

    function request_url() {
        @if($res['order_number'])
            $('.tracking_loading').show()
        $.ajax({
            type:'POST',
            url:'/tracking/index',
            data:{'_token':'{{csrf_token()}}',order_number:'{{$res['order_number']}}'},
            dataType: "json",
            success: function(res){
                $('.tracking_loading').hide()
                tracking_res(res)
            },
        });
        @endif
    }

    // let tt = [
    //     {
    //         "process_time": "2024-06-18T16:52:53Z",
    //         "process_utc_time": "2024-06-18T16:52:53Z",
    //         "process_content": "Shipment information received",
    //         "process_country": "",
    //         "process_province": "",
    //         "process_city": "",
    //         "process_location": "",
    //         "track_node_code": "ORDER_CREATION",
    //         "track_node_description": "",
    //         "node_labels": [
    //             {
    //                 "label_code": "",
    //                 "label_name": "",
    //                 "label_name_en": ""
    //             }
    //         ],
    //         "pod_url": "",
    //         "pod_urls": [],
    //         "IsSignature": true,
    //         "SignatureUrls": []
    //     },
    //     {
    //         "process_time": "2024-06-18T16:54:51Z",
    //         "process_utc_time": "2024-06-18T08:54:51Z",
    //         "process_content": "Arrived at origin facility11",
    //         "process_country": "",
    //         "process_province": "",
    //         "process_city": "Washington",
    //         "process_location": "Washington",
    //         "track_node_code": "FIRST_MILE_ARRIVE",
    //         "track_node_description": "",
    //         "node_labels": [
    //             {
    //                 "label_code": "",
    //                 "label_name": "",
    //                 "label_name_en": ""
    //             }
    //         ],
    //         "pod_url": "",
    //         "pod_urls": [],
    //         "IsSignature": true,
    //         "SignatureUrls": []
    //     },
    //     {
    //         "process_time": "2024-06-18T16:54:57Z",
    //         "process_utc_time": "2024-06-19T03:25:57Z",
    //         "process_content": "Departed from sort facility",
    //         "process_country": "",
    //         "process_province": "",
    //         "process_city": "futiankouan",
    //         "process_location": "futiankouan",
    //         "track_node_code": "FIRST_MILE_DEPART",
    //         "track_node_description": "",
    //         "node_labels": [
    //             {
    //                 "label_code": "",
    //                 "label_name": "",
    //                 "label_name_en": ""
    //             }
    //         ],
    //         "pod_url": "",
    //         "pod_urls": [],
    //         "IsSignature": true,
    //         "SignatureUrls": []
    //     }
    // ]
    // let h1 = ``;
    // const sortAsc = tt.sort((a, b) => {
    //     return new Date(b.process_utc_time) - new Date(a.process_utc_time);
    // });
    // sortAsc.forEach((item, index)=>{
    //     let LocalTime = utcToLocal(item.process_utc_time)
    //     if(!index){
    //         h1 += `<li>
    //                 <div class="flag1"><div class="common-iconfont icon-chenggong1"></div></div>
    //                 <div>
    //                     <div class="flag2">${LocalTime}</div>
    //                     <div class="flag3">${item.process_content}</div>
    //                 </div>
    //             </li>`
    //     }else{
    //         h1 += `<li>
    //                 <div class="flag1"><div class="flag1a"></div><div class="flag1b"></div></div>
    //                 <div>
    //                     <div class="flag2">${LocalTime}</div>
    //                     <div class="flag3">${item.process_content}</div>
    //                 </div>
    //             </li>`
    //     }
    // })
    // $('#track_events').html(h1)
</script>
@include('laravel-shop::front.common.footer')
