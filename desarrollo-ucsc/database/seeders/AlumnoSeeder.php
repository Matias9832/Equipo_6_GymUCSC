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
            ['rut_alumno' => '12345678-5', 'nombre_alumno' => 'Juan Pérez', 'carrera' => 'Ingeniería Civil', 'estado_alumno' => 'Activo'],
            ['rut_alumno' => '87654321-9', 'nombre_alumno' => 'María González', 'carrera' => 'Arquitectura', 'estado_alumno' => 'Activo'],
            ['rut_alumno' => '11222333-4', 'nombre_alumno' => 'Carlos López', 'carrera' => 'Derecho', 'estado_alumno' => 'Inactivo'],
            ['rut_alumno' => '33444555-6', 'nombre_alumno' => 'Ana Martínez', 'carrera' => 'Medicina', 'estado_alumno' => 'Activo'],
            ['rut_alumno' => '55666777-8', 'nombre_alumno' => 'Pedro Ramírez', 'carrera' => 'Psicología', 'estado_alumno' => 'Activo'],
            ['rut_alumno' => '77888999-1', 'nombre_alumno' => 'Sofía Torres', 'carrera' => 'Ingeniería Comercial', 'estado_alumno' => 'Inactivo'],
            ['rut_alumno' => '99887766-3', 'nombre_alumno' => 'Diego Fuentes', 'carrera' => 'Periodismo', 'estado_alumno' => 'Activo'],
            ['rut_alumno' => '66554433-2', 'nombre_alumno' => 'Camila Rojas', 'carrera' => 'Diseño Gráfico', 'estado_alumno' => 'Activo'],
            ['rut_alumno' => '44332211-7', 'nombre_alumno' => 'Javier Morales', 'carrera' => 'Ingeniería en Informática', 'estado_alumno' => 'Activo'],
            ['rut_alumno' => '11112222-0', 'nombre_alumno' => 'Valentina Vega', 'carrera' => 'Educación Física', 'estado_alumno' => 'Inactivo'],
        ]);
    }
}