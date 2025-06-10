<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisos = [
            'Acceso al Mantenedor de Alumnos',
            'Acceso al Mantenedor de Deportes',
            'Acceso al Mantenedor de Máquinas',
            'Acceso al Mantenedor de Marcas',
            'Acceso al Mantenedor de Países',
            'Acceso al Mantenedor de Regiones',
            'Acceso al Mantenedor de Ciudades',
            'Acceso al Mantenedor de Sucursales',
            'Acceso al Mantenedor de Espacios',
            'Acceso al Mantenedor de Salas',
            'Acceso al Mantenedor de Tipos de Espacios',
            'Acceso al Mantenedor de Tipos de Sanción',
            'Acceso al Mantenedor de Administradores',
            'Acceso al Mantenedor de Roles',
            'Acceso al Mantenedor de Equipos',
            'Acceso al Mantenedor de Torneos',
            'Acceso al Mantenedor de Rutinas',
            'Acceso al Mantenedor de Talleres',
            'Acceso al Mantenedor de Ejercicios',
            'Acceso al Mantenedor de Carreras',

            // Acceso a funcionalidades de gestión
            'Acceso a Gestión de QR',
            'Acceso a Gestión de Asistencia Talleres',

            // Accesos a Salas Abiertas
            'Acceso a Salas Abiertas',

            // Acceso al Mantenedor de Usuarios
            'Ver Usuarios',
            'Crear Usuarios',
            'Editar Usuarios',
            'Eliminar Usuarios',

            // Acceso al Mantenedor de Docentes
            'Ver Docentes',
            'Crear Docentes',
            'Editar Docentes',
            'Eliminar Docentes',

            // Acceso a las noticias
            'Crear Noticias',
        ];

        foreach ($permisos as $permiso) {
            DB::table('permiso')->updateOrInsert(
                ['nombre_permiso' => $permiso],
                ['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
            );
        }
    }
}
