<?php

namespace Aphly\LaravelShop\Models\Common;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class Currency extends Model
{
    use HasFactory;
    protected $table = 'shop_currency';
    public $timestamps = false;

    protected $fillable = [
        'name','code','symbol_left','symbol_right','decimal_place','value','status'
    ];

    public function findOneByCode($code) {
        $res = self::where('code', $code)->first();
        return $res?$res->toArray():[];
    }

    public function findAllStatus() {
        return Cache::rememberForever('currency', function (){
            return self::where('status', 1)->get()->keyBy('code')->toArray();
        });
    }


}
