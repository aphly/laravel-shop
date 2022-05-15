<?php

namespace Aphly\LaravelShop\Models\Common;

use Aphly\Laravel\Libs\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    use HasFactory;
    protected $table = 'shop_category';
    public $timestamps = false;

    protected $fillable = [
        'name','icon','pid','sort','status','description','meta_title','meta_keyword','meta_description','is_leaf'
    ];

    public function getCategory() {
        return Cache::rememberForever('category', function () {
            $category = self::where('status', 1)->orderBy('sort', 'desc')->get()->toArray();
            return Helper::getTree($category, true);
        });
    }
}
