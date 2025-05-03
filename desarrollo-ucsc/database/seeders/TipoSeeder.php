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
            ['nombre_tipo' => 'Sala de Gimnasio'],
            ['nombre_tipo' => 'Sala de Yoga'],
            ['nombre_tipo' => 'Pista de Atletismo'],
            ['nombre_tipo' => 'Sala de Pesas'],
            ['nombre_tipo' => 'Cancha de Fútbol 5']
        ]);
    }
}
