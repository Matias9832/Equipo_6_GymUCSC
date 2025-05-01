<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoSancion extends Model
{   
    protected $table = 'tipos_sancion';
    
    protected $primaryKey = 'id_tipo_sancion';

    public $timestamps = false;    

    protected $fillable = ['nombre_tipo_sancion', 'descripcion_tipo_sancion'];

    public function getRouteKeyName()
    {
        return 'id_tipo_sancion';
    }
}

