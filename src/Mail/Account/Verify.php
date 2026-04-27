<?php

namespace Aphly\LaravelShop\Mail\Account;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;

class Verify extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $userAuth;

    public function __construct($userAuth)
    {
        $this->userAuth = $userAuth;
        $this->userAuth->siteUrl = url('');
        $this->userAuth->token = Crypt::encryptString($userAuth->uid.','.time()+1200);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('laravel-shop::mail.account.verify');
    }
}
