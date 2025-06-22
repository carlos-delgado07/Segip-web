<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudBrigada extends Model
{
    protected $table = 'solicitud_brigada';

    protected $fillable = [
        'titulo',
        'contenido',
        'latitud',
        'longitud',
        'estado',
        'municipio_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function municipio()
    {
        return $this->belongsTo(Municipio::class);
    }

}
