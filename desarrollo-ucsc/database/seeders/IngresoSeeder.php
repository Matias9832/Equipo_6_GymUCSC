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
        $cantidadRegistros = 10000;

        for ($i = 0; $i < $cantidadRegistros; $i++) {
            $usuario = $usuarios->filter(function ($usuario) {
                return $usuario->tipo_usuario !== 'admin';
            })->random();
            $idSala = rand(1, 3);

            $mesAleatorio = rand(0, 1) === 0 ? now()->month : now()->subMonth()->month;
            $anioActual = now()->year;

            $inicioMes = Carbon::create($anioActual, $mesAleatorio, 1);
            $finMes = $inicioMes->copy()->endOfMonth();

            $fechaIngreso = Carbon::createFromTimestamp(rand($inicioMes->timestamp, $finMes->timestamp));

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

