<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $table = 'sucursal';

    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',        
        'latitud',
        'longitud',        
    ];

    
   
}
