<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuienesSomosSetting extends Model
{
    use HasFactory;
    protected $table = 'quienes_somos_settings'; // Asegúrate de crear esta tabla

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = ['banner_image_path', 'banner_title', 'banner_subtitle'];
}