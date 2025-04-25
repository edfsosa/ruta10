<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShipmentResource\Pages;
use App\Models\Address;
use App\Models\Agency;
use App\Models\Driver;
use App\Models\Price;
use App\Models\ProductType;
use App\Models\Shipment;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
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

        // Funciones auxiliares
        $getFromCityId = function ($get) {
            $type = $get('../../service_type');
            if (in_array($type, ['agency_to_agency', 'agency_to_door'])) {
                $agencyId = $get('../../origin_agency_id');
                return Agency::find($agencyId)?->city_id;
            } else {
                $pickupId = $get('../../pickup_address_id');
                return Address::find($pickupId)?->city_id;
            }
        };

        $getToCityId = function ($get) {
            $type = $get('../../service_type');
            if (in_array($type, ['agency_to_agency', 'door_to_agency'])) {
                $agencyId = $get('../../destination_agency_id');
                return Agency::find($agencyId)?->city_id;
            } else {
                $deliveryId = $get('../../delivery_address_id');
                return Address::find($deliveryId)?->city_id;
            }
        };

        return $form
            ->schema([
                Wizard::make([
                    Step::make('Basic Info')
                        ->schema([
                            Select::make('service_type')
                                ->options([
                                    'agency_to_agency' => 'Agency to Agency',
                                    'agency_to_door' => 'Agency to Door',
                                    'door_to_door' => 'Door to Door',
                                    'door_to_agency' => 'Door to Agency',
                                ])
                                ->searchable()
                                ->preload()
                                ->native(false)
                                ->reactive()
                                ->required(),

                            Select::make('sender_id')
                                ->relationship('sender', 'full_name')
                                ->searchable()
                                ->preload()
                                ->native(false)
                                ->required()
                                ->label('Sender')
                                ->reactive(),

                            Select::make('receiver_id')
                                ->relationship('receiver', 'full_name')
                                ->searchable()
                                ->preload()
                                ->native(false)
                                ->required()
                                ->label('Receiver')
                                ->reactive(),

                            Select::make('driver_id')
                                ->relationship('driver')
                                ->options(function () {
                                    return Driver::with('user')->get()->pluck('user.name', 'id');
                                })
                                ->searchable()
                                ->preload()
                                ->native(false),
                        ]),
                    Step::make('Origin & Destination')
                        ->schema([
                            Select::make('origin_agency_id')
                                ->relationship('origin_agency', 'name')
                                ->searchable()
                                ->preload()
                                ->native(false)
                                ->required()
                                ->visible(fn($get) => $get('service_type') === 'agency_to_agency'
                                    or $get('service_type') === 'agency_to_door'),

                            Select::make('destination_agency_id')
                                ->relationship('destination_agency', 'name')
                                ->searchable()
                                ->preload()
                                ->native(false)
                                ->required()
                                ->visible(fn($get) => $get('service_type') === 'agency_to_agency'
                                    or $get('service_type') === 'door_to_agency'),

                            Select::make('pickup_address_id')
                                ->relationship('pickup_address', 'address')
                                ->options(fn($get) => Address::where('customer_id', $get('sender_id'))->pluck('address', 'id'))
                                ->searchable('address', 'label')
                                ->preload()
                                ->native(false)
                                ->required()
                                ->visible(fn($get) => $get('service_type') === 'door_to_door'
                                    or $get('service_type') === 'door_to_agency'),

                            Select::make('delivery_address_id')
                                ->relationship('delivery_address', 'address')
                                ->searchable()
                                ->options(fn($get) => Address::where('customer_id', $get('receiver_id'))->pluck('address', 'id'))
                                ->preload()
                                ->native(false)
                                ->required()
                                ->visible(fn($get) => $get('service_type') === 'door_to_door'
                                    or $get('service_type') === 'agency_to_door'),
                        ]),
                    Step::make('Products')->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Select::make('product_type_id')
                                    ->label('Product')
                                    ->options(function (callable $get) use ($getFromCityId, $getToCityId) {
                                        $serviceType = $get('../../service_type');
                                        $originCityId = $getFromCityId($get);
                                        $destinationCityId = $getToCityId($get);

                                        if (! $originCityId || ! $destinationCityId || ! $serviceType) {
                                            return [];
                                        }

                                        $productTypeIds = Price::where('from_city_id', $originCityId)
                                            ->where('to_city_id', $destinationCityId)
                                            ->where('service_type', $serviceType)
                                            ->pluck('product_type_id')
                                            ->unique();

                                        return ProductType::whereIn('id', $productTypeIds)->pluck('name', 'id');
                                    })
                                    ->reactive()
                                    ->searchable()
                                    ->required()
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) use ($getFromCityId, $getToCityId) {
                                        $serviceType = $get('../../service_type');
                                        $originCityId = $getFromCityId($get);
                                        $destinationCityId = $getToCityId($get);

                                        if ($state && $serviceType && $originCityId && $destinationCityId) {
                                            $unitPrice = Price::where('product_type_id', $state)
                                                ->where('service_type', $serviceType)
                                                ->where('from_city_id', $originCityId)
                                                ->where('to_city_id', $destinationCityId)
                                                ->value('price');

                                            if ($unitPrice) {
                                                $set('unit_price', $unitPrice);
                                                $set('total_price', $unitPrice * ($get('quantity') ?? 1));
                                            }
                                        }
                                    }),


                                TextInput::make('quantity')
                                    ->numeric()
                                    ->default(1)
                                    ->reactive()
                                    ->required()
                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                        $unitPrice = $get('unit_price');
                                        if ($unitPrice) {
                                            $set('total_price', $unitPrice * $state);
                                        }
                                    }),

                                TextInput::make('unit_price')
                                    ->numeric()
                                    ->readOnly(),

                                TextInput::make('total_price')
                                    ->label('Subtotal')
                                    ->numeric()
                                    ->readOnly(),
                            ])
                            ->defaultItems(1)
                            ->columns(2),
                    ]),

                    Step::make('Confirmation')->schema([

                        Textarea::make('notes')
                            ->maxLength(1000)
                            ->columnSpanFull()
                            ->rows(3),
                        Placeholder::make('total')
                            ->label('Total a pagar')
                            ->content(function ($get) {
                                $items = $get('items') ?? [];
                                $total = array_sum(array_column($items, 'total_price'));
                                return 'Gs. ' . number_format($total, 0, ',', '.');
                            })
                            ->extraAttributes(['class' => 'text-lg font-bold text-primary']),
                    ]),
                ])->columnSpanFull()



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
                TextColumn::make('sender.full_name')
                    ->label('Sender')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('receiver.full_name')
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageShipments::route('/'),
            'create' => Pages\CreateShipment::route('/create'),
        ];
    }
}
