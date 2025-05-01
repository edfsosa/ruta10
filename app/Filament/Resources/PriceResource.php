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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PriceResource extends Resource
{
    protected static ?string $model = Price::class;
    protected static ?string $navigationLabel = 'Precios';
    protected static ?string $label = 'Precio';
    protected static ?string $pluralLabel = 'Precios';
    protected static ?string $slug = 'precios';
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('from_city_id')
                    ->label('Ciudad de Origen')
                    ->relationship('fromCity', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live()
                    ->native(false),
                Select::make('to_city_id')
                    ->label('Ciudad de Destino')
                    ->relationship('toCity', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live()
                    ->native(false),
                Select::make('product_type_id')
                    ->label('Tipo de Producto')
                    ->relationship('productType', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->live()
                    ->native(false),
                Select::make('service_type')
                    ->label('Tipo de Servicio')
                    ->options([
                        'agency_to_agency' => 'Agencia a Agencia',
                        'door_to_door' => 'Puerta a Puerta',
                        'agency_to_door' => 'Agencia a Puerta',
                        'door_to_agency' => 'Puerta a Agencia',
                    ])
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->required(),
                TextInput::make('price')
                    ->label('Precio')
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
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('fromCity.name')
                    ->label('Origen')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('toCity.name')
                    ->label('Destino')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('productType.name')
                    ->label('Producto')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('service_type')
                    ->label('Servicio')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'agency_to_agency' => 'success',
                        'door_to_door' => 'info',
                        'agency_to_door' => 'warning',
                        'door_to_agency' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn($state) => match ($state) {
                        'agency_to_agency' => 'Agencia a Agencia',
                        'door_to_door' => 'Puerta a Puerta',
                        'agency_to_door' => 'Agencia a Puerta',
                        'door_to_agency' => 'Puerta a Agencia',
                        default => 'Desconocido',
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Precio')
                    ->money('PYG')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('service_type')
                    ->label('Tipo de servicio')
                    ->multiple()
                    ->options([
                        'agency_to_agency' => 'Agencia a Agencia',
                        'door_to_door' => 'Puerta a Puerta',
                        'agency_to_door' => 'Agencia a Puerta',
                        'door_to_agency' => 'Puerta a Agencia',
                    ])
                    ->native(false),
                SelectFilter::make('from_city_id')
                    ->label('Origen')
                    ->relationship('fromCity', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->native(false),
                SelectFilter::make('to_city_id')
                    ->label('Destino')
                    ->relationship('toCity', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->native(false),
                SelectFilter::make('product_type_id')
                    ->label('Producto')
                    ->relationship('productType', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->native(false),
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
