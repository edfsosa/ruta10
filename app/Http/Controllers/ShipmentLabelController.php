<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ShipmentLabelController extends Controller
{
    public function show(Shipment $shipment)
    {
        $items = $shipment->items;

        $pdf = Pdf::loadView('pdf.shipment-labels', [
            'shipment' => $shipment,
            'items' => $items,
        ]);

        return view('pdf.shipment-labels', [
            'shipment' => $shipment,
            'items' => $items,
        ]);
    }
}
