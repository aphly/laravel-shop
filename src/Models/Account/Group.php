<?php

namespace Aphly\LaravelShop\Models\Account;

use Aphly\LaravelShop\Models\Common\Setting;
use Aphly\LaravelShop\Models\Product\ProductReward;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Cache;

class Group extends Model
{
    use HasFactory;
    protected $table = 'shop_customer_group';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name','description','sort'
    ];

    function reward(){
        return $this->hasOne(ProductReward::class,'group_id');
    }

    public function findAll() {
        return Cache::rememberForever('group', function () {
            return self::get()->keyBy('id')->toArray();
        });
    }

    function groupId(){
        $setting = Setting::findAll();
        return session()->has('customer')?session('customer')['group_id']:$setting['config']['group'];
    }
}
