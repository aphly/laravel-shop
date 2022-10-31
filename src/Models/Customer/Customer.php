<?php

namespace Aphly\LaravelShop\Models\Customer;

use Aphly\LaravelCommon\Models\User;
use Aphly\LaravelCommon\Models\UserAuth;
use Aphly\LaravelShop\Models\Checkout\Cart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'shop_customer';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'uuid','address_id'
    ];

    static $customer=false;

    function __construct()
    {
        $uuid = Auth::guard('user')->uuid;
        if(!self::$customer && $uuid){
            self::$customer = self::where(['uuid'=>$uuid])->first();
        }
        parent::__construct();
    }

    function user(){
        return $this->hasOne(User::class,'uuid','uuid');
    }

    function user_auth(){
        return $this->hasMany(UserAuth::class,'uuid');
    }

    static function initCart(){
        (new Cart)->login();
    }

    function afterLogout(){
        Cookie::queue('guest', null , -1);
        Cookie::queue('shop_address', null , -1);
        Cookie::queue('shop_shipping', null , -1);
        Cookie::queue('shop_coupon', null , -1);
        Cookie::queue('shop_payment', null , -1);
    }

    function afterRegister($user){
        self::create(['uuid'=>$user->uuid]);
    }
}
