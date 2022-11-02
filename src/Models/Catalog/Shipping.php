<?php

namespace Aphly\LaravelShop\Models\Catalog;

use Aphly\LaravelCommon\Models\GeoGroup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class Shipping extends Model
{
    use HasFactory;
    protected $table = 'shop_shipping';
    //public $timestamps = false;

    protected $fillable = [
        'name','desc','cost','free','geo_group_id','sort','status'
    ];

    static public function findAll() {
        return Cache::rememberForever('shop_shipping', function () {
            return self::where('status',1)->get()->toArray();
        });
    }

    public function geoGroup(){
        return $this->hasMany(GeoGroup::class,'id','geo_group_id');
    }

    public function getList() {
        $shop_address = Cookie::get('shop_address');
        if($shop_address){

        }

    }

    public function getTotal($total_data) {
        $shop_shipping = Cookie::get('shop_shipping');
        if($shop_shipping){

        }
    }
}
