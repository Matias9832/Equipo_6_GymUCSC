<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class AlumnoImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        // Saltar la primera fila (encabezados del Excel)
        $rows->skip(1)->each(function ($row) {
            DB::table('alumno')->insert([
                'rut_alumno' => $row[0],
                'apellido_paterno' => $row[1],
                'apellido_materno' => $row[2],
                'nombre_alumno' => $row[3],
                'carrera' => $row[4],
                'estado_alumno' => $row[5],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }
}
