<?php

namespace Aphly\LaravelShop\Models\Common;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

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
        return !empty($res)?$res->toArray():[];
    }

    static public function findAll(Int $status=0) {
        return Cache::rememberForever('currency'.$status, function () use ($status){
            return self::when($status,function ($query,$status){
                return $query->where('status',$status);
            })->get()->keyBy('code')->toArray();
        });
    }

    static function format($price,$string = true){
        $currency = Cookie::get('currency');
        $info = self::findAll()[$currency];
        if($info){
            $price = round($price, (int)$info['decimal_place']);
            if(!$string){
                return $price;
            }
            $string = '';
            if ($info['symbol_left']) {
                $string .= $info['symbol_left'];
            }
            $string .= number_format($price, (int)$info['decimal_place']);
            if ($info['symbol_right']) {
                $string .= $info['symbol_right'];
            }
            return $string;
        }
        return $price;
    }
}
