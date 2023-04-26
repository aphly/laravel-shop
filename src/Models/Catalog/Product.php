<?php

namespace Aphly\LaravelShop\Models\Catalog;

use Aphly\Laravel\Models\UploadFile;
use Aphly\LaravelCommon\Models\Currency;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    protected $table = 'shop_product';
    //public $timestamps = false;

    protected $fillable = [
        'sku','name','quantity','image','price','uuid','spu',
        'shipping','stock_status_id','weight','weight_class_id',
        'length','width','height','length_class_id','subtract',
        'status','viewed','sale','sort','date_available'
    ];

    function desc(){
        return $this->hasOne(ProductDesc::class,'product_id','id');
    }

    function img(){
        return $this->hasMany(ProductImage::class,'product_id');
    }

    function imgById($product_id){
        $productImage = ProductImage::where('product_id',$product_id)->orderBy('sort','desc')->get()->toArray();
        $res = [];
        foreach($productImage as $val){
            $val['image_src'] = UploadFile::getPath($val['image'],true);
            $res[] = $val;
        }
        return $res;
    }

    function imgByIds($product_ids){
        $productImage = ProductImage::whereIN('product_id',$product_ids)->orderBy('sort','desc')->get()->toArray();
        $res = [];
        foreach($productImage as $val){
            $val['image_src'] = UploadFile::getPath($val['image']);
            $res[$val['product_id']][] = $val;
        }
        return $res;
    }

    public $sub_category = false;

    public function getList($data = [],$bySpu=false) {
        //$type = 1 sku
        //$type = 2 spu
        $data['category_id'] = $data['category_id']??false;
        $filter = $data['filter']??false;
        $option_value = $data['option_value']??false;
        $price = $data['price']??false;
        $sort = $data['sort'];
        $time = time();
        if($data['category_id']){
            if($this->sub_category){
                $sql = DB::table('shop_category_path as cp')->leftJoin('shop_product_category as pc','cp.category_id','=','pc.category_id');
            }else{
                $sql = DB::table('shop_product_category as pc');
            }
            $sql->when($filter, function ($query) {
                return $query->leftJoin('shop_product_filter as pf','pc.product_id','=','pf.product_id');
            })->when($option_value, function ($query) {
                return $query->leftJoin('shop_product_option_value as pov','pc.product_id','=','pov.product_id');
            });
            $sql->leftJoin('shop_product as p','pc.product_id','=','p.id' );
        }else{
            $sql = DB::table('shop_product as p');
            $sql->when($filter, function ($query) {
                return $query->leftJoin('shop_product_filter as pf','p.id','=','pf.product_id');
            })->when($option_value, function ($query) {
                return $query->leftJoin('shop_product_option_value as pov','p.id','=','pov.product_id');
            });
        }
        $sql->where('p.status',1)->where('p.date_available','<=',$time);
        if($data['category_id']){
            if($this->sub_category) {
                $sql->where('cp.path_id', $data['category_id']);
            }else{
                $sql->where('pc.category_id', $data['category_id']);
            }
        }
        if($filter){
            $implode = [];
            $filters = explode(',', $filter);
            foreach ($filters as $filter_id) {
                $implode[] = (int)$filter_id;
            }
            $implode = array_filter($implode);
            $sql->whereIn('pf.filter_id',$implode);
        }
        if($option_value){
            $implode = [];
            $option_values = explode(',', $option_value);
            foreach ($option_values as $option_value_id) {
                $implode[] = (int)$option_value_id;
            }
            $implode = array_filter($implode);
            $sql->whereIn('pov.option_value_id',$implode);
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
            ->select('p.id','p.sale','p.viewed','p.date_available','p.price','p.name','p.quantity','p.image','p.spu');

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
                $price_max = abs((float)$price_arr[1]);
                if(!$price_min && $price_max){
                    return $query->whereRaw('IFNULL(special,IFNULL(discount,price))<='.$price_max);
                }else if($price_min && $price_max){
                    return $query->whereRaw('IFNULL(special,IFNULL(discount,price))>='.$price_min.' and IFNULL(special,IFNULL(discount,price))<='.$price_max);
                }else if($price_min && !$price_max){
                    return $query->whereRaw('IFNULL(special,IFNULL(discount,price))>='.$price_min);
                }
            })
            ->when($bySpu,function ($query){
                return $query->groupBy('spu')
                    ->selectRaw('spu,GROUP_CONCAT(id) as ids,max(viewed) as viewed,max(date_available) as date_available,
                            min(price) as price,min(special) as special,min(discount) as discount,max(sale) as sale,max(rating) as rating');
            })
            ->when($sort,
                function($query,$sort) {
                    $sort = explode('_',$sort);
                    if($sort[0]=='viewed'){
                        return $query->orderBy('viewed','desc');
                    }else if($sort[0]=='new'){
                        return $query->orderBy('date_available','desc');
                    }else if($sort[0]=='price'){
                        if($sort[1]=='asc'){
                            return $query->orderByRaw('(CASE WHEN min(special) IS NOT NULL THEN min(special) WHEN min(discount) IS NOT NULL THEN min(discount) ELSE min(price) END) asc');
                        }else{
                            return $query->orderByRaw('(CASE WHEN max(special) IS NOT NULL THEN max(special) WHEN max(discount) IS NOT NULL THEN min(discount) ELSE max(price) END) desc');
                        }
                    }else if($sort[0]=='sale'){
                        return $query->orderBy('sale','desc');
                    }else if($sort[0]=='rating'){
                        return $query->orderBy('rating','desc');
                    }
                });
        return $res->Paginate(config('admin.perPage'))->withQueryString();
    }

    function getByids($product_ids){
        $time = time();
        $sql = DB::table('shop_product as p')->where('p.status',1)->where('p.date_available','<=',$time)->whereIn('p.id',$product_ids);
        $sql->select('p.id','p.sale','p.viewed','p.date_available','p.price','p.name','p.quantity','p.image','p.spu');
        $sql->addSelect(['special'=>ProductSpecial::whereColumn('product_id','p.id')
            ->where(function ($query) use ($time){
                $query->where('date_start',0)->orWhere('date_start','<',$time);
            })->where(function ($query) use ($time){
                $query->where('date_end',0)->orWhere('date_end','>',$time);
            })->orderBy('priority','desc')
            ->select('price')->limit(1)
        ]);
        $sql->addSelect(['discount'=>ProductDiscount::whereColumn('product_id','p.id')
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
        $productOptionValue = ProductOptionValue::whereIn('product_option_id',$product_option_ids)->with('option_value')->with('productImage')->get()->keyBy('id')->toArray();
        $productOptionValueGroup = [] ;
        foreach ($productOptionValue as $key=>$val){
            list($val['price'],$val['price_format']) = Currency::format($val['price'],2);
            $val['option_value']['image_src'] = UploadFile::getPath($val['option_value']['image']);
            if($val['product_image']){
                $val['product_image']['image_src'] = UploadFile::getPath($val['product_image']['image']);
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
                              <select name="option['.$val['id'].']" class="form-control">';
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
                    $html .= '<input data-image_id="'.$v['product_image_id'].'" '.$data_image_src.' data-price="'.$v['price'].'" type="radio" name="option['.$val['id'].']" id="option_'.$val['id'].'_'.$v['id'].'" value="'.$v['id'].'" />
                            <label for="option_'.$val['id'].'_'.$v['id'].'" >'.$img.$v['option_value']['name'].'</label>';
                }
                $html .= '</div></div>';
            }else if($val['option']['type']=='checkbox'){
                $html .= '<div class="form-group flag_checkbox '.($val['required']==1?'required':'').'">
                              <div class="control-label">'.$val['option']['name'].'</div>
                              <div class="div_ul">';
                foreach ($val['product_option_value'] as $v){
                    $img = $v['option_value']['image']?'<img src="'.$v['option_value']['image_src'].'" />':'';
                    $html .= '<input data-price="'.$v['price'].'" type="checkbox" name="option['.$val['id'].'][]" id="option_'.$val['id'].'_'.$v['id'].'" value="'.$v['id'].'" /><label for="option_'.$val['id'].'_'.$v['id'].'">'
                        .$img.$v['option_value']['name'].'</label>';
                }
                $html .= '</div></div>';
            }else if($val['option']['type']=='text'){
                $html .= '<div class="form-group '.($val['required']==1?'required':'').'">
                              <div class="control-label">'.$val['option']['name'].'</div>
                              <input type="text" name="option['.$val['id'].']" value="'.$val['value'].'" placeholder="'.$val['option']['name'].'" class="form-control" />
                            </div>';
            }else if($val['option']['type']=='textarea'){
                $html .= '<div class="form-group '.($val['required']==1?'required':'').'">
                              <div class="control-label">'.$val['option']['name'].'</div>
                              <textarea name="option['.$val['id'].']" placeholder="'.$val['value'].'" class="form-control" >'.$val['value'].'</textarea>
                            </div>';
            }else if($val['option']['type']=='date' || $val['option']['type']=='datetime-local' || $val['option']['type']=='date'){
                $html .= '<div class="form-group '.($val['required']==1?'required':'').'">
                              <div class="control-label">'.$val['option']['name'].'</div>
                              <input type="'.$val['option']['type'].'" name="option['.$val['id'].']" value="'.$val['value'].'" placeholder="'.$val['value'].'" class="form-control" />
                            </div>';
            }

        }
        return $html;
    }
}
