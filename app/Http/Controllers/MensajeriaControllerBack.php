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
use Illuminate\Support\Facades\Mail;

class MensajeriaController extends Controller
{

    public function listarTodos(){
   //     $mensajeria = Mensajeria::all();
        $mensajeria = DB::table('mensajerias')
        ->join('users','mensajerias.user_id','=','users.id')
        ->select('mensajerias.id','mensajerias.campania','mensajerias.mensaje','users.nombre AS usuario',
        'mensajerias.fecha AS fecha','mensajerias.horamin AS horamin','mensajerias.horamax AS horamax')->get();
        return $mensajeria;
    }

    public function store(Request $request){
        $request->validate([
            'campania' => 'required|max:250',
            'mensaje' => 'required',
            'archivo' => 'required|mimes:xlsx|max:2048',
            'fecha' => 'required',
            'horamin' => 'required',
            'horamax' => 'required',
        ]);
        $archivo=request()->archivo;
        $ruta=Storage::disk('public')->put('archivos', $archivo);

        $mensajeria=new Mensajeria();
        $mensajeria->campania=request()->campania;
        $mensajeria->mensaje=request()->mensaje;
        $mensajeria->url=Storage::url($ruta);
        $mensajeria->archivo=basename($ruta);
        $mensajeria->fecha=request()->fecha;
        $mensajeria->horamin=request()->horamin;
        $mensajeria->horamax=request()->horamax;
        $mensajeria->user_id=auth()->id();
        
        $mensajes = Excel::toArray(new ContactoImport,'./public/archivos/'.$mensajeria->archivo);
        $cantidadMensajes=count($mensajes[0]) - 1;
        $contrato = Contrato::where('user_id','=',auth()->id())->orderBy('created_at','ASC')->first();
        
        if($contrato['total'] < $cantidadMensajes + $contrato['progreso']){
            return "Exceso";
        }else{
            $contrato->progreso = $contrato->progreso + $cantidadMensajes;
            $mensajeria->save();
            $contrato->save();
            $this->sendMail();

            return "Ok";
        }
    }

    public function edit(Request $request){
        $request->validate([
            'id' => 'required',
            'campania' => 'required|max:250',
            'mensaje' => 'required',
        ]);

        $mensajeria=Mensajeria::find(request()->id);
        $mensajeria->campania = request()->campania;
        $mensajeria->mensaje = request()->mensaje;
        $mensajeria->save();
        return 'Ok';
    }

    public function delete(Request $request){
        $request->validate([
            'id' => 'required',
        ]);

        $mensajeria=Mensajeria::find(request()->id);
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
}
