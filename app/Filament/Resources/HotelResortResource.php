<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HotelResortResource\Pages;
use App\Models\HotelResort;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HotelResortResource extends Resource implements HasShieldPermissions
{
    public static function getPermissionPrefixes(): array
    {
        return [
            'view_any',
            'view',
            'create',
            'update',
            'delete',
        ];
    }

    protected static ?string $navigationGroup = 'Hotel & Resort';

    protected static ?string $navigationLabel = 'Hotel & Resort';

    protected static ?string $model = HotelResort::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\Section::make()->schema([
                        Map::make('location')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                if (is_array($state)) {
                                    $set('lat', $state['lat']);
                                    $set('lng', $state['lng']);
                                }
                            })
                            ->autocomplete(
                                fieldName: 'address',
                                types: ['address'],
                                placeField: 'name',
                                countries: ['PH'],
                            )
                            ->height(fn() => '400px')
                            ->reverseGeocode([
                                'city' => '%L',
                                'zip' => '%z',
                                'state' => '%A1',
                                'street' => '%n %S',
                            ])
                            ->defaultLocation([14.599512, 120.984222])
                            ->columnSpanFull(),
                    ]),
                    Forms\Components\Section::make('Hotel & Resort Information')->schema([
                        Geocomplete::make('location')
                            ->isLocation()
                            ->countries(['PH'])
                            ->reverseGeocode([
                                'city' => '%L',
                                'zip' => '%z',
                                'state' => '%A1',
                                'street' => '%n %S',
                            ])
                            ->placeholder('Start typing an address ...')
                            ->reactive()
                            ->default(fn($record) => $record->address ?? null)
                            ->afterStateUpdated(function ($state, callable $set) {
                                if (is_array($state)) {
                                    if (isset($state['formatted_address'])) {
                                        $set('address', $state['formatted_address']);
                                    }
                                    if (isset($state['lat'])) {
                                        $set('lat', $state['lat']);
                                    }
                                    if (isset($state['lng'])) {
                                        $set('lng', $state['lng']);
                                    }
                                }
                            }),
                        Forms\Components\TextInput::make('address')
                            ->required()
                            ->readOnly(),
                        Forms\Components\Select::make('restaurant_id')
                            ->relationship('restaurant', 'name')
                            ->searchable()
                            ->preload()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('accommodation')
                            ->required(),
                        Forms\Components\TextInput::make('amenities')
                            ->required(),
                        Forms\Components\TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('₱'),
                        Forms\Components\Select::make('type')
                            ->options(HotelResort::TYPE_OPTIONS)
                            ->native(false)
                            ->required(),
                    ])->columns(2),

                ])->columnSpan([
                    'sm' => 3,
                    'md' => 3,
                    'lg' => 2
                ]),
                Forms\Components\Grid::make(1)->schema([
                    Forms\Components\Section::make('Visibility')->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Publish')
                            ->required()
                            ->default(false),
                    ])->visible(fn(): bool => auth()->user()->hasRole(1)),
                    Forms\Components\Section::make('Resort Images')->schema([
                        Forms\Components\FileUpload::make('images')
                            ->required()
                            ->multiple(),
                    ])->collapsible(),
                    Forms\Components\Section::make()->schema([
                        Forms\Components\TextInput::make('lat')
                            ->required()
                            ->numeric()
                            ->reactive()
                            ->readOnly(),
                        Forms\Components\TextInput::make('lng')
                            ->required()
                            ->numeric()
                            ->reactive()
                            ->readOnly(),
                    ]),
                    Forms\Components\Section::make()->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Created at')
                            ->hiddenOn('create')
                            ->content(function (\Illuminate\Database\Eloquent\Model $record): string {
                                $category = HotelResort::find($record->id);
                                $now = \Carbon\Carbon::now();

                                $diff = $category->created_at->diff($now);
                                if ($diff->y > 0) {
                                    return $diff->y . ' years ago';
                                } elseif ($diff->m > 0) {
                                    if ($diff->m == 1) {
                                        return '1 month ago';
                                    } else {
                                        return $diff->m . ' months ago';
                                    }
                                } elseif ($diff->d >= 7) {
                                    $weeks = floor($diff->d / 7);
                                    if ($weeks == 1) {
                                        return 'a week ago';
                                    } else {
                                        return $weeks . ' weeks ago';
                                    }
                                } elseif ($diff->d > 0) {
                                    if ($diff->d == 1) {
                                        return 'yesterday';
                                    } else {
                                        return $diff->d . ' days ago';
                                    }
                                } elseif ($diff->h > 0) {
                                    if ($diff->h == 1) {
                                        return '1 hour ago';
                                    } else {
                                        return $diff->h . ' hours ago';
                                    }
                                } elseif ($diff->i > 0) {
                                    if ($diff->i == 1) {
                                        return '1 minute ago';
                                    } else {
                                        return $diff->i . ' minutes ago';
                                    }
                                } elseif ($diff->s > 0) {
                                    if ($diff->s == 1) {
                                        return '1 second ago';
                                    } else {
                                        return $diff->s . ' seconds ago';
                                    }
                                } else {
                                    return 'just now';
                                }
                            }),
                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(function (\Illuminate\Database\Eloquent\Model $record): string {
                                $category = HotelResort::find($record->id);
                                $now = \Carbon\Carbon::now();

                                $diff = $category->updated_at->diff($now);
                                if ($diff->y > 0) {
                                    return $diff->y . ' years ago';
                                } elseif ($diff->m > 0) {
                                    if ($diff->m == 1) {
                                        return '1 month ago';
                                    } else {
                                        return $diff->m . ' months ago';
                                    }
                                } elseif ($diff->d >= 7) {
                                    $weeks = floor($diff->d / 7);
                                    if ($weeks == 1) {
                                        return 'a week ago';
                                    } else {
                                        return $weeks . ' weeks ago';
                                    }
                                } elseif ($diff->d > 0) {
                                    if ($diff->d == 1) {
                                        return 'yesterday';
                                    } else {
                                        return $diff->d . ' days ago';
                                    }
                                } elseif ($diff->h > 0) {
                                    if ($diff->h == 1) {
                                        return '1 hour ago';
                                    } else {
                                        return $diff->h . ' hours ago';
                                    }
                                } elseif ($diff->i > 0) {
                                    if ($diff->i == 1) {
                                        return '1 minute ago';
                                    } else {
                                        return $diff->i . ' minutes ago';
                                    }
                                } elseif ($diff->s > 0) {
                                    if ($diff->s == 1) {
                                        return '1 second ago';
                                    } else {
                                        return $diff->s . ' seconds ago';
                                    }
                                } else {
                                    return 'just now';
                                }
                            }),
                    ])->hiddenOn('create'),
                ])->columnSpan([
                    'sm' => 3,
                    'md' => 3,
                    'lg' => 1
                ])
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
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
