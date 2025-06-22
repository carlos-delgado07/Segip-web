<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VentanillaServicio extends Model
{
    protected $table = 'ventanilla_servicio';

    protected $fillable = [
        'ventanilla_id',
        'servicio_id',
    ];

    public function ventanilla()
    {
        return $this->belongsTo(Ventanilla::class, 'ventanilla_id');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }
}
