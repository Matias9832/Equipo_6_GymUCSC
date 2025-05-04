<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\News;

class Administrador extends Model
{
    use HasFactory;

    // Nombre de la tabla asociada
    protected $table = 'administrador';

    // Clave primaria de la tabla
    protected $primaryKey = 'id_admin';

    // Deshabilitar timestamps si no usas `created_at` y `updated_at`
    public $timestamps = false;
    
    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'rut_admin',
        'nombre_admin',
        'fecha_creacion',
    ];

        public function news()
    {
        return $this->hasMany(News::class, 'id_admin');
    }


}