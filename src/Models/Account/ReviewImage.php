<?php

namespace Aphly\LaravelShop\Models\Account;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewImage extends Model
{
    use HasFactory;
    protected $table = 'shop_review';
    public $timestamps = false;

    protected $fillable = [
        'review_id','image'
    ];


}
