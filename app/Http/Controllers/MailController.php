<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\Correo;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function send()
    {
        $objDemo = new \stdClass();
        $objDemo->demo_one = 'Demo One Value';
        $objDemo->demo_two = 'Demo Two Value';
        $objDemo->sender = 'Yodonante';
        $objDemo->receiver = 'Donitos';
 
        Mail::to("jhomalex07@hotmail.com")->send(new Correo($objDemo));
    }
}
