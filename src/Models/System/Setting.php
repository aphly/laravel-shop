<?php

namespace Aphly\LaravelShop\Models\System;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;
    protected $table = 'shop_setting';
    public $timestamps = false;

    protected $fillable = [
        'key','value'
    ];

    static public function findAll() {
        return Cache::rememberForever('shop_setting', function () {
            $arr =  self::get();
            $res = [];
            foreach ($arr as $val){
                $res[$val['key']] = $val['value'];
            }
            return $res;
        });
    }

}
