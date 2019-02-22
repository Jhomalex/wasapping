<?php

namespace App\Http\Controllers;

use App\Imports\ContactoImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ContactoController extends Controller
{
    public function mostrarContactos(){
        return $array = Excel::toArray(new ContactoImport, 'contactoss.xlsx');
    }

    public function listar(Request $request, $aptos = false){
        //********** FALTA HACER UN WHERE PARA QUE SE MUESTREN SOLO LOS DE UN CENTRO MEDICO DETERMINADO */
        /* 
        // *** FORMATO DE ARRAY FILTROS ***
        'filtros' => [
            'criterio' => ['buscar']
        ],
         */
        $filtros = $request->get('filtros');

        $contacto=Contacto::where('user_id','=',auth()->user()->id)
        ->when($filtros, function ($query, $filtros)
        {
            foreach ($filtros as $criterio => $filtro) {
                $query = $query->where(function ($query) use ($filtro, $criterio)
                {
                    foreach ($filtro as $buscar) {
                        $query = $query->orWhere($criterio,'like','%'.$buscar.'%');
                    }
                });
            }
            return $query;
        })
        ->orderBy('id','desc')->get();
        
        return $contacto;
    }

    public function store(Request $request){
        $this->validate($request,[
            'nombre' => 'required',
            'celular' => 'required|max:15|unique:contactos,celular',
            'dni' => 'max:8',
            'ruc' => 'max:11',
            'correo' => 'required|email',
        ]);
        if($request->get('resultadoBusquedaPersona')=='1'){ //Si no existe una persona con el celular ingresado
            $contacto=new Contacto();
            $contacto->nombre=$request->get('nombre');
            $contacto->celular=$request->get('celular');
            $contacto->dni=$request->get('dni');
            $contacto->ruc=$request->get('ruc');
            $contacto->correo=$request->get('correo');
            $contacto->referencia=$request->get('referencia');
            $contacto->user_id=Auth::user()['id']; //Esto debe cambiar al implementar las funciones de los CM
            $contacto->save();
            return 'Ok';
        }else{ //Si ya existe una contacto con el celular ingresado
            return 'Ya se registró este número de celular';
        }
    }
    
    public function update(Request $request){
        $this->validate($request,[
            'id' => 'required',
            'nombre' => 'required',
            'celular' => 'required|max:15',
            'dni' => 'max:8',
            'ruc' => 'max:11',
            'correo' => 'required|email',
        ]);
        //Buscamos al contacto
        $contacto->nombre=$request->get('nombre');
        $contacto->celular=$request->get('celular');
        $contacto->dni=$request->get('dni');
        $contacto->ruc=$request->get('ruc');
        $contacto->correo=$request->get('correo');
        $contacto->referencia=$request->get('referencia');
        $this->authorize('update', $contacto);
        $contacto->save();
        return 'Ok';
    }

    public function delete(Request $request){
        $id=$request->get('id');
        $contacto=Contacto::findOrFail($id);
        $this->authorize('delete', $contacto);
        // Falta eliminar relaciones de este contacto
        // DB::table('contacto_grupomsj')->where('contacto_id',$id)->get();
        $contacto->delete();
        return 'Ok';
    }
}
