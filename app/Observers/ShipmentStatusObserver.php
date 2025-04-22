<?php

namespace App\Observers;

use App\Models\Shipment;
use App\Models\ShipmentHistory;
use Illuminate\Support\Facades\Auth;

class ShipmentStatusObserver
{
    /**
     * Handle the Shipment "created" event.
     */
    public function created(Shipment $shipment): void
    {
        //
    }

    /**
     * Handle the Shipment "updated" event.
     */
    public function updated(Shipment $shipment): void
    {
        if ($shipment->isDirty('status')) {
            ShipmentHistory::create([
                'shipment_id' => $shipment->id,
                'status' => $shipment->status,
                'changed_by' => Auth::id(),
            ]);
        }
    }

    /**
     * Handle the Shipment "deleted" event.
     */
    public function deleted(Shipment $shipment): void
    {
        //
    }

    /**
     * Handle the Shipment "restored" event.
     */
    public function restored(Shipment $shipment): void
    {
        //
    }

    /**
     * Handle the Shipment "force deleted" event.
     */
    public function forceDeleted(Shipment $shipment): void
    {
        //
    }
}
