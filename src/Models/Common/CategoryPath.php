<?php

namespace Aphly\LaravelShop\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;

class CategoryPath extends Model
{
    use HasFactory;
    protected $table = 'shop_category_path';
    protected $primaryKey = ['category_id','path_id'];
    public $timestamps = false;

    protected $fillable = [
        'category_id','path_id','level'
    ];


}
