<?php

namespace App\Filament\Resources\NewsEventCategoryResource\Pages;

use App\Filament\Resources\NewsEventCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNewsEventCategory extends EditRecord
{
    protected static string $resource = NewsEventCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
