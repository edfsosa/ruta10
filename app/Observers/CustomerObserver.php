<?php

namespace App\Observers;

use App\Models\Customer;

class CustomerObserver
{
    /**
     * Handle the Customer "created" event.
     */
    public function created(Customer $customer): void
    {
        $customer->full_name = $customer->type === 'individual'
            ? trim("{$customer->first_name} {$customer->last_name}")
            : $customer->company_name;
        $customer->saveQuietly();
    }

    /**
     * Handle the Customer "updated" event.
     */
    public function updated(Customer $customer): void
    {
        $customer->full_name = $customer->type === 'individual'
            ? trim("{$customer->first_name} {$customer->last_name}")
            : $customer->company_name;
        $customer->saveQuietly();
    }

    /**
     * Handle the Customer "deleted" event.
     */
    public function deleted(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "restored" event.
     */
    public function restored(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "force deleted" event.
     */
    public function forceDeleted(Customer $customer): void
    {
        //
    }
}
