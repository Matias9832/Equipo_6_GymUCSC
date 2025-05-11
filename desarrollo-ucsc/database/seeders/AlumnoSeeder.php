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
                'rut_alumno' => '20839592',
                'apellido_paterno' => 'Guzman',
                'apellido_materno' => 'Ahuile',
                'nombre_alumno' => 'Joaquin',
                'carrera' => 'Ingeniería Civil Informática',
                'estado_alumno' => 'Activo',
            ],
            [
                'rut_alumno' => '21164518',
                'apellido_paterno' => 'Constanzo',
                'apellido_materno' => 'Hidalgo',
                'nombre_alumno' => 'Sebastian',
                'carrera' => 'Ingeniería Civil Informática',
                'estado_alumno' => 'Activo',
            ],
            [
                'rut_alumno' => '20154345',
                'apellido_paterno' => 'Riquelme',
                'apellido_materno' => 'Castillo',
                'nombre_alumno' => 'Javiera',
                'carrera' => 'Ingeniería Civil Informática',
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
