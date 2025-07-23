<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrigadaSolicitud extends Model
{
    protected $table = 'brigada_solicitud_nueva';

    protected $fillable = [
        'titulo',
        'contenido',
        'latitud',
        'longitud',
        'estado',
        'user_id',
        'municipio_id',
    ];

    // Relaciones opcionales:
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class);
    }
}
