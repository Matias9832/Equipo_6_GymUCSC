<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Torneo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre_torneo', 'id_sucursal', 'id_deporte', 'max_equipos', 'tipo_competencia'];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'id_sucursal');
    }

    public function deporte()
    {
        return $this->belongsTo(Deporte::class, 'id_deporte');
    }

    public function equipos()
    {
        return $this->belongsToMany(Equipo::class, 'torneo_equipo', 'torneo_id', 'equipo_id');
    }
}