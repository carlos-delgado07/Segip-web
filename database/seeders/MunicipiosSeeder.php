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
            'Ascensión de Guarayos',//1
            'Buena Vista',//2
            'Cabezas',//3
            'Camiri',//4
            'Charagua',//5
            'Colpa Bélgica',//6
            'Concepción',//7
            'Cotoca',//8
            'Cuatro Cañadas',//9
            'El Carmen Rivero Tórrez',//10
            'El Puente',//11
            'El Torno',//12
            'Fernández Alonso',//13
            'General Saavedra',//14
            'Gutiérrez',//15
            'La Guardia',//16
            'Lagunillas',//17
            'Mineros',//18
            'Montero',//19
            'Ñuflo de Chávez',//20
            'Okoruro',//21
            'Pailón',//22
            'Pampa Grande',//23
            'Porongo',//24
            'Postrervalle',//25
            'Puerto Quijarro',//26
            'Puerto Suárez',//27
            'Roboré',//28
            'Saipina',//29
            'Samaipata',//30
            'San Carlos',//31
            'San Ignacio de Velasco',//32
            'San Javier',//33
            'San José de Chiquitos',//34
            'San Juan',//35
            'San Julián',//36
            'San Matías',//37
            'San Miguel de Velasco',//38
            'San Pedro',//39
            'San Rafael',//40
            'San Ramón',//41
            'Santa Rosa del Sara',//42
            'Santa Cruz de la Sierra',//43
            'Urubichá',//44
            'Vallegrande',//45
            'Warnes',//46
            'Yapacaní'//47
        ];

        foreach ($municipios as $nombre) {
            Municipio::create(['nombre' => $nombre]);
        }
    }
}
