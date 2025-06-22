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
        // SUPER ADMIN ------------------------------------
        $usuario = Usuario::create([
            'rut' => '6960920',
            'correo_usuario' => 'ugym@gmail.com',
            'tipo_usuario' => 'admin',
            'contrasenia_usuario' => Hash::make('123456'),
            'activado_usuario' => 1,
        ]);
        Administrador::create([
            'rut_admin' => '6960920',
            'nombre_admin' => 'Jaime Muñoz Guzmán',
            'fecha_creacion' => now(),
            'numero_contacto' => '912345678',
            'sobre_mi' => 'Soy el super administrador del sistema, encargado de gestionar todas las operaciones y supervisar el funcionamiento de la plataforma.',
            'descripcion_ubicacion' => 'Sucursal Central, Edificio B.',
            'foto_perfil' => 'default.png',
            'descripcion_cargo' => 'Super Administrador del Sistema',
        ]);
        $usuario->assignRole('Super Admin');

        // DIRECTOR ------------------------------------
        $usuario = Usuario::create([
            'rut' => '15345678',
            'correo_usuario' => 'JaPerez@deportesucsc.cl',
            'tipo_usuario' => 'admin',
            'contrasenia_usuario' => Hash::make('123456'),
            'activado_usuario' => 1,
        ]);
        Administrador::create([
            'rut_admin' => '15345678',
            'nombre_admin' => 'Javier Pérez',
            'fecha_creacion' => now(),
            'foto_perfil' => 'default.png',
            'descripcion_cargo' => 'Director de la Institución',
        ]);
        $usuario->assignRole('Director');

        // DOCENTES ------------------------------------
        // Docente 1
        $usuario = Usuario::create([
            'rut' => '17456789',
            'correo_usuario' => 'ErMaldonado@deportesucsc.cl',
            'tipo_usuario' => 'admin',
            'contrasenia_usuario' => Hash::make('123456'),
            'activado_usuario' => 1,
        ]);
        Administrador::create([
            'rut_admin' => '17456789',
            'nombre_admin' => 'Eric Maldonado',
            'fecha_creacion' => now(),
            'foto_perfil' => 'default.png',
            'descripcion_cargo' => 'Docente de Preescripción del ejercicio físico',
        ]);
        $usuario->assignRole('Docente');

        // Docente 2
        $usuario = Usuario::create([
            'rut' => '16059402',
            'correo_usuario' => 'LaFernandez@deportesucsc.cl',
            'tipo_usuario' => 'admin',
            'contrasenia_usuario' => Hash::make('123456'),
            'activado_usuario' => 1,
        ]);
        Administrador::create([
            'rut_admin' => '16059402',
            'nombre_admin' => 'Laura Fernández',
            'fecha_creacion' => now(),
            'foto_perfil' => 'default.png',
            'descripcion_cargo' => 'Docente de Entrenamiento Deportivo',
        ]);
        $usuario->assignRole('Docente');

        // Docente 3
        $usuario = Usuario::create([
            'rut' => '18239123',
            'correo_usuario' => 'PeLopez@deportesucsc.cl',
            'tipo_usuario' => 'admin',
            'contrasenia_usuario' => Hash::make('123456'),
            'activado_usuario' => 1,
        ]);
        Administrador::create([
            'rut_admin' => '18239123',
            'nombre_admin' => 'Pedro López',
            'fecha_creacion' => now(),
            'foto_perfil' => 'default.png',
            'descripcion_cargo' => 'Docente de Actividad Física y Salud',
        ]);
        $usuario->assignRole('Docente');

        // Docente 4
        $usuario = Usuario::create([
            'rut' => '17043569',
            'correo_usuario' => 'AnTorres@deportesucsc.cl',
            'tipo_usuario' => 'admin',
            'contrasenia_usuario' => Hash::make('123456'),
            'activado_usuario' => 1,
        ]);
        Administrador::create([
            'rut_admin' => '17043569',
            'nombre_admin' => 'Ana Torres',
            'fecha_creacion' => now(),
            'foto_perfil' => 'default.png',
            'descripcion_cargo' => 'Docente de Kinesiología Deportiva',
        ]);
        $usuario->assignRole('Docente');

        // Docente 5
        $usuario = Usuario::create([
            'rut' => '15274053',
            'correo_usuario' => 'JaSoto@deportesucsc.cl',
            'tipo_usuario' => 'admin',
            'contrasenia_usuario' => Hash::make('123456'),
            'activado_usuario' => 1,
        ]);
        Administrador::create([
            'rut_admin' => '15274053',
            'nombre_admin' => 'Javier Soto',
            'fecha_creacion' => now(),
            'foto_perfil' => 'default.png',
            'descripcion_cargo' => 'Docente de Gestión Deportiva',
        ]);
        $usuario->assignRole('Docente');

        // Docente 6
        $usuario = Usuario::create([
            'rut' => '17642771',
            'correo_usuario' => 'SoHerrera@deportesucsc.cl',
            'tipo_usuario' => 'admin',
            'contrasenia_usuario' => Hash::make('123456'),
            'activado_usuario' => 1,
        ]);
        Administrador::create([
            'rut_admin' => '17642771',
            'nombre_admin' => 'Sofía Herrera',
            'fecha_creacion' => now(),
            'foto_perfil' => 'default.png',
            'descripcion_cargo' => 'Docente de Educación Física',
        ]);
        $usuario->assignRole('Docente');

        // SUPER ADMIN 2 ------------------------------------
        $usuario = Usuario::create([
            'rut' => '18888999',
            'correo_usuario' => 'MaGonzalez@deportesucsc.cl',
            'tipo_usuario' => 'admin',
            'contrasenia_usuario' => Hash::make('123456'),
            'activado_usuario' => 1,
        ]);
        Administrador::create([
            'rut_admin' => '18888999',
            'nombre_admin' => 'María González',
            'fecha_creacion' => now(),
            'foto_perfil' => 'default.png',
            'descripcion_cargo' => 'Super Administradora',
        ]);
        $usuario->assignRole('Super Admin');

        // COORDINADOR ------------------------------------
        $usuario = Usuario::create([
            'rut' => '18032940',
            'correo_usuario' => 'VaGomez@deportesucsc.cl',
            'tipo_usuario' => 'admin',
            'contrasenia_usuario' => Hash::make('123456'),
            'activado_usuario' => 1,
        ]);
        Administrador::create([
            'rut_admin' => '18032940',
            'nombre_admin' => 'Valentina Gómez',
            'fecha_creacion' => now(),
            'foto_perfil' => 'default.png',
            'descripcion_cargo' => 'Coordinadora de Actividades',
        ]);
        $usuario->assignRole('Coordinador');

        // VISOR QR ------------------------------------
        $usuario = Usuario::create([
            'rut' => '19765432',
            'correo_usuario' => 'ViSanAndres@deportesucsc.cl',
            'tipo_usuario' => 'admin',
            'contrasenia_usuario' => Hash::make('123456'),
            'activado_usuario' => 1,
        ]);
        Administrador::create([
            'rut_admin' => '19765432',
            'nombre_admin' => 'VisorQR SanAndrés',
            'fecha_creacion' => now(),
            'foto_perfil' => 'default.png',
            'descripcion_cargo' => 'Visor QR de Sucursal San Andrés',
        ]);
        $usuario->assignRole('Visor QR');
    }
}