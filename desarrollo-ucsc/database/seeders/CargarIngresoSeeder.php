<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ingreso;
use App\Models\Usuario;
use App\Models\Sala;
use Illuminate\Support\Carbon;

class CargarIngresoSeeder extends Seeder
{
    public function run()
    {
        $usuarios = Usuario::where('tipo_usuario', 'estudiante')->get();
        $salas = Sala::all();

        if ($salas->isEmpty() || $usuarios->isEmpty()) {
            $this->command->warn('No hay salas o usuarios disponibles para poblar ingresos.');
            return;
        }

        foreach ($usuarios as $usuario) {
            $cantidad = rand(1, 5);
            for ($i = 0; $i < $cantidad; $i++) {
                $fecha = Carbon::now()->subDays(rand(0, 30));
                $horaIngreso = Carbon::createFromTime(rand(8, 18), rand(0, 59));
                $duracion = rand(30, 90); // minutos
                $horaSalida = (clone $horaIngreso)->addMinutes($duracion);

                Ingreso::create([
                    'id_usuario' => $usuario->id_usuario,
                    'id_sala' => $salas->random()->id_sala,
                    'fecha_ingreso' => $fecha->toDateString(),
                    'hora_ingreso' => $horaIngreso->format('H:i:s'),
                    'hora_salida' => $horaSalida->format('H:i:s'),
                    'tiempo_uso' => gmdate('H:i:s', $duracion * 60),
                ]);
            }
        }
    }
}
