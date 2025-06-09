<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(DatabaseSeeder_tenant::class);
    }
}
