<?php

namespace Aphly\LaravelShop\Models\Common;

use Aphly\LaravelShop\Models\Checkout\Cart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;

class Extension extends Model
{
    use HasFactory;
    protected $table = 'shop_extension';
    public $timestamps = false;

    protected $fillable = [
        'type','code'
    ];

    static public function findAll() {
        $arr = self::get()->toArray();
        $res = [];
        foreach ($arr as $val){
            $res[$val['type']][] = $val['code'];
        }
        return $res;
    }

    static public function findAllCache() {
        return Cache::rememberForever('extension', function (){
            $arr = self::get()->toArray();
            $res = [];
            foreach ($arr as $val){
                $res[$val['type']][] = $val['code'];
            }
            return $res;
        });
    }

    public function findAllByType($type) {
        $arr = self::findAll();
        return !empty($arr[$type])?$arr[$type]:[];
    }

    public function total($products) {
        $arr = $this->findAllByType('total');
        $totals = array();
        $total = 0;
        $total_data = array(
            'totals' => &$totals,
            'total'  => &$total,
            'total_format'  => 0
        );
        $Cart = new Cart;
        $sub_total = $Cart->getSubTotal($products);
        $total_data['totals'][] = array(
            'code'       => 'sub_total',
            'title'      => 'Sub_total',
            'value'      => $sub_total??0,
            'value_format'      => Currency::format($sub_total),
            'sort_order' => 1
        );
        $total_data['total'] += $sub_total;

        foreach ($arr as $class){
            if(class_exists($class)){
                (new $class($products))->getTotal($total_data);
            }
        }

        $shipping_method = Cookie::get('shipping_method');
        $shipping_method = json_decode($shipping_method,true);
        if($Cart->hasShipping($products) && $shipping_method) {
            $total_data['totals'][] = array(
                'code'       => 'shipping',
                'title'      => $shipping_method['title'],
                'value'      => $shipping_method['cost'],
                'value_format'      => Currency::format($shipping_method['cost']),
                'sort_order' => 100
            );
            $total_data['total'] += $shipping_method['cost'];
        }

        $total_data['total'] = max(0, $total_data['total']);
        $total_data['total_format'] = Currency::format($total_data['total']);
        return $total_data;
    }



}
