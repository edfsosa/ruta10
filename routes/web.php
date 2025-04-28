<?php

use App\Http\Controllers\ShipmentLabelController;
use App\Http\Controllers\ShipmentTicketController;
use Illuminate\Support\Facades\Route;

Route::get('/shipments/{shipment}/labels', [ShipmentLabelController::class, 'show'])->name('shipments.labels');

Route::get('/shipments/{shipment}/ticket', [ShipmentTicketController::class, 'generate'])
    ->name('shipments.ticket');

