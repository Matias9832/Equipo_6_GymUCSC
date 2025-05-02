<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AlumnoSeeder::class);

        //Seeder marcas
        $this->call(MarcaSeeder::class);

        //Seeder geograficos
        $this->call([
            GeographicSeeder::class
        ]);

        //Seeder sucursales
        $this->call(SucursalSeeder::class);
    }
}
