<?php

namespace Aphly\LaravelShop\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class Review extends Model
{
    use HasFactory;
    protected $table = 'shop_review';
    protected $primaryKey = 'id';
    //public $timestamps = false;

    protected $fillable = [
        'product_id','uuid','author','text','rating','status'
    ];

    function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }

    function img(){
        return $this->hasMany(ReviewImage::class,'review_id');
    }

    function findAllByProductId($product_id){
        $review = self::where('product_id',$product_id)->with('img')->get();
        foreach ($review as $val){
            foreach ($val->img as $v){
                $val->img->image_src = ProductImage::render($v->image,true);
            }
        }
        return $review;
    }
}
