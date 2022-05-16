<?php

namespace Aphly\LaravelShop\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\DB;

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

    public function getProducts($data = []) {
        $filter = $data['filter'];
        $sort = $data['sort'];
        $time = time();
        $group_id = session()->has('customer')?session('customer')['group_id']:0;
        if($data['category_id']){
            $sql = DB::table('shop_category_path as cp')->leftJoin('shop_product_category as pc','cp.category_id','=','pc.category_id')
                ->when($filter, function ($query) {
                    return $query->leftJoin('shop_product_filter as pf','pc.product_id','=','pf.product_id');
                });
            $sql->leftJoin('shop_product as p','pc.product_id','=','p.id' );
        }else{
            $sql = DB::table('shop_product as p');
        }
        $sql->where('p.status',1)->where('p.date_available','<=',time());
        if($data['category_id']){
            $sql->where('cp.path_id',$data['category_id']);
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
}
