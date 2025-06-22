<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $table = 'ingreso';
    protected $primaryKey = 'id_ingreso';

    protected $fillable = [
        'id_sala',
        'id_usuario',
        'fecha_ingreso',
        'hora_ingreso',
        'hora_salida',
        'hora_salida_estimada',
        'tiempo_uso',
    ];

    // Ingreso.php
    public function sala()
    {
        return $this->belongsTo(Sala::class, 'id_sala');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public $timestamps = true;
}
