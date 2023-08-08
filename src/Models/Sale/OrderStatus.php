<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class OrderStatus extends Model
{
    use HasFactory;
    protected $table = 'shop_order_status';
    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

	public function findAll($cache=true) {
	    if($cache){
            return Cache::rememberForever('shop_order_status', function () {
                return self::get()->keyBy('id')->toArray();
            });
        }else{
            return self::get()->keyBy('id')->toArray();
        }
	}
}
