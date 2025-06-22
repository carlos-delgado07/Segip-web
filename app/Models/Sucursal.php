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
        'municipio_id'
    ];
    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'municipio_id');
    }

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'sucursal_servicio');
    }
    public function ventanillas()
    {
        return $this->hasMany(Ventanilla::class, 'sucursal_id');
    }
}
