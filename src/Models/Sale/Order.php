<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Mail\MailSend;
use Aphly\Laravel\Models\Model;
use Aphly\LaravelCommon\Models\Currency;
use Aphly\LaravelCommon\Models\RemoteEmail;
use Aphly\LaravelPayment\Models\Payment;
use Aphly\LaravelShop\Mail\Order\Cancel;
use Aphly\LaravelShop\Mail\Order\Paid;
use Aphly\LaravelShop\Mail\Order\Refunded;
use Aphly\LaravelShop\Mail\Order\Shipped;
use Aphly\LaravelShop\Models\Catalog\Product;
use Aphly\LaravelShop\Models\Catalog\ProductOptionValue;
use Aphly\LaravelShop\Models\Catalog\Shipping;
use Aphly\LaravelShop\Models\System\Setting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Order extends Model
{
    use HasFactory;
    protected $table = 'shop_order';
    public $incrementing = false;
    //public $timestamps = false;

    protected $fillable = [
        'id','uuid','email','address_id','address_firstname','address_lastname','address_address_1','address_address_2',
		'address_city','address_postcode','address_country','address_country_id','address_zone','address_zone_id','address_telephone',
		'shipping_id','shipping_name','shipping_desc','shipping_cost','shipping_free_cost','shipping_geo_group_id','payment_method_id',
		'payment_method_name','items','total','total_format','comment','currency_id','currency_code','currency_value','order_status_id',
		'ip','user_agent','accept_language','tracking'
    ];

    function orderStatus(){
        return $this->hasOne(OrderStatus::class,'id','order_status_id');
    }

    function orderProduct(){
        return $this->hasMany(OrderProduct::class,'order_id','id');
    }

    function orderTotal(){
        return $this->hasMany(OrderTotal::class,'order_id','id');
    }

    function orderHistory(){
        return $this->hasMany(OrderHistory::class,'order_id','id');
    }

    function orderShipping(){
        return $this->hasOne(Shipping::class,'id','shipping_id');
    }

    public function notify($payment)
    {
        $info = self::where(['payment_id'=>$payment->id])->lockForUpdate()->first();
        if(!empty($info) && $info->order_status_id==1){
            $info->order_status_id=2;
            if($info->save()){
                $this->addOrderHistory($info,$info->order_status_id);
            }
        }
    }

    public function handle($info){
        $orderProduct = OrderProduct::where('order_id',$info->id)->get()->toArray();
        foreach ($orderProduct as $val){
            //(new UserCredit)->handle('Reward', $info->uuid, 'point', '+', $val['reward'], 'payment_id#' . $info->payment_id);
            Product::where(['subtract'=>1,'id'=>$val['product_id']])->decrement('quantity',$val['quantity']);
            $orderOption = OrderOption::where(['order_id'=>$info->id,'order_product_id'=>$val['id']])->get()->toArray();
            foreach ($orderOption as $v){
                ProductOptionValue::where(['id'=>$v['product_option_value_id'],'subtract'=>1])->decrement('quantity',$val['quantity']);
            }
        }
    }

    public function rollback($info){
        $orderProduct = OrderProduct::where('order_id',$info->id)->get()->toArray();
        foreach ($orderProduct as $val){
            //(new UserCredit)->handle('Reward', $info->uuid, 'point', '-', $val['reward'], 'cancel#' . $info->payment_id);
            Product::where(['subtract'=>1,'id'=>$val['product_id']])->increment('quantity',$val['quantity']);
            $orderOption = OrderOption::where(['order_id'=>$info->id,'order_product_id'=>$val['id']])->get()->toArray();
            foreach ($orderOption as $v){
                ProductOptionValue::where(['id'=>$v['product_option_value_id'],'subtract'=>1])->increment('quantity',$val['quantity']);
            }
        }
    }

    public function addOrderHistory($info, $order_status_id, $input = []){
        $shop_setting = Setting::findAll();
        $notify = $amount = 0;
        if($order_status_id==2){
            //Paid
            $notify = $shop_setting['order_paid_notify'];
            $this->handle($info);
        }else if($order_status_id==3){
            //Shipped
            $info->shipping_no = $input['shipping_no']??'';
        }else if($order_status_id==6){
            //Canceled
            $notify = $shop_setting['order_canceled_notify'];
            $this->rollback($info);
        }else if($order_status_id==7){
            //Refunded
            $notify = $shop_setting['order_refunded_notify'];
            if($info->order_status_id>=2) {
                $fee = intval($input['fee']);
                if($fee>=0 && $fee<=100) {
                    list($amount, $amount_format) = Currency::codeFormat((100 - $fee) / 100 * $info->total, $info->currency_code);
                    if ($amount > 0) {
                        (new Payment)->refund_api($info->payment_id, $amount, 'System refund -' . $fee . '% transaction fee');
                    }
                    if ($info->order_status_id != 6) {
                        $this->rollback($info);
                    }
                }else{
                    throw new ApiException(['code'=>1,'msg'=>'Fee error']);
                }
            }
        }

        if($input['override']??false){
            $orderHistory = OrderHistory::where(['order_id'=>$info->id,'order_status_id'=>$order_status_id])->orderBy('created_at','desc')->first();
            if(!empty($orderHistory)){
                $orderHistory->update([
                    'comment'=>$input['comment']??'',
                    'notify'=>$input['notify']??$notify
                ]);
            }
        }else{
            $orderHistory = OrderHistory::create([
                'order_id'=>$info->id,
                'order_status_id'=>$order_status_id,
                'comment'=>$input['comment']??'',
                'notify'=>$input['notify']??$notify
            ]);
            $info->order_status_id = $order_status_id;
        }

        if(!empty($orderHistory) && $orderHistory->id){
            if($info->save() && $orderHistory->notify==1){
                if($order_status_id==2){
                    //Paid
                    (new RemoteEmail())->send([
                        'email'=>$info->email,
                        'title'=>'Order Paid',
                        'content'=>(new Paid($info))->render(),
                        'type'=>config('common.email_type'),
                        'queue_priority'=>0,
                        'is_cc'=>1
                    ]);
                }else if($order_status_id==3){
                    //Shipped
                    (new RemoteEmail())->send([
                        'email'=>$info->email,
                        'title'=>'Order Shipped',
                        'content'=>(new Shipped($info))->render(),
                        'type'=>config('common.email_type'),
                        'queue_priority'=>0,
                        'is_cc'=>0
                    ]);
                }else if($order_status_id==6){
                    //Canceled
                    $info->cancel_amount = $input['cancel_amount'];
                    $info->cancel_fee = $input['cancel_fee'];
                    (new RemoteEmail())->send([
                        'email'=>$info->email,
                        'title'=>'Order cancel',
                        'content'=>(new Cancel($info))->render(),
                        'type'=>config('common.email_type'),
                        'queue_priority'=>0,
                        'is_cc'=>1
                    ]);
                }else if($order_status_id==7 && $amount > 0){
                    //Refunded
                    $info->email_refund_amount = $amount_format;
                    $info->email_refund_fee = $fee;
                    (new RemoteEmail())->send([
                        'email'=>$info->email,
                        'title'=>'Order Refunded',
                        'content'=>(new Refunded($info,$orderHistory))->render(),
                        'type'=>config('common.email_type'),
                        'queue_priority'=>0,
                        'is_cc'=>0
                    ]);
                }
            }
        }
    }


}
