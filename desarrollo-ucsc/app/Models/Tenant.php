<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    public function temaTenant()
    {
        return $this->hasOne(\App\Models\Tenants\TemaTenant::class, 'tenant_id', 'id');
    }
    public function empresa()
    {
        return $this->belongsTo(\App\Models\Tenants\Empresa::class);
    }
}