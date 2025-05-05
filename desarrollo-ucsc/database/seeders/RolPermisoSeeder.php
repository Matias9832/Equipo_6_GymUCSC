<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolPermisoSeeder extends Seeder
{
    public function run()
    {
        // Crear roles
        DB::table('rol')->insert([
            ['id_rol' => 1, 'nombre_rol' => 'Super Admin'],
            ['id_rol' => 2, 'nombre_rol' => 'Director'],
            ['id_rol' => 3, 'nombre_rol' => 'Docente'],
        ]);

        // Crear permisos
        DB::table('permiso')->insert([
            ['id_permiso' => 1, 'nombre_permiso' => 'Acceso al Mantenedor de Alumnos'],
            ['id_permiso' => 2, 'nombre_permiso' => 'Acceso al Mantenedor de Usuarios'],
            ['id_permiso' => 3, 'nombre_permiso' => 'Acceso al Mantenedor de Roles'],
            ['id_permiso' => 4, 'nombre_permiso' => 'Acceso al Mantenedor de Deportes'],
            ['id_permiso' => 5, 'nombre_permiso' => 'Acceso al Mantenedor de Máquinas'],
            ['id_permiso' => 6, 'nombre_permiso' => 'Acceso al Mantenedor de Marcas'],
            ['id_permiso' => 7, 'nombre_permiso' => 'Acceso al Mantenedor de Países'],
            ['id_permiso' => 8, 'nombre_permiso' => 'Acceso al Mantenedor de Regiones'],
            ['id_permiso' => 9, 'nombre_permiso' => 'Acceso al Mantenedor de Ciudades'],
            ['id_permiso' => 10, 'nombre_permiso' => 'Acceso al Mantenedor de Tipos de Espacios'],
            ['id_permiso' => 11, 'nombre_permiso' => 'Acceso al Mantenedor de Tipos de Sanción'],
            ['id_permiso' => 12, 'nombre_permiso' => 'Acceso al Mantenedor de Gestión de QR'],
        ]);

        // Asociar permisos a roles
        DB::table('rol_permiso')->insert([
            // Super Admin
            ['id_rol' => 1, 'id_permiso' => 1],
            ['id_rol' => 1, 'id_permiso' => 2],
            ['id_rol' => 1, 'id_permiso' => 3], 
            ['id_rol' => 1, 'id_permiso' => 4],
            ['id_rol' => 1, 'id_permiso' => 5],
            ['id_rol' => 1, 'id_permiso' => 6], 
            ['id_rol' => 1, 'id_permiso' => 7],
            ['id_rol' => 1, 'id_permiso' => 8],
            ['id_rol' => 1, 'id_permiso' => 9], 
            ['id_rol' => 1, 'id_permiso' => 10],
            ['id_rol' => 1, 'id_permiso' => 11],
            ['id_rol' => 1, 'id_permiso' => 12], 

            // Director
            ['id_rol' => 2, 'id_permiso' => 2],
            ['id_rol' => 2, 'id_permiso' => 2],
            ['id_rol' => 2, 'id_permiso' => 3], 
            ['id_rol' => 2, 'id_permiso' => 4],
            ['id_rol' => 2, 'id_permiso' => 5],
            ['id_rol' => 2, 'id_permiso' => 6], 
            ['id_rol' => 2, 'id_permiso' => 7],
            ['id_rol' => 2, 'id_permiso' => 8],
            ['id_rol' => 2, 'id_permiso' => 9], 
            ['id_rol' => 2, 'id_permiso' => 10],
            ['id_rol' => 2, 'id_permiso' => 11],
        
            // Docente
            ['id_rol' => 3, 'id_permiso' => 1],
            ['id_rol' => 3, 'id_permiso' => 2],
            ['id_rol' => 3, 'id_permiso' => 12],

        ]);
    }
}