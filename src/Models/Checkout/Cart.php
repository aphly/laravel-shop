<?php

namespace Aphly\LaravelShop\Models\Checkout;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Cookie;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'shop_cart';
    public $timestamps = false;

    protected $fillable = [
        'uuid','product_id','session_id','quantity','json','date_add'
    ];

    public function __construct() {
        self::where('uuid',0)->where('date_add','<',time()-3600*24)->delete();
        parent::__construct();
    }

    public function login() {
        $visitor = Cookie::get('visitor');
        if($visitor){
            $cart = self::where('visitor',$visitor);
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
        self::updateOrCreate(['uuid'=>$uuid,'visitor'=>Cookie::get('visitor'),'product_id'=>$product_id,'option'=>$option],['quantity'=>$quantity]);
    }


}
