<?php

namespace App\Filament\Resources\HotelResortResource\Pages;

use App\Filament\Resources\HotelResortResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHotelResorts extends ListRecords
{
    protected static string $resource = HotelResortResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
