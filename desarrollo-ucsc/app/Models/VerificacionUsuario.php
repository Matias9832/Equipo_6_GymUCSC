<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificacionUsuario extends Model
{
    protected $table = 'verificacion_usuario';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_usuario',
        'codigo_verificacion',
        'intentos',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}