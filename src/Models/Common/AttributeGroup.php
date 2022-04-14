<?php

namespace Aphly\LaravelShop\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeGroup extends Model
{
    use HasFactory;
    protected $table = 'shop_attribute_group';
    public $timestamps = false;

    protected $fillable = [
        'name','sort'
    ];


}
