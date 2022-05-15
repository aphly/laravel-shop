<?php

namespace Aphly\LaravelShop\Controllers;

//use Aphly\Laravel\Libs\Func;
//use Aphly\Laravel\Models\Dictionary;

use Aphly\LaravelAdmin\Models\Dict;
use Illuminate\Support\Facades\View;

class Controller extends \Aphly\LaravelAdmin\Controllers\Controller
{
//    public $filter_id=13;
//
//    function getFilter(){
//        $res['dict']= Dictionary::where('status',1)->where('pid',$this->filter_id)->orderBy('sort','desc')->get()->toArray();
//        $res['arr'] = [];
//        $res['dict'] = Func::array_orderby($res['dict'],'sort',SORT_DESC);
//        foreach ($res['dict'] as $val){
//            if($val['json']){
//                $arr = json_decode($val['json'],true);
//                $arr = Func::array_orderby($arr,'sort',SORT_DESC);
//                $res['arr'][$val['name']] = array_column($arr,null,'value');
//            }
//        }
//        return $res['arr'];
//    }


}
