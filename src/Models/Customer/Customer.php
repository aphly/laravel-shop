<?php

namespace Aphly\LaravelShop\Models\Customer;

use Aphly\LaravelAdmin\Models\User;
use Aphly\LaravelAdmin\Models\UserAuth;
use Aphly\LaravelShop\Models\Checkout\Cart;
use Aphly\LaravelShop\Models\Common\Setting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Cookie;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'shop_customer';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'uuid','address_id','group_id'
    ];

    function user(){
        return $this->hasOne(User::class,'uuid','uuid');
    }

    function user_auth(){
        return $this->hasMany(UserAuth::class,'uuid');
    }

    static function groupId(){
        $setting = Setting::findAll();
        return session()->has('customer')?session('customer')['group_id']:$setting['config']['group'];
    }

    static function uuid(){
        return session()->has('customer')?session('customer')['uuid']:0;
    }

    static function addressId(){
        return session()->has('customer')?session('customer')['address_id']:0;
    }

    static function makeSession($uuid=false){
        if(!$uuid){
            $uuid = session()->has('user')?session('user')['uuid']:0;
        }
        $customer = self::where(['uuid'=>$uuid])->first();

        if(!empty($customer)){
            session(['customer'=>['group_id'=>$customer->group_id,'address_id'=>$customer->address_id,'uuid'=>$customer->uuid]]);
        }
    }

    static function initCart(){
        (new Cart)->login();
    }

    static function logout(){
        session()->forget('customer');
        Cookie::queue('guest', null , -1);
        Cookie::queue('coupon', null , -1);
        Cookie::queue('shipping_address', null , -1);
        Cookie::queue('shipping_coupon', null , -1);
        Cookie::queue('shipping_method', null , -1);
        Cookie::queue('shipping_method_all', null , -1);
        Cookie::queue('payment_method', null , -1);
    }
}
