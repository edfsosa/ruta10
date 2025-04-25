<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\Shipment;
use App\Models\ShipmentItem;
use App\Observers\CustomerObserver;
use App\Observers\ShipmentItemObserver;
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
        Customer::observe(CustomerObserver::class);
        ShipmentItem::observe(ShipmentItemObserver::class);
    }
}
