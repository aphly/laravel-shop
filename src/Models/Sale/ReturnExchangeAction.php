<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class ReturnExchangeAction extends Model
{
    use HasFactory;
    protected $table = 'shop_return_exchange_action';
    public $timestamps = false;

    protected $fillable = [
        'name','cn_name'
    ];

    static public function findAll() {
        return Cache::rememberForever('shop_return_exchange_action', function () {
            return self::get()->keyBy('id')->toArray();
        });
    }
}
