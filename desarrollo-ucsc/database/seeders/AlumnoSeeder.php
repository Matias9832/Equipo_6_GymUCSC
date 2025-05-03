<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlumnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('alumno')->insert([
            [
                'rut_alumno' => '12345678-5',
                'apellido_paterno' => 'Pérez',
                'apellido_materno' => 'González',
                'nombre_alumno' => 'Juan',
                'carrera' => 'Ingeniería Civil',
                'estado_alumno' => 'Activo',
            ],
            [
                'rut_alumno' => '87654321-9',
                'apellido_paterno' => 'González',
                'apellido_materno' => 'Pérez',
                'nombre_alumno' => 'María',
                'carrera' => 'Arquitectura',
                'estado_alumno' => 'Activo',
            ],
            [
                'rut_alumno' => '11222333-4',
                'apellido_paterno' => 'López',
                'apellido_materno' => 'Sánchez',
                'nombre_alumno' => 'Carlos',
                'carrera' => 'Derecho',
                'estado_alumno' => 'Inactivo',
            ],
            [
                'rut_alumno' => '33444555-6',
                'apellido_paterno' => 'Martínez',
                'apellido_materno' => 'Fernández',
                'nombre_alumno' => 'Ana',
                'carrera' => 'Medicina',
                'estado_alumno' => 'Activo',
            ],
            [
                'rut_alumno' => '55666777-8',
                'apellido_paterno' => 'Ramírez',
                'apellido_materno' => 'Ortega',
                'nombre_alumno' => 'Pedro',
                'carrera' => 'Psicología',
                'estado_alumno' => 'Activo',
            ],
            [
                'rut_alumno' => '77888999-1',
                'apellido_paterno' => 'Torres',
                'apellido_materno' => 'Muñoz',
                'nombre_alumno' => 'Sofía',
                'carrera' => 'Ingeniería Comercial',
                'estado_alumno' => 'Inactivo',
            ],
            [
                'rut_alumno' => '99887766-3',
                'apellido_paterno' => 'Fuentes',
                'apellido_materno' => 'Castro',
                'nombre_alumno' => 'Diego',
                'carrera' => 'Periodismo',
                'estado_alumno' => 'Activo',
            ],
            [
                'rut_alumno' => '66554433-2',
                'apellido_paterno' => 'Rojas',
                'apellido_materno' => 'Vargas',
                'nombre_alumno' => 'Camila',
                'carrera' => 'Diseño Gráfico',
                'estado_alumno' => 'Activo',
            ],
            [
                'rut_alumno' => '44332211-7',
                'apellido_paterno' => 'Morales',
                'apellido_materno' => 'Herrera',
                'nombre_alumno' => 'Javier',
                'carrera' => 'Ingeniería en Informática',
                'estado_alumno' => 'Activo',
            ],
            [
                'rut_alumno' => '21080600',
                'apellido_paterno' => 'Carrasco',
                'apellido_materno' => 'Aguayo',
                'nombre_alumno' => 'Matías',
                'carrera' => 'Ingienería Civil Informática',
                'estado_alumno' => 'Activo',
            ],
        ]);
    }
}
