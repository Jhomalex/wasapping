<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Respuesta;
use Illuminate\Http\Request;

class RespuestaController extends Controller
{
    public function listarTodos($mensajeria_id){
        $respuesta = DB::table('respuestas')->where('respuestas.mensajeria_id','=',$mensajeria_id)->get();
        return $respuesta;
    }

    public function listarTodosByUser(){
        $respuesta = DB::table('respuestas')->join('mensajerias','mensajerias.id','=','respuestas.mensajeria_id')
        ->select('respuestas.id as id','respuestas.contacto','respuestas.celular','respuestas.respuesta')->where('mensajerias.user_id','=',auth()->id())->get();
        return $respuesta;
    }

    public function store(Request $request){
      $request->validate([
          'contacto' => 'required|max:250',
          'celular' => 'required',
          'respuesta' => 'required',
          'mensajeria_id' => 'required',
      ]);

      $respuesta=new Respuesta();
      $respuesta->contacto=request()->contacto;
      $respuesta->celular=request()->celular;
      $respuesta->respuesta=request()->respuesta;
      $respuesta->mensajeria_id=request()->mensajeria_id;
      $respuesta->save();
      return 'Ok';
    }

    public function delete(Request $request){
        $request->validate([
            'id' => 'required',
        ]);

        $respuesta=Respuesta::find(request()->id);
        $respuesta->delete();
        return 'Ok';
    }
}
