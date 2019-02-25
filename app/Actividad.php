<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    public function contacto()
    {
        return $this->belongsTo(Contacto::class);
    }
}
