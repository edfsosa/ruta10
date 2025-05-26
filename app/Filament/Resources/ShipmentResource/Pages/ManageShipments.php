<?php

namespace App\Filament\Resources\ShipmentResource\Pages;

use App\Filament\Resources\ShipmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

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
            ExportAction::make()
                ->exports([
                    ExcelExport::make()
                        ->fromTable()
                        ->except([
                            'created_at',
                            'updated_at',
                        ])
                        ->withFilename('envios')
                ])
                ->label('Exportar')
                ->color('primary'),
        ];
    }
}
