<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;
use App\Models\Ingreso;

class IngresosExport implements FromCollection, WithHeadings
{
    protected $salaId, $inicio, $fin;

    public function __construct($salaId, $inicio, $fin)
    {
        $this->salaId = $salaId;
        $this->inicio = Carbon::parse($inicio)->startOfDay();
        $this->fin = Carbon::parse($fin)->endOfDay();
    }

    public function collection()
    {
        $ingresos = Ingreso::with(['usuario.alumno'])
            ->where('id_sala', $this->salaId)
            ->whereBetween('fecha_ingreso', [$this->inicio, $this->fin])
            ->get();

        return $ingresos->map(function ($ingreso) {
            $usuario = $ingreso->usuario;
            $rut = $usuario->rut;
            $nombre = 'Administrador';

            if ($usuario->tipo_usuario != 'admin' && $usuario->alumno) {
                $rut = $usuario->alumno->rut_alumno;
                $nombre = $usuario->alumno->nombre_alumno . ' ' . $usuario->alumno->apellido_paterno . ' ' . $usuario->alumno->apellido_materno;
            }

            return [
                'ID Ingreso'   => $ingreso->id_ingreso,
                'Fecha Ingreso'=> $ingreso->fecha_ingreso,
                'Hora Ingreso' => $ingreso->hora_ingreso,
                'Hora Salida'  => $ingreso->hora_salida,
                'Tiempo Uso'   => $ingreso->tiempo_uso,
                'RUT'          => $rut,
                'Nombre'       => $nombre,
            ];
        });
    }

    public function headings(): array
    {
        return ['ID Ingreso', 'Fecha Ingreso', 'Hora Ingreso', 'Hora Salida', 'Tiempo Uso', 'RUT', 'Nombre'];
    }
}
