<?php

namespace Database\Seeders;

use App\Models\Municipio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MunicipiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $municipios = [
            'Ascensión de Guarayos',
            'Buena Vista',
            'Cabezas',
            'Camiri',
            'Charagua',
            'Colpa Bélgica',
            'Concepción',
            'Cotoca',
            'Cuatro Cañadas',
            'El Carmen Rivero Tórrez',
            'El Puente',
            'El Torno',
            'Fernández Alonso',
            'General Saavedra',
            'Gutiérrez',
            'La Guardia',
            'Lagunillas',
            'Mineros',
            'Montero',
            'Ñuflo de Chávez',
            'Okoruro',
            'Pailón',
            'Pampa Grande',
            'Porongo',
            'Postrervalle',
            'Puerto Quijarro',
            'Puerto Suárez',
            'Roboré',
            'Saipina',
            'Samaipata',
            'San Carlos',
            'San Ignacio de Velasco',
            'San Javier',
            'San José de Chiquitos',
            'San Juan',
            'San Julián',
            'San Matías',
            'San Miguel de Velasco',
            'San Pedro',
            'San Rafael',
            'San Ramón',
            'Santa Rosa del Sara',
            'Santa Cruz de la Sierra',
            'Urubichá',
            'Vallegrande',
            'Warnes',
            'Yapacaní'
        ];

        foreach ($municipios as $nombre) {
            Municipio::create(['nombre' => $nombre]);
        }
    }
}
