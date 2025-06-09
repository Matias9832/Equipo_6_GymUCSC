<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partido extends Model
{
    protected $fillable = [
        'torneo_id', 'equipo_local_id', 'equipo_visitante_id', 'goles_local', 'goles_visitante'
    ];  
    
    public function local() { return $this->belongsTo(Equipo::class, 'equipo_local_id'); }
    public function visitante() { return $this->belongsTo(Equipo::class, 'equipo_visitante_id'); }
    public function torneo() { return $this->belongsTo(Torneo::class, 'torneo_id'); }
}