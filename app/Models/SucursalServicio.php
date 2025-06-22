<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SucursalServicio extends Model
{
    protected $table = 'sucursal_servicio';

    protected $fillable = [
        'servicio_id',
        'sucursal_id',
    ];

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id');
    }
}
