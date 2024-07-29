<?php

namespace Aphly\LaravelShop\Models\Common;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class Banner extends Model
{
    use HasFactory;
    protected $table = 'shop_banner';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'key','url','img','img_m','status','title'
    ];

    static public function findAll($cache=true) {
        if($cache) {
            return Cache::rememberForever('shop_banner', function () {
                $arr =  self::where('status',1)->get()->toArray();
                $res = [];
                foreach ($arr as $val){
                    $res[$val['key']][] = $val;
                }
                return $res;
            });
        }else{
            $arr =  self::where('status',1)->get()->toArray();
            $res = [];
            foreach ($arr as $val){
                $res[$val['key']][] = $val;
            }
            return $res;
        }
    }


}
