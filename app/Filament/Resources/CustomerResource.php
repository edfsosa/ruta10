<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;
    protected static ?string $navigationLabel = 'Clientes';
    protected static ?string $label = 'Cliente';
    protected static ?string $pluralLabel = 'Clientes';
    protected static ?string $slug = 'clientes';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Datos Generales')
                    ->columns(2)
                    ->description('Los datos generales son necesarios para la creación de un cliente.')
                    ->schema([
                        Radio::make('type')
                            ->label('Tipo')
                            ->options([
                                'individual' => 'Individual',
                                'company' => 'Empresa',
                            ])
                            ->default('individual')
                            ->inline()
                            ->inlineLabel(false)
                            ->required()
                            ->reactive(),
                        TextInput::make('first_name')
                            ->label('Nombre(s)')
                            ->maxLength(100)
                            ->visible(fn($get) => $get('type') === 'individual')
                            ->required(),
                        TextInput::make('last_name')
                            ->label('Apellido(s)')
                            ->maxLength(100)
                            ->visible(fn($get) => $get('type') === 'individual')
                            ->required(),
                        TextInput::make('company_name')
                            ->label('Nombre de la Empresa')
                            ->maxLength(100)
                            ->visible(fn($get) => $get('type') === 'company')
                            ->required(),
                        TextInput::make('document')
                            ->label('Número de Documento')
                            ->label(fn($get) => $get('type') === 'company' ? 'RUC' : 'C.I.')
                            ->minValue(1)
                            ->maxLength(12)
                            ->required(),
                        TextInput::make('phone')
                            ->label('Teléfono')
                            ->tel()
                            ->prefix('+595')
                            ->minLength(7)
                            ->maxLength(20)
                            ->required(),
                        TextInput::make('email')
                            ->label('Correo Electrónico')
                            ->email()
                            ->maxLength(100)
                            ->required(),
                    ]),
                Section::make('Direcciones')
                    ->description('Las direcciones son necesarias para el retiro y envio de productos.')
                    ->schema([
                        Repeater::make('addresses')
                            ->label('Direcciones')
                            ->relationship()
                            ->schema([
                                TextInput::make('label')
                                    ->label('Etiqueta')
                                    ->placeholder('Casa, Oficina, etc.')
                                    ->maxLength(100)
                                    ->required(),
                                TextInput::make('address')
                                    ->label('Dirección')
                                    ->maxLength(255)
                                    ->required(),
                                Select::make('city_id')
                                    ->label('Ciudad')
                                    ->relationship('city', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->live()
                                    ->native(false)
                                    ->required(),
                                Toggle::make('is_default')
                                    ->label('Dirección por defecto')
                                    ->inline(false)
                                    ->default(false)
                                    ->required(),
                            ])
                            ->columns(2)
                            ->defaultItems(1)
                            ->collapsible()
                            ->addActionLabel('Agregar dirección'),
                    ])
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
                TextColumn::make('type')
                    ->label('Tipo')
                    ->sortable()
                    ->searchable()->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'individual' => 'success',
                        'company' => 'primary',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'individual' => 'Individual',
                        'company' => 'Empresa',
                    }),
                TextColumn::make('full_name')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('document')
                    ->label('Documento')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Teléfono')
                    ->sortable()
                    ->searchable()
                    ->prefix('+595'),
                TextColumn::make('email')
                    ->label('Correo Electrónico')
                    ->sortable()
                    ->searchable(),
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
                SelectFilter::make('type')
                    ->label('Tipo')
                    ->options([
                        'individual' => 'Individual',
                        'company' => 'Empresa',
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
                Tables\Actions\DeleteAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
