<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsEventCategoryResource\Pages;
use App\Filament\Resources\NewsEventCategoryResource\RelationManagers;
use App\Models\NewsEventCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NewsEventCategoryResource extends Resource
{
    protected static ?string $navigationGroup = 'News & Events';

    protected static ?string $navigationLabel = 'Categories';

    protected static ?string $model = NewsEventCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('images')
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
                Tables\Columns\ImageColumn::make('images')
                    ->square()
                    ->width(150)
                    ->height(150)
                    ->label('Image')
                    ->defaultImageUrl(fn($record) => $record->images === null ? asset('https://placehold.co/600x800') : null),
                Tables\Columns\TextColumn::make('name')
                    ->description(fn($record) => $record->slug)
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->limit(10)
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
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
                TrashedFilter::make(),
                SelectFilter::make('is_active')
                    ->options([
                        true => 'Active',
                        false => 'Inactive',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make()->visible(fn($record) => $record->deleted_at !== null),
                Tables\Actions\RestoreAction::make()->visible(fn($record) => $record->deleted_at !== null),
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
            'index' => Pages\ListNewsEventCategories::route('/'),
            'create' => Pages\CreateNewsEventCategory::route('/create'),
            'edit' => Pages\EditNewsEventCategory::route('/{record}/edit'),
        ];
    }
}
