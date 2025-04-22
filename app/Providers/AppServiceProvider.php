<?php

namespace App\Providers;

use App\Models\Shipment;
use App\Observers\ShipmentObserver;
use App\Observers\ShipmentStatusObserver;
use Illuminate\Support\ServiceProvider;

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
    public function boot(): void
    {
        Shipment::observe(ShipmentStatusObserver::class);
    }
}
