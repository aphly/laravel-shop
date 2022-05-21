<?php

namespace Aphly\LaravelShop\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Cache;

class Zone extends Model
{
    use HasFactory;
    protected $table = 'shop_zone';
    public $timestamps = false;

    protected $fillable = [
        'country_id','name','code','status'
    ];

    public function findAllByCountry($country_id) {
        return Cache::rememberForever('zone_'. (int)$country_id, function () use ($country_id){
            return self::where('country_id', $country_id)->where('status',1)->orderBy('name','asc')->get()->keyBy('id')->toArray();
        });
    }

    public function findAll(Int $status=0) {
        return Cache::rememberForever('zone'.$status, function () use ($status){
            return self::when($status,function ($query,$status){
                return $query->where('status',$status);
            })->get()->keyBy('code')->toArray();
        });
    }
}
