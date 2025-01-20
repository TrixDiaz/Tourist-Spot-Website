<?php

namespace App\Filament\Resources\HotelResortResource\Pages;

use App\Filament\Resources\HotelResortResource;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditHotelResort extends EditRecord
{
    protected static string $resource = HotelResortResource::class;

    protected function getSavedNotification(): ?Notification
    {
        $record = $this->getRecord();

        $notification = Notification::make()
            ->success()
            ->icon('heroicon-o-bell-alert')
            ->title('Hotel Resort Updated')
            ->body("Hotel Resort {$record->name} Updated!");

        // Get all users with the 'super_admin' or 'admin' role
        $notifiedUsers = User::role([1,2])->get();

        // Send notification to all panel users and accountants
        foreach ($notifiedUsers as $user) {
            $notification->sendToDatabase($user);
        }

        // Send notification to the authenticated user
        $notification->sendToDatabase(auth()->user());

        return $notification;
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
