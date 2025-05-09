<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Usuario;

class IngresoSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = Usuario::where('rut', '!=', '21080600')->get();
        $cantidadRegistros = 1;

        for ($i = 0; $i < $cantidadRegistros; $i++) {
            $usuario = $usuarios->random();
            $idSala = rand(1, 3);
            $fechaIngreso = Carbon::today()->subMonths(rand(0, 1));
            $horaIngreso = Carbon::createFromFormat('H:i', rand(8, 10) . ':' . str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT));
            $horaSalida = $horaIngreso->copy()->addMinutes(rand(10, 90));
            $tiempoUso = $horaSalida->diff($horaIngreso);

            DB::table('ingreso')->insert([
                'id_sala' => $idSala,
                'id_usuario' => $usuario->id_usuario,
                'fecha_ingreso' => $fechaIngreso,
                'hora_ingreso' => $horaIngreso->format('H:i:s'),
                'hora_salida' => $horaSalida->format('H:i:s'),
                'tiempo_uso' => $tiempoUso->format('%H:%I:%S'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}

