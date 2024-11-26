<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HotelResortResource\Pages;
use App\Models\HotelResort;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HotelResortResource extends Resource
{
    protected static ?string $navigationGroup = 'Hotel & Resort';

    protected static ?string $navigationLabel = 'Hotel & Resort';

    protected static ?string $model = HotelResort::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('accommodation')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Forms\Components\TextInput::make('amenities')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('latitude')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('longitude')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('type')
                    ->required(),
                Forms\Components\Textarea::make('images')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->limit(10)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('accommodation')
                    ->searchable()
                    ->limit(10)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('price')
                    ->money('PHP')
                    ->sortable(),
                Tables\Columns\TextColumn::make('amenities')
                    ->searchable()
                    ->limit(10)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->extraAttributes([
                        'class' => 'capitalize',
                    ]),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options(HotelResort::TYPE_OPTIONS),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make()->visible(fn(HotelResort $record): bool => $record->trashed()),
                Tables\Actions\RestoreAction::make()->visible(fn(HotelResort $record): bool => $record->trashed()),
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
            'index' => Pages\ListHotelResorts::route('/'),
            'create' => Pages\CreateHotelResort::route('/create'),
            'edit' => Pages\EditHotelResort::route('/{record}/edit'),
        ];
    }
}
