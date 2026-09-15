<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Model;
use Aphly\LaravelPayment\Models\Currency;
use Aphly\Laravel\Models\RemoteEmail;
use Aphly\LaravelPayment\Models\Payment;
use Aphly\LaravelShop\Mail\Order\Cancel;
use Aphly\LaravelShop\Mail\Order\Paid;
use Aphly\LaravelShop\Mail\Order\Refunded;
use Aphly\LaravelShop\Mail\Order\Shipped;
use Aphly\LaravelShop\Models\Catalog\Product;
use Aphly\LaravelShop\Models\Catalog\ProductOptionValue;
use Aphly\LaravelShop\Models\Catalog\Shipping;
use Aphly\LaravelShop\Models\Setting\Config;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $table = 'shop_order';
    public $incrementing = false;
    //public $timestamps = false;

    protected $fillable = [
        'id','uid','email','address_id','delivery_firstname','delivery_lastname','delivery_address_1','delivery_address_2',
		'delivery_city','delivery_postcode','delivery_country','delivery_country_code','delivery_country_id','delivery_zone','delivery_zone_id','delivery_telephone',
		'shipping_id','shipping_name','shipping_desc','shipping_cost','shipping_free_cost','shipping_geo_group_id','payment_method_id',
		'payment_method_name','items','total','total_format','currency_code','comment','order_status_id',
		'ip','user_agent','accept_language','tracking_number','tracking_at','salesperson_id'
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
        return $this->hasOne(OrderShipping::class,'order_id','id');
    }

    function shipping(){
        return $this->hasOne(Shipping::class,'id','shipping_id');
    }

    function salesperson(){
        return $this->hasOne(Salesperson::class,'id','salesperson_id');
    }

    function checkPostcode($postcode, $country_code)
    {
        $rule = [
            'CN' => '/^\d{6}$/',
            'US' => '/^\d{5}(-\d{4})?$/',
            'CA' => '/^[A-Z]\d[A-Z] \d[A-Z]\d$/i',
            'AU' => '/^\d{4}$/',
            'JP' => '/^\d{3}-\d{4}$/',
            'KR' => '/^\d{5}$/',
            'SG' => '/^\d{6}$/',
            'GB' => '/^[A-Z0-9 ]{5,8}$/i'
        ];
        if (!isset($rule[$country_code])) return true;
        return preg_match($rule[$country_code], trim($postcode));
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
            //(new UserCredit)->handle('Reward', $info->uid, 'point', '+', $val['reward'], 'payment_id#' . $info->payment_id);
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
            //(new UserCredit)->handle('Reward', $info->uid, 'point', '-', $val['reward'], 'cancel#' . $info->payment_id);
            Product::where(['subtract'=>1,'id'=>$val['product_id']])->increment('quantity',$val['quantity']);
            $orderOption = OrderOption::where(['order_id'=>$info->id,'order_product_id'=>$val['id']])->get()->toArray();
            foreach ($orderOption as $v){
                ProductOptionValue::where(['id'=>$v['product_option_value_id'],'subtract'=>1])->increment('quantity',$val['quantity']);
            }
        }
    }

    public function addOrderHistory($info, $order_status_id, $input = []){
        $shop_config = Config::findAll();
        $notify = $amount = 0;
        if($order_status_id==2){
            //Paid
            $notify = 1;
            $this->handle($info);
        }else if($order_status_id==3){
            //Shipped
            $info->tracking_number = $input['tracking_number']??'';
            $info->tracking_at = time();
        }else if($order_status_id==6){
            //Canceled
            $notify = 1;
            $this->rollback($info);
        }else if($order_status_id==7){
            //Refunded
            $notify = 1;
            if($info->order_status_id>=2) {
                $fee = intval($input['fee']);
                if($fee>=0 && $fee<=100) {
                    list($amount, $amount_format) = Currency::codeFormat((100 - $fee) / 100 * $info->total, $info->currency_code);
                    if ($amount > 0) {
                        if($fee){
                            (new Payment)->refund_api($info->payment_id, $amount, 'System refund: ' . $fee . '% transaction fee deducted');
                        }else{
                            (new Payment)->refund_api($info->payment_id, $amount, 'System refund');
                        }
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
                    'notify'=>$notify==1?$notify:($input['notify']??0),
                ]);
            }
        }else{
            $orderHistory = OrderHistory::create([
                'order_id'=>$info->id,
                'order_status_id'=>$order_status_id,
                'comment'=>$input['comment']??'',
                'notify'=>$notify==1?$notify:($input['notify']??0),
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
                        'cc'=>$shop_config['after_sales_email']?:'',
                    ]);
                }else if($order_status_id==3){
                    //Shipped
                    $info->tracking_at = Carbon::createFromTimestamp($info->tracking_at);
                    (new RemoteEmail())->send([
                        'email'=>$info->email,
                        'title'=>'Order Shipped',
                        'content'=>(new Shipped($info))->render()
                    ]);
                }else if($order_status_id==6){
                    //Canceled
                    $info->cancel_amount = $input['cancel_amount'];
                    $info->cancel_fee = $input['cancel_fee'];
                    (new RemoteEmail())->send([
                        'email'=>$info->email,
                        'title'=>'Order Canceled',
                        'content'=>(new Cancel($info))->render()
                    ]);
                }else if($order_status_id==7 && $amount > 0){
                    //Refunded
                    $info->email_refund_amount = $amount_format;
                    $info->email_refund_fee = $fee;
                    $info->email_comment = $input['comment']??'';
                    (new RemoteEmail())->send([
                        'email'=>$info->email,
                        'title'=>'Order Refunded',
                        'content'=>(new Refunded($info))->render()
                    ]);
                }
            }
        }
    }


}
