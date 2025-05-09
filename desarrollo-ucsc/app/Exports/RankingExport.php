<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Ingreso;
use Carbon\Carbon;

class RankingExport implements FromArray, WithHeadings, WithTitle
{
    protected $salaId, $inicio, $fin;

    public function __construct($salaId, $inicio, $fin)
    {
        $this->salaId = $salaId;
        $this->inicio = Carbon::parse($inicio)->startOfDay();
        $this->fin = Carbon::parse($fin)->endOfDay();
    }

    public function array(): array
    {
        $ingresos = Ingreso::with('usuario.alumno')
            ->where('id_sala', $this->salaId)
            ->whereBetween('fecha_ingreso', [$this->inicio, $this->fin])
            ->get();

        $agrupados = $ingresos->groupBy('id_usuario')->map(function ($items) {
            $usuario = $items->first()->usuario;
            $nombre = 'Administrador';

            if ($usuario->tipo_usuario != 'admin' && $usuario->alumno) {
                $nombre = $usuario->alumno->nombre_alumno . ' ' . $usuario->alumno->apellido_paterno . ' ' . $usuario->alumno->apellido_materno;
            }

            // Sumar tiempo_uso (HH:MM:SS) como segundos
            $tiempoTotalSegundos = $items->reduce(function ($carry, $item) {
                list($h, $m, $s) = explode(':', $item->tiempo_uso);
                return $carry + ($h * 3600) + ($m * 60) + $s;
            }, 0);

            $tiempoTotalFormateado = gmdate('H:i:s', $tiempoTotalSegundos);

            return [
                'Nombre' => $nombre,
                'Ingresos' => $items->count(),
                'Tiempo Total' => $tiempoTotalFormateado,
            ];
        });

        return $agrupados->sortByDesc('Ingresos')->take(10)->values()->toArray();
    }

    public function headings(): array
    {
        return ['Nombre', 'Ingresos', 'Tiempo Total'];
    }

    public function title(): string
    {
        return 'Ranking';
    }
}
