<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ventanilla extends Model
{
    protected $table = 'ventanilla';

    protected $fillable = [
        'nombre',
        'estado',
        'sucursal_id',
        'servicio_id',
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
