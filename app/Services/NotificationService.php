<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\IzinAbsen;

class NotificationService
{
    public function sendNotificationAbsenToAllUsers(
        string $title,
        string $message,
        string $url
    ): void {
        $users = User::all();

        foreach ($users as $user) {
            $user->notify(new IzinAbsen($title, $message, $url));
        }
    }
}
