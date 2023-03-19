<?php

namespace Aphly\LaravelShop\Models\Catalog;

use Aphly\Laravel\Models\UploadFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Aphly\Laravel\Models\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class ProductImage extends Model
{
    use HasFactory;
    protected $table = 'shop_product_image';
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'image',
        'sort'
    ];


}
