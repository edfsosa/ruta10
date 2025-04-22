<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShipmentResource\Pages;
use App\Filament\Resources\ShipmentResource\RelationManagers;
use App\Models\Shipment;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShipmentResource extends Resource
{
    protected static ?string $model = Shipment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Basic Info')
                    ->schema([
                        TextInput::make('tracking_number')
                            ->readOnly()
                            ->hiddenOn('create')
                            ->required(),

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

                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'in_transit' => 'In Transit',
                                'delivered' => 'Delivered',
                                'cancelled' => 'Cancelled',
                            ])
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->default('pending')
                            ->hiddenOn('create')
                            ->required(),
                    ]),

                Section::make('Sender & Receiver')
                    ->schema([
                        Select::make('sender_id')
                            ->relationship('sender', 'document')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required()
                            ->label('Sender'),

                        Select::make('receiver_id')
                            ->relationship('receiver', 'document')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required()
                            ->label('Receiver'),
                    ]),

                Section::make('Logistics')
                    ->schema([
                        Select::make('origin_agency_id')
                            ->relationship('origin_agency', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required(),

                        Select::make('destination_agency_id')
                            ->relationship('destination_agency', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->required(),

                        Select::make('pickup_address_id')
                            ->relationship('pickup_address', 'address')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->label('Pickup Address'),

                        Select::make('delivery_address_id')
                            ->relationship('delivery_address', 'address')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->label('Delivery Address'),
                        Textarea::make('notes')
                            ->maxLength(1000)
                            ->columnSpanFull()
                            ->rows(3),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tracking_number')
                    ->label('Tracking #')
                    ->searchable()
                    ->copyable()
                    ->sortable(),
                TextColumn::make('sender.document')
                    ->label('Sender')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('receiver.document')
                    ->label('Receiver')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('service_type')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'agency_to_agency' => 'primary',
                        'door_to_door' => 'info',
                        'agency_to_door', 'door_to_agency' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        'pending' => 'gray',
                        'in_transit' => 'warning',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                    }),

                TextColumn::make('created_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\HistoriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShipments::route('/'),
            'create' => Pages\CreateShipment::route('/create'),
            'edit' => Pages\EditShipment::route('/{record}/edit'),
        ];
    }
}
