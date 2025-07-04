<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Stancl\Tenancy\Resolvers\DomainTenantResolver;
use Stancl\Tenancy\Events\TenancyInitialized;
use Illuminate\Support\Facades\Event;
use Illuminate\Pagination\Paginator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

    public function boot()
    {
        if (tenancy()->initialized) {
            URL::forceRootUrl(request()->getSchemeAndHttpHost());
        }
        Paginator::useBootstrapFive();
    }
}
