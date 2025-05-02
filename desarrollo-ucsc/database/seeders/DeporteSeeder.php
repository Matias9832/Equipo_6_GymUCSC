<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Deporte;

class DeporteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Agregar deporte Basketball
        Deporte::create([
            'nombre_deporte' => 'Basketball',
            'jugadores_por_equipo' => 5,
            'descripcion' => 'Deporte de equipo jugado con una pelota que se pasa entre los jugadores para encestarla en el aro del equipo contrario.',
        ]);

        // Agregar deporte Volleyball
        Deporte::create([
            'nombre_deporte' => 'Volleyball',
            'jugadores_por_equipo' => 6,
            'descripcion' => 'Deporte de equipo donde los jugadores deben pasar una pelota por encima de una red y evitar que toque el suelo del lado contrario.',
        ]);

        // Agregar deporte Football
        Deporte::create([
            'nombre_deporte' => 'Football',
            'jugadores_por_equipo' => 11,
            'descripcion' => 'Deporte de equipo donde los jugadores deben llevar un balón hacia la portería contraria para marcar goles, utilizando principalmente los pies.',
        ]);

        // Agregar deporte Tenis de mesa
        Deporte::create([
            'nombre_deporte' => 'Tenis de mesa',
            'jugadores_por_equipo' => 2,
            'descripcion' => 'Deporte de raqueta jugado sobre una mesa, donde los jugadores deben devolver la pelota sobre la mesa del contrario usando una raqueta.',
        ]);

        // Agregar deporte Paddle
        Deporte::create([
            'nombre_deporte' => 'Deporte de prueba',
            'jugadores_por_equipo' => 2,
            'descripcion' => 'Deporte de prueba',
        ]);
    }
}
