<?php

namespace Aphly\LaravelShop\Models\Account;

use Aphly\Laravel\Models\CommonUser;
use Aphly\Laravel\Models\Model;
use Aphly\Laravel\Models\CommonUploadFile;
use Aphly\LaravelShop\Models\Catalog\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;
    protected $table = 'shop_review';
    //protected $primaryKey = 'id';
    public $incrementing = false;
    //public $timestamps = false;

    protected $fillable = [
        'product_id','uid','author','text','rating','status','id'
    ];

    function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }

    function user(){
        return $this->hasOne(CommonUser::class,'uid','uid');
    }

    function img(){
        return $this->hasMany(ReviewImage::class,'review_id');
    }

    function findAllByProductId($product_id){
        $review = self::where('product_id',$product_id)->with('img')->orderBy('created_at','desc')->get();
        foreach ($review as $val){
            foreach ($val->img as $v){
                $v->image_src = CommonUploadFile::getPath($v->image,$v->disk);
            }
        }
        return $review;
    }
}
