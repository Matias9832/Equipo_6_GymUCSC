<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    protected $table = 'sala';
    protected $primaryKey = 'id_sala';
    public $timestamps = false;

    protected $fillable = [
        'nombre_sala',
        'aforo_sala',
        'horario_apertura',
        'horario_cierre',
        'activo',
        'aforo_qr',
        'id_suc',
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'id_suc');
    }

}
