<?php

use App\Http\Controllers\ShipmentLabelController;
use Illuminate\Support\Facades\Route;

Route::get('/shipments/{shipment}/labels', [ShipmentLabelController::class, 'show'])->name('shipments.labels');
