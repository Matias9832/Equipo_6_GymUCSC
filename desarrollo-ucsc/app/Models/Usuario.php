<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'usuario'; // Nombre de la tabla
    protected $primaryKey = 'id'; // Clave primaria
    protected $fillable = ['correo', 'contraseña', 'bloqueado', 'rut']; // Columnas asignables
    protected $hidden = ['contraseña']; // Ocultar la contraseña al serializar

    /**
     * Establecer el nombre del campo de contraseña para la autenticación.
     */
    public function getAuthPassword()
    {
        return $this->contraseña; // Indica que el campo de contraseña es "contraseña"
    }
}