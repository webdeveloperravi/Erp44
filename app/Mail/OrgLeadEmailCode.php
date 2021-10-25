<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrgLeadEmailCode extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $otp;
    
    public function __construct($otp)
    {
        
        $this->otp=$otp;
    }
   
    public function build()
    {
           return $this->from('nandkishore906734@gmail.com','OTP code')->subject(env('APP_NAME').' '.'Create account verify')->view('email_templates.otp_verification',['otp'=>$this->otp]);
    }
}
