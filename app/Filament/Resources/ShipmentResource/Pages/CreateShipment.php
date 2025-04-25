<?php

namespace App\Filament\Resources\ShipmentResource\Pages;

use App\Filament\Resources\ShipmentResource;
use App\Models\Shipment;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateShipment extends CreateRecord
{
    protected static string $resource = ShipmentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();

        do {
            $tracking = 'REM' . mt_rand(100000, 999999);
        } while (Shipment::where('tracking_number', $tracking)->exists());
        
        $data['tracking_number'] = $tracking;

        return $data;
    }
}
