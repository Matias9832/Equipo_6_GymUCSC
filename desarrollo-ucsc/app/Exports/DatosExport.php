<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Models\Ingreso;
use Carbon\Carbon;

class DatosExport implements FromArray, WithTitle
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
        $ingresos = Ingreso::with('usuario')
            ->where('id_sala', $this->salaId)
            ->whereBetween('fecha_ingreso', [$this->inicio, $this->fin])
            ->get();

        $adminCount = $ingresos->where('usuario.tipo_usuario', 'admin')->count();
        $estudianteCount = $ingresos->where('usuario.tipo_usuario',"!=", 'admin')->count();
        $periodo = $this->inicio->toDateString() . ' a ' . $this->fin->toDateString();

        return [
            ['Período', $periodo],
            ['Cantidad de ingresos de Estudiantes', $estudianteCount],
        ];
    }

    public function title(): string
    {
        return 'Datos';
    }
}
