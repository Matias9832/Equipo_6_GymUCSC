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
            'rut' => '6960920',
            'correo_usuario' => 'ugym@gmail.com',
            'tipo_usuario' => 'admin',
            'contrasenia_usuario' => Hash::make('123456'),
            'activado_usuario' => 1,
        ]);

        // Crear el administrador asociado
        Administrador::create([
            'rut_admin' => '6960920',
            'nombre_admin' => 'Jaime Muñoz Guzmán',
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
            'nombre_admin' => 'Javier Pérez',
            'fecha_creacion' => now(),
        ]);
        $usuario->assignRole('Director');

        // DOCENTES (6) ------------------------------------
        // Docente 1
        $usuario = Usuario::create([
            'rut' => '123456',
            'correo_usuario' => 'docente1@example.com',
            'tipo_usuario' => 'admin',
            'contrasenia_usuario' => Hash::make('123456'),
            'activado_usuario' => 1,
        ]);
        Administrador::create([
            'rut_admin' => '123456',
            'nombre_admin' => 'Eric Maldonado',
            'fecha_creacion' => now(),
        ]);
        $usuario->assignRole('Docente');

        // Docente 2
        $usuario = Usuario::create([
            'rut' => '16059402',
            'correo_usuario' => 'docente2@example.com',
            'tipo_usuario' => 'admin',
            'contrasenia_usuario' => Hash::make('123456'),
            'activado_usuario' => 1,
        ]);
        Administrador::create([
            'rut_admin' => '16059402',
            'nombre_admin' => 'Laura Fernández',
            'fecha_creacion' => now(),
        ]);
        $usuario->assignRole('Docente');

        // Docente 3
        $usuario = Usuario::create([
            'rut' => '18239123',
            'correo_usuario' => 'docente3@example.com',
            'tipo_usuario' => 'admin',
            'contrasenia_usuario' => Hash::make('123456'),
            'activado_usuario' => 1,
        ]);
        Administrador::create([
            'rut_admin' => '18239123',
            'nombre_admin' => 'Pedro López',
            'fecha_creacion' => now(),
        ]);
        $usuario->assignRole('Docente');

        // Docente 4
        $usuario = Usuario::create([
            'rut' => '17043569',
            'correo_usuario' => 'docente4@example.com',
            'tipo_usuario' => 'admin',
            'contrasenia_usuario' => Hash::make('123456'),
            'activado_usuario' => 1,
        ]);
        Administrador::create([
            'rut_admin' => '17043569',
            'nombre_admin' => 'Ana Torres',
            'fecha_creacion' => now(),
        ]);
        $usuario->assignRole('Docente');

        // Docente 5
        $usuario = Usuario::create([
            'rut' => '15274053',
            'correo_usuario' => 'docente5@example.com',
            'tipo_usuario' => 'admin',
            'contrasenia_usuario' => Hash::make('123456'),
            'activado_usuario' => 1,
        ]);
        Administrador::create([
            'rut_admin' => '15274053',
            'nombre_admin' => 'Javier Soto',
            'fecha_creacion' => now(),
        ]);
        $usuario->assignRole('Docente');

        // Docente 6
        $usuario = Usuario::create([
            'rut' => '12064277',
            'correo_usuario' => 'docente6@example.com',
            'tipo_usuario' => 'admin',
            'contrasenia_usuario' => Hash::make('123456'),
            'activado_usuario' => 1,
        ]);
        Administrador::create([
            'rut_admin' => '12064277',
            'nombre_admin' => 'Sofía Herrera',
            'fecha_creacion' => now(),
        ]);
        $usuario->assignRole('Docente');

        // ADMINISTRADOR SUCURSAL 2
        $usuario = Usuario::create([
            'rut' => '22222',
            'correo_usuario' => 'superadmin2@example.com',
            'tipo_usuario' => 'admin',
            'contrasenia_usuario' => Hash::make('123456'),
            'activado_usuario' => 1,
        ]);
        Administrador::create([
            'rut_admin' => '22222',
            'nombre_admin' => 'María González',
            'fecha_creacion' => now(),
        ]);
        $usuario->assignRole('Super Admin');

        // COORDINADOR ------------------------------------
        $usuario = Usuario::create([
            'rut' => '18032940',
            'correo_usuario' => 'superadmin2@example.com',
            'tipo_usuario' => 'admin',
            'contrasenia_usuario' => Hash::make('123456'),
            'activado_usuario' => 1,
        ]);
        Administrador::create([
            'rut_admin' => '18032940',
            'nombre_admin' => 'Valentina Gómez',
            'fecha_creacion' => now(),
        ]);
        $usuario->assignRole('Coordinador');
        
        // Visor QR ------------------------------------
        $usuario = Usuario::create([
            'rut' => '1234567',
            'correo_usuario' => 'admin3@example.com',
            'tipo_usuario' => 'admin',
            'contrasenia_usuario' => Hash::make('123456'),
            'activado_usuario' => 1,
        ]);
        Administrador::create([
            'rut_admin' => '1234567',
            'nombre_admin' => 'VisorQR SanAndrés',
            'fecha_creacion' => now(),
        ]);
        $usuario->assignRole('Visor QR');
    }
}