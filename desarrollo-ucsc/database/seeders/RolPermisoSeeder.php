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
            ['id_rol' => 2, 'nombre_rol' => 'Editor'],
            ['id_rol' => 3, 'nombre_rol' => 'Viewer'],
        ]);

        // Crear permisos
        DB::table('permiso')->insert([
            ['id_permiso' => 1, 'nombre_permiso' => 'Ver Panel de Control'],
            ['id_permiso' => 2, 'nombre_permiso' => 'Editar Usuarios'],
            ['id_permiso' => 3, 'nombre_permiso' => 'Eliminar Usuarios'],
        ]);

        // Asociar permisos a roles
        DB::table('rol_permiso')->insert([
            ['id_rol' => 1, 'id_permiso' => 1], // Super Admin puede ver el panel
            ['id_rol' => 1, 'id_permiso' => 2], // Super Admin puede editar usuarios
            ['id_rol' => 1, 'id_permiso' => 3], // Super Admin puede eliminar usuarios
            ['id_rol' => 2, 'id_permiso' => 1], // Editor puede ver el panel
            ['id_rol' => 2, 'id_permiso' => 2], // Editor puede editar usuarios
            ['id_rol' => 3, 'id_permiso' => 1], // Viewer solo puede ver el panel
        ]);
    }
}