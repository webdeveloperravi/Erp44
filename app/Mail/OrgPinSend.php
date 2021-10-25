<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrgPinSend extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $pin_data;
    
    public function __construct($data)
    {
        $this->pin_data=$data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
          return $this->from('nandkishore906734@gmail.com','thanks')->subject('Welocme to 9GEM.net')->view('admin.amaster.organization.email_config.org_pin',['pin_data'=>$this->pin_data]);
    }
}
