<?php

namespace Aphly\LaravelShop\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'createtime'
    ];

    function desc(){
        return $this->hasOne(ProductDesc::class);
    }

    function img(){
        return $this->hasMany(ProductImg::class,'product_id');
    }
}
