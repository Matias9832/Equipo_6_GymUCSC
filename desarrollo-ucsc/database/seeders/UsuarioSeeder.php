<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usuario')->insert([
            [
                'rut' => '12345678',
                'bloqueado_usuario' => true,  // Bloqueado
                'activado_usuario' => true,
                'correo_usuario' => 'juan.perez@dominio.com',
                'contrasenia_usuario' => '12345678',  // Contraseña igual al rut
                'tipo_usuario' => 'Alumno',
                'codigo_verificacion' => null,
            ],
            [
                'rut' => '87654321',
                'bloqueado_usuario' => true,  // Bloqueado
                'activado_usuario' => true,
                'correo_usuario' => 'maria.gonzalez@dominio.com',
                'contrasenia_usuario' => '87654321',  // Contraseña igual al rut
                'tipo_usuario' => 'Alumno',
                'codigo_verificacion' => null,
            ],
            [
                'rut' => '11222333',
                'bloqueado_usuario' => true,  // Bloqueado
                'activado_usuario' => true,
                'correo_usuario' => 'carlos.lopez@dominio.com',
                'contrasenia_usuario' => '11222333',  // Contraseña igual al rut
                'tipo_usuario' => 'Alumno',
                'codigo_verificacion' => null,
            ],
            [
                'rut' => '33444555',
                'bloqueado_usuario' => true,  // Bloqueado
                'activado_usuario' => true,
                'correo_usuario' => 'ana.martinez@dominio.com',
                'contrasenia_usuario' => '33444555',  // Contraseña igual al rut
                'tipo_usuario' => 'Alumno',
                'codigo_verificacion' => null,
            ],
            [
                'rut' => '55666777',
                'bloqueado_usuario' => true,  // Bloqueado
                'activado_usuario' => true,
                'correo_usuario' => 'pedro.ramirez@dominio.com',
                'contrasenia_usuario' => '55666777',  // Contraseña igual al rut
                'tipo_usuario' => 'Alumno',
                'codigo_verificacion' => null,
            ],
            [
                'rut' => '77888999',
                'bloqueado_usuario' => true,  // Bloqueado
                'activado_usuario' => true,
                'correo_usuario' => 'sofia.torres@dominio.com',
                'contrasenia_usuario' => '77888999',  // Contraseña igual al rut
                'tipo_usuario' => 'Alumno',
                'codigo_verificacion' => null,
            ],
            [
                'rut' => '99887766',
                'bloqueado_usuario' => true,  // Bloqueado
                'activado_usuario' => true,
                'correo_usuario' => 'diego.fuentes@dominio.com',
                'contrasenia_usuario' => '99887766',  // Contraseña igual al rut
                'tipo_usuario' => 'Alumno',
                'codigo_verificacion' => null,
            ],
            [
                'rut' => '66554433',
                'bloqueado_usuario' => true,  // Bloqueado
                'activado_usuario' => true,
                'correo_usuario' => 'camila.rojas@dominio.com',
                'contrasenia_usuario' => '66554433',  // Contraseña igual al rut
                'tipo_usuario' => 'Alumno',
                'codigo_verificacion' => null,
            ],
            [
                'rut' => '44332211',
                'bloqueado_usuario' => false,  // No bloqueado
                'activado_usuario' => true,
                'correo_usuario' => 'javier.morales@dominio.com',
                'contrasenia_usuario' => '44332211',  // Contraseña igual al rut
                'tipo_usuario' => 'Alumno',
                'codigo_verificacion' => null,
            ],
            [
                'rut' => '21080600',
                'bloqueado_usuario' => true,  // Bloqueado
                'activado_usuario' => true,
                'correo_usuario' => 'matias.carrasco@dominio.com',
                'contrasenia_usuario' => '21080600',  // Contraseña igual al rut
                'tipo_usuario' => 'Alumno',
                'codigo_verificacion' => null,
            ],
        ]);
    }
}
