<?php

namespace Aphly\LaravelShop\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Cache;

class Extension extends Model
{
    use HasFactory;
    protected $table = 'shop_extension';
    public $timestamps = false;

    protected $fillable = [
        'type','code'
    ];

    static public function findAll() {
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
            'total'  => &$total
        );
        foreach ($arr as $class){
            if(class_exists($class)){
                (new $class)->getTotal($products,$total_data);
            }
        }
        return '';
    }
}
