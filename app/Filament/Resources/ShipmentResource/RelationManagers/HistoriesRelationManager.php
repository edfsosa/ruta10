<?php

namespace App\Filament\Resources\ShipmentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HistoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'histories';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('status')
            ->columns([
                TextColumn::make('status')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'pending' => 'gray',
                        'in_transit' => 'warning',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Changed By')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                
            ])
            ->actions([
                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
