<?php

namespace Aphly\LaravelShop\Models\Checkout;

use Aphly\LaravelShop\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Cookie;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'shop_cart';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'uuid','product_id','guest','quantity','option','date_add'
    ];

    public function __construct() {
        self::where('uuid',0)->where('date_add','<',time()-3600*24)->delete();
        parent::__construct();
    }

    function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }

    public function login() {
        $guest = Cookie::get('guest');
        if($guest){
            $cart = self::where('guest',$guest);
            $data = $cart->get()->toArray();
            $cart->delete();
            foreach ($data as $val){
                $this->add($val['product_id'], $val['quantity'], json_decode($val['option']));
            }
        }
    }

    public function add($product_id, $quantity = 1, $option = []) {
        $option = json_encode($option);
        $uuid = session('user')['uuid']??0;
        $where = ['uuid'=>$uuid,'guest'=>Cookie::get('guest'),'product_id'=>$product_id,'option'=>$option];
        $info = self::where($where)->first();
        if(!empty($info)){
            $info->increment('quantity',$quantity);
        }else{
            self::create(array_merge($where,['quantity'=>$quantity,'date_add'=>time()]));
        }
    }

    public function getProducts(){
        $product_data = [];
        $uuid = session('user')['uuid']??0;
        $cart_data = self::where(['uuid'=>$uuid,'guest'=>Cookie::get('guest')])->with('product')->get()->toArray();
        foreach($cart_data as $val){
            if($val['quantity']>0 && $val['product']['status']==1 && $val['product']['date_available']<time()){
                foreach (json_decode($val['option']) as $k => $v) {

                }
            }
        }
    }
}
