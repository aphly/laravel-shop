<?php

namespace Aphly\LaravelShop\Models\Account;

use Aphly\LaravelBlog\Models\User;
use Aphly\LaravelShop\Models\Catalog\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class Wishlist extends Model
{
    use HasFactory;
    protected $table = 'shop_user_wishlist';
    protected $primaryKey = 'id';
    //public $timestamps = false;

    protected $fillable = [
        'uuid','product_id'
    ];

    static $product_ids = [];

    function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }

    public function afterRegister() {
        $this->afterLogin();
    }

    public function afterLogin() {
        $shop_wishlist = session('shop_wishlist');
        if($shop_wishlist){
            $shop_wishlist_arr = json_decode($shop_wishlist,true);
            $count = count($shop_wishlist_arr);
            if($count){
                $wishlist = self::where('uuid',User::uuid())->get('product_id')->toArray();
                $wishlist_product_ids = array_column($wishlist,'product_id');
                $product_ids = [];
                foreach ($shop_wishlist_arr as $val){
                    if(!in_array($val,$wishlist_product_ids)){
                        $product_ids[] = $val;
                    }
                }
                $time = time();
                $data = [];
                foreach ($product_ids as $val){
                    $data[] = ['uuid'=>User::uuid(),'product_id'=>$val,'created_at'=>$time,'updated_at'=>$time];
                }
                self::insert($data);
            }
            session()->forget('shop_wishlist');
        }
    }



}
