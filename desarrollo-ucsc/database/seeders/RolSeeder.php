<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rol')->insert([
            ['id_rol' => 1, 'nombre_rol' => 'Super Admin'],
            ['id_rol' => 2, 'nombre_rol' => 'Editor'],
            ['id_rol' => 3, 'nombre_rol' => 'Viewer'],
        ]);
    }
}