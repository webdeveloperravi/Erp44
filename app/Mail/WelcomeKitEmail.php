<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeKitEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data='';
    public function __construct($data)
    {

        $this->data=$data;
    }

   
    public function build()
    {
       return $this->from('nandkishore906734@gmail.com','Welcome Kit Email')->subject('Email Kit')->view('email_templates.welcomekit',['info'=>$this->data]);
    }
    
}
