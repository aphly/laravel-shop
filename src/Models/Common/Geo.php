<?php

namespace Aphly\LaravelShop\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Cache;

class Geo extends Model
{
    use HasFactory;
    protected $table = 'shop_geo';
    public $timestamps = false;

    protected $fillable = [
        'country_id','zone_id','geo_group_id'
    ];

    function group(){
        return $this->hasOne(GeoGroup::class,'id','geo_group_id');
    }

    public function findAll() {
        return Cache::rememberForever('geo', function (){
            return self::get()->keyBy('geo_group_id')->toArray();
        });
    }

    public function in($geo_group_id,$country_id,$zone_id) {
        $arr = self::where('geo_group_id',$geo_group_id)->get()->keyBy('country_id')->toArray();
        if($arr){

        }

    }
}
