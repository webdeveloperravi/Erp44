<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class leadToStoreVerifyEmailMail extends Mailable
{
    use Queueable, SerializesModels;
     
    public $emailtoken;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailtoken)
    { 
        $this->emailtoken = $emailtoken;
    }
    
    public function build()
    {
        return $this->view('email_templates.leadtostoreemailverify');
    }
}
