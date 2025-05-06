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
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShipmentResource extends Resource
{
    protected static ?string $model = Shipment::class;
    protected static ?string $navigationLabel = 'Envíos';
    protected static ?string $label = 'Envío';
    protected static ?string $pluralLabel = 'Envíos';
    protected static ?string $slug = 'envios';
    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $recordTitleAttribute = 'tracking_number';

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
                    Step::make('Info General')
                        ->schema([
                            Select::make('service_type')
                                ->label('Tipo de servicio')
                                ->options([
                                    'agency_to_agency' => 'Agencia a Agencia',
                                    'agency_to_door' => 'Agencia a Puerta',
                                    'door_to_door' => 'Puerta a Puerta',
                                    'door_to_agency' => 'Puerta a Agencia',
                                ])
                                ->native(false)
                                ->reactive()
                                ->required(),

                            Select::make('payment_method')
                                ->label('Método de pago')
                                ->options([
                                    'efectivo' => 'Efectivo',
                                    'crédito' => 'Crédito',
                                    'transferencia bancaria' => 'Transferencia bancaria',
                                    'qr' => 'Código QR',
                                    'tarjeta débito' => 'Tarjeta de débito',
                                    'tarjeta crédito' => 'Tarjeta de crédito',
                                    'contra entrega' => 'Contra entrega',

                                ])
                                ->searchable()
                                ->native(false)
                                ->reactive()
                                ->required(),

                            Select::make('sender_id')
                                ->label('Remitente')
                                ->relationship('sender', 'full_name')
                                ->searchable([
                                    'full_name',
                                    'document',
                                ])
                                ->searchPrompt('Buscar por nombre o documento')
                                ->searchDebounce(500)
                                ->preload()
                                ->native(false)
                                ->required()
                                ->reactive(),

                            Select::make('receiver_id')
                                ->label('Destinatario')
                                ->relationship('receiver', 'full_name')
                                ->searchable([
                                    'full_name',
                                    'document',
                                ])
                                ->searchPrompt('Buscar por nombre o documento')
                                ->searchDebounce(500)
                                ->preload()
                                ->native(false)
                                ->required()
                                ->reactive(),

                            Select::make('driver_id')
                                ->label('Conductor')
                                ->relationship('driver', 'ci')
                                ->options(function () {
                                    return Driver::with('user')->get()->pluck('user.name', 'id');
                                })
                                ->searchable()
                                ->preload()
                                ->native(false),

                            Select::make('status')
                                ->label('Estado')
                                ->options([
                                    'pending' => 'Pendiente',
                                    'in_transit' => 'En tránsito',
                                    'delivered' => 'Entregado',
                                    'cancelled' => 'Cancelado',
                                ])
                                ->searchable()
                                ->preload()
                                ->native(false)
                                ->default('pending')
                                ->hiddenOn('create')
                                ->required(),
                            Textarea::make('notes')
                                ->label('Notas')
                                ->placeholder('Máximo 500 caracteres')
                                ->rows(3)
                                ->maxLength(500)
                                ->rows(1),
                        ])->columns(2),
                    Step::make('Origen y Destino')
                        ->schema([
                            Select::make('origin_agency_id')
                                ->label('Agencia de origen')
                                ->relationship('origin_agency', 'name')
                                ->searchable()
                                ->preload()
                                ->native(false)
                                ->required()
                                ->visible(
                                    fn($get) =>
                                    $get('service_type') === 'agency_to_agency' ||
                                        $get('service_type') === 'agency_to_door'
                                ),

                            Select::make('destination_agency_id')
                                ->label('Agencia de destino')
                                ->relationship('destination_agency', 'name')
                                ->searchable()
                                ->preload()
                                ->native(false)
                                ->required()
                                ->visible(
                                    fn($get) =>
                                    $get('service_type') === 'agency_to_agency' ||
                                        $get('service_type') === 'door_to_agency'
                                ),

                            Select::make('pickup_address_id')
                                ->label('Dirección de origen')
                                ->relationship('pickupAddress', 'address')
                                ->options(
                                    fn($get) => Address::with('city')
                                        ->where('customer_id', $get('sender_id'))
                                        ->get()
                                        ->mapWithKeys(fn($address) => [
                                            $address->id => $address->address . ' - ' . $address->city->name
                                        ])
                                )
                                ->searchable()
                                ->preload()
                                ->native(false)
                                ->required()
                                ->visible(
                                    fn($get) =>
                                    $get('service_type') === 'door_to_door' ||
                                        $get('service_type') === 'door_to_agency'
                                ),


                            Select::make('delivery_address_id')
                                ->label('Dirección de destino')
                                ->relationship('deliveryAddress', 'address')
                                ->options(
                                    fn($get) => Address::with('city')
                                        ->where('customer_id', $get('receiver_id'))
                                        ->get()
                                        ->mapWithKeys(fn($address) => [
                                            $address->id => $address->address . ' - ' . $address->city->name
                                        ])
                                )
                                ->searchable()
                                ->preload()
                                ->native(false)
                                ->required()
                                ->visible(
                                    fn($get) =>
                                    $get('service_type') === 'door_to_door' ||
                                        $get('service_type') === 'agency_to_door'
                                ),

                        ])->columns(2),
                    Step::make('Productos')
                        ->schema([
                            Repeater::make('items')
                                ->relationship('items')
                                ->label('Productos')
                                ->schema([
                                    Select::make('product_type_id')
                                        ->label('Producto')
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
                                        ->preload()
                                        ->native(false)
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
                                                } else {
                                                    $set('unit_price', null);
                                                    $set('total_price', null);
                                                }
                                            }
                                        }),


                                    TextInput::make('quantity')
                                        ->label('Cantidad')
                                        ->integer()
                                        ->default(1)
                                        ->minValue(1)
                                        ->maxValue(1000)
                                        ->reactive()
                                        ->required()
                                        ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                            $unitPrice = $get('unit_price');
                                            if ($unitPrice) {
                                                $set('total_price', $unitPrice * $state);
                                            }
                                        }),

                                    TextInput::make('unit_price')
                                        ->label('Precio unitario')
                                        ->default(0)
                                        ->minValue(0)
                                        ->maxValue(10000000)
                                        ->prefix('Gs. ')
                                        ->integer()
                                        ->readOnly(),

                                    TextInput::make('total_price')
                                        ->label('Subtotal')
                                        ->default(0)
                                        ->minValue(0)
                                        ->maxValue(10000000)
                                        ->prefix('Gs. ')
                                        ->integer()
                                        ->readOnly(),
                                ])
                                ->defaultItems(1)
                                ->minItems(1)
                                ->columns(4),
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
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('tracking_number')
                    ->label('Tracking')
                    ->searchable()
                    ->copyable()
                    ->sortable(),
                TextColumn::make('sender.full_name')
                    ->label('Remitente')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('receiver.full_name')
                    ->label('Destinatario')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('service_type')
                    ->label('Tipo de servicio')
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
                    ->sortable(),
                SelectColumn::make('status')
                    ->label('Estado')
                    ->options([
                        'pending' => 'Pendiente',
                        'in_transit' => 'En tránsito',
                        'delivered' => 'Entregado',
                        'cancelled' => 'Cancelado',
                    ])
                    ->sortable(),

                TextColumn::make('driver.user.name')
                    ->label('Conductor')
                    ->formatStateUsing(fn($state, $record) => $state . ' (' . $record->driver->ci . ')')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Actualizado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Estado')
                    ->multiple()
                    ->options([
                        'pending' => 'Pendiente',
                        'in_transit' => 'En tránsito',
                        'delivered' => 'Entregado',
                        'cancelled' => 'Cancelado',
                    ])
                    ->native(false),
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
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')
                            ->label('Creados desde')
                            ->format('d/m/Y')
                            ->displayFormat('d/m/Y')
                            ->native(false)
                            ->closeOnDateSelection(),
                        DatePicker::make('created_until')
                            ->label('Creados hasta')
                            ->format('d/m/Y')
                            ->displayFormat('d/m/Y')
                            ->native(false)
                            ->closeOnDateSelection(),
                    ])
                    ->columns(2)
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('ticket')
                    ->label('Ticket')
                    ->icon('heroicon-o-printer')
                    ->url(fn(Shipment $record) => route('shipments.ticket', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('labels')
                    ->label('Etiquetas')
                    ->icon('heroicon-o-printer')
                    ->color('primary')
                    ->url(fn($record) => route('shipments.labels', $record)) // Usamos una ruta
                    ->openUrlInNewTab(), // Esto hace que abra en nueva pestaña
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
