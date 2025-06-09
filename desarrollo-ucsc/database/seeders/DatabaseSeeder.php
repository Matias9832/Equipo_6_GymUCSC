<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\Tenants\FuentesSeeder;
use Database\Seeders\Tenants\ColoresSeeder;
use Database\Seeders\Tenants\TemasSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    $this->call([
        FuentesSeeder::class,
        ColoresSeeder::class,
        TemasSeeder::class,
    ]);
    }
}
