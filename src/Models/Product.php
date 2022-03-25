<?php

namespace Aphly\LaravelShop\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';
    public $timestamps = false;

    protected $fillable = [
        'spu',
        'sku',
        'cate_id',
        'name',
        'status',
        'gender',
        'size',
        'frame_width',
        'lens_width',
        'lens_height',
        'bridge_width',
        'arm_length',
        'shape',
        'material',
        'frame',
        'color',
        'feature',
        'price',
        'viewed',
        'createtime',
        'sale'
    ];

    function desc(){
        return $this->hasOne(ProductDesc::class);
    }

    function img(){
        return $this->hasMany(ProductImg::class,'product_id');
    }

    static function radio($name,array $arr,$nv=false) {
        $html = '';
        foreach($arr as $k=>$v){
            $img = '';
            if($name=='color'){
                $img = '<div class="filter-icon" style="background-color: '.$v['img'].'"></div>';
            }else if($name=='shape' || $name=='frame'){
                $img = '<img src="'.URL::asset('vendor/laravel-shop/img/filter/'.$name.'/'.$v['value'].'.png').'">';
            }
            if($v==$nv){
                $html.= '<div class="form-check"><label class="form-check-label" ><input checked="checked" class="form-check-input" type="radio" name="'.$name.'" value="'.$v['value'].'">'
                    .$img.$v['name'].'</label></div>';
            }else{
                $html.= '<div class="form-check"><label class="form-check-label" ><input class="form-check-input" type="radio" name="'.$name.'" value="'.$v['value'].'">'
                    .$img.$v['name'].'</label></div>';
            }
        }
        return $html;
    }

    static function checkbox($name,array $arr,$nv='') {
        $html = '';
        $nv = explode(',',$nv);
        foreach($arr as $k=>$v){
            $img = '';
            if($name=='color'){
                $img = '<div class="filter-icon" style="background-color: '.$v['img'].'"></div>';
            }else if($name=='shape' || $name=='frame'){
                $img = '<img src="'.URL::asset('vendor/laravel-shop/img/filter/'.$name.'/'.$v['value'].'.png').'">';
            }
            if($nv && in_array($v['value'],$nv)){
                $html.= '<div class="form-check"><label class="form-check-label" ><input checked="checked" class="form-check-input" type="checkbox" name="'.$name.'[]" value="'.$v['value'].'">'
                    .$img.$v['name'].'</label></div>';
            }else{
                $html.= '<div class="form-check"><label class="form-check-label" ><input class="form-check-input" type="checkbox" name="'.$name.'[]" value="'.$v['value'].'">'
                    .$img.$v['name'].'</label></div>';
            }
        }
        return $html;
    }

    static function color(array $color_arr,$val='') {
        $html = '<ul class="d-flex color_img">';
        $color_arr_all = [];
        foreach ($color_arr as $v){
            $color_arr_all[$v['value']] = $v['img'];
        }
        $arr = explode(',',$val);
        foreach($arr as $v){
            if(isset($color_arr_all[$v])){
                $html .= '<li style="background-color:'.$color_arr_all[$v].'"></li>';
            }
        }
        $html .='</ul>';
        return $html;
    }
}
