<?php

namespace Aphly\LaravelShop\Models\Catalog;

use Aphly\Laravel\Models\UploadFile;
use Aphly\LaravelCommon\Models\Currency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    protected $table = 'shop_product';
    //public $timestamps = false;

    protected $fillable = [
        'sku','name','quantity','image','price','uuid','spu',
        'is_shipping','stock_status_id','weight','weight_class_id',
        'length','width','height','length_class_id','subtract',
        'status','viewed','sale','sort','date_available','url','remote'
    ];

    function desc(){
        return $this->hasOne(ProductDesc::class,'product_id','id');
    }

    function img(){
        return $this->hasMany(ProductImage::class,'product_id');
    }

    function imgById($product_id,$group=false){
        $productImage = ProductImage::where('product_id',$product_id)->orderBy('sort','desc')->get()->toArray();
        $res = [];
        foreach($productImage as $val){
            $val['image_src'] = UploadFile::getPath($val['image'],$val['remote']);
            if($group){
                $res[$val['is_content']][$val['option_value_id']][] = $val;
            }else{
                $res[$val['is_content']][] = $val;
            }
        }
        return $res;
    }

    function imgByIds($product_ids,$group=false){
        $productImage = ProductImage::whereIN('product_id',$product_ids)->orderBy('sort','desc')->get()->toArray();
        $res = [];
        foreach($productImage as $val){
            $val['image_src'] = UploadFile::getPath($val['image'],$val['remote']);
            if(!$val['is_content']){
                if($group){
                    $res[$val['product_id']][$val['option_value_id']][] = $val;
                }else{
                    $res[$val['product_id']][] = $val;
                }
            }
        }
        return $res;
    }

    function optionValueTable($value=''){
        $filter_values = explode(',', $value);
        $filter_values = array_filter($filter_values);
        $arr = [];
        $option = Option::where(['is_filter'=>1,'status'=>1])->with('value')->get()->toArray();
        foreach ($filter_values as $id){
            foreach ($option as $val){
                foreach ($val['value'] as $val1){
                    if($id==$val1['id']){
                        $arr[$val['id']][] = $val1['id'];
                    }
                }
            }
        }
        if($arr){
            return ProductOptionValue::groupBy('product_id')->select('product_id')->when($arr,function ($query,$arr){
                $h = [];
                foreach ($arr as $val){
                    $h1 = [];
                    foreach ($val as $v){
                        $h1[] = 'FIND_IN_SET('.$v.',GROUP_CONCAT(`option_value_id`))';
                    }
                    if($h1){
                        $h[] = '('.implode(' or ',$h1).')';
                    }
                }
                if($h){
                    $h_sql = implode(' and ',$h);
                    return $query->havingRaw($h_sql);
                }
                return $query;
            });
        }
        return false;
    }

    function filterTable($value=''){
        $filter_values = explode(',', $value);
        $filter_values = array_filter($filter_values);
        $arr = [];
        $filter = FilterGroup::where(['status'=>1])->with('filter')->get()->toArray();
        foreach ($filter_values as $id){
            foreach ($filter as $val){
                foreach ($val['filter'] as $val1){
                    if($id==$val1['id']){
                        $arr[$val['id']][] = $val1['id'];
                    }
                }
            }
        }
        if($arr){
            return ProductFilter::groupBy('product_id')->select('product_id')->when($arr,function ($query,$arr){
                $h = [];
                foreach ($arr as $val){
                    $h1 = [];
                    foreach ($val as $v){
                        $h1[] = 'FIND_IN_SET('.$v.',GROUP_CONCAT(`filter_id`))';
                    }
                    if($h1){
                        $h[] = '('.implode(' or ',$h1).')';
                    }
                }
                if($h){
                    $h_sql = implode(' and ',$h);
                    return $query->havingRaw($h_sql);
                }
                return $query;
            });
        }
        return false;
    }

    public $sub_category = false;

    public function getList($data = [],$bySpu=false) {
        //$type = 1 sku
        //$type = 2 spu
        list('category_id'=>$category_id,'filter'=>$filter,'option_value'=>$option_value,'price'=>$price,'sort'=>$sort) = $data;
        $time = time();
        $optionValueTable = $option_value?$this->optionValueTable($option_value):false;
        $filterTable = $filter?$this->filterTable($filter):false;
        if($category_id){
            if($this->sub_category){
                $sql = DB::table('shop_category_path as cp')->leftJoin('shop_product_category as pc','cp.category_id','=','pc.category_id');
            }else{
                $sql = DB::table('shop_product_category as pc');
            }
            $sql->when($filterTable, function ($query,$filterTable)  {
                return $query->joinSub($filterTable,'filterTable',function (JoinClause $join){
                    $join->on('pc.product_id', '=', 'filterTable.product_id');
                });
            })->when($optionValueTable, function ($query,$optionValueTable)  {
                return $query->joinSub($optionValueTable,'optionValueTable',function (JoinClause $join){
                    $join->on('pc.product_id', '=', 'optionValueTable.product_id');
                });
            });
            $sql->leftJoin('shop_product as p','pc.product_id','=','p.id' );
        }else{
            $sql = DB::table('shop_product as p');
            $sql->when($filterTable, function ($query,$filterTable)  {
                return $query->joinSub($filterTable,'filterTable',function (JoinClause $join){
                    $join->on('p.id', '=', 'filterTable.product_id');
                });
            })->when($optionValueTable, function ($query,$optionValueTable)  {
                return $query->joinSub($optionValueTable,'optionValueTable',function (JoinClause $join){
                    $join->on('p.id', '=', 'optionValueTable.product_id');
                });
            });
        }
        $sql->where('p.status',1)->where('p.date_available','<=',$time);
        if($category_id){
            if($this->sub_category) {
                $sql->where('cp.path_id', $category_id);
            }else{
                $sql->where('pc.category_id', $category_id);
            }
        }
        if($data['name']){
            $words = explode(' ', trim($data['name']));
            if(count($words)>1){
                foreach ($words as $word) {
                    $sql->where('p.name','like','%'.$word.'%');
                }
            }else{
                $sql->where('p.name','like','%'.$data['name'].'%');
            }
        }

        $sql->groupBy('p.id')
            ->select('p.id','p.sale','p.viewed','p.date_available','p.price','p.name','p.quantity','p.image','p.spu','p.remote');
        $sql->addSelect([
            'reviews'=>Review::whereColumn('product_id','p.id')->where('status',1)
                ->groupBy('product_id')
                ->selectRaw('count(*)'),
            'rating'=>Review::whereColumn('product_id','p.id')->where('status',1)
                ->groupBy('product_id')
                ->selectRaw('AVG(rating)'),
            'special'=>ProductSpecial::whereColumn('product_id','p.id')
                ->where(function ($query) use ($time){
                    $query->where('date_start',0)->orWhere('date_start','<',$time);
                })->where(function ($query) use ($time){
                    $query->where('date_end',0)->orWhere('date_end','>',$time);
                })->orderBy('priority','desc')
                ->select('price')->limit(1),
            'discount'=>ProductDiscount::whereColumn('product_id','p.id')
                ->where('quantity',1)
                ->select('price')->limit(1)
        ]);

        $res = DB::table($sql)
            ->when($price,function ($query,$price){
                $price_arr = explode('-',$price);
                $price_min = abs((float)$price_arr[0]);
                $price_max = !empty($price_arr[1])?abs((float)$price_arr[1]):false;
                if(!$price_min && $price_max){
                    $price_max = Currency::toDefault($price_max);
                    return $query->whereRaw('IFNULL(special,IFNULL(discount,price))<='.$price_max);
                }else if($price_min && $price_max){
                    $price_min = Currency::toDefault($price_min);
                    $price_max = Currency::toDefault($price_max);
                    return $query->whereRaw('IFNULL(special,IFNULL(discount,price))>='.$price_min.' and IFNULL(special,IFNULL(discount,price))<='.$price_max);
                }else if($price_min && !$price_max){
                    $price_min = Currency::toDefault($price_min);
                    return $query->whereRaw('IFNULL(special,IFNULL(discount,price))>='.$price_min);
                }
            })
            ->when($bySpu,function ($query){
                return $query->groupBy('spu')
                    ->selectRaw('spu,GROUP_CONCAT(id) as ids,max(viewed) as viewed,max(date_available) as date_available,
                            min(price) as price,min(special) as special,min(discount) as discount,max(sale) as sale,max(rating) as rating');
            })
            ->when($sort,
                function($query,$sort) use ($bySpu) {
                    $sort = explode('_',$sort);
                    if($sort[0]=='viewed'){
                        return $query->orderBy('viewed','desc');
                    }else if($sort[0]=='new'){
                        return $query->orderBy('date_available','desc');
                    }else if($sort[0]=='price'){
                        if($bySpu){
                            if($sort[1]=='asc'){
                                return $query->orderByRaw('(CASE WHEN min(special) IS NOT NULL THEN min(special) WHEN min(discount) IS NOT NULL THEN min(discount) ELSE min(price) END) asc');
                            }else{
                                return $query->orderByRaw('(CASE WHEN max(special) IS NOT NULL THEN max(special) WHEN max(discount) IS NOT NULL THEN min(discount) ELSE max(price) END) desc');
                            }
                        }else{
                            if($sort[1]=='asc'){
                                return $query->orderByRaw('(CASE WHEN special IS NOT NULL THEN special WHEN discount IS NOT NULL THEN discount ELSE price END) asc');
                            }else{
                                return $query->orderByRaw('(CASE WHEN special IS NOT NULL THEN special WHEN discount IS NOT NULL THEN discount ELSE price END) desc');
                            }
                        }
                    }else if($sort[0]=='sale'){
                        return $query->orderBy('sale','desc');
                    }else if($sort[0]=='rating'){
                        return $query->orderBy('rating','desc');
                    }
                });
        return $res->Paginate(config('admin.perPage'))->withQueryString();
    }

    function sortArr(){
        return [''=>'Default sorting','viewed_desc'=>'Popularity','new_desc'=>'Latest',
            'price_asc'=>'Price: low to high','price_desc'=>'Price: high to low',
            'sale_desc'=>'Sales volume','rating_desc'=>'Average rating'];
    }

    function priceArr($symbol){
        return [
            ['0-20','Under '.$symbol.'20'],
            ['20-50',''.$symbol.'20 to '.$symbol.'50'],
            ['50-100',''.$symbol.'50 to '.$symbol.'100'],
            ['100','Over '.$symbol.'100']
        ];
    }

    function getByids($product_ids){
        $time = time();
        $sql = DB::table('shop_product as p')->where('p.status',1)->where('p.date_available','<=',$time)->whereIn('p.id',$product_ids);
        $sql->select('p.id','p.sale','p.image','p.viewed','p.date_available','p.price','p.name','p.quantity','p.remote','p.spu');
        $sql->addSelect([
            'reviews'=>Review::whereColumn('product_id','p.id')->where('status',1)
                ->groupBy('product_id')
                ->selectRaw('count(*)'),
            'rating'=>Review::whereColumn('product_id','p.id')->where('status',1)
                ->groupBy('product_id')
                ->selectRaw('AVG(rating)'),
            'special'=>ProductSpecial::whereColumn('product_id','p.id')
                ->where(function ($query) use ($time){
                    $query->where('date_start',0)->orWhere('date_start','<',$time);
                })->where(function ($query) use ($time){
                    $query->where('date_end',0)->orWhere('date_end','>',$time);
                })->orderBy('priority','desc')
                ->select('price')->limit(1),
            'discount'=>ProductDiscount::whereColumn('product_id','p.id')
                ->where('quantity',1)
                ->select('price')->limit(1)
        ]);
        return $sql->get()->keyBy('id')->toArray();
    }

    function findAttribute($id){
        return ProductAttribute::with('attribute')->where('product_id',$id)->get()->toArray();
    }

    function findSpecial($id){
        $time = time();
        $special = ProductSpecial::where('product_id',$id)->where(function ($query) use ($time){
            $query->where('date_start',0)->orWhere('date_start','<',$time);
        })->where(function ($query) use ($time){
            $query->where('date_end',0)->orWhere('date_end','>',$time);
        })->orderBy('priority','desc')->select('price')->firstToArray();
        if($special){
            return Currency::format($special['price'],2);
        }
        return [0,''];
    }

    function findReward($id,$group_id){
        return ProductReward::where('product_id',$id)->where('group_id',$group_id)->first();
    }

    function findDiscount($id){
        $arr = ProductDiscount::where('product_id',$id)->get()->toArray();
        foreach ($arr as $key=>$val){
            list($arr[$key]['price'],$arr[$key]['price_format']) = Currency::format($val['price'],2);
        }
        return $arr;
    }

    function isColorGroup(){
        $info = Option::where('is_color',1)->where('status',1)->first();
        return !empty($info);
    }

    function findOption($id,$render=false){
        $res = $this->optionValue($id);
        if($render){
            return $this->optionRender($res);
        }else{
            return $res;
        }
    }

    function optionValue($id,$productOption_ids=false){
        $productOption = ProductOption::where('product_id',$id)->when(
                            $productOption_ids,function ($query,$productOption_ids){
                                return $query->whereIn('id',$productOption_ids);
                            }
                        )->with('option')->orderBy('id','desc')->get()->keyBy('id')->toArray();
        return $this->_optionValue($productOption);
    }

    function optionValueByName($ids,$name='color'){
        $option = Option::where('name',$name)->firstToArray();
        if($option){
            $productOption = ProductOption::whereIn('product_id',$ids)->where('option_id',$option['id'])->with('option')->get()->keyBy('product_id')->toArray();
            return $this->_optionValue($productOption);
        }
        return [];
    }

    function _optionValue($productOption){
        $product_option_ids = array_column($productOption,'id');
        $productOptionValue = ProductOptionValue::whereIn('product_option_id',$product_option_ids)->with('option_value')->with('productImage')->orderBy('sort','desc')->get()->keyBy('id')->toArray();
        $productOptionValueGroup = [] ;
        foreach ($productOptionValue as $key=>$val){
            list($val['price'],$val['price_format']) = Currency::format($val['price'],2);
            $val['option_value']['image_src'] = UploadFile::getPath($val['option_value']['image'],$val['option_value']['remote']);
            if($val['product_image']){
                $val['product_image']['image_src'] = UploadFile::getPath($val['product_image']['image'],$val['product_image']['remote']);
            }
            $productOptionValueGroup[$val['product_option_id']][$key] = $val;
        }
        $res = [];
        foreach ($productOption as $key=>$val){
            $res[$key] = $val;
            $res[$key]['product_option_value'] = $productOptionValueGroup[$val['id']]??[];
        }
        return $res;
    }

    function optionRender($options){
        $html = '';
        foreach ($options as $val){
            if($val['option']['type']=='select'){
                $html .= '<div class="form-group flag_select'.($val['required']==1?'required':'').'">
                              <div class="control-label">'.$val['option']['name'].'</div>
                              <select name="option['.$val['id'].']" class="form-control" '.($val['required']==1?'required':'').'>';
                foreach ($val['product_option_value'] as $v){
                    $html .= '<option data-price="'.$v['price'].'" value="'.$v['id'].'">'.$v['option_value']['name'].'</option>';
                }
                $html .= '</select></div>';
            }else if($val['option']['type']=='radio'){
                $html .= '<div class="form-group flag_radio '.($val['required']==1?'required':'').'">
                              <div class="control-label">'.$val['option']['name'].'</div>
                              <div class="div_ul">';
                foreach ($val['product_option_value'] as $v){
                    $data_image_src = '';
                    if($v['product_image_id']){
                        if($v['product_image']['image_src']){
                            $img = '<img src="'.$v['product_image']['image_src'].'" />';
                            $data_image_src = 'data-image_src="true"';
                        }else{
                            $img = '';
                        }
                    }else{
                        $img = $v['option_value']['image']?'<img src="'.$v['option_value']['image_src'].'" />':'';
                    }
                    $html .= '<div class="position-relative"><input '.($val['required']==1?'required':'').' data-image_id="'.$v['product_image_id'].'" '.$data_image_src.' data-price="'.$v['price'].'" type="radio" name="option['.$val['id'].']" id="option_'.$val['id'].'_'.$v['id'].'" value="'.$v['id'].'" />
                            <label data-option_value_id="'.$v['option_value_id'].'" for="option_'.$val['id'].'_'.$v['id'].'" >'.$img.$v['option_value']['name'].'</label></div>';
                }
                $html .= '</div></div>';
            }else if($val['option']['type']=='checkbox'){
                $html .= '<div class="form-group flag_checkbox '.($val['required']==1?'required':'').'">
                              <div class="control-label">'.$val['option']['name'].'</div>
                              <div class="div_ul">';
                foreach ($val['product_option_value'] as $v){
                    $img = $v['option_value']['image']?'<img src="'.$v['option_value']['image_src'].'" />':'';
                    $html .= '<div class="position-relative"><input '.($val['required']==1?'required':'').'  data-price="'.$v['price'].'" type="checkbox" name="option['.$val['id'].'][]" id="option_'.$val['id'].'_'.$v['id'].'" value="'.$v['id'].'" />
                            <label  for="option_'.$val['id'].'_'.$v['id'].'">'
                        .$img.$v['option_value']['name'].'</label></div>';
                }
                $html .= '</div></div>';
            }else if($val['option']['type']=='text'){
                $html .= '<div class="form-group '.($val['required']==1?'required':'').'">
                              <div class="control-label">'.$val['option']['name'].'</div>
                              <input type="text" '.($val['required']==1?'required':'').' name="option['.$val['id'].']" value="'.$val['value'].'" placeholder="'.$val['option']['name'].'" class="form-control" />
                            </div>';
            }else if($val['option']['type']=='textarea'){
                $html .= '<div class="form-group '.($val['required']==1?'required':'').'">
                              <div class="control-label">'.$val['option']['name'].'</div>
                              <textarea '.($val['required']==1?'required':'').' name="option['.$val['id'].']" placeholder="'.$val['value'].'" class="form-control" >'.$val['value'].'</textarea>
                            </div>';
            }else if($val['option']['type']=='date' || $val['option']['type']=='datetime-local' || $val['option']['type']=='date'){
                $html .= '<div class="form-group '.($val['required']==1?'required':'').'">
                              <div class="control-label">'.$val['option']['name'].'</div>
                              <input '.($val['required']==1?'required':'').' type="'.$val['option']['type'].'" name="option['.$val['id'].']" value="'.$val['value'].'" placeholder="'.$val['value'].'" class="form-control" />
                            </div>';
            }

        }
        return $html;
    }
}
