<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademyImg extends Model
{
    use HasFactory;

    protected $table = 'academyimg';
    protected $primaryKey = 'id_imagen';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_noticia',
        'image_path',
    ];

    /**
     * Relación inversa: esta imagen pertenece a una noticia.
     */
    public function academynews()
    {
        return $this->belongsTo(AcademyNews::class, 'id_noticia', 'id_noticia');
    }
}
