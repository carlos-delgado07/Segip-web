<?php

namespace Database\Seeders;

use App\Models\SolicitudBrigada;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SolicitudBrigadaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SolicitudBrigada::create([
            'titulo' => 'Brigada CI - Barrio Plan 3000',
            'contenido' => 'Brigada para emitir Cédulas de Identidad en el Plan 3000.',
            'latitud' => -17.8401,
            'longitud' => -63.1574,
            'estado' => 'pendiente',
            'municipio_id' => 1, // Asegúrate de que este ID exista
            'user_id' => 1,
        ]);

        SolicitudBrigada::create([
            'titulo' => 'Brigada Licencia - Montero',
            'contenido' => 'Solicitud de brigada para emisión de licencias de conducir en Montero.',
            'latitud' => -17.3400,
            'longitud' => -63.2500,
            'estado' => 'pendiente',
            'municipio_id' => 2, // Asegúrate de que este ID exista
            'user_id' => 1,
        ]);

        SolicitudBrigada::create([
            'titulo' => 'Brigada CI - La Guardia',
            'contenido' => 'Brigada para renovar Cédulas de Identidad en La Guardia.',
            'latitud' => -17.8786,
            'longitud' => -63.3372,
            'estado' => 'pendiente',
            'municipio_id' => 3, // Asegúrate de que este ID exista
            'user_id' => 1,
        ]);

        SolicitudBrigada::create([
            'titulo' => 'Brigada Licencia - Cotoca',
            'contenido' => 'Emisión de licencias de conducir en el municipio de Cotoca.',
            'latitud' => -17.8133,
            'longitud' => -63.0125,
            'estado' => 'pendiente',
            'municipio_id' => 4, // Asegúrate de que este ID exista
            'user_id' => 1,
        ]);

        SolicitudBrigada::create([
            'titulo' => 'Brigada CI - Warnes',
            'contenido' => 'Brigada para emitir Cédulas de Identidad en el centro de Warnes.',
            'latitud' => -17.5087,
            'longitud' => -63.1658,
            'estado' => 'pendiente',
            'municipio_id' => 5, // Asegúrate de que este ID exista
            'user_id' => 1,
        ]);
    }
}
