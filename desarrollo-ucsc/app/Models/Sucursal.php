<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sucursal extends Model
{
    protected $table = 'sucursal';
    protected $primaryKey = 'id_suc';
    public $timestamps = false;

    protected $fillable = [
        'id_ciudad',
        'id_marca',
        'nombre_suc',
        'direccion_suc',
    ];

    // Relación con la Ciudad
    public function ciudad(): BelongsTo
    {
        return $this->belongsTo(Ciudad::class, 'id_ciudad', 'id_ciudad');
    }

    // Relación con la Marca
    public function marca(): BelongsTo
    {
        return $this->belongsTo(Marca::class, 'id_marca', 'id_marca');
    }

    public function salas()
    {
        return $this->hasMany(Sala::class, 'id_suc');
    }

}
