<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PriceResource\Pages;
use App\Filament\Resources\PriceResource\RelationManagers;
use App\Models\Price;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PriceResource extends Resource
{
    protected static ?string $model = Price::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('from_city_id')
                    ->relationship('fromCity', 'name')
                    ->label('Origin City')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live()
                    ->native(false),
                Select::make('to_city_id')
                    ->relationship('toCity', 'name')
                    ->label('Destination City')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live()
                    ->native(false),
                Select::make('product_type_id')
                    ->relationship('productType', 'name')
                    ->label('Product Type')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live()
                    ->native(false),
                Select::make('service_type')
                    ->options([
                        'agency_to_agency' => 'Agency to Agency',
                        'door_to_door' => 'Door to Door',
                        'agency_to_door' => 'Agency to Door',
                        'door_to_agency' => 'Door to Agency',
                    ])
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->required(),
                TextInput::make('price')
                    ->integer()
                    ->minValue(1)
                    ->maxLength(20)
                    ->prefix('Gs')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fromCity.name')
                    ->label('Origin')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('toCity.name')
                    ->label('Destination')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('productType.name')
                    ->label('Product')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('service_type')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'agency_to_agency' => 'primary',
                        'door_to_door' => 'info',
                        'agency_to_door', 'door_to_agency' => 'warning',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price')
                    ->money('PYG')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePrices::route('/'),
        ];
    }
}
