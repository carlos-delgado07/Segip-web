<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ficha extends Model
{
    protected $fillable = [
        'user_id',
        'fecha',
        'hora',
        'ventanilla',
        'codigo',
        'nombres',     // ✅ Añadido
        'apellidos',   // ✅ Añadido
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

