<?php

namespace Aphly\LaravelShop\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'shop_category';
    public $timestamps = false;

    protected $fillable = [
        'name','image','pid','sort','status','description','meta_title','meta_keyword','meta_description'
    ];


}
