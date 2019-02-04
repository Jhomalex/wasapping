<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function dashboard(){
        return view('plataforma/dashboard');
    }

    public function mensajeria(){
        return view('plataforma/mensajeria');
    }
}
