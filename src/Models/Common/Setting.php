<?php

namespace Aphly\LaravelShop\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;
    protected $table = 'shop_setting';
    public $timestamps = false;

    protected $fillable = [
        'code','key','value'
    ];

    static public function findAll() {
        $arr = self::get()->toArray();
        $res = [];
        foreach ($arr as $val){
            $res[$val['code']][$val['key']] = $val['value'];
        }
        return $res;
    }

    static public function findAllCache() {
        return Cache::rememberForever('shop_setting', function (){
            $arr = self::get()->toArray();
            $res = [];
            foreach ($arr as $val){
                $res[$val['code']][$val['key']] = $val['value'];
            }
            return $res;
        });
    }

}
