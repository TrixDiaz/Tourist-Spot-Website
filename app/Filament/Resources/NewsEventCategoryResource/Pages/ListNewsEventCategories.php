<?php

namespace App\Filament\Resources\NewsEventCategoryResource\Pages;

use App\Filament\Resources\NewsEventCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNewsEventCategories extends ListRecords
{
    protected static string $resource = NewsEventCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
