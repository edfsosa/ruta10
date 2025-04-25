<?php

namespace App\Observers;

use App\Models\ShipmentItem;

class ShipmentItemObserver
{
    /**
     * Handle the ShipmentItem "created" event.
     */
    public function created(ShipmentItem $shipmentItem): void
    {
        // Generamos el barcode usando el ID del item y el tracking_number del Shipment
        $shipmentItem->barcode = $shipmentItem->id . '-' . $shipmentItem->shipment->tracking_number;
        $shipmentItem->saveQuietly(); // Importante: usar saveQuietly para evitar loops de observers
    }

    /**
     * Handle the ShipmentItem "updated" event.
     */
    public function updated(ShipmentItem $shipmentItem): void
    {
        //
    }

    /**
     * Handle the ShipmentItem "deleted" event.
     */
    public function deleted(ShipmentItem $shipmentItem): void
    {
        //
    }

    /**
     * Handle the ShipmentItem "restored" event.
     */
    public function restored(ShipmentItem $shipmentItem): void
    {
        //
    }

    /**
     * Handle the ShipmentItem "force deleted" event.
     */
    public function forceDeleted(ShipmentItem $shipmentItem): void
    {
        //
    }
}
