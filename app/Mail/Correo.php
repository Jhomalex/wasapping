<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Correo extends Mailable
{
    use Queueable, SerializesModels;

    public $demo;

    public function __construct($demo)
    {
        $this->demo = $demo;
    }

    public function build()
    {
        return $this->from('hola@yodonante.com')
            ->view('mails.mail')
            
            ->with([
                'testVarOne' => '1',
                'testVarTwo' => '2',
            ])
        /*    ->attach(public_path('/images').'/demo.jpg', [
                'as' => 'demo.jpg',
                'mime' => 'image/jpeg',
            ]
        )*/;
    }
}
