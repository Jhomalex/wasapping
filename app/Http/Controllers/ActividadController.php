<?php

namespace App\Http\Controllers;

use App\Actividad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActividadController extends Controller
{
    public function listar(Request $request)
    {
        $actividad = Actividad::where('actividads.contacto_id','=',$request->contacto_id)->get();
        return $actividad;
    }

    public function store(Request $request){
        $request->validate([
            'fechaHoraContactado' => 'required',
            'descripcion' => 'required',
            'contacto_id' => 'required'
        ]);

        $actividad = new Actividad();
        $actividad->descripcion=$request->descripcion;
        $actividad->fechaHoraContactado=$request->fechaHoraContactado;
        $actividad->contacto_id= $request->contacto_id;
        
        $actividad->save();
        return "Ok";
    }

    public function update(Request $request){
        $request->validate([
            'id' => 'required',
            'descripcion' => 'required',
            'fechaHoraContactado' => 'required',
        ]);
        
        $actividad = Actividad::find($request->id);
        $actividad->descripcion = $request->descripcion;
        $actividad->fechaHoraContactado = $request->fechaHoraContactado;
        $actividad->save();
        return 'Ok';
    }

    public function delete(Request $request){
        $request->validate([
            'id' => 'required',
        ]);

        $actividad = Actividad::find($request->id);
        $actividad->delete();
        return 'Ok';
    }
}
