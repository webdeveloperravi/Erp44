<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisteredOtpCode extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
        public $registered='';

    public function __construct($data)
    {
       
        $this->registered=$data;


    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       return $this->from('nandkishore906734@gmail.com','Registered Email')->subject('Verification OTP Code')->view('admin.amaster.organization.email_config.registered_otp',['reg_data'=>$this->registered]);
    }
}
