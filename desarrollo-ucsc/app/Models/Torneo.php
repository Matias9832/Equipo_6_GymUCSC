<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Torneo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre_torneo', 'id_sucursal', 'id_deporte', 'max_equipos'];

    /**
     * Relación con la sucursal.
     */
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'id_sucursal', 'id_suc');
    }

    /**
     * Relación con el deporte.
     */
    public function deporte()
    {
        return $this->belongsTo(Deporte::class, 'id_deporte', 'id_deporte');
    }

    /**
     * Relación con los equipos.
     */
    public function equipos()
    {
        return $this->belongsToMany(Equipo::class, 'torneo_equipo', 'torneo_id', 'equipo_id');
    }
}