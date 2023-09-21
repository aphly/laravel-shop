<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Model;
use Aphly\LaravelCommon\Models\Currency;
use Aphly\LaravelCommon\Models\RemoteEmail;
use Aphly\LaravelPayment\Models\Payment;
//use Aphly\LaravelShop\Jobs\Service\Refund;
use Aphly\LaravelShop\Mail\Service\Agree;
use Aphly\LaravelShop\Mail\Service\Awaiting;
use Aphly\LaravelShop\Mail\Service\Refund;
use Aphly\LaravelShop\Mail\Service\Refusal;
use Aphly\LaravelShop\Mail\Service\Request;
use Aphly\LaravelShop\Models\System\Setting;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;
    protected $table = 'shop_service';
    //public $timestamps = false;

    protected $fillable = [
        'order_id','uuid','is_received','is_opened','reason','service_action_id','service_status_id','delete_at',
        'service_address','service_name','service_postcode','service_phone'
    ];

    public function product(){
        return $this->hasMany(ServiceProduct::class,'service_id','id');
    }

    public function order(){
        return $this->hasOne(Order::class,'id','order_id');
    }

    function img(){
        return $this->hasMany(ServiceImage::class,'service_id');
    }

    public function addServiceHistory($info, $service_status_id, $input = []){
        $shop_setting = Setting::findAll();
        $notify = $amount = 0;
        if($info->service_action_id==1){
            if($service_status_id==1){
                //Refund::dispatch($info)->delay(now()->addMinutes(48));
                $notify = $shop_setting['service_request_notify'];
            }else if($service_status_id==2){
            }else if($service_status_id==3){
            }else if($service_status_id==4){
                if($info->refund_amount>0 && $info->service_status_id==3){
                    (new Payment)->refund_api($info->order->payment_id,$info->refund_amount,'System Refund');
                    $info->order->addOrderHistory($info->order, 4);
                }
            }
        }else if($info->service_action_id==2){
            if($service_status_id==1){
                $notify = $shop_setting['service_request_notify'];
            }else if($service_status_id==2){
            }else if($service_status_id==3){
                $info->service_name = $input['service_name'];
                $info->service_address = $input['service_address'];
                $info->service_postcode = $input['service_postcode'];
                $info->service_phone = $input['service_phone'];
            }else if($service_status_id==4){
                $notify = $shop_setting['service_awaiting_notify'];
                $info->c_shipping = $input['c_shipping']??'';
                $info->c_shipping_no = $input['c_shipping_no']??'';
            }else if($service_status_id==5){
            }else if($service_status_id==6){
                if($info->refund_amount>0 && $info->service_status_id==5){
                    $fee = intval($input['fee']);
                    if($fee>=0 && $fee<=100){
                        list($amount,$amount_format) = Currency::codeFormat((100 - $fee) / 100 * $info->refund_amount, $info->currency_code);
                        if ($amount > 0) {
                            (new Payment)->refund_api($info->order->payment_id,$amount,'System refund -' . $fee . '% transaction fee');
                        }
                        $info->order->addOrderHistory($info->order, 4);
                    }else{
                        throw new ApiException(['code'=>1,'msg'=>'Fee error']);
                    }
                }
            }
        }
        $override = $input['override']??false;
        if($override){
            $serviceHistory = ServiceHistory::where(['service_id'=>$info->id,'service_status_id'=>$service_status_id])->orderBy('created_at','desc')->first();
            if(!empty($serviceHistory)){
                $serviceHistory->update([
                    'comment'=>$input['comment']??'',
                    'notify'=>$input['notify']??$notify
                ]);
            }
        }else{
            $serviceHistory = ServiceHistory::create([
                'service_id'=>$info->id,
                'service_action_id'=>$info->service_action_id,
                'service_status_id'=>$service_status_id,
                'comment'=>$input['comment']??'',
                'notify'=>$input['notify']??$notify
            ]);
            $info->service_status_id = $service_status_id;
        }
        if(!empty($serviceHistory)){
            if($info->save() && $serviceHistory->notify==1){
                if($info->service_action_id==1){
                    if($service_status_id==1){
                        if($shop_setting['service_email']){
                            (new RemoteEmail())->send([
                                'email'=>$shop_setting['service_email'],
                                'title'=>'Service Request',
                                'content'=>(new Request($info))->render(),
                                'type'=>config('common.email_type'),
                                'queue_priority'=>0,
                                'is_cc'=>0
                            ]);
                        }
                    }else if($service_status_id==2){
                        (new RemoteEmail())->send([
                            'email'=>$info->order->email,
                            'title'=>'Service Refusal',
                            'content'=>(new Refusal($info))->render(),
                            'type'=>config('common.email_type'),
                            'queue_priority'=>0,
                            'is_cc'=>0
                        ]);
                    }else if($service_status_id==3){
                    }else if($service_status_id==4){
                        (new RemoteEmail())->send([
                            'email'=>$info->order->email,
                            'title'=>'Service Refund',
                            'content'=>(new Refund($info))->render(),
                            'type'=>config('common.email_type'),
                            'queue_priority'=>0,
                            'is_cc'=>0
                        ]);
                    }
                }else if($info->service_action_id==2){
                    if($service_status_id==1){
                        if($shop_setting['service_email']){
                            (new RemoteEmail())->send([
                                'email'=>$shop_setting['service_email'],
                                'title'=>'Service Request',
                                'content'=>(new Request($info))->render(),
                                'type'=>config('common.email_type'),
                                'queue_priority'=>0,
                                'is_cc'=>0
                            ]);
                        }
                    }else if($service_status_id==2){
                        (new RemoteEmail())->send([
                            'email'=>$info->order->email,
                            'title'=>'Service Refusal',
                            'content'=>(new Refusal($info))->render(),
                            'type'=>config('common.email_type'),
                            'queue_priority'=>0,
                            'is_cc'=>0
                        ]);
                    }else if($service_status_id==3){
                        (new RemoteEmail())->send([
                            'email'=>$info->order->email,
                            'title'=>'Service Agree',
                            'content'=>(new Agree($info))->render(),
                            'type'=>config('common.email_type'),
                            'queue_priority'=>0,
                            'is_cc'=>0
                        ]);
                    }else if($service_status_id==4){
                        if($shop_setting['service_email']) {
                            (new RemoteEmail())->send([
                                'email' => $shop_setting['service_email'],
                                'title' => 'Service Awaiting',
                                'content' => (new Awaiting($info))->render(),
                                'type' => config('common.email_type'),
                                'queue_priority' => 0,
                                'is_cc' => 0
                            ]);
                        }
                    }else if($service_status_id==5){
                    }else if($service_status_id==6 && $amount > 0){
                        $info->email_refund_amount = $amount_format;
                        $info->email_refund_fee = $fee;
                        (new RemoteEmail())->send([
                            'email'=>$info->order->email,
                            'title'=>'Service Refund',
                            'content'=>(new Refund($info))->render(),
                            'type'=>config('common.email_type'),
                            'queue_priority'=>0,
                            'is_cc'=>0
                        ]);
                    }
                }
            }
        }

    }

}
