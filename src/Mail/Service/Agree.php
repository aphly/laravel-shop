<?php

namespace Aphly\LaravelShop\Mail\Service;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Agree extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $service;

    public $serviceHistory;

    public function __construct($service,$serviceHistory)
    {
        $this->service = $service;
        $this->serviceHistory = $serviceHistory;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Service Agree')
            ->view('laravel-shop::mail.service.agree');
    }
}
