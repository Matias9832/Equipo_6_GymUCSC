<?php

namespace App\Imports;

use App\Models\Alumno;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow; //Salta la primera fila que considera los encabezados
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;

class AlumnoImport implements OnEachRow, WithHeadingRow, WithEvents
{
    public static function beforeImport(BeforeImport $event)
    {
        $sheet = $event->getReader()->getActiveSheet();
        $actualHeaders = $sheet->rangeToArray('A1:F1')[0];

        $expectedHeaders = [
            'rut_alumno',
            'apellido_paterno',
            'apellido_materno',
            'nombre_alumno',
            'carrera',
            'estado_alumno'
        ];

        foreach ($expectedHeaders as $index => $expected) {
            if (!isset($actualHeaders[$index]) || strtolower(trim($actualHeaders[$index])) !== $expected) {
                throw new \Exception("La columna '$expected' está ausente o en orden incorrecto en el archivo.");
            }
        }
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => [self::class, 'beforeImport'],
        ];
    }
    public function onRow(Row $row)
    {
        $data = $row->toArray();
        $fila = $row->getIndex();

        // Validaciones
        if (empty($data['rut_alumno'])) {
            session()->push('import_errors_missing_rut', "Fila {$fila}: Falta el RUT del alumno.");
            return;
        }

        if (
            empty($data['apellido_paterno']) ||
            empty($data['apellido_materno']) ||
            empty($data['nombre_alumno']) ||
            empty($data['carrera']) ||
            empty($data['estado_alumno'])
        ) {
            session()->push('import_errors_incomplete_data', "RUT '{$data['rut_alumno']}': Datos incompletos.");
            return;
        }

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
                'rut_alumno' => $data['rut_alumno'],
                'apellido_paterno' => $data['apellido_paterno'],
                'apellido_materno' => $data['apellido_materno'],
                'nombre_alumno' => $data['nombre_alumno'],
                'carrera' => $data['carrera'],
                'estado_alumno' => $data['estado_alumno'],
            ]);
        }
    }
}
