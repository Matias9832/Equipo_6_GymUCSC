<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alumno;
use App\Models\Usuario;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class CargarUsuarioSeeder extends Seeder
{
    public function run()
    {
        $alumnos = Alumno::whereBetween('rut_alumno', ['10000000', '10999999'])->get();

        foreach ($alumnos as $alumno) {
            Usuario::firstOrCreate(
                ['rut' => $alumno->rut_alumno],
                [
                    'correo_usuario' => $this->generarCorreo($alumno),
                    'contrasenia_usuario' => Hash::make('12345678'),
                    'tipo_usuario' => 'estudiante',
                    'bloqueado_usuario' => 0,
                    'activado_usuario' => 1,
                ]
            );
        }
    }

    private function generarCorreo($alumno)
    {
        $nombre = Str::slug($alumno->nombre_alumno, '');
        $apellido = Str::slug($alumno->apellido_paterno, '');
        return strtolower($nombre . '.' . $apellido . '@alumnos.ucsc.cl');
    }
}
