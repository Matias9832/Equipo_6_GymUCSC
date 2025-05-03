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
            'aforo_sala' => 60,
            'id_suc' => 1,
        ]);
    }
}
