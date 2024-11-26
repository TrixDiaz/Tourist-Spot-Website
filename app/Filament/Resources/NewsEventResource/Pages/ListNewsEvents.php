<?php

namespace App\Filament\Resources\NewsEventResource\Pages;

use App\Filament\Resources\NewsEventResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNewsEvents extends ListRecords
{
    protected static string $resource = NewsEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
