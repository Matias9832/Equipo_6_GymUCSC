<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GeographicSeeder extends Seeder
{
    public function run(): void
    {
        // Insertar el país Chile
        $paisId = DB::table('pais')->insertGetId([
            'nombre_pais' => 'Chile',
            'bandera_pais' => 'https://es.flagsdb.com/img/flags/cl.svg',
        ]);

        // Insertar las regiones de Chile
        $regionIds = [
            'Región Metropolitana',
            'Región de Valparaíso',
            'Región del Libertador General Bernardo O’Higgins',
            'Región de Maule',
            'Región de Biobío',
            'Región de La Araucanía',
            'Región de Los Lagos',
            'Región de Coquimbo',
        ];

        foreach ($regionIds as $regionNombre) {
            DB::table('region')->insert([
                'nombre_region' => $regionNombre,
                'id_pais' => $paisId,
            ]);
        }
        // Insertar las ciudades de cada región
        $regiones = DB::table('region')->where('id_pais', $paisId)->get();

        $ciudadesPorRegion = [
            'Región Metropolitana' => ['Santiago', 'Puente Alto', 'Maipú'],
            'Región de Valparaíso' => ['Valparaíso', 'Viña del Mar', 'Quillota'],
            'Región del Libertador General Bernardo O’Higgins' => ['Rancagua', 'Machalí'],
            'Región de Maule' => ['Talca', 'Curicó'],
            'Región de Biobío' => ['Concepción', 'Chillán', 'Los Ángeles'],
            'Región de La Araucanía' => ['Temuco', 'Villarrica'],
            'Región de Los Lagos' => ['Puerto Montt', 'Osorno'],
            'Región de Coquimbo' => ['La Serena', 'Coquimbo'],
        ];

        foreach ($regiones as $region) {
            $ciudades = $ciudadesPorRegion[$region->nombre_region] ?? [];

            foreach ($ciudades as $ciudad) {
                DB::table('ciudad')->insert([
                    'nombre_ciudad' => $ciudad,
                    'id_region' => $region->id_region,
                ]);
            }
        }
    }
}
