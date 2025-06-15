<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taller extends Model
{
    use HasFactory;

    protected $table = 'talleres';
    protected $primaryKey = 'id_taller';

    protected $fillable = [
        'nombre_taller',
        'descripcion_taller',
        'cupos_taller',
        'indicaciones_taller',
        'activo_taller',
        'id_admin',
        'id_espacio',
    ];

    public function horarios()
    {
        return $this->hasMany(HorarioTaller::class, 'id_taller', 'id_taller');
    }
    public function administrador()
    {
        return $this->belongsTo(Administrador::class, 'id_admin');
    }
    public function usuarios()
    {
        return $this->belongsToMany(Usuario::class, 'taller_usuario', 'id_taller', 'id_usuario')
                    ->withPivot('fecha_asistencia')
                    ->withTimestamps();
    }
    public function espacio()
    {
        return $this->belongsTo(Espacio::class, 'id_espacio');
    }
}
