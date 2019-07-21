<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Mensajeria;
use App\Contrato;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Imports\ContactoImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\Correo;
use App\Contacto;
use Illuminate\Support\Facades\Mail;

class MensajeriaController extends Controller
{

    public function listarTodos(){
        $mensajeria = DB::table('mensajerias')
        ->join('users','mensajerias.user_id','=','users.id')->get();
        return $mensajeria;
    }

    public function store(Request $request){
        $request->validate([
            'nombre' => 'required',
        ]);

        $mensajeria=new Mensajeria();
        $mensajeria->nombre=$request->nombre;
        $mensajeria->descripcion=$request->descripcion;
        $mensajeria->user_id=auth()->id();
        $mensajeria->save();
        
        $mensajeria->contactos()->attach($request->get('contactos'));
        
        return "Ok";
    }

    public function edit(Request $request){
        $request->validate([
            'id' => 'required',
            'nombre' => 'required|max:250',
            'descripcion' => 'required',
        ]);

        $mensajeria=Mensajeria::find($request->id);
        $mensajeria->nombre = $request->nombre;
        $mensajeria->descripcion = $request->mensaje;
        $mensajeria->save();

        $this.asignarContactos($mensajeria, $request->get('contactos'));

        return 'Ok';
    }

    public function delete(Request $request){
        $request->validate([
            'id' => 'required',
        ]);
        $mensajeria_id = request()->id;
        $mensajeria=Mensajeria::find($mensajeria_id);
        // DB::table('contacto_mensajeria')->where('mensajeria_id',$mensajeria_id)->get();
        $mensajeria->delete();
        return 'Ok';
    }

    public function mostrarContactos(Request $request){
        $mensajeria = Mensajeria::find($request->get('mensajeria_id'));
        $array = Excel::toArray(new ContactoImport,'./public/archivos/'.$mensajeria->archivo);
        return $array;
    }

    public function sendMail()
    {
        $objDemo = new \stdClass();
        $objDemo->demo_one = 'Demo One Value';
        $objDemo->demo_two = 'Demo Two Value';
        $objDemo->sender = 'Yodonante';
        $objDemo->receiver = 'Donitos';
        $mails=["jhomalex07@hotmail.com","jhomalex07@gmail.com"];
        Mail::to($mails)->send(new Correo($objDemo));
    }

    public function contarMensajerias()
    {
        $contrato = Contrato::where('user_id','=',auth()->id())->orderBy('created_at','ASC')->first();
        return $contrato['total'] - $contrato['progreso'];
    }

    public function contarCampanias(){
        $mensajeria = Mensajeria::where('user_id','=', auth()->id())->count();
        return $mensajeria;
    }

    public function asignarContactos(Mensajeria $mensajeria, Array $contactos)
    {
        if ($contactos) {
            foreach ($contactos_id as $contacto_id) {
                if (DB::table('contacto_mensajeria')->where('mensajeria_id','=',$mensajeria->id)->where('contacto_id','=',$contacto_id)->doesntExist()) {
                    $mensajeria->contactos()->attach($contacto_id);
                }
            }
        }
    }

    public function listar(){
        $mensajeria = DB::table('mensajerias')
        ->where('mensajerias.user_id','=',auth()->id())->get();
        return $mensajeria;
    }

    public function listarr(Request $request){
        $this->validate($request,[
            'grupo' => 'required',
        ]);
        $grupo_id =  $request->get('grupo');
        
         $contacto = Contacto::where('contactos.user_id', '=', auth()->user()->id)
         ->join('contacto_mensajeria','contacto_mensajeria.contacto_id','=','contactos.id')
         ->where('contacto_mensajeria.mensajeria_id','=',$grupo_id)->get();
         return $contacto;
    }

    public function deletemsj(Request $request){
        $this->validate($request,[
            'mensajeId' => 'required',
        ]);

        $grupomsj=Mensajeria::find($request->get('mensajeId'));
        $grupomsj->contactos()->detach();
        $grupomsj->delete();
        return 'Ok';
    }
}
