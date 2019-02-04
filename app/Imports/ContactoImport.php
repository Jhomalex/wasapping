<?php

namespace App\Imports;

use App\Contacto;
use Maatwebsite\Excel\Concerns\ToModel;

class ContactoImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Contacto([
            'nombre'     => $row[0],
            'celular'    => $row[1], 
            //'mensajeria_id' => '1',
        ]);
    }
}
