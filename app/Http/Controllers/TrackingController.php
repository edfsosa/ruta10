<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function showForm()
    {
        return view('tracking.form');
    }

    public function track(Request $request)
    {
        $request->validate(['tracking_number' => 'required|string']);
        $shipment = Shipment::where('tracking_number', $request->tracking_number)->first();

        if (!$shipment) {
            return back()->withErrors(['tracking_number' => 'Número de seguimiento no encontrado.']);
        }

        return view('tracking.result', ['shipment' => $shipment]);
    }
}
