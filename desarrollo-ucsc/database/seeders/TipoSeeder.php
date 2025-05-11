<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipos_espacio')->insert([
            ['nombre_tipo' => 'Cancha de Césped'],
            ['nombre_tipo' => 'Multicancha'],
            ['nombre_tipo' => 'Cancha de Volley'],
            ['nombre_tipo' => 'Cancha de Tenis'],
            ['nombre_tipo' => 'Piscina'],
            ['nombre_tipo' => 'Cancha de Baloncesto'],
            ['nombre_tipo' => 'Cancha de Fútbol'],
            ['nombre_tipo' => 'Cancha de Fútbol 7'],
            ['nombre_tipo' => 'Cancha de Fútbol 11'],
            ['nombre_tipo' => 'Cancha de Tenis de Mesa'],
            ['nombre_tipo' => 'Pista de Atletismo'],
            ['nombre_tipo' => 'Cancha de Fútbol 5'],
            ['nombre_tipo' => 'Cancha de Hockey'],
            ['nombre_tipo' => 'Cancha de Rugby'],
            ['nombre_tipo' => 'Cancha de Béisbol'],
            ['nombre_tipo' => 'Cancha de Softbol'],
            ['nombre_tipo' => 'Cancha de Squash']
        ]);
    }
}
