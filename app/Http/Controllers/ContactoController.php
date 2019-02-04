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
}
