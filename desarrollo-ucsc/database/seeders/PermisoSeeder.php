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
        $gruposPermisos = [
            'Alumnos' => [
                'Acceso al Mantenedor de Alumnos',
            ],
            'Deportes' => [
                'Acceso al Mantenedor de Deportes',
            ],
            'Máquinas' => [
                'Acceso al Mantenedor de Máquinas',
            ],
            'Marcas' => [
                'Acceso al Mantenedor de Marcas',
            ],
            'Países' => [
                'Acceso al Mantenedor de Países',
            ],
            'Regiones' => [
                'Acceso al Mantenedor de Regiones',
            ],
            'Ciudades' => [
                'Acceso al Mantenedor de Ciudades',
            ],
            'Sucursales' => [
                'Acceso al Mantenedor de Sucursales',
            ],
            'Espacios' => [
                'Acceso al Mantenedor de Espacios',
            ],
            'Salas' => [
                'Acceso al Mantenedor de Salas',
            ],
            'Tipos de Espacios' => [
                'Acceso al Mantenedor de Tipos de Espacios',
            ],
            'Tipos de Sanción' => [
                'Acceso al Mantenedor de Tipos de Sanción',
            ],
            'Administradores' => [
                'Acceso al Mantenedor de Administradores',
            ],
            'Roles' => [
                'Acceso al Mantenedor de Roles',
            ],
            'Equipos' => [
                'Acceso al Mantenedor de Equipos',
            ],
            'Torneos' => [
                'Acceso al Mantenedor de Torneos',
            ],
            'Rutinas' => [
                'Acceso al Mantenedor de Rutinas',
            ],
            'Talleres' => [
                'Acceso al Mantenedor de Talleres',
                'Acceso a Gestión de Asistencia Talleres',
            ],
            'Ejercicios' => [
                'Acceso al Mantenedor de Ejercicios',
            ],
            'Carreras' => [
                'Acceso al Mantenedor de Carreras',
            ],
            'Usuarios' => [
                'Acceso al Mantenedor de Usuarios',
                'Ver Usuarios',
                'Crear Usuarios',
                'Editar Usuarios',
                'Eliminar Usuarios',
            ],
            'Docentes' => [
                'Acceso al Mantenedor de Docentes',
                'Ver Docentes',
                'Crear Docentes',
                'Editar Docentes',
                'Eliminar Docentes',
            ],
            'Noticias' => [
                'Crear Noticias',
            ],
            'Gestión' => [
                'Acceso a Gestión de QR',
            ],
            'Salas Abiertas' => [
                'Acceso a Salas Abiertas',
            ],
        ];

        foreach ($gruposPermisos as $subpermiso => $permisos) {
            foreach ($permisos as $permiso) {
                DB::table('permiso')->updateOrInsert(
                    ['nombre_permiso' => $permiso],
                    [
                        'subpermisos' => $subpermiso,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]
                );
            }
        }
    }
}
