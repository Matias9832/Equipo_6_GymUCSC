<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuario'; // Nombre de la tabla
    protected $primaryKey = 'id_usuario'; // Clave primaria
    public $incrementing = true; // Indica que la clave primaria es autoincremental
    protected $keyType = 'int'; // Tipo de dato de la clave primaria

    protected $fillable = [
        'rut_alumno',
        'correo_usuario',
        'contrasenia_usuario',
        'bloqueado_usuario',
        'activado_usuario',
        'tipo_usuario',
    ];

    protected $hidden = [
        'contrasenia_usuario', // Ocultar la contraseña en las respuestas JSON
    ];

    /**
     * Método para obtener la contraseña para la autenticación.
     */
    public function getAuthPassword()
    {
        return $this->contrasenia_usuario;
    }
}