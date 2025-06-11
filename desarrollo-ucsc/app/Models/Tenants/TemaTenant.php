<?php

namespace App\Models\Tenants;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\CentralConnection;

class TemaTenant extends Model
{
    use HasFactory, CentralConnection;

    protected $table = 'tema_tenant';
    protected $primaryKey = 'id_tema_tenant';
    public $timestamps = true;

    protected $guarded = [];
    protected $fillable = [
        'tenant_id',
        'nombre_tema',
        'nombre_fuente',
        'familia_css',
        'url_fuente',
        'bs_primary',
        'bs_success',
        'bs_danger',
        'primary_focus',
        'border_primary_focus',
        'primary_gradient',
        'success_focus',
        'border_success_focus',
        'success_gradient',
        'danger_focus',
        'border_danger_focus',
        'danger_gradient',
    ];

    public function tenant()
    {
        return $this->belongsTo(\App\Models\Tenant::class, 'tenant_id', 'id');
    }
}
