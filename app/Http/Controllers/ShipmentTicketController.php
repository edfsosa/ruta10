<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ShipmentTicketController extends Controller
{
    public function generate(Shipment $shipment)
    {
        $pdf = Pdf::loadView('pdf.shipment-ticket', compact('shipment'));

        return view('pdf.shipment-ticket', compact('shipment'));
    }
}
