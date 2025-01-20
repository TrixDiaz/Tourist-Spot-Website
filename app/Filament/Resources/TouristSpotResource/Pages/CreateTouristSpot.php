<?php

namespace App\Filament\Resources\TouristSpotResource\Pages;

use App\Filament\Resources\TouristSpotResource;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateTouristSpot extends CreateRecord
{

    protected function getCreatedNotification(): ?Notification
    {
        $record = $this->getRecord();

        $notification = Notification::make()
            ->success()
            ->icon('heroicon-o-bell-alert')
            ->title('New Tourist Created')
            ->body("New Spot {$record->name} Created!");

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
    protected static string $resource = TouristSpotResource::class;
}
