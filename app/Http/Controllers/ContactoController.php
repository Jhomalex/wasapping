<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Contacto;
use Illuminate\Support\Facades\Storage;
use App\Imports\ContactoImport;
use Maatwebsite\Excel\Facades\Excel;

class ContactoController extends Controller
{
    public function mostrarContactos(){
        return $array = Excel::toArray(new ContactoImport, 'contactoss.xlsx');
    }

    public function listar(Request $request){
        $this->validate($request,[
            'filtros' => 'required',
        ]);
        $contacto = Contacto::where('user_id', '=', auth()->user()->id)->get();
        return $contacto;
    }

    public function store(Request $request){
        $this->validate($request,[
            'nombre' => 'required',
            'celular' => 'required|max:15|unique:contactos,celular',
            'dni' => 'max:8',
            'curso' => 'max:11',
            'correo' => 'required|email',
        ]);
        if($request->get('resultadoBusquedaPersona')=='1'){ //Si no existe una persona con el celular ingresado
            $contacto=new Contacto();
            $contacto->nombre=$request->get('nombre');
            $contacto->celular=$request->get('celular');
            $contacto->dni=$request->get('dni');
            $contacto->curso=$request->get('curso');
            $contacto->correo=$request->get('correo');
            $contacto->referencia=$request->get('referencia');
            $contacto->user_id=Auth::user()['id']; //Esto debe cambiar al implementar las funciones de los CM
            $contacto->save();
            return 'Ok';
        }else{ //Si ya existe una contacto con el celular ingresado
            return 'Ya se registró este número de celular';
        }
    }

    public function storevarios(Request $request)
    {
        $request->validate([
            'archivo' => 'required|mimes:xlsx|max:2048',
        ]);

        $archivo=request()->archivo;
        //$ruta=Storage::disk('public')->put('archivos', $archivo);  --> Si quisiera guardar el Excel
        $excelArray = Excel::toArray(new ContactoImport,$archivo); //Excel:: devuelve un Arreglo contenido en otro arreglo
        $excelRows = $excelArray[0]; //Las filas del Excel están dentro del arreglo contenido
        for($i = 1; $i < sizeof($excelRows); $i++){
            $contacto = $excelRows[$i]; // La fila 0 es el encabezado, por lo que no se toma en cuenta
            $nuevoContacto = new Contacto;
            $nuevoContacto->nombre = $contacto[0];
            $nuevoContacto->dni = $contacto[1];
            $nuevoContacto->curso = $contacto[2];
            $nuevoContacto->celular = $contacto[3];
            $nuevoContacto->correo = $contacto[4];
            $nuevoContacto->ubicacion = $contacto[5];
            $nuevoContacto->user_id = auth()->user()->id;
            $nuevoContacto->save();
        }

        return 'Ok';
    }
    
    public function update(Request $request){
        $this->validate($request,[
            'id' => 'required',
            'nombre' => 'required',
            'celular' => 'required|max:15',
            'dni' => 'max:8',
        ]);
        $contacto = Contacto::find($request->get('id'));
        $contacto->nombre=$request->get('nombre');
        $contacto->celular=$request->get('celular');
        $contacto->dni=$request->get('dni');
        $contacto->curso=$request->get('curso');
        $contacto->correo=$request->get('correo');
        $contacto->ubicacion=$request->get('ubicacion');
        $contacto->referencia=$request->get('referencia');
        $contacto->save();
        return 'Ok';
    }

    public function delete(Request $request){
        $id=$request->get('id');
        $contacto=Contacto::findOrFail($id);
        $contacto->delete();
        return 'Ok';
    }

    public function deletevarios(Request $request)
    {
        $this->validate($request,[
            'contactos' => 'required',
        ]);

        $contactos =  json_decode($request->get('contactos'),true);
        
         foreach ($contactos as $contacto) {
            $contacto=Contacto::findOrFail($contacto['id']);
            $contacto->delete();
        }
        
        return 'Ok';
    }

    public function contartodos()
    {
        return Contacto::where('contactos.user_id','=',auth()->user()->id)->count();
    }
}
