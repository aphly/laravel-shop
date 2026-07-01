<?php

namespace Aphly\LaravelShop\Models\Sale;

use Aphly\Laravel\Models\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderShipping extends Model
{
    use HasFactory;
    protected $table = 'shop_order_shipping';
    public $timestamps = false;

    protected $fillable = [
        'order_id','waybill_number','label_url',
        'weight','length','width','height'
    ];

    public $package_status_dict = [
        'N'=>['cn'=>'未找到订单','us'=>'Order Not Found'],
        'F'=>['cn'=>'电子预报信息接收','us'=>'Electronic Pre-advice Received'],
        'T'=>['cn'=>'运输中','us'=>'In Transit'],
        'D'=>['cn'=>'成功投递','us'=>'Delivered Successfully'],
        'E'=>['cn'=>'可能异常','us'=>'Abnormal Risk'],
        'R'=>['cn'=>'包裹退回','us'=>'Package Returned'],
        'C'=>['cn'=>'订单取消','us'=>'Order Cancelled'],
    ];
}
