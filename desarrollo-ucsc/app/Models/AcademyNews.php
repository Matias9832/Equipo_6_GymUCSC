<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademyNews extends Model
{
    use HasFactory; 

    protected $table = 'academynews';
    protected $primaryKey = 'id_noticia';
    public $timestamps = false; // no usas created_at ni updated_at

    protected $fillable = [
        'nombre_noticia',
        'encargado_noticia',
        'descripcion_noticia',
        'fecha_noticia',
        'id_admin',
        'is_featured',
        'featured_until'
    ];

    public function administrador()
    {
        return $this->belongsTo(Administrador::class, 'id_admin');
    }

    /**
     * Relación con las imágenes asociadas a la noticia
     */
    public function images()
    {
        return $this->hasMany(AcademyImg::class, 'id_noticia', 'id_noticia');
    }

}
