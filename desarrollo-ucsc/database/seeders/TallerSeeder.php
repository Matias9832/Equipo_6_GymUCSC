<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Taller;

class TallerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Taller 1 - Yoga
        $taller = Taller::create([
            'nombre_taller' => 'Yoga Básico',
            'descripcion_taller' => 'Un taller de iniciación al yoga.',
            'cupos_taller' => 20,
            'id_admin' => 1,
            'id_espacio' => 1,
            'indicaciones_taller' => 'Traer esterilla.',
            'activo_taller' => true,
        ]);
        $taller->horarios()->createMany([
            ['dia_taller' => 'Martes', 'hora_inicio' => '11:00', 'hora_termino' => '12:00'],
            ['dia_taller' => 'Jueves', 'hora_inicio' => '11:00', 'hora_termino' => '13:00'],
        ]);

        // Taller 2 - Básquetbol
        $taller = Taller::create([
            'nombre_taller' => 'Básquetbol Intermedio',
            'descripcion_taller' => 'Perfecciona tus habilidades en la cancha.',
            'cupos_taller' => 25,
            'id_admin' => 2,
            'id_espacio' => 2,
            'indicaciones_taller' => 'Ropa deportiva y agua.',
            'activo_taller' => true,
        ]);
        $taller->horarios()->createMany([
            ['dia_taller' => 'Lunes', 'hora_inicio' => '18:00', 'hora_termino' => '20:00'],
        ]);

        // Taller 3 - Fútbol
        $taller = Taller::create([
            'nombre_taller' => 'Fútbol Avanzado',
            'descripcion_taller' => 'Estrategias y juego en equipo.',
            'cupos_taller' => 30,
            'id_admin' => 3,
            'id_espacio' => 3,
            'indicaciones_taller' => 'Traer zapatos de fútbol.',
            'activo_taller' => true,
        ]);
        $taller->horarios()->createMany([
            ['dia_taller' => 'Miércoles', 'hora_inicio' => '17:00', 'hora_termino' => '19:00'],
        ]);

        // Taller 4 - Vóleibol
        $taller = Taller::create([
            'nombre_taller' => 'Vóleibol Recreativo',
            'descripcion_taller' => 'Aprende fundamentos y diviértete.',
            'cupos_taller' => 20,
            'id_admin' => 4,
            'id_espacio' => 4,
            'indicaciones_taller' => 'Ropa cómoda.',
            'activo_taller' => true,
        ]);
        $taller->horarios()->createMany([
            ['dia_taller' => 'Viernes', 'hora_inicio' => '10:00', 'hora_termino' => '12:00'],
        ]);

        // Taller 5 - Tenis
        $taller = Taller::create([
            'nombre_taller' => 'Tenis Básico',
            'descripcion_taller' => 'Golpes básicos y técnica.',
            'cupos_taller' => 12,
            'id_admin' => 5,
            'id_espacio' => 6,
            'indicaciones_taller' => 'Raqueta propia sugerida.',
            'activo_taller' => true,
        ]);
        $taller->horarios()->createMany([
            ['dia_taller' => 'Lunes', 'hora_inicio' => '09:00', 'hora_termino' => '10:30'],
            ['dia_taller' => 'Miércoles', 'hora_inicio' => '09:00', 'hora_termino' => '10:30'],
        ]);

        // Taller 6 - Natación
        $taller = Taller::create([
            'nombre_taller' => 'Natación Nivel 1',
            'descripcion_taller' => 'Iniciación a la natación.',
            'cupos_taller' => 15,
            'id_admin' => 6,
            'id_espacio' => 3,
            'indicaciones_taller' => 'Traje de baño obligatorio.',
            'activo_taller' => true,
        ]);
        $taller->horarios()->createMany([
            ['dia_taller' => 'Martes', 'hora_inicio' => '14:00', 'hora_termino' => '15:00'],
            ['dia_taller' => 'Jueves', 'hora_inicio' => '14:00', 'hora_termino' => '15:00'],
        ]);
    }

}
