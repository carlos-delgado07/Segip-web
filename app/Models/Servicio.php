<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicio';

    protected $fillable = [
        'nombre',
        'tiempo_estimado',
    ];

    
}
