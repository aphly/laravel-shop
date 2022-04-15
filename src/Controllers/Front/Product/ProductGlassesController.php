<?php

namespace Aphly\LaravelShop\Controllers\Front\Product;

use Aphly\Laravel\Libs\Func;
use Aphly\Laravel\Libs\Helper;
use Aphly\Laravel\Models\Dictionary;
use Aphly\LaravelShop\Controllers\Controller;
use Aphly\LaravelShop\Models\Product\Product;
use Aphly\LaravelShop\Models\Product\ProductImg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function config;

class ProductController extends Controller
{
    public function _orWhere($field_name,$field,$string=false){
        $str= [];
        foreach ($field as $val){
            $val = intval($val);
            if($val){
                if($string){
                    $str[] = 'find_in_set('.$val.',`'.$field_name.'`)';
                }else{
                    $str[] = '`'.$field_name.'`='.$val;
                }
            }
        }
        return '('.implode(' or ',$str).')';
    }

    public function index(Request $request)
    {
        $res['title'] = '';
        $res['filter_arr'] = $this->getFilter();
        $res['filter']['param_str'] = http_build_query($request->query());
        $res['filter']['cate_id']  = $cate_id = intval($request->query('cate_id',0));
        $res['filter']['gender']  = $gender = $request->query('gender',false);
        $res['filter']['size']  = $size = $request->query('size',false);
        $res['filter']['frame_width']  = $frame_width = $request->query('frame_width',false);
        $res['filter']['lens_width']  = $lens_width = $request->query('lens_width',false);
        $res['filter']['lens_height']  = $lens_height = $request->query('lens_height',false);
        $res['filter']['bridge_width']  = $bridge_width = $request->query('bridge_width',false);
        $res['filter']['arm_length']  = $arm_length = $request->query('arm_length',false);
        $res['filter']['shape']  = $shape = $request->query('shape',false);
        $res['filter']['material']  = $material = $request->query('material',false);
        $res['filter']['frame']  = $frame = $request->query('frame',false);
        $res['filter']['color']  = $color = $request->query('color',false);
        $res['filter']['feature']  = $feature = $request->query('feature',false);

        $res['filter']['sort']  = $sort = $request->query('sort',false);

//        $sub = Product::leftjoin('order','product.id','=','order.product_id')
//            ->whereRaw('product.status=1')
//            ->when($cate_id,
//                function($query,$cate_id) {
//                    $cate_id=intval($cate_id);
//                    if($cate_id){
//                        return $query->whereRaw('product.cate_id='.$cate_id);
//                    }
//                })
//            ->select(DB::raw('any_value(`name`) as `name`,
//                            any_value(`spu`) as `spu`,
//                            any_value(`sku`) as `sku`,
//                            any_value(`gender`) as `gender`,
//                            any_value(`size`) as `size`,
//                            any_value(`frame_width`) as `frame_width`,
//                            any_value(`lens_width`) as `lens_width`,
//                            any_value(`lens_height`) as `lens_height`,
//                            any_value(`bridge_width`) as `bridge_width`,
//                            any_value(`arm_length`) as `arm_length`,
//                            any_value(`shape`) as `shape`,
//                            any_value(`material`) as `material`,
//                            any_value(`frame`) as `frame`,
//                            any_value(`color`) as `color`,
//                            any_value(`feature`) as `feature`,
//                            any_value(`viewed`) as `viewed`,
//                            any_value(`createtime`) as `createtime`,
//                            any_value(`price`) as `price`,
//                            count(`order`.`id`) as sale'))
//            ->groupBy('product.id');
//        $res['list'] = DB::table(DB::raw("({$sub->toSql()}) as sub"))
        $res['list'] = Product::whereRaw('status=1')
            ->when($cate_id,
                function($query,$cate_id) {
                    return $query->whereRaw('cate_id='.$cate_id);
                })
            ->select(DB::raw('any_value(`name`) as `name`,
                            any_value(`spu`) as `spu`,
                            any_value(`gender`) as `gender`,
                            any_value(`size`) as `size`,
                            any_value(`frame_width`) as `frame_width`,
                            any_value(`lens_width`) as `lens_width`,
                            any_value(`lens_height`) as `lens_height`,
                            any_value(`bridge_width`) as `bridge_width`,
                            any_value(`arm_length`) as `arm_length`,
                            any_value(`shape`) as `shape`,
                            any_value(`material`) as `material`,
                            any_value(`frame`) as `frame`,
                            group_concat(`color`) as `color`,
                            any_value(`feature`) as `feature`,
                            sum(`viewed`) as `viewed`,
                            max(`createtime`) as `createtime`,
                            min(`price`) as `price`,
				            sum(`sale`) as sale'))
            ->groupBy('spu')
            ->when($gender,
                function($query,$gender) {
                    return $query->havingRaw($this->_orWhere('gender',$gender,1));
                })
            ->when($size,
                function($query,$size) {
                    return $query->havingRaw($this->_orWhere('size',$size));
                })
            ->when($frame_width,
                function($query,$frame_width) {
                    return $query->havingRaw($this->_orWhere('frame_width',$frame_width));
                })
            ->when($lens_width,
                function($query,$lens_width) {
                    return $query->havingRaw($this->_orWhere('lens_width',$lens_width));
                })
            ->when($lens_height,
                function($query,$lens_height) {
                    return $query->havingRaw($this->_orWhere('lens_height',$lens_height));
                })
            ->when($bridge_width,
                function($query,$bridge_width) {
                    return $query->havingRaw($this->_orWhere('bridge_width',$bridge_width));
                })
            ->when($arm_length,
                function($query,$arm_length) {
                    return $query->havingRaw($this->_orWhere('arm_length',$arm_length));
                })
            ->when($shape,
                function($query,$shape) {
                    return $query->havingRaw($this->_orWhere('shape',$shape));
                })
            ->when($material,
                function($query,$material) {
                    return $query->havingRaw($this->_orWhere('material',$material,1));
                })
            ->when($frame,
                function($query,$frame) {
                    return $query->havingRaw($this->_orWhere('frame',$frame));
                })
            ->when($color,
                function($query,$color) {
                    return $query->havingRaw($this->_orWhere('color',$color,1));
                })
            ->when($feature,
                function($query,$feature) {
                    return $query->havingRaw($this->_orWhere('feature',$feature,1));
                })
            ->when($sort,
                function($query,$sort) {
                    $sort = explode('_',$sort);
                    if($sort[0]=='viewed'){
                        return $query->orderBy('viewed','desc');
                    }else if($sort[0]=='new'){
                        return $query->orderBy('createtime','desc');
                    }else if($sort[0]=='price'){
                        if($sort[1]=='asc'){
                            return $query->orderBy('price','asc');
                        }else{
                            return $query->orderBy('price','desc');
                        }
                    }else if($sort[0]=='sale'){
                        return $query->orderBy('sale','desc');
                    }
                })
            ->Paginate(config('shop.perPage'))->withQueryString()->toArray();

        $spus = array_column($res['list']['data'],'spu');
        $product = Product::with('desc')->whereIn('spu',$spus)->where(['status'=>1])->get()->toArray();
        $res['product'] = $res['product_img'] = $product_img_arr = [];
        $product_ids = [];
        foreach ($product as $v){
            $res['product'][$v['spu']][] = $v;
            $product_ids[] = $v['id'];
        }
        $product_img = ProductImg::whereIn('product_id',$product_ids)->orderBy('sort','desc')->get()->toArray();
        foreach ($product_img as $v){
            $product_img_arr[$v['product_id']][] = $v;
        }
        foreach ($product_img_arr as $k=>$v){
            $res['product_img'][$k] = array_slice($v,0,2);
        }
        return $this->makeView('laravel-shop::product.index',['res'=>$res]);
    }

    function detail(Request $request){
        $res['product'] = Product::where('sku',$request->sku)->with('desc')->first();
        $res['title'] = $res['product']->name;
        $res['product_img'] = $res['product']->img->toArray();
        $res['spu'] = Product::where('spu',$res['product']->spu)->get()->toArray();
        $res['filter_arr'] = $this->getFilter();
        $res['product']['size'] = $this->size($res['product']['size']);
        $res['product']['color'] = $this->color($res['product']['color'],$res['filter_arr']);
        return $this->makeView('laravel-shop::product.detail',['res'=>$res]);
    }

    function size($val){
        return match ($val) {
            1 => 'S',
            2 => 'M',
            3 => 'L',
        };
    }

    function color($val,$filter_arr){
        $arr = explode(',',$val);
        $color = [];
        foreach($arr as $v){
            if(isset($filter_arr['color'][$v])){
                $color[] = $filter_arr['color'][$v]['name'];
            }
        }
        return implode('/',$color);
    }

    function lens(Request $request){
        $res['product'] = Product::where('sku',$request->sku)->with('desc')->first();
        $res['title'] = $res['product']->name;
        $res['product_img'] = $res['product']->img()->orderBy('sort','desc')->first();
        $res['product_img'] =  !is_null($res['product_img']) ? $res['product_img']->toArray() : [];
        $res['filter_arr'] = $this->getFilter();
        $res['product']['size'] = $this->size($res['product']['size']);
        $res['product']['color'] = $this->color($res['product']['color'],$res['filter_arr']);
        $dictionary = new Dictionary;
        $res['lens']['usage'] =  $dictionary->getDictionaryTreeById(37);
        //dd($res['lens']['usage']);
        $res['lens']['type'] =  $dictionary->getDictionaryTreeById(24);
        Helper::getTreeByid([$res['lens']['type']],32,$res['lens']['sunglasses']);
        $this->getThickness([$res['lens']['type']],$res['lens']['thickness']);
        $res['lens']['coating'] =  $dictionary->getDictionaryTreeById(15);
        if(isset($res['lens']['coating']['json'][0])){
            $res['lens']['coating']['json'] = Func::array_orderby($res['lens']['coating']['json'][0],'sort',SORT_DESC);
        }
        $res['lens']['prism'] =  $dictionary->getDictionaryTreeById(42);
        //dd($res['lens']['thickness']);
        return $this->makeView('laravel-shop::product.lens',['res'=>$res]);
    }

    function getThickness($type,&$res){
        foreach ($type as $val){
            if($val['json'] && isset($val['json'][0])){
                $res[$val['id']]=Func::array_orderby($val['json'][0],'sort',SORT_DESC);
            }
            if(isset($val['child'])){
                $this->getThickness($val['child'],$res);
            }
        }
    }
}
