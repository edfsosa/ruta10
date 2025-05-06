<?php

namespace App\Filament\Resources\ShipmentResource\Pages;

use App\Filament\Resources\ShipmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageShipments extends ManageRecords
{
    protected static string $resource = ShipmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('tracking')
                ->label('Tracking')
                ->url(route('tracking.form'))
                ->openUrlInNewTab()
                ->icon('heroicon-o-magnifying-glass')
                ->color('primary'),
        ];
    }
}
