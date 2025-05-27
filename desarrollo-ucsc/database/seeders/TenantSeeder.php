<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TenantSeeder extends Seeder
{
    public function run()
    {
        DB::table('tenant')->insert([
            'nombre_tenant' => 'UCSC',
            'id_marca' => 1,
            'id_tema' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
