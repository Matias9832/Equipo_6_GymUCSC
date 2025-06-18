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
        $actualHeaders = $sheet->rangeToArray('A1:H1')[0];

        $expectedHeaders = [
            'rut',
            'ua',
            'carr_descripcion',
            'correo_inst',
            'paterno',
            'materno',
            'nombres',
            'sexo',
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
        if (empty($data['rut'])) {
            session()->push('import_errors_missing_rut', "Fila {$fila}: Falta el RUT del alumno.");
            return;
        }

        if (
            empty($data['paterno']) ||
            empty($data['materno']) ||
            empty($data['nombres']) ||
            empty($data['ua']) ||
            empty($data['carr_descripcion']) ||
            empty($data['correo_inst']) ||
            empty($data['sexo'])
        ) {
            session()->push('import_errors_incomplete_data', "RUT '{$data['rut']}': Datos incompletos.");
            return;
        }

        $alumno = Alumno::find($data['rut']);

        $datos = [
            'apellido_paterno' => $data['paterno'],
            'apellido_materno' => $data['materno'],
            'nombre_alumno' => $data['nombres'],
            'carrera' => $data['carr_descripcion'],
            'ua_carrera' => $data['ua'],
            'correo_alumno' => $data['correo_inst'],
            'sexo_alumno' => strtoupper(trim($data['sexo'])),
            'estado_alumno' => 'Activo',
        ];

        if ($alumno) {
            $alumno->update($datos);
        } else {
            $datos['rut_alumno'] = $data['rut'];
            Alumno::create($datos);
        }
        session()->push('ua_carreras', [
            'ua' => trim($data['ua']),
            'carrera' => trim($data['carr_descripcion']),
        ]);
    }

}
