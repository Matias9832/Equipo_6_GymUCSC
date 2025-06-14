<?php

namespace App\Models\Tenants;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UsuarioTenant extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuario_tenant';
    protected $primaryKey = 'id_usuario_tenant';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'rut_usuario',
        'nombre_usuario',
        'gmail_usuario',
        'tipo_usuario_tenant',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Autenticación con Gmail
    public function getAuthIdentifierName()
    {
        return 'gmail_usuario';
    }
}
