<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Customer Information')
                    ->schema([
                        Select::make('type')
                            ->options([
                                'individual' => 'Individual',
                                'company' => 'Company',
                            ])
                            ->default('individual')
                            ->native(false)
                            ->required()
                            ->reactive(),
                        TextInput::make('first_name')
                            ->maxLength(100)
                            ->visible(fn($get) => $get('type') === 'individual')
                            ->required(),
                        TextInput::make('last_name')
                            ->maxLength(100)
                            ->visible(fn($get) => $get('type') === 'individual')
                            ->required(),
                        TextInput::make('company_name')
                            ->maxLength(100)
                            ->visible(fn($get) => $get('type') === 'company')
                            ->required(),
                        TextInput::make('document')
                            ->label(fn($get) => $get('type') === 'company' ? 'RUC' : 'C.I.')
                            ->minValue(1)
                            ->maxLength(12)
                            ->required(),
                        TextInput::make('phone')
                            ->tel()
                            ->prefix('+595')
                            ->minLength(7)
                            ->maxLength(20)
                            ->required(),
                        TextInput::make('email')
                            ->email()
                            ->maxLength(100),
                    ]),
                Section::make('Addresses')
                    ->schema([
                        Repeater::make('addresses')
                            ->relationship()
                            ->schema([
                                TextInput::make('label')
                                    ->maxLength(100)
                                    ->required(),
                                TextInput::make('address')
                                    ->maxLength(255)
                                    ->required(),
                                Select::make('city_id')
                                    ->relationship('city', 'name')
                                    ->preload()
                                    ->searchable()
                                    ->live()
                                    ->native(false)
                                    ->required(),
                                Toggle::make('is_default')
                                    ->default(false)
                                    ->required(),
                            ])
                            ->columns(2)
                            ->defaultItems(1)
                            ->collapsible(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->sortable()
                    ->searchable()->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'individual' => 'success',
                        'company' => 'primary',
                    }),
    
                TextColumn::make('full_name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('document')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('phone')
                    ->sortable()
                    ->searchable()
                    ->prefix('+595'),
                TextColumn::make('email')
                    ->sortable()
                    ->searchable(),
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
