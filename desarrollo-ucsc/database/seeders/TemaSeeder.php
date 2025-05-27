<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('temas')->insert([
            // [
            //     'nombre_tema' => 'Predeterminado Vacío',
            //     'color_fondo' => null,
            //     'color_barra' => null,
            //     'color_boton' => null,
            //     'color_texto' => null,
            //     'color_exito' => null,
            //     'color_error' => null,
            //     'nombre_fuente' => null,
            //     'familia_css' => null,
            //     'url_fuente' => null,
            //     'activo' => false,
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
            [
                'nombre_tema' => 'Clásico Académico',
                'color_fondo' => '#FFFFFF',
                'color_barra' => '#003366',
                'color_boton' => '#336699',
                'color_texto' => '#000000',
                'color_exito' => '#28a745',
                'color_error' => '#dc3545',
                'nombre_fuente' => 'Roboto',
                'familia_css' => "'Roboto', sans-serif",
                'url_fuente' => 'https://fonts.googleapis.com/css2?family=Roboto&display=swap',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_tema' => 'Deportivo Moderno',
                'color_fondo' => '#F4F4F4',
                'color_barra' => '#1F1F1F',
                'color_boton' => '#E91E63',
                'color_texto' => '#212121',
                'color_exito' => '#4CAF50',
                'color_error' => '#F44336',
                'nombre_fuente' => 'Poppins',
                'familia_css' => "'Poppins', sans-serif",
                'url_fuente' => 'https://fonts.googleapis.com/css2?family=Poppins&display=swap',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_tema' => 'Campus Verde',
                'color_fondo' => '#E8F5E9',
                'color_barra' => '#2E7D32',
                'color_boton' => '#66BB6A',
                'color_texto' => '#1B5E20',
                'color_exito' => '#81C784',
                'color_error' => '#C62828',
                'nombre_fuente' => 'Open Sans',
                'familia_css' => "'Open Sans', sans-serif",
                'url_fuente' => 'https://fonts.googleapis.com/css2?family=Open+Sans&display=swap',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_tema' => 'Universitario Rojo',
                'color_fondo' => '#FFF5F5',
                'color_barra' => '#B71C1C',
                'color_boton' => '#D32F2F',
                'color_texto' => '#212121',
                'color_exito' => '#388E3C',
                'color_error' => '#D50000',
                'nombre_fuente' => 'Lato',
                'familia_css' => "'Lato', sans-serif",
                'url_fuente' => 'https://fonts.googleapis.com/css2?family=Lato&display=swap',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_tema' => 'Futuro Digital',
                'color_fondo' => '#0F172A',
                'color_barra' => '#1E293B',
                'color_boton' => '#3B82F6',
                'color_texto' => '#F8FAFC',
                'color_exito' => '#22C55E',
                'color_error' => '#EF4444',
                'nombre_fuente' => 'Inter',
                'familia_css' => "'Inter', sans-serif",
                'url_fuente' => 'https://fonts.googleapis.com/css2?family=Inter&display=swap',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
