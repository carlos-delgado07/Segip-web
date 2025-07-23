<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificacionDocumento extends Model
{
    protected $table = 'verificaciones_documentos';

    protected $fillable = ['usuario_id', 'resultado'];

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
