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
        //SUPER ADMIN ------------------------------------

        // Crear el usuario super admin
        $usuario = Usuario::create([
            'rut' => '1234',
            'correo_usuario' => 'admin@example.com',
            'tipo_usuario' => 'admin',
            'contrasenia_usuario' => Hash::make('123456'),
            'activado_usuario' => 1,
        ]);

        // Crear el administrador asociado
        Administrador::create([
            'rut_admin' => '1234',
            'nombre_admin' => 'Administrador Principal',
            'fecha_creacion' => now(),
        ]);
        // Asignar el rol de Super Admin al usuario con todos los permisos
        $usuario->assignRole('Super Admin');

        //DIRECTOR ------------------------------------
        $usuario = Usuario::create([
            'rut' => '12345',
            'correo_usuario' => 'director@example.com',
            'tipo_usuario' => 'admin',
            'contrasenia_usuario' => Hash::make('123456'),
            'activado_usuario' => 1,
        ]);
        Administrador::create([
            'rut_admin' => '12345',
            'nombre_admin' => 'Director Principal',
            'fecha_creacion' => now(),
        ]);
        $usuario->assignRole('Director');

        // DOCENTE ------------------------------------
        $usuario = Usuario::create([
            'rut' => '123456',
            'correo_usuario' => 'admin@example.com',
            'tipo_usuario' => 'admin',
            'contrasenia_usuario' => Hash::make('123456'),
            'activado_usuario' => 1,
        ]);
        Administrador::create([
            'rut_admin' => '123456',
            'nombre_admin' => 'Primer Docente',
            'fecha_creacion' => now(),
        ]);
        $usuario->assignRole('Docente');

        // ADMINISTRADOR SUCURSAL 2
        $usuario = Usuario::create([
            'rut' => '22222',
            'correo_usuario' => 'admin2@example.com',
            'tipo_usuario' => 'admin',
            'contrasenia_usuario' => Hash::make('123456'),
            'activado_usuario' => 1,
        ]);
        Administrador::create([
            'rut_admin' => '22222',
            'nombre_admin' => 'Administrador IT Chillán',
            'fecha_creacion' => now(),
        ]);
        $usuario->assignRole('Super Admin');
    }
}