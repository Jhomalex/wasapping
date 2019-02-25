<?php

namespace App\Http\Controllers;

use App\Actividad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActividadController extends Controller
{
    public function listar()
    {
        $actividad = DB::table('actividads')
        ->join('contactos','actividads.contacto_id','=','contactos.id')->get();
        return $actividad;
    }

    public function store(Request $request){
        $request->validate([
            'fechaHoraActividad' => 'required',
            'descripcion' => 'required',
            'contacto_id' => 'required'
        ]);

        $actividad = new Actividad();
        $actividad->nombre=$request->nombre;
        $actividad->descripcion=$request->descripcion;
        $actividad->contacto_id= $request->contacto_id;
        
        $actividad->save();
        return "Ok";
    }

    public function edit(Request $request){
        $request->validate([
            'id' => 'required',
            'descripcion' => 'required',
            'fechaHoraActividad' => 'required',
        ]);

        $actividad = Actividad::find($request->id);
        $actividad->nombre = $request->nombre;
        $actividad->fechaHoraActividad = $request->fechaHoraActividad;
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
