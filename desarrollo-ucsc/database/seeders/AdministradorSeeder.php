<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdministradorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear el usuario asociado
        DB::table('usuario')->insert([
            'rut' => '1234', // RUT de ejemplo
            'correo_usuario' => 'admin@example.com',
            'tipo_usuario' => 'admin',
            'contrasenia_usuario' => Hash::make('123456'), // Contraseña encriptada
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear el administrador
        DB::table('administrador')->insert([
            'rut_admin' => '1234', // Debe coincidir con el RUT del usuario
            'nombre_admin' => 'Administrador Principal',
            'fecha_creacion' => now(),
        ]);
    }
}