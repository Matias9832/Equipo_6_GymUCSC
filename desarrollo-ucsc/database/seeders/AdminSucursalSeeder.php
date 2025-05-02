<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admin_sucursal')->insert([
            'id_admin' => 1,
            'id_suc' => 1,
            'activa' => true,
        ]);
    }
}
