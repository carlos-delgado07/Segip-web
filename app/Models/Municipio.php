<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    protected $table = 'municipio';

    protected $fillable = [
        'nombre',
    ];
    
    public function sucursales()
    {
        return $this->hasMany(Sucursal::class, 'municipio_id');
    }
    
    
}
