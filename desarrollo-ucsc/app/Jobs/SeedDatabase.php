<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

class SeedDatabase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tenant;

    public function __construct($tenant)
    {
        $this->tenant = $tenant;
    }

    public function handle()
    {
        // Inicializa tenancy con el tenant recibido
        tenancy()->initialize($this->tenant);

        Artisan::call('db:seed', [
            '--class' => 'Database\\Seeders\\TenantDatabaseSeeder',
            '--force' => true,
        ]);

        tenancy()->end();
    }
}
