<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news'; 

    protected $primaryKey = 'id_noticia';
    public $incrementing = true; 
    protected $keyType = 'int' ;

    public $timestamps = false; 

    protected $fillable = [
        
        'nombre_noticia',
        'encargado_noticia',
        'descripcion_noticia',
        'fecha_noticia',
        'tipo_deporte',
        'id_admin',
    ];

    public function administrador()
    {
        return $this->belongsTo(Administrador::class, 'id_admin');
    }

    public function images()
{
    return $this->hasMany(NewsImage::class, 'id_noticia', 'id_noticia');
}

}