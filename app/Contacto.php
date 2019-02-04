<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Mensajeria;

class Contacto extends Model
{
    public function mensajerias(){
        return $this->belongsTo(Mensajeria::class);
    }
}
