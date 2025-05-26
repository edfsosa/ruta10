<?php

use App\Http\Controllers\ShipmentLabelController;
use App\Http\Controllers\ShipmentTicketController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

Route::get('/shipments/{shipment}/labels', [ShipmentLabelController::class, 'show'])->name('shipments.labels');
Route::get('/shipments/{shipment}/ticket', [ShipmentTicketController::class, 'generate'])->name('shipments.ticket');

Route::get('/tracking', [TrackingController::class, 'showForm'])->name('tracking.form');
Route::post('/tracking', [TrackingController::class, 'track'])->name('tracking.track');
