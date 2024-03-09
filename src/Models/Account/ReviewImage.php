<?php

namespace Aphly\LaravelShop\Models\Account;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReviewImage extends Model
{
    use HasFactory;
    protected $table = 'shop_review_image';
    public $timestamps = false;

    protected $fillable = [
        'review_id','image','remote'
    ];


}
