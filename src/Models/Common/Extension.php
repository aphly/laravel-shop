<?php

namespace Aphly\LaravelShop\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Cache;

class Extension extends Model
{
    use HasFactory;
    protected $table = 'shop_extension';
    public $timestamps = false;

    protected $fillable = [
        'type','code'
    ];

    static public function findAll($type='total') {
        return Cache::rememberForever('extension_'.$type, function () use ($type){
            $arr = self::where('code',$type)->get()->toArray();
            $res = [];
            foreach ($arr as $val){
                $res[$val['code']][$val['key']] = $val['value'];
            }
            return $res;
        });
    }

    public function total() {

    }
}
