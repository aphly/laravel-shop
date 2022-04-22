<?php

namespace Aphly\LaravelShop\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Currency extends Model
{
    use HasFactory;
    protected $table = 'shop_currency';
    public $timestamps = false;

    protected $fillable = [
        'title','code','symbol_left','symbol_right','decimal_place','value','status'
    ];

    public function getByCode($currency) {
        $res = self::where('code', $currency)->first();
        return $res?$res->toArray():[];
    }

    public function getCurrencies() {
        return Cache::rememberForever('currency', function (){
            return self::where('status', 1)->get()->keyBy('code')->toArray();
        });
    }
}
