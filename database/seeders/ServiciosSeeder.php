<?php

namespace Database\Seeders;

use App\Models\Servicio;
use App\Models\Sucursal;
use App\Models\SucursalServicio;
use App\Models\Ventanilla;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiciosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $servicios = [
            ['nombre' => 'Carnet de Identidad','tiempo_estimado'=>7],//1
            ['nombre' => 'Carnet de Identidad Extranjero','tiempo_estimado'=>9],//2
            ['nombre' => 'Licencia de Conducir','tiempo_estimado'=>10],//3
        ];
        foreach ($servicios as $servicio) {
            Servicio::create($servicio);
        }


        $sucursales = [
            ['nombre' => 'INDANA', 'direccion' => 'CENTRO COMERCIAL INDANA 3ER ANILLO Y AV. PIRAI Z. MERCADO ABASTO', 
            'telefono' => '800101102', 'latitud'=>-17.7929134, 'longitud'=>-63.209937,'municipio_id'=>43],//1
            ['nombre' => 'DISTRITO 12 - LOS LOTES', 'direccion' => 'ENTRE AV. BOLIVIA SUB ALCALDIA DISTRITO 12', 
            'telefono' => '800101102', 'latitud'=>-17.8540379,'longitud'=>-63.1709427,'municipio_id'=>43],//2
            ['nombre' => 'DISTRITO 5 - LOS TUSEQUIS', 'direccion' => 'AV. 2 DE AGOSTO ESQ. EXUPERY, ZONA LOS TUSEQUIS', 
            'telefono' => '800101102', 'latitud'=>-17.7410161,'longitud'=>-63.1504689,'municipio_id'=>43],//3
        ];

        foreach ($sucursales as $sucursal) {
            Sucursal::create($sucursal);
        }
        $sucursalServicios = [
            ['servicio_id' => 1, 'sucursal_id' => 1],
            ['servicio_id' => 2, 'sucursal_id' => 1],
            ['servicio_id' => 1, 'sucursal_id' => 2],
            ['servicio_id' => 1, 'sucursal_id' => 3],
            ['servicio_id' => 3, 'sucursal_id' => 3],
        ];
        foreach ($sucursalServicios as $sucursalServicio) {
            SucursalServicio::create($sucursalServicio);
        }

        //Ventanillas
        $ventanillas = [
            ['nombre' => 'VENTANILLA 1', 'sucursal_id' => 1,'user_id' => 6],
            ['nombre' => 'VENTANILLA 2', 'sucursal_id' => 1,'user_id' => 6],
            ['nombre' => 'VENTANILLA 3', 'sucursal_id' => 1,'user_id' => 6],
            ['nombre' => 'VENTANILLA 4', 'sucursal_id' => 1,'user_id' => 6],
            ['nombre' => 'VENTANILLA 5', 'sucursal_id' => 1,'user_id' => 6],


            ['nombre' => 'VENTANILLA 1', 'sucursal_id' => 2,'user_id' => 2],
            ['nombre' => 'VENTANILLA 2', 'sucursal_id' => 2,'user_id' => 2],
            ['nombre' => 'VENTANILLA 3', 'sucursal_id' => 2,'user_id' => 2],
            ['nombre' => 'VENTANILLA 4', 'sucursal_id' => 2,'user_id' => 2],
            ['nombre' => 'VENTANILLA 5', 'sucursal_id' => 2,'user_id' => 2],

            ['nombre' => 'VENTANILLA 1', 'sucursal_id' => 3,'user_id' => 3],
            ['nombre' => 'VENTANILLA 2', 'sucursal_id' => 3,'user_id' => 3],
            ['nombre' => 'VENTANILLA 3', 'sucursal_id' => 3,'user_id' => 3],
            ['nombre' => 'VENTANILLA 4', 'sucursal_id' => 3,'user_id' => 3],            
            ['nombre' => 'VENTANILLA 5', 'sucursal_id' => 3,'user_id' => 3],
        ];
        foreach ($ventanillas as $ventanilla) {
            Ventanilla::create($ventanilla);
        }

    }
}
