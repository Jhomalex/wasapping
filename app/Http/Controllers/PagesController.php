<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contacto;

class PagesController extends Controller
{
    public function dashboard(){
        return view('plataforma/dashboard');
    }

    public function mensajeria(){
        return view('plataforma/mensajeria');
    }

    public function contactos(){
        return view('plataforma/contactos');
    }

    public function perfilcontacto($id){
        $contacto =Contacto::find($id);
        if ($contacto->user_id == auth()->user()->id) {
            $contacto=Contacto::where('contactos.id','=',$id)->get();
            return view('plataforma.perfilcontacto',compact('contacto'));
        } else {
            return 'No';
            // return view('plataforma.contactos');
        };
    }

    public function listamensajeria()
    {
        return view('plataforma/listaMensajeria');
    }
}
