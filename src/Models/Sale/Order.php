<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Exceptions\ApiException;
use Aphly\Laravel\Models\Model;
use Aphly\LaravelCommon\Models\UserCredit;
use Aphly\LaravelShop\Models\Catalog\Product;
use Aphly\LaravelShop\Models\Catalog\ProductOptionValue;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;
    protected $table = 'shop_order';
    //public $timestamps = false;

    protected $fillable = [
        'uuid','email','address_id','address_firstname','address_lastname','address_address_1','address_address_2',
		'address_city','address_postcode','address_country','address_country_id','address_zone','address_zone_id','address_telephone',
		'shipping_id','shipping_name','shipping_desc','shipping_cost','shipping_free_cost','shipping_geo_group_id','payment_method_id',
		'payment_method_name','items','total','total_format','comment','currency_id','currency_code','currency_value','order_status_id',
		'ip','user_agent','accept_language'
    ];

    public function notify($payment)
    {
        DB::beginTransaction();
        try {
            $info = self::where(['payment_id'=>$payment->id])->lockForUpdate()->first();
            if(!empty($info)){
                $info->order_status_id=2;
                if($info->save()){
                    $this->addOrderHistory($info,$info->order_status_id);
                }
            }
        }catch (ApiException $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();
    }

    public function addOrderHistory($info, $order_status_id, $comment = '', $notify = false){
        if($order_status_id==2){
            $orderProduct = OrderProduct::where('order_id',$info->id)->get()->toArray();
            foreach ($orderProduct as $val){
                (new UserCredit)->handle('Reward', $info->uuid, 'point', '+', $val['reward'], 'payment_id#' . $info->payment_id);
                Product::where(['subtract'=>1,'id'=>$val['product_id']])->decrement('quantity',$val['quantity']);
                $orderOption = OrderOption::where(['order_id'=>$info->id,'order_product_id'=>$val['id']])->get()->toArray();
                foreach ($orderOption as $v){
                    ProductOptionValue::where(['product_option_value_id'=>$v['product_option_value_id'],'subtract'=>1])->decrement('quantity',$val['quantity']);
                }
            }
        }else if($order_status_id==5){
            $orderProduct = OrderProduct::where('order_id',$info->id)->get()->toArray();
            foreach ($orderProduct as $val){
                (new UserCredit)->handle('Reward', $info->uuid, 'point', '-', $val['reward'], 'cancel#' . $info->payment_id);
                Product::where(['subtract'=>1,'id'=>$val['product_id']])->increment('quantity',$val['quantity']);
                $orderOption = OrderOption::where(['order_id'=>$info->id,'order_product_id'=>$val['id']])->get()->toArray();
                foreach ($orderOption as $v){
                    ProductOptionValue::where(['product_option_value_id'=>$v['product_option_value_id'],'subtract'=>1])->increment('quantity',$val['quantity']);
                }
            }
        }

        OrderHistory::create([
            'order_id'=>$info->id,
            'order_status_id'=>$order_status_id,
            'comment'=>$comment,
            'notify'=>$notify
        ]);

    }

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
}
