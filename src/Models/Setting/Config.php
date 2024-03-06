<?php

namespace Aphly\LaravelShop\Models\Setting;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Cache;

class Config extends Model
{
    use HasFactory;
    protected $table = 'shop_config';
    public $timestamps = false;

    protected $fillable = [
        'key','value'
    ];

    static public function findAll($cache=true) {
        if($cache) {
            return Cache::rememberForever('shop_config', function () {
                $arr =  self::get();
                $res = [];
                foreach ($arr as $val){
                    $res[$val['key']] = $val['value'];
                }
                return $res;
            });
        }else{
            $arr =  self::get();
            $res = [];
            foreach ($arr as $val){
                $res[$val['key']] = $val['value'];
            }
            return $res;
        }
    }

}
