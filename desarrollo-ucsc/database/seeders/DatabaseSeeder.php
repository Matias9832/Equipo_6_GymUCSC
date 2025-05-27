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
        //Seeder de los Alumnos
        $this->call(AlumnoSeeder::class);
        $this->call(UsuarioSeeder::class);

        //Seeder de los Roles y Permisos
        $this->call(RolesAndPermissionsSeeder::class);

        //Seeder de los Administradores
        $this->call(AdministradorSeeder::class);

        //Seeder marcas
        $this->call(MarcaSeeder::class);

        //Seeder geograficos
        $this->call(GeographicSeeder::class);

        //Seeder sucursales
        $this->call(SucursalSeeder::class);

        //Seeder deportes
        $this->call(DeporteSeeder::class);

        //Seeder de los administradores de las sucursales
        $this->call(AdminSucursalSeeder::class);

        //Seeder de las Sedes
        $this->call(SalaSeeder::class);
        $this->call(TipoSeeder::class);

        $this->call([
            TallerSeeder::class,
        ]);

        $this->call(FontColorSeeder::class);
        $this->call(TemaSeeder::class);

    }
}
