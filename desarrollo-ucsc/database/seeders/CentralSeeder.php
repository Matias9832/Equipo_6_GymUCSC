<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\tenants\FuentesSeeder;
use Database\Seeders\tenants\ColoresSeeder;
use Database\Seeders\tenants\TemasSeeder;
use Database\Seeders\tenants\EmpresaSeeder;
use Database\Seeders\tenants\UsuarioTenantSeeder;

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
            UsuarioTenantSeeder::class,
        ]);
    }
}
