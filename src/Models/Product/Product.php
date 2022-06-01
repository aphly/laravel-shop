<?php

namespace Aphly\LaravelShop\Models\Product;

use Aphly\LaravelShop\Models\Account\Customer;
use Aphly\LaravelShop\Models\Account\Group;
use Aphly\LaravelShop\Models\Common\Currency;
use Aphly\LaravelShop\Models\Common\Setting;
//use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;
    protected $table = 'shop_product';
    public $timestamps = false;

    protected $fillable = [
        'sku','name','quantity','image','price',
        'shipping','points','stock_status_id','weight','weight_class_id',
        'length','width','height','length_class_id','subtract',
        'minimum','status','viewed','sale','sort','date_add','date_available'
    ];

    function desc(){
        return $this->hasOne(ProductDesc::class);
    }

    function img(){
        return $this->hasMany(ProductImage::class,'product_id');
    }

    public $sub_category = false;

    public function getList($data = []) {
        $filter = $data['filter'];
        $sort = $data['sort'];
        $time = time();
        $setting = Setting::findAll();
        $group_id = session()->has('customer')?session('customer')['group_id']:$setting['config']['group'];
        if($data['category_id']){
            if($this->sub_category){
                $sql = DB::table('shop_category_path as cp')->leftJoin('shop_product_category as pc','cp.category_id','=','pc.category_id');
            }else{
                $sql = DB::table('shop_product_category as pc');
            }
            $sql->when($filter, function ($query) {
                    return $query->leftJoin('shop_product_filter as pf','pc.product_id','=','pf.product_id');
                });
            $sql->leftJoin('shop_product as p','pc.product_id','=','p.id' );
        }else{
            $sql = DB::table('shop_product as p');
        }
        $sql->where('p.status',1)->where('p.date_available','<=',time());
        if($data['category_id']){
            if($this->sub_category) {
                $sql->where('cp.path_id', $data['category_id']);
            }else{
                $sql->where('pc.category_id', $data['category_id']);
            }
            if($filter){
                $implode = [];
                $filters = explode(',', $filter);
                foreach ($filters as $filter_id) {
                    $implode[] = (int)$filter_id;
                }
                $sql->whereIn('pf.filter_id',$implode);
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
            ->select('p.id','p.sale','p.viewed','p.date_available','p.price','p.name','p.quantity');
        $sql->addSelect(['rating'=>Review::whereColumn('product_id','p.id')->where('status',1)
            ->groupBy('product_id')
            ->selectRaw('AVG(rating) AS total')->limit(1)
        ]);
        $sql->addSelect(['special'=>ProductSpecial::whereColumn('product_id','p.id')->where('group_id',$group_id)
            ->where('date_start','<',$time)->where('date_end','>',$time)
            ->select('price')->limit(1)
        ]);
        $sql->when($sort,
            function($query,$sort) {
                $sort = explode('_',$sort);
                if($sort[0]=='viewed'){
                    return $query->orderBy('p.viewed','desc');
                }else if($sort[0]=='new'){
                    return $query->orderBy('p.date_available','desc');
                }else if($sort[0]=='price'){
                    if($sort[1]=='asc'){
                        return $query->orderBy('p.price','asc');
                    }else{
                        return $query->orderBy('p.price','desc');
                    }
                }else if($sort[0]=='sale'){
                    return $query->orderBy('p.sale','desc');
                }else if($sort[0]=='rating'){
                    return $query->orderBy('rating','desc');
                }
            });
        return $sql->Paginate(config('admin.perPage'))->withQueryString();
    }

//    protected function price(): Attribute
//    {
//        return new Attribute(
//            get: fn ($value) => Currency::format($value)
//        );
//    }

    function findAttribute($id){
        return ProductAttribute::with('attribute')->where('product_id',$id)->get()->toArray();
    }



    function findSpecial($id){
        $group_id = Customer::groupId();
        return ProductSpecial::where('product_id',$id)->where('group_id',$group_id)->first();
    }

    function findReward($id){
        $group_id = Customer::groupId();
        return ProductReward::where('product_id',$id)->where('group_id',$group_id)->first();
    }

    function findDiscount($id){
        $group_id = Customer::groupId();
        return ProductDiscount::where('product_id',$id)->where('group_id',$group_id)->get()->toArray();
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
                        )->with('option')->get()->keyBy('id')->toArray();
        $product_option_ids = array_column($productOption,'id');
        $productOptionValue = ProductOptionValue::whereIn('product_option_id',$product_option_ids)->with('option_value')->get()->keyBy('id')->toArray();
        $productOptionValueGroup = [] ;
        foreach ($productOptionValue as $key=>$val){
            $val['price_format'] = Currency::format($val['price']);
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
                $html .= '<div class="form-group '.($val['required']==1?'required':'').'">
                              <label class="control-label">'.$val['option']['name'].'</label>
                              <select name="option['.$val['id'].']" class="form-control">';
                foreach ($val['product_option_value'] as $v){
                    $html .= '<option value="'.$v['id'].'">'.$v['option_value']['name'].(intval($v['price'])?'(+'.$v['price_format'].')':'').'</option>';
                }
                $html .= '</select></div>';
            }else if($val['option']['type']=='radio'){
                $html .= '<div class="form-group '.($val['required']==1?'required':'').'">
                              <label class="control-label">'.$val['option']['name'].'</label>
                              <div>';
                foreach ($val['product_option_value'] as $v){
                    $img = $v['option_value']['image']?'<img src="'.Storage::url($v['option_value']['image']).'" />':'';
                    $html .= '<label><input type="radio" name="option['.$val['id'].']" value="'.$v['id'].'" />'
                        .$img.$v['option_value']['name'].(intval($v['price'])?'(+'.$v['price_format'].')':'').'</label>';
                }
                $html .= '</div></div>';
            }else if($val['option']['type']=='checkbox'){
                $html .= '<div class="form-group '.($val['required']==1?'required':'').'">
                              <label class="control-label">'.$val['option']['name'].'</label>
                              <div>';
                foreach ($val['product_option_value'] as $v){
                    $img = $v['option_value']['image']?'<img src="'.Storage::url($v['option_value']['image']).'" />':'';
                    $html .= '<label><input type="checkbox" name="option['.$val['id'].'][]" value="'.$v['id'].'" />'
                        .$img.$v['option_value']['name'].(intval($v['price'])?'(+'.$v['price_format'].')':'').'</label>';
                }
                $html .= '</div></div>';
            }else if($val['option']['type']=='text'){
                $html .= '<div class="form-group '.($val['required']==1?'required':'').'">
                              <label class="control-label">'.$val['option']['name'].'</label>
                              <input type="text" name="option['.$val['id'].']" value="'.$val['value'].'" placeholder="'.$val['option']['name'].'" class="form-control" />
                            </div>';
            }else if($val['option']['type']=='textarea'){
                $html .= '<div class="form-group '.($val['required']==1?'required':'').'">
                              <label class="control-label">'.$val['option']['name'].'</label>
                              <textarea name="option['.$val['id'].']" placeholder="'.$val['value'].'" class="form-control" >'.$val['value'].'</textarea>
                            </div>';
            }else if($val['option']['type']=='date' || $val['option']['type']=='datetime-local' || $val['option']['type']=='date'){
                $html .= '<div class="form-group '.($val['required']==1?'required':'').'">
                              <label class="control-label">'.$val['option']['name'].'</label>
                              <input type="'.$val['option']['type'].'" name="option['.$val['id'].']" value="'.$val['value'].'" placeholder="'.$val['value'].'" class="form-control" />
                            </div>';
            }

        }
        return $html;
    }
}
