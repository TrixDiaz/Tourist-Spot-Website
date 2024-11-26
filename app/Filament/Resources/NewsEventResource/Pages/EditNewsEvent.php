<?php

namespace App\Filament\Resources\NewsEventResource\Pages;

use App\Filament\Resources\NewsEventResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNewsEvent extends EditRecord
{
    protected static string $resource = NewsEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
