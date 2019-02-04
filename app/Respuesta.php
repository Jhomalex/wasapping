<?php

namespace App;
use App\Mensajeria;

use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    public function mensajerias(){
        return $this->belongsTo(Mensajeria::class);
    }
}
