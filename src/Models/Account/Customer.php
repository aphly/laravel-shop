<?php

namespace Aphly\LaravelShop\Models\Account;

use Aphly\LaravelAdmin\Models\User;
use Aphly\LaravelAdmin\Models\UserAuth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

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
}
