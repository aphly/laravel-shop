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

    public function findAll(int $status=0) {
        return Cache::rememberForever('category'.$status, function () use ($status) {
            $category = self::when($status,function ($query,$status){
                return $query->where('status', $status);
            })->orderBy('sort', 'desc')->get()->toArray();
            return Helper::getTree($category, true);
        });
    }
}
