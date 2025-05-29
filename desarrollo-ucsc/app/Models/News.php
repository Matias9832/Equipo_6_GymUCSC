<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = 'news'; // Nombre explícito de la tabla

    protected $primaryKey = 'id_noticia'; // Clave primaria personalizada
    public $incrementing = true;
    protected $keyType = 'int';

    public $timestamps = false; // Se desactiva created_at y updated_at

    protected $fillable = [
        'nombre_noticia',
        'encargado_noticia',
        'descripcion_noticia',
        'fecha_noticia',
        'tipo_deporte',
        'id_admin',
    ];

    /**
     * Relación con el administrador que creó la noticia
     */
    public function administrador()
    {
        return $this->belongsTo(Administrador::class, 'id_admin');
    }

    /**
     * Relación con las imágenes asociadas a la noticia
     */
    public function images()
    {
        return $this->hasMany(NewsImage::class, 'id_noticia', 'id_noticia');
    }
}
