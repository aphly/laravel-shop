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
        Cookie::queue('shop_address_id', null , -1);
        Cookie::queue('shop_shipping_id', null , -1);
    }

    function afterRegister($user){
        self::create(['uuid'=>$user->uuid]);
    }
}
