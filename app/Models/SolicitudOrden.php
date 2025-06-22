<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudOrden extends Model
{
    protected $table = 'solicitud_orden';

    protected $fillable = [
        'url_ci',
        'url_pdf',
        'estado', // pendiente, aprobado, rechazado
        'comentario',
        'respuesta',
        'url_respuesta',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
