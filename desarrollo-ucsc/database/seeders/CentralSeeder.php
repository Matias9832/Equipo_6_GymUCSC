<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\Tenants\FuentesSeeder;
use Database\Seeders\Tenants\ColoresSeeder;
use Database\Seeders\Tenants\TemasSeeder;
use Database\Seeders\Tenants\EmpresaSeeder;

class CentralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            FuentesSeeder::class,
            ColoresSeeder::class,
            TemasSeeder::class,
            EmpresaSeeder::class,
        ]);
    }
}
