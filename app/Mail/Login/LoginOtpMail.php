<?php

namespace App\Mail\Login;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoginOtpMail extends Mailable
{
    use Queueable, SerializesModels;
    public $title = '';
    public $otp = '';
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title,$otp)
    {
        $this->title = $title;
        $this->otp = $otp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->title)->view('email_templates.storeLoginOtp',['title'=> $this->title,'otp'=>$this->otp]);
    }
}
