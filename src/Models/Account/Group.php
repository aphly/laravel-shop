<?php

namespace Aphly\LaravelShop\Models\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Cache;

class Group extends Model
{
    use HasFactory;
    protected $table = 'shop_group';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name','sort','price','cn_name'
    ];

    public function findAll($cache=true) {
        if($cache){
            return Cache::rememberForever('group', function () {
                return self::get()->keyBy('id')->toArray();
            });
        }else{
            return self::get()->keyBy('id')->toArray();
        }
    }


}
