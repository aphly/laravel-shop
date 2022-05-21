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

    public function findAll(Int $status=0) {
        return Cache::rememberForever('currency'.$status, function () use ($status){
            return self::when($status,function ($query,$status){
                return $query->where('status',$status);
            })->get()->keyBy('code')->toArray();
        });
    }


}
