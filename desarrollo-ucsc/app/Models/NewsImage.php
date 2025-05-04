<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsImage extends Model
{
    use HasFactory;

    protected $table = 'news_images';
    protected $primaryKey = 'id_imagen';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['id_noticia', 'image_path'];

    public function news()
    {
        return $this->belongsTo(News::class, 'id_noticia', 'id_noticia');
    }
}
