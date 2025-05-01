<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgencyResource\Pages;
use App\Filament\Resources\AgencyResource\RelationManagers;
use App\Models\Agency;
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

class AgencyResource extends Resource
{
    protected static ?string $model = Agency::class;
    protected static ?string $navigationLabel = 'Agencias';
    protected static ?string $label = 'Agencia';
    protected static ?string $pluralLabel = 'Agencias';
    protected static ?string $slug = 'agencias';
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nombre')
                    ->autoFocus()
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
                    ->maxLength(100),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('address')
                    ->label('Dirección')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('city.name')
                    ->label('Ciudad')
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
            'index' => Pages\ManageAgencies::route('/'),
        ];
    }
}
