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

    public function getProducts($category_id = 0,$filter =false,$name = '') {
        $time = time();
        $group_id = session()->has('customer')?session('customer')['group_id']:0;
        if($category_id){
            $sql = DB::table('shop_category_path as cp')->leftJoin('shop_product_category as pc','cp.category_id','=','pc.category_id')
                ->when($filter, function ($query) {
                    return $query->leftJoin('shop_product_filter as pf','pc.product_id','=','pf.product_id');
                });
            $sql->leftJoin('shop_product as p','pc.product_id','=','p.id' );
        }else{
            $sql = DB::table('shop_product as p');
        }
        $sql->where('p.status',1)->where('p.date_available','<=',time());
        if($category_id){
            $sql->where('cp.path_id',$category_id);
            if($filter){
                $implode = [];
                $filters = explode(',', $filter);
                foreach ($filters as $filter_id) {
                    $implode[] = (int)$filter_id;
                }
                $sql->whereIn('pf.filter_id',$implode);
            }
        }
        if($name){
            $words = explode(' ', trim($name));
            if(count($words)>1){
                foreach ($words as $word) {
                    $sql->where('p.name','like','%'.$word.'%');
                }
            }else{
                $sql->where('p.name','like','%'.$name.'%');
            }
        }
        $sql->groupBy('p.id')
            ->select('p.id','p.sale','p.viewed','p.date_available','p.price','p.name');
        $sql->addSelect(['rating'=>Review::whereColumn('product_id','p.id')->where('status',1)
            ->groupBy('product_id')
            ->selectRaw('AVG(rating) AS total')->limit(1)
        ]);
        $sql->addSelect(['special'=>ProductSpecial::whereColumn('product_id','p.id')->where('group_id',$group_id)
            ->where('date_start','<',$time)->where('date_end','>',$time)
            ->select('price')->limit(1)
        ]);
        $sort_data = ['p.quantity','p.price','rating','p.sort_order','p.date_added'];

        return $sql->Paginate(config('admin.perPage'))->withQueryString();
    }
}
