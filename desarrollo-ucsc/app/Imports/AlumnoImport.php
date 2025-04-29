<?php

namespace App\Imports;

use App\Models\Alumno;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow; //Salta la primera fila que considera los encabezados

class AlumnoImport implements OnEachRow, WithHeadingRow
{
    public function onRow(Row $row)
    {
        $data = $row->toArray();

        $alumno = Alumno::find($data['rut_alumno']);

        if ($alumno) {
            $alumno->update([
                'apellido_paterno' => $data['apellido_paterno'],
                'apellido_materno' => $data['apellido_materno'],
                'nombre_alumno' => $data['nombre_alumno'],
                'carrera' => $data['carrera'],
                'estado_alumno' => $data['estado_alumno'],
            ]);
        } else {
            Alumno::create([
                'rut_alumno'      => $data['rut_alumno'],
                'apellido_paterno' => $data['apellido_paterno'],
                'apellido_materno' => $data['apellido_materno'],
                'nombre_alumno'   => $data['nombre_alumno'],
                'carrera'         => $data['carrera'],
                'estado_alumno'   => $data['estado_alumno'],
            ]);
        }
    }
}
