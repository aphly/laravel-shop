<?php

namespace Aphly\LaravelShop\Jobs\Service;

use Aphly\LaravelPayment\Models\Payment;
use Aphly\LaravelShop\Models\Sale\Order;
use Aphly\LaravelShop\Models\Sale\ServiceHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class Refund implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    //public $tries = 1;

    public $timeout = 60;

    public $failOnTimeout = true;

    public $service ;

    //php artisan queue:work --queue=order_service

    public function __construct($service){
        $this->service = $service;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $orderInfo = Order::where('id',$this->service->order_id)->where('order_status_id',3)->where('delete_at',0)->first();
        if($this->service->service_status_id===1 && !empty($orderInfo)){
            (new Payment)->refund_api($orderInfo->payment_id,$this->service->refund_amount,'System Refund');
            $service_status_id = 6;
            $serviceHistory = ServiceHistory::create([
                'service_id'=>$this->service->id,
                'service_action_id'=>$this->service->service_action_id,
                'service_status_id'=>$service_status_id,
                'comment'=>'48 hour system automatic refund',
                'notify'=>1
            ]);
            if($serviceHistory->id){
                $this->service->service_status_id = $service_status_id;
                $this->service->save();
                $orderInfo->addOrderHistory($orderInfo, 4);
            }
        }

    }
}
