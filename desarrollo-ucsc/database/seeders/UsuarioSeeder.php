<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usuario')->insert([
            'rut' => '1234', //creedenciale de administrador temporales, borrar cuando se pase a producción
            'correo_usuario' => 'admin@ucsc.cl',
            'tipo_usuario' => 'admin',
            'contrasenia_usuario' => Hash::make('123456'), // Contraseña encriptada
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
