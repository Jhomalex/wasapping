<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Contacto;
use App\Respuesta;

use Illuminate\Http\Request;

class Mensajeria extends Model
{
    public function contactos(){
        return $this->hasMany(Contacto::class);
    }

    public function users(){
        return $this->belongsTo(User::class);
    }

    public function respuestas(){
        return $this->hasMany(Respuesta::class);
    }
    
}
