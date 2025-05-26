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
    $taller = Taller::create([
        'nombre_taller' => 'Yoga Básico',
        'descripcion_taller' => 'Un taller de iniciación al yoga.',
        'cupos_taller' => 20,
        'indicaciones_taller' => 'Traer esterilla.',
        'activo_taller' => true,
    ]);

    $taller->horarios()->createMany([
        ['dia_taller' => 'Martes', 'hora_inicio' => '11:00', 'hora_termino' => '12:00'],
        ['dia_taller' => 'Jueves', 'hora_inicio' => '11:00', 'hora_termino' => '13:00'],
    ]);
}

}
