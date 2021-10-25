<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StoreSecurityPin extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
     public $info;
    public function __construct($data)
    {

          $this ->info = $data;

   }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
             return $this->from('nandkishore906734@gmail.com','Welcome Kit Email')->subject('Email Kit')->view('admin.amaster.organization.email_config.store_security_kit',['info'=>$this->info]);
   
    }
}
