<?php

namespace Database\Seeders\Tenants;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ColoresSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('colores')->insert([
            // Base colors
            [
                'nombre_color' => 'Base Primary',
                'codigo_hex' => '#fb6340',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nombre_color' => 'Base Danger',
                'codigo_hex' => '#f5365c',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nombre_color' => 'Base Success',
                'codigo_hex' => '#2dce89',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // UCSC colors
            [
                'nombre_color' => 'Rojo UCSC',
                'codigo_hex' => '#D12421',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nombre_color' => 'Negro UCSC',
                'codigo_hex' => '#646567',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
