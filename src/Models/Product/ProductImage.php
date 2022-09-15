<?php

namespace Aphly\LaravelShop\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class ProductImage extends Model
{
    use HasFactory;
    protected $table = 'shop_product_image';
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'image',
        'sort'
    ];

    static public $oss_url = 'https://img.lioasde.top';

    static function render($img){
        if($img){
            return self::$oss_url?self::$oss_url.$img:Storage::url($img);
        }else{
            return URL::asset('vendor/laravel-admin/img/none.png');
        }
    }
}
