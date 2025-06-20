<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsSetting extends Model
{
    use HasFactory;
    protected $table = 'news_setting'; 

    protected $primaryKey = 'id'; 

    public $timestamps = true; 

    protected $fillable = ['banner_image_path', 'banner_title', 'banner_subtitle'];
}