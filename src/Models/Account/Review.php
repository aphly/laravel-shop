<?php

namespace Aphly\LaravelShop\Models\Account;

use Aphly\Laravel\Models\Model;
use Aphly\Laravel\Models\UploadFile;
use Aphly\LaravelShop\Models\Catalog\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        $review = self::where('product_id',$product_id)->with('img')->orderBy('created_at','desc')->get();
        foreach ($review as $val){
            foreach ($val->img as $v){
                $v->image_src = UploadFile::getPath($v->image,$v->remote);
            }
        }
        return $review;
    }
}
