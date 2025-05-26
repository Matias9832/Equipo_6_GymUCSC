<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre_equipo', 'id_deporte'];

    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'equipo_usuario', 'equipo_id', 'usuario_id');
    }

    public function deporte()
    {
        return $this->belongsTo(Deporte::class, 'id_deporte', 'id_deporte');
    }

    public function torneos()
    {
        return $this->belongsToMany(Torneo::class, 'torneo_equipo', 'equipo_id', 'torneo_id');
    }
    public function talleres()
    {
        return $this->hasMany(Taller::class, 'id_espacio');
    }
}