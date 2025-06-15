<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademySetting extends Model
{
    use HasFactory;
    protected $table = 'academy_settings'; 

    protected $primaryKey = 'id'; 

    public $timestamps = true; 

    protected $fillable = ['banner_image_path', 'banner_title', 'banner_subtitle'];
}
