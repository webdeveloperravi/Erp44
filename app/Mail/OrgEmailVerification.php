<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrgEmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $signup_email;
    
    public function __construct($data)
    {
        $this->signup_email=$data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('nandkishore906734@gmail.com','OTP code')->subject('Welocme to New User')->view('admin.amaster.organization.email_config.index',['mail_data'=>$this->signup_email]);
    }
}
