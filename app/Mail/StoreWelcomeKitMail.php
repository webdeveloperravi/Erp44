<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StoreWelcomeKitMail extends Mailable
{
    use Queueable, SerializesModels;

   public  $storeRole;
   public  $securityPin;


    public function __construct($storeRole,$securityPin)
    {
        $this->storeRole = $storeRole;
        $this->securityPin = $securityPin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email_templates.store_welcome_kit');
    }
}
