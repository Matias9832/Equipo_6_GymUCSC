<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalleresImg extends Model
{
    use HasFactory;

    protected $table = 'talleresimg';
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
    public function talleresnews()
    {
        return $this->belongsTo(TalleresNews::class, 'id_noticia', 'id_noticia');
    }
}