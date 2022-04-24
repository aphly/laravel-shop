<?php

namespace Aphly\LaravelShop\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Cache;

class Country extends Model
{
    use HasFactory;
    protected $table = 'shop_country';
    public $timestamps = false;

    protected $fillable = [
        'name','iso_code_2','iso_code_3','postcode_required','status','address_format'
    ];

    public function getListOpenCache() {
        return Cache::rememberForever('country_open', function (){
            return self::where('status', 1)->get()->keyBy('id')->toArray();
        });
    }

    public function getListCache() {
        return Cache::rememberForever('country', function (){
            return self::get()->keyBy('id')->toArray();
        });
    }
}
