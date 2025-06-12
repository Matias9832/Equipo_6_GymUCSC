<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardDocente extends Component
{
    public $nombre, $foto, $cargo, $sucursal, $ubicacion, $correo, $telefono, $sobre_mi, $talleres;

    public function __construct($nombre, $foto = null, $cargo = null, $sucursal = null, $ubicacion = null, $correo = null, $telefono = null, $sobreMi = null, $talleres = [])
    {
        $this->nombre = $nombre;
        $this->foto = $foto;
        $this->cargo = $cargo;
        $this->sucursal = $sucursal;
        $this->ubicacion = $ubicacion;
        $this->correo = $correo;
        $this->telefono = $telefono;
        $this->sobre_mi = $sobreMi;
        $this->talleres = $talleres;
    }

    public function render()
    {
        return view('components.card-docente');
    }
}