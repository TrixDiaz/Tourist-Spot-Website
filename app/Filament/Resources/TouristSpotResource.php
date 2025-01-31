<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TouristSpotResource\Pages;
use App\Filament\Resources\TouristSpotResource\RelationManagers;
use App\Models\TouristSpot;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Cheesegrits\FilamentGoogleMaps\Fields\Geocomplete;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TouristSpotResource extends Resource implements HasShieldPermissions
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

    protected static ?string $navigationGroup = "Tourist Spots";

    protected static ?string $navigationLabel = "Tourist Spots";

    protected static ?string $model = TouristSpot::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

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
                    Forms\Components\Section::make('Tourist Spot Information')->schema([
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
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2)
                ])->columnSpan([
                    'sm' => 3,
                    'md' => 3,
                    'lg' => 2
                ]),

                Forms\Components\Grid::make(1)->schema([
                    Forms\Components\Section::make('Visibility')->schema([
                        Forms\Components\Toggle::make('popular')
                            ->label('Publish')
                            ->onColor('secondary')
                            ->offColor('danger')
                            ->onIcon('heroicon-s-star')
                            ->offIcon('heroicon-s-x-mark')
                            ->columnSpanFull(),
                    ])->visible(fn(): bool => auth()->user()->hasRole(1)),
                    Forms\Components\Section::make('Images')->schema([
                        Forms\Components\FileUpload::make('images')
                            ->disk('public')
                            ->required()
                            ->multiple()
                            ->columnSpanFull(),
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
                                $category = TouristSpot::find($record->id);
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
                                $category = TouristSpot::find($record->id);
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
                Tables\Columns\ImageColumn::make('images')
                    ->square()
                    ->width(150)
                    ->height(150)
                    ->label('Image')
                    ->defaultImageUrl(fn($record) => $record->images === null ? asset('https://placehold.co/600x800') : null),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->limit(20)
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->limit(20)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Status')
                    ->onIcon('heroicon-s-bolt')
                    ->offIcon('heroicon-s-bolt-slash')
                    ->disabled(fn() => !auth()->user()->hasRole(1)),
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
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make()->visible(fn(TouristSpot $record): bool => $record->trashed()),
                Tables\Actions\RestoreAction::make()->visible(fn(TouristSpot $record): bool => $record->trashed()),
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
            'index' => Pages\ListTouristSpots::route('/'),
            'create' => Pages\CreateTouristSpot::route('/create'),
            'edit' => Pages\EditTouristSpot::route('/{record}/edit'),
        ];
    }
}
