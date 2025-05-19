<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Salud;

class Usuario extends Authenticatable
{
    use HasFactory;
    use HasRoles;
    protected $guard_name = 'web';
    protected $table = 'usuario'; // Nombre de la tabla
    protected $primaryKey = 'id_usuario'; // Clave primaria
    public $incrementing = true; // Indica que la clave primaria es autoincremental
    protected $keyType = 'int'; // Tipo de dato de la clave primaria

    

    protected $attributes = [
        'bloqueado_usuario' => 0,
        'activado_usuario' => 0,
    ];

    protected $fillable = [
        'rut',
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

    public function getIsAdminAttribute()
    {
        return $this->tipo_usuario === 'admin'; // o el valor que uses para admins
    }

    public function salud()
    {
        return $this->hasOne(Salud::class, 'id_usuario', 'id_usuario');
    }

    public function equipos()
    {
        return $this->belongsToMany(Equipo::class, 'equipo_usuario', 'usuario_id', 'equipo_id');
    }

    public function alumno()
    {
        return $this->hasOne(Alumno::class, 'rut_alumno', 'rut');
    }

    public function administrador()
    {
        return $this->hasOne(Administrador::class, 'rut_admin', 'rut');
    }

}