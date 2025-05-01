<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DriverResource\Pages;
use App\Filament\Resources\DriverResource\RelationManagers;
use App\Models\Driver;
use App\Models\User;
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

class DriverResource extends Resource
{
    protected static ?string $model = Driver::class;
    protected static ?string $navigationLabel = 'Conductores';
    protected static ?string $label = 'Conductor';
    protected static ?string $pluralLabel = 'Conductores';
    protected static ?string $slug = 'conductores';
    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('Usuario')
                    ->autoFocus()
                    ->relationship('user', 'name')
                    ->options(fn() => User::role('Conductor')
                    ->whereDoesntHave('driver')
                    ->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->live()
                    ->native(false)
                    ->required(),
                TextInput::make('ci')
                    ->label('CI')
                    ->integer()
                    ->minValue(1)
                    ->maxLength(20)
                    ->unique(ignoreRecord: true)
                    ->required(),
                TextInput::make('phone')
                    ->label('Teléfono')
                    ->tel()
                    ->prefix('+595')
                    ->minLength(7)
                    ->maxLength(20)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('ci')
                    ->label('CI')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Teléfono')
                    ->sortable()
                    ->searchable()
                    ->prefix('+595'),
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
            'index' => Pages\ManageDrivers::route('/'),
        ];
    }
}
