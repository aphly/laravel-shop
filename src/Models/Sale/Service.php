<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;
    protected $table = 'shop_service';
    //public $timestamps = false;

    protected $fillable = [
        'order_id','uuid','is_received','is_opened','reason','service_action_id','service_status_id','delete_at'
    ];

    public function product(){
        return $this->hasMany(ServiceProduct::class,'service_id','id');
    }

    public function order(){
        return $this->hasOne(Order::class,'id','order_id');
    }

    public function addServiceHistory($info, $service_status_id, $input = []){

        if($info->service_action_id==1){
            if($service_status_id==1){
            }else if($service_status_id==2){
            }else if($service_status_id==3){
            }else if($service_status_id==4){
            }else if($service_status_id==5){
            }
        }else if($info->service_action_id==2){
            if($service_status_id==1){
            }else if($service_status_id==2){
            }else if($service_status_id==3){
            }else if($service_status_id==4){
                $info->c_shipping = $input['c_shipping']??'';
                $info->c_shipping_no = $input['c_shipping_no']??'';
                $input['override'] = 1;
            }else if($service_status_id==5){
            }
        }else if($info->service_action_id==3){
            if($service_status_id==1){
            }else if($service_status_id==2){
            }else if($service_status_id==3){
            }else if($service_status_id==4){
                $info->c_shipping = $input['c_shipping']??'';
                $info->c_shipping_no = $input['c_shipping_no']??'';
                $input['override'] = 1;
            }else if($service_status_id==5){
                $info->shipping_id = $input['shipping_id']??'';
                $info->b_shipping_no = $input['b_shipping_no']??'';
                $input['override'] = 1;
            }
        }
        if($input['override']??false){
            ServiceHistory::where(['service_id'=>$info->id,'service_status_id'=>$service_status_id])->delete();
        }
        $serviceHistory = ServiceHistory::create([
            'service_id'=>$info->id,
            'service_action_id'=>$info->service_action_id,
            'service_status_id'=>$service_status_id,
            'comment'=>$input['comment']??'',
            'notify'=>$input['notify']??0
        ]);
        if($serviceHistory->id){
            $info->service_status_id = $service_status_id;
            $info->save();
        }
    }

}
