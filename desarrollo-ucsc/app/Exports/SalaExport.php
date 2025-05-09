<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SalaExport implements WithMultipleSheets
{
    protected $salaId, $inicio, $fin;

    public function __construct($salaId, $inicio, $fin)
    {
        $this->salaId = $salaId;
        $this->inicio = $inicio;
        $this->fin = $fin;
    }

    public function sheets(): array
    {
        return [
            new DatosExport($this->salaId, $this->inicio, $this->fin),
            new RankingExport($this->salaId, $this->inicio, $this->fin),
            new IngresosExport($this->salaId, $this->inicio, $this->fin),
        ];
    }
}
