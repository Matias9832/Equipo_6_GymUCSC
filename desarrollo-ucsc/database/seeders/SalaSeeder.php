<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sala')->insert([
            'nombre_sala' => 'Sala Musculación',
            'horario_apertura' => '08:00:00',
            'horario_cierre' => '19:00:00',
            'activo' => false,
            'aforo_sala' => 60,
            'id_suc' => 1,
        ]);

        DB::table('sala')->insert([
            'nombre_sala' => 'Sala Musculación2',
            'horario_apertura' => '08:00:00',
            'horario_cierre' => '19:00:00',
            'activo' => false,
            'aforo_sala' => 100,
            'id_suc' => 1,
        ]);

        DB::table('sala')->insert([
            'nombre_sala' => 'Sala Musculación IT',
            'horario_apertura' => '08:00:00',
            'horario_cierre' => '19:00:00',
            'activo' => false,
            'aforo_sala' => 100,
            'id_suc' => 2,
        ]);
    }
}
