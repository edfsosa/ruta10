<?php

namespace App\Observers;

use App\Models\ShipmentItem;
use App\Models\ShipmentItemBarcode;

class ShipmentItemObserver
{
    /**
     * Handle the ShipmentItem "created" event.
     */
    public function created(ShipmentItem $item): void
    {
        // Genera un código por cada unidad
        for ($i = 1; $i <= $item->quantity; $i++) {
            ShipmentItemBarcode::create([
                'shipment_item_id' => $item->id,
                'barcode'          => "{$item->id}-{$item->shipment->tracking_number}-{$i}",
            ]);
        }
    }

    public function updated(ShipmentItem $item): void
    {
        // Si el usuario cambia quantity, puedes regenerar:
        if ($item->isDirty('quantity')) {
            // Borrar los anteriores
            $item->barcodes()->delete();
            // Volver a generar
            for ($i = 1; $i <= $item->quantity; $i++) {
                ShipmentItemBarcode::create([
                    'shipment_item_id' => $item->id,
                    'barcode'          => "{$item->id}-{$item->shipment->tracking_number}-{$i}",
                ]);
            }
        }
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
