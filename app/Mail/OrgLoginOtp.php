<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrgLoginOtp extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $login='';

    public function __construct($data)
    {
       
        $this->login=$data;


    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

             return $this->from('nandkishore906734@gmail.com','OTP code')->subject('Login')->view('admin.amaster.organization.email_config.login_otp',['mail_data'=>$this->login]);
    }
}
