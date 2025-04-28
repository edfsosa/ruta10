<?php

namespace App\Filament\Resources\ShipmentResource\Pages;

use App\Filament\Resources\ShipmentResource;
use App\Models\Shipment;
use Filament\Actions;
use Filament\Notifications\Notification;
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

    protected function getCreatedNotification(): ?Notification
    {
        $url = route('shipments.ticket', $this->record);

        return Notification::make()
            ->success()
            ->title('¡Envío creado exitosamente!')
            ->body('El envío fue creado. Puede imprimir el ticket si lo desea.')
            ->actions([
                \Filament\Notifications\Actions\Action::make('Imprimir Ticket')
                    ->button()
                    ->url($url, shouldOpenInNewTab: true),
            ]);
    }
}
