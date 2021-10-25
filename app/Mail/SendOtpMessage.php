<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendOtpMessage extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $otp_code="";
    public function __construct($otp_code)
    {
        $this->otp_code=$otp_code;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         // return $this->view('admin.name',['flag'=>true]);
         return $this->from('nandkishore906734@gmail.com','Login Verification')->subject('OTP Code')->view('admin.name',['otp_code'=>$this->otp_code]);
    }
}
