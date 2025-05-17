<?php

namespace App\Providers;

use App\Models\Agency;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Price;
use App\Models\ProductType;
use App\Models\Shipment;
use App\Models\ShipmentItem;
use App\Models\User;
use App\Observers\CustomerObserver;
use App\Observers\ShipmentItemObserver;
use App\Observers\ShipmentStatusObserver;
use App\Policies\AgencyPolicy;
use App\Policies\CustomerPolicy;
use App\Policies\DriverPolicy;
use App\Policies\PricePolicy;
use App\Policies\ProductTypePolicy;
use App\Policies\RolePolicy;
use App\Policies\ShipmentPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Models\Role;

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

        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(Permission::class, RolePolicy::class);
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Driver::class, DriverPolicy::class);
        Gate::policy(Agency::class, AgencyPolicy::class);
        Gate::policy(Customer::class, CustomerPolicy::class);
        Gate::policy(Price::class, PricePolicy::class);
        Gate::policy(ProductType::class, ProductTypePolicy::class);
        Gate::policy(Shipment::class, ShipmentPolicy::class);
    }
}
