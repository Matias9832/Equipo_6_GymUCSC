<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EspacioSeeder extends Seeder
{
    public function run()
    {

        DB::table('espacio')->insert([
            [
                'nombre_espacio' => 'Cancha A',
                'tipo_espacio' =>'Cancha de Baloncesto',
                'id_suc' => 1,
                'descripcion' => 'Primera cancha que se ve al entrar al gimnasio del campus San Andrés',
            ],
            [
                'nombre_espacio' => 'Cancha B',
                'tipo_espacio' =>'Cancha de Baloncesto',
                'id_suc' => 1,
                'descripcion' => 'Segunda cancha que se ve al entrar al gimnasio del campus San Andrés, Está detrás de la Cancha A',
            ],
            [
                'nombre_espacio' => 'Piscina Olímpica',
                'tipo_espacio' =>'Piscina',
                'id_suc' => 1,
                'descripcion' => 'Edificio Deportivo',
            ],
            [
                'nombre_espacio' => 'Multicancha Central',
                'tipo_espacio' =>'Multicancha',
                'id_suc' => 1,
                'descripcion' => 'Frente a la Biblioteca',
            ],
            [
                'nombre_espacio' => 'Pista de Atletismo Sur',
                'tipo_espacio' =>'Pista de Atletismo',
                'id_suc' => 1,
                'descripcion' => 'Zona Sur',
            ],
            [
                'nombre_espacio' => 'Cancha de Tenis 1',
                'tipo_espacio' =>'Cancha de Tenis',
                'id_suc' => 1,
                'descripcion' => 'Sector Este',
            ],
            
        ]);
    }
}