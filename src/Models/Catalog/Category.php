<?php

namespace Aphly\LaravelShop\Models\Catalog;

use Aphly\Laravel\Libs\Helper;
use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    use HasFactory;
    protected $table = 'shop_category';
    public $timestamps = false;

    protected $fillable = [
        'name','icon','pid','sort','status','meta_title','meta_description','type','cn_name'
    ];

    public function findAll() {
        return Cache::rememberForever('category', function (){
            $category = self::where('status', 1)->orderBy('sort', 'desc')->get()->toArray();
            return Helper::getTree($category, true);
        });
    }


}
