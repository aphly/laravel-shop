<?php

namespace Aphly\LaravelShop\Models\Catalog;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttributeGroup extends Model
{
    use HasFactory;
    protected $table = 'shop_attribute_group';
    public $timestamps = false;

    protected $fillable = [
        'name','sort','status'
    ];


}
