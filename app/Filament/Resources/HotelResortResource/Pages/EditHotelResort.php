<?php

namespace App\Filament\Resources\HotelResortResource\Pages;

use App\Filament\Resources\HotelResortResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHotelResort extends EditRecord
{
    protected static string $resource = HotelResortResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
