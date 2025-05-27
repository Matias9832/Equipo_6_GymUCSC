<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rutina extends Model
{
    protected $table = 'rutinas';

    protected $fillable = [
        'nombre',
        'user_id',
        'creador_rut',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'user_id', 'id_usuario');
    }

    public function creador()
    {
        return $this->belongsTo(Usuario::class, 'creador_rut', 'rut');
    }

    public function ejercicios()
    {
        return $this->belongsToMany(Ejercicio::class, 'ejercicio_rutina', 'rutina_id', 'ejercicio_id')
            ->withPivot('series', 'repeticiones', 'descanso')
            ->withTimestamps();
    }
}