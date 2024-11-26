<?php

namespace App\Filament\Resources\TouristSpotResource\Pages;

use App\Filament\Resources\TouristSpotResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTouristSpot extends EditRecord
{
    protected static string $resource = TouristSpotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
