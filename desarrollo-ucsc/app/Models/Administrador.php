<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\News;
use App\Models\Sucursal;
class Administrador extends Model
{
    use HasFactory;

    protected $table = 'administrador';
    protected $primaryKey = 'id_admin';
    public $timestamps = false;
    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'rut_admin',
        'nombre_admin',
        'fecha_creacion',
        'correo_usuario',
    ];
    public function news()
    {
        return $this->hasMany(News::class, 'id_admin');
    }
    
    public function sucursales()
    {
        return $this->belongsToMany(Sucursal::class, 'admin_sucursal', 'id_admin', 'id_suc')
                    ->withPivot('activa');
    }
    public function talleres()
    {
        return $this->hasMany(Taller::class, 'id_admin', 'id_admin');
    }

}