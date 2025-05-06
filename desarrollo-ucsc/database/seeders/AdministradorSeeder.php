<?php

namespace Database\Seeders;
use App\Models\Administrador;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdministradorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear el usuario 
        $usuario = Usuario::create([
            'rut' => '1234',
            'correo_usuario' => 'admin@example.com',
            'tipo_usuario' => 'admin',
            'contrasenia_usuario' => Hash::make('123456'),
        ]);

        // Crear el administrador asociado
        Administrador::create([
            'rut_admin' => '1234',
            'nombre_admin' => 'Administrador Principal',
            'fecha_creacion' => now(),
        ]);
        // Asignar el rol de Super Admin al usuario con todos los permisos
        $usuario->assignRole('Super Admin');

    
    }
}