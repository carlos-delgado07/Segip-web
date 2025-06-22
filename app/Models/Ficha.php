<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ficha extends Model
{
    protected $table = 'fichas';
    protected $fillable = [
        'user_id',
        'fecha',
        'hora',
        'ventanilla',
        'codigo',
        'nombres',  
        'apellidos',  
        'funcionario_id', 
        'sucursal_id', 
        'ventanilla_id', 
        'servicio_id', 
        'estado',     

        
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

