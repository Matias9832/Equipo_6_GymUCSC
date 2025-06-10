<?php

namespace Database\Seeders\Tenants;

use Illuminate\Database\Seeder;
use App\Models\Tenants\Fuente;

class FuentesSeeder extends Seeder
{
    public function run(): void
    {
        $fuentes = [
            [
                'nombre_fuente' => 'Montserrat',
                'familia_css' => 'Montserrat, sans-serif',
                'url_fuente' => 'https://fonts.googleapis.com/css2?family=Montserrat',

            ],
            [
                'nombre_fuente' => 'Merriweather',
                'familia_css' => 'Merriweather, serif',
                'url_fuente' => 'https://fonts.googleapis.com/css2?family=Merriweather',

            ],
            [
                'nombre_fuente' => 'Roboto',
                'familia_css' => 'Roboto, sans-serif',
                'url_fuente' => 'https://fonts.googleapis.com/css2?family=Roboto',

            ],
            [
                'nombre_fuente' => 'Lato',
                'familia_css' => 'Lato, sans-serif',
                'url_fuente' => 'https://fonts.googleapis.com/css2?family=Lato',

            ],
            [
                'nombre_fuente' => 'Open Sans',
                'familia_css' => 'Open Sans, sans-serif',
                'url_fuente' => 'https://fonts.googleapis.com/css2?family=Open+Sans',

            ],
            [
                'nombre_fuente' => 'Poppins',
                'familia_css' => 'Poppins, sans-serif',
                'url_fuente' => 'https://fonts.googleapis.com/css2?family=Poppins',

            ],
            [
                'nombre_fuente' => 'Inter',
                'familia_css' => 'Inter, sans-serif',
                'url_fuente' => 'https://fonts.googleapis.com/css2?family=Inter',

            ],
        ];

        foreach ($fuentes as $fuente) {
            Fuente::updateOrCreate(
                ['nombre_fuente' => $fuente['nombre_fuente']],
                $fuente
            );
        }
    }
}
