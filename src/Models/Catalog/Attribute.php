<?php

namespace Aphly\LaravelShop\Models\Catalog;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attribute extends Model
{
    use HasFactory;
    protected $table = 'shop_attribute';
    public $timestamps = false;

    protected $fillable = [
        'name','attribute_group_id','sort'
    ];

    function group(){
        return $this->hasOne(AttributeGroup::class,'id','attribute_group_id');
    }
}
