<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TitleParagraphMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $title;
    public $paragraph;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title,$paragraph)
    {
         $this->title = $title;
         $this->paragraph = $paragraph;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email_templates.title_paragraph');
        
        // return $this->from("9GemLab",$title)->subject($this->title)->view('email_templates.title_paragraph');
        // return $this->from('nandkishore906734@gmail.com','Login Verification')->subject('OTP Code')->view('admin.name',['otp_code'=>$this->otp_code]);
    }
}
