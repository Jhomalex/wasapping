<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    public function listar(Request $request)
    {
        /* 
        // *** FORMATO DE ARRAY FILTROS ***
        'filtros' => [
            'criterio' => ['buscar']
        ],
         */
        $this->validate($request,[
            'filtros' => 'required',
        ]);
        $filtros =  json_decode($request->get('filtros'));
        $filtros = null;
        $users=User::when($filtros, function ($query, $filtros)
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
        
        return $users;
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'nombre'    => 'required',
            'foto'      => 'file|image',
            'email'     => 'required|email|unique',
            'password'  => 'required',
        ]);
        $user= new User;
        $user->nombre=$request->nombre;
        $user->foto="cliente.png";
        $user->email=$request->email;
        $user->password=bcrypt($request->password);
        $user->save();

        $user->assignRole($clienteRole);

        return 'Ok';
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'id'        => 'required',
            'nombre'    => 'required',
            'foto'      => 'file|image',
            'email'     => 'required|email|unique',
            'password'  => 'required',
        ]);
        $user= User::find($request->id);
        $user->nombre=$request->nombre;
        $user->foto="cliente.png";
        $user->email=$request->email;
        $user->password=bcrypt($request->password);
        $user->save();

        return 'Ok';
    }

    public function delete(Request $request)
    {
        $id = $request->get('id');
        $user = User::findOrFail($id);
        $user->delete();
        return 'Ok';
    }
}
